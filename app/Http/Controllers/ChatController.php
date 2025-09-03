<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Exception;

class ChatController extends Controller
{
    /**
     * RAG API base URL
     */
    private function getRagApiBase(): string
    {
        // Use Docker service name when running in Docker, localhost otherwise
        return env('RAG_API_URL', 'http://localhost:8002');
    }
    
    /**
     * Default timeout for RAG API calls (seconds)
     */
    private const API_TIMEOUT = 30;
    
    /**
     * Session timeout for conversations (minutes)
     */
    private const SESSION_TIMEOUT = 60;

    /**
     * Handle chat message from frontend
     */
    public function chat(Request $request): JsonResponse
    {
        // Validate request
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            'session_id' => 'nullable|string|max:100',
        ]);

        // Generate or use existing session ID
        $sessionId = $validated['session_id'] ?? $this->generateSessionId();
        
        try {
            // Prepare metadata for better context
            $metadata = $this->buildConversationMetadata($request, $sessionId);
            
            // Call RAG API
            $response = Http::timeout(self::API_TIMEOUT)
                ->post($this->getRagApiBase() . '/chat', [
                    'message' => $validated['message'],
                    'session_id' => $sessionId,
                    'metadata' => $metadata
                ]);

            if ($response->failed()) {
                Log::error('RAG API call failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'session_id' => $sessionId
                ]);
                
                return $this->fallbackResponse($sessionId, 'RAG API unavailable');
            }

            $responseData = $response->json();
            
            // Store conversation in session/cache for tracking
            $this->storeConversationMessage($sessionId, $validated['message'], $responseData['answer']);
            
            // Store analytics data in database
            $this->storeAnalyticsData($request, $sessionId, $validated['message'], $responseData);
            
            // Automatically qualify lead after each conversation exchange
            $this->triggerLeadQualification($request, $sessionId);
            
            // Log successful interaction
            Log::info('Chat interaction completed', [
                'session_id' => $sessionId,
                'processing_time' => $responseData['processing_time'] ?? 0,
                'conversation_length' => $responseData['conversation_length'] ?? 0
            ]);

            return response()->json([
                'success' => true,
                'answer' => $responseData['answer'],
                'session_id' => $sessionId,
                'sources' => $responseData['sources'] ?? [],
                'conversation_length' => $responseData['conversation_length'] ?? 0,
                'timestamp' => now()->toISOString()
            ]);

        } catch (Exception $e) {
            Log::error('Chat controller error', [
                'error' => $e->getMessage(),
                'session_id' => $sessionId,
                'trace' => $e->getTraceAsString()
            ]);

            return $this->fallbackResponse($sessionId, 'An error occurred while processing your message');
        }
    }

    /**
     * Qualify lead based on conversation history
     */
    public function qualifyLead(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
        ]);

        try {
            // Get conversation history from cache/session
            $conversationHistory = $this->getConversationHistory($validated['session_id']);
            
            if (empty($conversationHistory)) {
                return response()->json([
                    'success' => false,
                    'error' => 'No conversation history found for qualification'
                ], 400);
            }

            // Prepare metadata for qualification
            $metadata = $this->buildQualificationMetadata($request, $validated['session_id']);

            // Call RAG qualification API
            $response = Http::timeout(self::API_TIMEOUT)
                ->post($this->getRagApiBase() . '/qualify', [
                    'session_id' => $validated['session_id'],
                    'conversation_history' => $conversationHistory,
                    'metadata' => $metadata
                ]);

            if ($response->failed()) {
                Log::error('RAG qualification API call failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'session_id' => $validated['session_id']
                ]);
                
                // FALLBACK: Try rule-based qualification
                Log::info('Attempting rule-based qualification fallback', [
                    'session_id' => $validated['session_id']
                ]);
                
                $fallbackQualification = $this->performRuleBasedQualification($conversationHistory, $metadata);
                if ($fallbackQualification) {
                    $this->storeQualificationResults($validated['session_id'], $fallbackQualification);
                    $this->storeLeadQualification($request, $validated['session_id'], $fallbackQualification);
                    
                    Log::info('Manual qualification fallback successful', [
                        'session_id' => $validated['session_id'],
                        'lead_score' => $fallbackQualification['lead_score'],
                        'method' => 'manual-fallback'
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'qualification' => $fallbackQualification,
                        'session_id' => $validated['session_id'],
                        'processing_time' => 0,
                        'fallback_used' => true
                    ]);
                }
                
                return response()->json([
                    'success' => false,
                    'error' => 'Qualification service unavailable and fallback failed'
                ], 503);
            }

            $qualificationData = $response->json();
            
            // Check if Groq returned successful results
            if ($qualificationData['success'] && isset($qualificationData['qualification'])) {
                // Store qualification results for CRM integration
                $this->storeQualificationResults($validated['session_id'], $qualificationData['qualification']);
                $this->storeLeadQualification($request, $validated['session_id'], $qualificationData['qualification']);
                
                Log::info('Lead qualification completed', [
                    'session_id' => $validated['session_id'],
                    'success' => $qualificationData['success'],
                    'lead_score' => $qualificationData['qualification']['lead_score'] ?? 0
                ]);
                
                return response()->json($qualificationData);
            } else {
                // FALLBACK: Groq returned failure, use rule-based system
                Log::warning('Groq returned unsuccessful qualification, using fallback', [
                    'session_id' => $validated['session_id'],
                    'groq_response' => $qualificationData
                ]);
                
                $fallbackQualification = $this->performRuleBasedQualification($conversationHistory, $metadata);
                if ($fallbackQualification) {
                    $this->storeQualificationResults($validated['session_id'], $fallbackQualification);
                    $this->storeLeadQualification($request, $validated['session_id'], $fallbackQualification);
                    
                    Log::info('Groq failure fallback successful', [
                        'session_id' => $validated['session_id'],
                        'lead_score' => $fallbackQualification['lead_score'],
                        'method' => 'groq-failure-fallback'
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'qualification' => $fallbackQualification,
                        'session_id' => $validated['session_id'],
                        'processing_time' => 0,
                        'fallback_used' => true,
                        'groq_failed' => true
                    ]);
                } else {
                    return response()->json($qualificationData);
                }
            }

        } catch (Exception $e) {
            Log::error('Lead qualification error', [
                'error' => $e->getMessage(),
                'session_id' => $validated['session_id'],
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Lead qualification failed'
            ], 500);
        }
    }

    /**
     * Get conversation history for a session
     */
    public function getConversationHistory(string $sessionId): array
    {
        try {
            // Try to get from cache first
            $cacheKey = "conversation:{$sessionId}";
            $history = Cache::get($cacheKey, []);
            
            if (!empty($history)) {
                return $history;
            }

            // If not in cache, try to get from RAG API
            $response = Http::timeout(10)
                ->get($this->getRagApiBase() . "/conversation/{$sessionId}");

            if ($response->successful()) {
                $data = $response->json();
                return $data['conversation_history'] ?? [];
            }

            return [];

        } catch (Exception $e) {
            Log::warning('Failed to get conversation history', [
                'session_id' => $sessionId,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Clear conversation for a session
     */
    public function clearConversation(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
        ]);

        try {
            // Clear from cache
            $cacheKey = "conversation:{$validated['session_id']}";
            Cache::forget($cacheKey);

            // Clear from RAG API
            $response = Http::timeout(10)
                ->delete($this->getRagApiBase() . "/conversation/{$validated['session_id']}");

            return response()->json([
                'success' => true,
                'message' => 'Conversation cleared successfully'
            ]);

        } catch (Exception $e) {
            Log::error('Failed to clear conversation', [
                'session_id' => $validated['session_id'],
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to clear conversation'
            ], 500);
        }
    }

    /**
     * Check RAG system health
     */
    public function healthCheck(): JsonResponse
    {
        try {
            $response = Http::timeout(5)->get($this->getRagApiBase() . '/health');
            
            if ($response->successful()) {
                return response()->json([
                    'status' => 'healthy',
                    'rag_system' => $response->json(),
                    'timestamp' => now()->toISOString()
                ]);
            }

            return response()->json([
                'status' => 'unhealthy',
                'error' => 'RAG system not responding',
                'timestamp' => now()->toISOString()
            ], 503);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * Generate unique session ID
     */
    private function generateSessionId(): string
    {
        return 'session_' . uniqid() . '_' . time();
    }

    /**
     * Build conversation metadata for better context
     */
    private function buildConversationMetadata(Request $request, string $sessionId): array
    {
        return [
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
            'referrer' => $request->header('referer'),
            'pages_visited' => session('pages_visited', []),
            'session_start' => session('chat_session_start', now()->toISOString()),
            'laravel_session_id' => session()->getId(),
            'timestamp' => now()->toISOString()
        ];
    }

    /**
     * Build qualification metadata
     */
    private function buildQualificationMetadata(Request $request, string $sessionId): array
    {
        return array_merge($this->buildConversationMetadata($request, $sessionId), [
            'qualification_requested_at' => now()->toISOString(),
            'total_session_time' => $this->calculateSessionTime($sessionId),
            'page_views' => session('page_view_count', 0),
        ]);
    }

    /**
     * Store conversation message in cache for tracking
     */
    private function storeConversationMessage(string $sessionId, string $userMessage, string $botResponse): void
    {
        try {
            $cacheKey = "conversation:{$sessionId}";
            $history = Cache::get($cacheKey, []);
            
            // Add user message
            $history[] = [
                'role' => 'user',
                'content' => $userMessage,
                'timestamp' => now()->toISOString()
            ];
            
            // Add bot response
            $history[] = [
                'role' => 'assistant',
                'content' => $botResponse,
                'timestamp' => now()->toISOString()
            ];
            
            // Keep only last 50 messages to prevent cache bloat
            if (count($history) > 50) {
                $history = array_slice($history, -50);
            }
            
            // Store in cache for session timeout duration
            Cache::put($cacheKey, $history, now()->addMinutes(self::SESSION_TIMEOUT));
            
        } catch (Exception $e) {
            Log::warning('Failed to store conversation message', [
                'session_id' => $sessionId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Store qualification results for CRM integration
     */
    private function storeQualificationResults(string $sessionId, array $qualification): void
    {
        try {
            // Store in cache for immediate access
            $cacheKey = "qualification:{$sessionId}";
            Cache::put($cacheKey, $qualification, now()->addHours(24));
            
            // TODO: Integrate with your CRM system here
            // Example: Create lead in Salesforce, HubSpot, etc.
            
            // Log high-priority leads for immediate attention
            if ($qualification['sales_ready'] ?? false) {
                Log::info('High-priority lead detected', [
                    'session_id' => $sessionId,
                    'lead_score' => $qualification['lead_score'] ?? 0,
                    'company_size' => $qualification['company_size'] ?? 'unknown',
                    'industry' => $qualification['industry'] ?? 'unknown',
                    'intent' => $qualification['intent'] ?? 'unknown'
                ]);
                
                // TODO: Send notification to sales team
                // $this->notifySalesTeam($qualification);
            }
            
        } catch (Exception $e) {
            Log::error('Failed to store qualification results', [
                'session_id' => $sessionId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Calculate total session time
     */
    private function calculateSessionTime(string $sessionId): ?float
    {
        $startTime = session('chat_session_start');
        if (!$startTime) {
            return null;
        }
        
        return now()->diffInSeconds(\Carbon\Carbon::parse($startTime));
    }

    /**
     * Provide fallback response when RAG system is unavailable
     */
    private function fallbackResponse(string $sessionId, string $reason): JsonResponse
    {
        $fallbackMessage = "I apologize, but I'm currently experiencing technical difficulties. " .
                          "Please try again in a few moments, or contact our support team directly at " .
                          "contact@braingentech.com for immediate assistance.";

        return response()->json([
            'success' => false,
            'answer' => $fallbackMessage,
            'session_id' => $sessionId,
            'sources' => [],
            'conversation_length' => 0,
            'error' => $reason,
            'timestamp' => now()->toISOString()
        ], 503);
    }

    /**
     * Store analytics data in database
     */
    private function storeAnalyticsData(Request $request, string $sessionId, string $userMessage, array $responseData): void
    {
        try {
            // Store or update conversation record
            $conversation = DB::table('chat_conversations')->updateOrInsert(
                ['session_id' => $sessionId],
                [
                    'user_ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'referrer' => $request->header('referer'),
                    'metadata' => json_encode([
                        'pages_visited' => session('pages_visited', []),
                        'session_start' => session('chat_session_start', now()->toISOString()),
                        'laravel_session_id' => session()->getId(),
                    ]),
                    'started_at' => session('chat_session_start', now()),
                    'last_activity_at' => now(),
                    'is_active' => true,
                    'updated_at' => now()
                ]
            );

            // Increment message count
            DB::table('chat_conversations')
                ->where('session_id', $sessionId)
                ->increment('message_count', 2); // User message + assistant response

            // Store user message
            DB::table('chat_messages')->insert([
                'session_id' => $sessionId,
                'message_id' => 'msg_' . uniqid() . '_user',
                'role' => 'user',
                'content' => $userMessage,
                'metadata' => json_encode([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'timestamp' => now()->toISOString()
                ]),
                'sent_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Store assistant response
            DB::table('chat_messages')->insert([
                'session_id' => $sessionId,
                'message_id' => 'msg_' . uniqid() . '_assistant',
                'role' => 'assistant',
                'content' => $responseData['answer'],
                'metadata' => json_encode([
                    'sources' => $responseData['sources'] ?? [],
                    'processing_time' => $responseData['processing_time'] ?? 0,
                    'conversation_length' => $responseData['conversation_length'] ?? 0,
                    'timestamp' => now()->toISOString()
                ]),
                'sent_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

        } catch (Exception $e) {
            Log::error('Failed to store analytics data', [
                'session_id' => $sessionId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Trigger automatic lead qualification after conversation exchange
     */
    private function triggerLeadQualification(Request $request, string $sessionId): void
    {
        try {
            // Get conversation history to determine if qualification is warranted
            $conversationHistory = $this->getConversationHistory($sessionId);
            
            // Only qualify if we have meaningful conversation (3+ exchanges)
            if (count($conversationHistory) >= 3) {
                
                Log::info('Triggering automatic lead qualification', [
                    'session_id' => $sessionId,
                    'conversation_length' => count($conversationHistory)
                ]);
                
                // Prepare metadata for qualification
                $metadata = $this->buildQualificationMetadata($request, $sessionId);

                // Call RAG qualification API asynchronously to avoid blocking response
                $response = Http::timeout(self::API_TIMEOUT)
                    ->post($this->getRagApiBase() . '/qualify', [
                        'session_id' => $sessionId,
                        'conversation_history' => $conversationHistory,
                        'metadata' => $metadata
                    ]);

                if ($response->successful()) {
                    $qualificationData = $response->json();
                    
                    // Store qualification results if successful
                    if ($qualificationData['success'] && isset($qualificationData['qualification'])) {
                        $this->storeQualificationResults($sessionId, $qualificationData['qualification']);
                        $this->storeLeadQualification($request, $sessionId, $qualificationData['qualification']);
                        
                        Log::info('Automatic lead qualification successful', [
                            'session_id' => $sessionId,
                            'lead_score' => $qualificationData['qualification']['lead_score'] ?? 0,
                            'sales_ready' => $qualificationData['qualification']['sales_ready'] ?? false
                        ]);
                    }
                } else {
                    Log::warning('Automatic qualification API failed', [
                        'session_id' => $sessionId,
                        'status' => $response->status(),
                        'response' => $response->body()
                    ]);
                    
                    // FALLBACK: Use rule-based qualification when Groq fails
                    $fallbackQualification = $this->performRuleBasedQualification($conversationHistory, $metadata);
                    if ($fallbackQualification) {
                        $this->storeQualificationResults($sessionId, $fallbackQualification);
                        $this->storeLeadQualification($request, $sessionId, $fallbackQualification);
                        
                        Log::info('Fallback rule-based qualification successful', [
                            'session_id' => $sessionId,
                            'lead_score' => $fallbackQualification['lead_score'],
                            'method' => 'rule-based-fallback'
                        ]);
                    }
                }
            }
            
        } catch (Exception $e) {
            Log::warning('Automatic lead qualification failed', [
                'session_id' => $sessionId,
                'error' => $e->getMessage()
            ]);
            
            // FALLBACK: Try rule-based qualification even when API throws exception
            try {
                $conversationHistory = $this->getConversationHistory($sessionId);
                if (count($conversationHistory) >= 3) {
                    $metadata = $this->buildQualificationMetadata($request, $sessionId);
                    $fallbackQualification = $this->performRuleBasedQualification($conversationHistory, $metadata);
                    if ($fallbackQualification) {
                        $this->storeQualificationResults($sessionId, $fallbackQualification);
                        $this->storeLeadQualification($request, $sessionId, $fallbackQualification);
                        
                        Log::info('Exception fallback qualification successful', [
                            'session_id' => $sessionId,
                            'lead_score' => $fallbackQualification['lead_score'],
                            'method' => 'exception-fallback'
                        ]);
                    }
                }
            } catch (Exception $fallbackException) {
                Log::error('Fallback qualification also failed', [
                    'session_id' => $sessionId,
                    'fallback_error' => $fallbackException->getMessage()
                ]);
            }
            // Don't throw - this should not block the main chat response
        }
    }

    /**
     * Perform rule-based qualification as fallback when Groq API fails
     */
    private function performRuleBasedQualification(array $conversationHistory, array $metadata): ?array
    {
        try {
            // Combine all conversation content for analysis
            $allContent = '';
            $userMessages = [];
            $assistantMessages = [];
            
            foreach ($conversationHistory as $message) {
                $content = strtolower($message['content'] ?? '');
                $allContent .= ' ' . $content;
                
                if ($message['role'] === 'user') {
                    $userMessages[] = $content;
                } elseif ($message['role'] === 'assistant') {
                    $assistantMessages[] = $content;
                }
            }
            
            $allContent = strtolower(trim($allContent));
            
            // Initialize qualification data
            $qualification = [
                'intent' => 'information',
                'urgency' => 'low',
                'company_size' => 'sme',
                'industry' => 'other',
                'company_name' => null,
                'technology_interests' => [],
                'pain_points' => [],
                'use_cases' => null,
                'decision_maker_level' => 'unknown',
                'geographic_region' => null,
                'timezone' => null,
                'lead_score' => 0,
                'sales_ready' => false,
                'notes' => 'Generated by rule-based fallback system',
                'conversation_quality' => 5,
                'follow_up_priority' => 'medium',
                'model_confidence' => 0.7,
                'qualification_timestamp' => now()->toISOString()
            ];
            
            // Rule-based scoring system
            $score = 0;
            
            // INTENT ANALYSIS
            if ($this->containsKeywords($allContent, ['consultation', 'meeting', 'demo', 'schedule', 'discuss'])) {
                $qualification['intent'] = 'consultation';
                $score += 20;
            } elseif ($this->containsKeywords($allContent, ['quote', 'pricing', 'cost', 'budget', 'price'])) {
                $qualification['intent'] = 'quote';
                $score += 25;
            } elseif ($this->containsKeywords($allContent, ['demo', 'demonstration', 'show', 'example'])) {
                $qualification['intent'] = 'demo';
                $score += 22;
            }
            
            // URGENCY ANALYSIS
            if ($this->containsKeywords($allContent, ['urgent', 'asap', 'immediately', 'critical', 'emergency'])) {
                $qualification['urgency'] = 'critical';
                $score += 25;
            } elseif ($this->containsKeywords($allContent, ['soon', 'quick', 'fast', 'weeks', 'month'])) {
                $qualification['urgency'] = 'high';
                $score += 20;
            } elseif ($this->containsKeywords($allContent, ['next quarter', 'planning', 'future', 'months'])) {
                $qualification['urgency'] = 'medium';
                $score += 10;
            }
            
            // COMPANY SIZE DETECTION
            if ($this->containsKeywords($allContent, ['enterprise', '500+', '1000+', 'large', 'corporation'])) {
                $qualification['company_size'] = 'enterprise';
                $score += 25;
            } elseif ($this->containsKeywords($allContent, ['50', '100', '200', 'employees', 'team'])) {
                $qualification['company_size'] = 'mid_market';
                $score += 15;
            } elseif ($this->containsKeywords($allContent, ['startup', 'small', '10', '20'])) {
                $qualification['company_size'] = 'startup';
                $score += 5;
            }
            
            // DECISION MAKER LEVEL
            if ($this->containsKeywords($allContent, ['cto', 'ceo', 'cfo', 'chief', 'founder'])) {
                $qualification['decision_maker_level'] = 'c_level';
                $score += 30;
            } elseif ($this->containsKeywords($allContent, ['director', 'vp', 'vice president', 'head of'])) {
                $qualification['decision_maker_level'] = 'director';
                $score += 25;
            } elseif ($this->containsKeywords($allContent, ['manager', 'lead', 'supervisor'])) {
                $qualification['decision_maker_level'] = 'manager';
                $score += 15;
            } elseif ($this->containsKeywords($allContent, ['owner', 'founder'])) {
                $qualification['decision_maker_level'] = 'owner';
                $score += 30;
            }
            
            // BUDGET INDICATORS
            if ($this->containsKeywords($allContent, ['budget', 'approved', '$', 'million', '000', 'investment'])) {
                $score += 20;
                $qualification['pain_points'][] = 'Budget approved for automation initiatives';
            }
            
            // INDUSTRY DETECTION
            if ($this->containsKeywords($allContent, ['fintech', 'banking', 'finance', 'financial'])) {
                $qualification['industry'] = 'fintech';
                $score += 10;
            } elseif ($this->containsKeywords($allContent, ['healthcare', 'hospital', 'medical', 'patient'])) {
                $qualification['industry'] = 'healthcare';
                $score += 10;
            } elseif ($this->containsKeywords($allContent, ['retail', 'ecommerce', 'store'])) {
                $qualification['industry'] = 'retail';
                $score += 10;
            } elseif ($this->containsKeywords($allContent, ['technology', 'tech', 'software', 'it'])) {
                $qualification['industry'] = 'technology';
                $score += 10;
            }
            
            // TECHNOLOGY INTERESTS
            if ($this->containsKeywords($allContent, ['ai', 'artificial intelligence', 'machine learning'])) {
                $qualification['technology_interests'][] = 'ai';
                $score += 10;
            }
            if ($this->containsKeywords($allContent, ['automation', 'automate', 'process automation'])) {
                $qualification['technology_interests'][] = 'automation';
                $score += 10;
            }
            
            // PAIN POINTS DETECTION
            if ($this->containsKeywords($allContent, ['manual', 'time consuming', 'inefficient', 'errors'])) {
                $qualification['pain_points'][] = 'Manual processes causing inefficiencies';
                $score += 10;
            }
            
            // COMPANY NAME EXTRACTION
            if (preg_match('/(?:at|from|with)\s+([A-Z][a-zA-Z\s]+(?:Corp|Inc|LLC|Ltd|Company|Solutions|Tech|Technologies))/i', $allContent, $matches)) {
                $qualification['company_name'] = trim($matches[1]);
                $score += 10;
            }
            
            // CONVERSATION QUALITY BASED ON LENGTH AND ENGAGEMENT
            $totalMessages = count($conversationHistory);
            if ($totalMessages >= 8) {
                $qualification['conversation_quality'] = 8;
                $score += 5;
            } elseif ($totalMessages >= 6) {
                $qualification['conversation_quality'] = 7;
                $score += 3;
            } elseif ($totalMessages >= 4) {
                $qualification['conversation_quality'] = 6;
            }
            
            // Final lead score and sales readiness
            $qualification['lead_score'] = min(100, $score);
            $qualification['sales_ready'] = $score >= 70; // Sales ready threshold
            
            // Set follow-up priority based on score
            if ($score >= 80) {
                $qualification['follow_up_priority'] = 'urgent';
            } elseif ($score >= 60) {
                $qualification['follow_up_priority'] = 'high';
            } elseif ($score >= 40) {
                $qualification['follow_up_priority'] = 'medium';
            } else {
                $qualification['follow_up_priority'] = 'low';
            }
            
            // Add detailed notes
            $qualification['notes'] = "Rule-based qualification: Score {$score}/100. " . 
                "Intent: {$qualification['intent']}, " .
                "Company: {$qualification['company_size']}, " .
                "Decision Level: {$qualification['decision_maker_level']}. " .
                "Fallback system used due to AI API failure.";
            
            return $qualification;
            
        } catch (Exception $e) {
            Log::error('Rule-based qualification failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
    
    /**
     * Helper function to check if content contains any of the specified keywords
     */
    private function containsKeywords(string $content, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (stripos($content, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Store lead qualification data in database
     */
    private function storeLeadQualification(Request $request, string $sessionId, array $qualification): void
    {
        try {
            DB::table('lead_qualifications')->updateOrInsert(
                ['session_id' => $sessionId],
                [
                    'intent' => $qualification['intent'] ?? null,
                    'urgency' => $qualification['urgency'] ?? null,
                    'company_size' => $qualification['company_size'] ?? null,
                    'industry' => $qualification['industry'] ?? null,
                    'company_name' => $qualification['company_name'] ?? null,
                    'technology_interests' => json_encode($qualification['technology_interests'] ?? []),
                    'pain_points' => json_encode($qualification['pain_points'] ?? []),
                    'use_cases' => $qualification['use_cases'] ?? null,
                    'decision_maker_level' => $qualification['decision_maker_level'] ?? null,
                    'geographic_region' => $qualification['geographic_region'] ?? null,
                    'timezone' => $qualification['timezone'] ?? null,
                    'lead_score' => (int) ($qualification['lead_score'] ?? 0),
                    'sales_ready' => (bool) ($qualification['sales_ready'] ?? false),
                    'notes' => $qualification['notes'] ?? null,
                    'conversation_quality' => (int) ($qualification['conversation_quality'] ?? 5),
                    'follow_up_priority' => $qualification['follow_up_priority'] ?? 'medium',
                    'model_confidence' => (float) ($qualification['model_confidence'] ?? 0.5),
                    'qualified_at' => now(),
                    'raw_qualification_data' => json_encode($qualification),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            // If high-priority lead, log for immediate attention and create consultation request
            if (($qualification['lead_score'] ?? 0) >= 80 || ($qualification['sales_ready'] ?? false)) {
                Log::info('High-priority lead stored in analytics database', [
                    'session_id' => $sessionId,
                    'lead_score' => $qualification['lead_score'] ?? 0,
                    'sales_ready' => $qualification['sales_ready'] ?? false,
                    'company_size' => $qualification['company_size'] ?? 'unknown',
                    'industry' => $qualification['industry'] ?? 'unknown'
                ]);
                
                // Automatically create consultation request for Sales Ready leads
                $this->createAutoConsultationRequest($sessionId, $qualification);
            }

        } catch (Exception $e) {
            Log::error('Failed to store lead qualification', [
                'session_id' => $sessionId,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Automatically create consultation request for Sales Ready leads
     */
    private function createAutoConsultationRequest(string $sessionId, array $qualification): void
    {
        try {
            // Determine request type based on intent
            $requestType = $this->mapIntentToRequestType($qualification['intent'] ?? 'consultation');
            
            // Determine status based on lead score and urgency
            $status = $this->determineConsultationStatus($qualification);
            
            // Create consultation request
            DB::table('consultation_requests')->updateOrInsert(
                ['session_id' => $sessionId],
                [
                    'industry' => $qualification['industry'] ?? 'other',
                    'request_type' => $requestType,
                    'status' => $status,
                    'notes' => $this->buildConsultationNotes($qualification),
                    'requested_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
            
            Log::info('Automatic consultation request created', [
                'session_id' => $sessionId,
                'request_type' => $requestType,
                'status' => $status,
                'lead_score' => $qualification['lead_score'] ?? 0,
                'industry' => $qualification['industry'] ?? 'other'
            ]);
            
        } catch (Exception $e) {
            Log::error('Failed to create automatic consultation request', [
                'session_id' => $sessionId,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Map BANT+ intent to consultation request type
     */
    private function mapIntentToRequestType(string $intent): string
    {
        $mapping = [
            'consultation' => 'consultation',
            'demo' => 'demo', 
            'quote' => 'quote',
            'information' => 'consultation',
            'support' => 'consultation',
            'partnership' => 'consultation'
        ];
        
        return $mapping[$intent] ?? 'consultation';
    }
    
    /**
     * Determine consultation status based on qualification data
     */
    private function determineConsultationStatus(array $qualification): string
    {
        $leadScore = $qualification['lead_score'] ?? 0;
        $urgency = $qualification['urgency'] ?? 'low';
        $decisionLevel = $qualification['decision_maker_level'] ?? 'unknown';
        
        // High-priority leads get scheduled immediately
        if ($leadScore >= 90 && in_array($urgency, ['critical', 'high']) && in_array($decisionLevel, ['c_level', 'owner'])) {
            return 'scheduled';
        }
        
        // Very high scores get priority processing
        if ($leadScore >= 80) {
            return 'pending';
        }
        
        // Default status for sales ready leads
        return 'pending';
    }
    
    /**
     * Build consultation notes from qualification data
     */
    private function buildConsultationNotes(array $qualification): string
    {
        $notes = [];
        
        // Lead score and readiness
        $notes[] = "BANT+ Score: {$qualification['lead_score']}/100";
        $notes[] = "Sales Ready: " . ($qualification['sales_ready'] ? 'YES' : 'NO');
        
        // Company information
        if (!empty($qualification['company_name'])) {
            $notes[] = "Company: {$qualification['company_name']}";
        }
        $notes[] = "Size: " . ucfirst($qualification['company_size'] ?? 'unknown');
        $notes[] = "Decision Level: " . ucfirst($qualification['decision_maker_level'] ?? 'unknown');
        
        // Business context
        if (!empty($qualification['urgency'])) {
            $notes[] = "Urgency: " . ucfirst($qualification['urgency']);
        }
        
        // Technology interests
        if (!empty($qualification['technology_interests'])) {
            $interests = is_array($qualification['technology_interests']) 
                ? implode(', ', $qualification['technology_interests'])
                : $qualification['technology_interests'];
            $notes[] = "Tech Interests: {$interests}";
        }
        
        // Pain points
        if (!empty($qualification['pain_points'])) {
            $painPoints = is_array($qualification['pain_points']) 
                ? implode('; ', $qualification['pain_points'])
                : $qualification['pain_points'];
            $notes[] = "Pain Points: {$painPoints}";
        }
        
        // Priority
        $notes[] = "Follow-up Priority: " . ucfirst($qualification['follow_up_priority'] ?? 'medium');
        
        // Source
        $notes[] = "Generated automatically from BANT+ qualification";
        
        return implode(' | ', $notes);
    }
}