<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    private string $pythonApiUrl;
    private int $timeout;

    public function __construct()
    {
        $this->pythonApiUrl = env('LANGCHAIN_SERVICE_URL', 'http://localhost:8001');
        $this->timeout = env('LANGCHAIN_TIMEOUT', 30);
    }

    /**
     * Handle chatbot message
     */
    public function sendMessage(Request $request): JsonResponse
    {
        try {
            // Validate request
            $request->validate([
                'message' => 'required|string|max:10000',
                'context' => 'array',
                'lead_data' => 'array',
                'session_id' => 'string'
            ]);

            // Prepare data for Python API
            $payload = [
                'message' => $request->input('message'),
                'session_id' => $request->input('session_id', Str::uuid()->toString()),
                'context' => $request->input('context', []),
                'lead_data' => $request->input('lead_data', []),
                'metadata' => [
                    'user_agent' => $request->userAgent(),
                    'ip_address' => $request->ip(),
                    'referrer' => $request->header('referer'),
                    'timestamp' => now()->toISOString()
                ]
            ];

            // Call Python API
            $response = Http::timeout($this->timeout)
                ->post($this->pythonApiUrl . '/chat', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                // Transform Python API response to frontend format
                return response()->json([
                    'success' => true,
                    'message' => $data['response'],
                    'suggestions' => $data['suggestions'] ?? [],
                    'lead_qualification' => $data['lead_qualification'] ?? null,
                    'confidence' => $data['confidence'] ?? 0.0,
                    'processing_time' => $data['processing_time'] ?? 0,
                    'session_id' => $data['session_id'],
                    'sources' => $data['sources'] ?? [],
                    'timestamp' => $data['timestamp'] ?? now()->toISOString()
                ]);
            } else {
                Log::error('Python API error', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'payload' => $payload
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Désolé, je rencontre une difficulté technique. Pouvez-vous reformuler ?',
                    'error' => 'API_ERROR'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Chatbot error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => '⚠️ Erreur technique. Veuillez réessayer dans quelques instants.',
                'error' => 'INTERNAL_ERROR'
            ], 500);
        }
    }

    /**
     * Get chatbot status
     */
    public function getStatus(): JsonResponse
    {
        try {
            $response = Http::timeout(10)
                ->get($this->pythonApiUrl . '/health');

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'status' => $data['status'],
                    'services' => $data['services'] ?? [],
                    'metrics' => $data['metrics'] ?? []
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'offline',
                    'message' => 'Service temporairement indisponible'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Status check error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'status' => 'offline',
                'message' => 'Impossible de vérifier le statut du service'
            ]);
        }
    }

    /**
     * Search knowledge base
     */
    public function searchKnowledge(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'query' => 'required|string|max:500',
                'limit' => 'integer|min:1|max:20'
            ]);

            $response = Http::timeout(15)
                ->get($this->pythonApiUrl . '/search-knowledge', [
                    'query' => $request->input('query'),
                    'limit' => $request->input('limit', 5)
                ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'results' => $response->json()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la recherche'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Knowledge search error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche'
            ], 500);
        }
    }

    /**
     * Qualify lead
     */
    public function qualifyLead(Request $request): JsonResponse
    {
        try {
            // Validate BANT data
            $request->validate([
                'budget' => 'required|numeric|min:0',
                'authority' => 'required|string|in:low,medium,high,executive',
                'need' => 'required|string|in:low,medium,high,critical',
                'timeline' => 'required|string|in:6months,3months,1month,immediate'
            ]);

            // Get BANT data from request
            $budget = intval($request->input('budget'));
            $authority = $request->input('authority');
            $need = $request->input('need');
            $timeline = $request->input('timeline');

            // Calculate BANT scores
            $budgetScore = $this->calculateBudgetScore($budget);
            $authorityScore = $this->calculateAuthorityScore($authority);
            $needScore = $this->calculateNeedScore($need);
            $timelineScore = $this->calculateTimelineScore($timeline);
            
            // Total score (0-100)
            $totalScore = $budgetScore + $authorityScore + $needScore + $timelineScore;
            
            // Determine lead category
            $category = $this->getLeadCategory($totalScore);
            $recommendation = $this->getRecommendation($totalScore);
            
            // Log the qualification for analytics
            Log::info('Lead qualified', [
                'budget' => $budget,
                'authority' => $authority,
                'need' => $need,
                'timeline' => $timeline,
                'score' => $totalScore,
                'category' => $category,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'score' => $totalScore,
                'category' => $category,
                'recommendation' => $recommendation,
                'breakdown' => [
                    'budget' => $budgetScore,
                    'authority' => $authorityScore,
                    'need' => $needScore,
                    'timeline' => $timelineScore
                ],
                'details' => [
                    'budget_range' => $this->getBudgetRange($budget),
                    'authority_level' => $this->getAuthorityLevel($authority),
                    'need_urgency' => $this->getNeedUrgency($need),
                    'timeline_expectation' => $this->getTimelineExpectation($timeline)
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Lead qualification error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la qualification'
            ], 500);
        }
    }

    /**
     * Get chatbot configuration
     */
    public function getConfig(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'config' => [
                'api_url' => $this->pythonApiUrl,
                'timeout' => $this->timeout,
                'features' => [
                    'knowledge_search' => true,
                    'lead_qualification' => true,
                    'conversation_memory' => true,
                    'smart_suggestions' => true
                ]
            ]
        ]);
    }

    /**
     * BANT Scoring Methods
     */
    private function calculateBudgetScore(int $budget): int
    {
        if ($budget >= 200000) return 25;
        if ($budget >= 100000) return 20;
        if ($budget >= 50000) return 15;
        if ($budget >= 10000) return 10;
        return 5;
    }

    private function calculateAuthorityScore(string $authority): int
    {
        return match($authority) {
            'executive' => 25,
            'high' => 20,
            'medium' => 15,
            'low' => 10,
            default => 5
        };
    }

    private function calculateNeedScore(string $need): int
    {
        return match($need) {
            'critical' => 25,
            'high' => 20,
            'medium' => 15,
            'low' => 10,
            default => 5
        };
    }

    private function calculateTimelineScore(string $timeline): int
    {
        return match($timeline) {
            'immediate' => 25,
            '1month' => 20,
            '3months' => 15,
            '6months' => 10,
            default => 5
        };
    }

    private function getLeadCategory(int $score): string
    {
        if ($score >= 75) return 'Hot';
        if ($score >= 50) return 'Warm';
        return 'Cold';
    }

    private function getRecommendation(int $score): string
    {
        if ($score >= 75) {
            return 'Lead prioritaire - Suivi commercial immédiat recommandé. Contact dans les 2 heures.';
        }
        if ($score >= 50) {
            return 'Lead qualifié - Suivi dans les 24 heures. Planifier un appel de découverte.';
        }
        return 'Lead à nurturing - Intégrer dans une campagne d\'éducation marketing. Suivi hebdomadaire.';
    }

    private function getBudgetRange(int $budget): string
    {
        if ($budget >= 200000) return 'Premium (200k€+)';
        if ($budget >= 100000) return 'Entreprise (100k-200k€)';
        if ($budget >= 50000) return 'Business (50k-100k€)';
        if ($budget >= 10000) return 'Standard (10k-50k€)';
        return 'Starter (<10k€)';
    }

    private function getAuthorityLevel(string $authority): string
    {
        return match($authority) {
            'executive' => 'C-Level Executive',
            'high' => 'Decision Maker',
            'medium' => 'Manager/Supervisor',
            'low' => 'Influencer/User',
            default => 'Unknown'
        };
    }

    private function getNeedUrgency(string $need): string
    {
        return match($need) {
            'critical' => 'Critical Business Issue',
            'high' => 'Urgent Need',
            'medium' => 'Evaluating Solutions',
            'low' => 'Exploring Options',
            default => 'Unknown'
        };
    }

    private function getTimelineExpectation(string $timeline): string
    {
        return match($timeline) {
            'immediate' => 'Immediate Implementation',
            '1month' => '1-3 months',
            '3months' => '3-6 months',
            '6months' => '6+ months',
            default => 'Undefined'
        };
    }
}