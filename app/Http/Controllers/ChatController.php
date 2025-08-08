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
                
                return response()->json([
                    'success' => false,
                    'error' => 'Qualification service unavailable'
                ], 503);
            }

            $qualificationData = $response->json();
            
            // Store qualification results for CRM integration
            if ($qualificationData['success'] && isset($qualificationData['qualification'])) {
                $this->storeQualificationResults($validated['session_id'], $qualificationData['qualification']);
                $this->storeLeadQualification($request, $validated['session_id'], $qualificationData['qualification']);
            }

            Log::info('Lead qualification completed', [
                'session_id' => $validated['session_id'],
                'success' => $qualificationData['success'],
                'lead_score' => $qualificationData['qualification']['lead_score'] ?? 0
            ]);

            return response()->json($qualificationData);

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

            // If high-priority lead, log for immediate attention
            if (($qualification['lead_score'] ?? 0) >= 80 || ($qualification['sales_ready'] ?? false)) {
                Log::info('High-priority lead stored in analytics database', [
                    'session_id' => $sessionId,
                    'lead_score' => $qualification['lead_score'] ?? 0,
                    'sales_ready' => $qualification['sales_ready'] ?? false,
                    'company_size' => $qualification['company_size'] ?? 'unknown',
                    'industry' => $qualification['industry'] ?? 'unknown'
                ]);
            }

        } catch (Exception $e) {
            Log::error('Failed to store lead qualification', [
                'session_id' => $sessionId,
                'error' => $e->getMessage()
            ]);
        }
    }
}