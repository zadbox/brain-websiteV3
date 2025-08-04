<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class LangChainService
{
    private $pythonServiceUrl;
    private $timeout;

    public function __construct()
    {
        $this->pythonServiceUrl = env('LANGCHAIN_SERVICE_URL', 'http://localhost:8001');
        $this->timeout = env('LANGCHAIN_TIMEOUT', 30);
    }

    /**
     * Process a query using LangChain service
     */
    public function processQuery(string $query, array $context = [], array $leadData = []): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post($this->pythonServiceUrl . '/chat', [
                    'message' => $query,
                    'context' => $context,
                    'lead_data' => $leadData
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                Log::info('LangChain query processed successfully', [
                    'query' => substr($query, 0, 100),
                    'response_time' => $response->handlerStats()['total_time'] ?? 0,
                    'source' => $data['source'] ?? 'langchain'
                ]);

                return $this->formatResponse($data);
            } else {
                Log::error('LangChain service error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return $this->getFallbackResponse($query);
            }

        } catch (\Exception $e) {
            Log::error('LangChain service exception', [
                'error' => $e->getMessage(),
                'query' => substr($query, 0, 100)
            ]);

            return $this->getFallbackResponse($query);
        }
    }

    /**
     * Qualify a lead using LangChain tools
     */
    public function qualifyLead(string $message, array $context = [], array $leadData = []): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post($this->pythonServiceUrl . '/qualify-lead', [
                    'message' => $message,
                    'context' => $context,
                    'lead_data' => $leadData
                ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('LangChain lead qualification error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return $this->getDefaultLeadQualification();
            }

        } catch (\Exception $e) {
            Log::error('LangChain lead qualification exception', [
                'error' => $e->getMessage()
            ]);

            return $this->getDefaultLeadQualification();
        }
    }

    /**
     * Check if LangChain service is healthy
     */
    public function isHealthy(): bool
    {
        try {
            Log::info('Checking LangChain health at: ' . $this->pythonServiceUrl . '/health');
            
            $response = Http::timeout(5)
                ->get($this->pythonServiceUrl . '/health');

            Log::info('LangChain health response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('LangChain health data', $data);
                $isHealthy = $data['status'] === 'healthy';
                Log::info('LangChain isHealthy result: ' . ($isHealthy ? 'true' : 'false'));
                return $isHealthy;
            }

            Log::error('LangChain health check failed - response not successful', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('LangChain health check failed', [
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Get service metrics
     */
    public function getMetrics(): array
    {
        try {
            $response = Http::timeout(5)
                ->get($this->pythonServiceUrl . '/metrics');

            if ($response->successful()) {
                return $response->json();
            }

            return [];

        } catch (\Exception $e) {
            Log::error('LangChain metrics error', [
                'error' => $e->getMessage()
            ]);

            return [];
        }
    }

    /**
     * Add knowledge to the vector store
     */
    public function addKnowledge(string $text, array $metadata = []): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post($this->pythonServiceUrl . '/add-knowledge', [
                    'text' => $text,
                    'metadata' => $metadata
                ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('LangChain add knowledge error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return ['success' => false, 'error' => 'Failed to add knowledge'];
            }

        } catch (\Exception $e) {
            Log::error('LangChain add knowledge exception', [
                'error' => $e->getMessage()
            ]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Search knowledge base
     */
    public function searchKnowledge(string $query, int $limit = 5): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->pythonServiceUrl . '/search-knowledge', [
                    'query' => $query,
                    'limit' => $limit
                ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('LangChain search knowledge error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return ['results' => []];
            }

        } catch (\Exception $e) {
            Log::error('LangChain search knowledge exception', [
                'error' => $e->getMessage()
            ]);

            return ['results' => []];
        }
    }

    /**
     * Format response from LangChain service
     */
    private function formatResponse(array $data): array
    {
        return [
            'response' => $data['response'] ?? 'Désolé, je ne peux pas traiter votre demande pour le moment.',
            'confidence' => $data['confidence'] ?? 0.5,
            'sources' => $data['sources'] ?? [],
            'suggestions' => $data['suggestions'] ?? [
                'Quel est votre rôle dans l\'entreprise ?',
                'Quel est votre budget pour ce projet ?',
                'Dans quel délai souhaitez-vous implémenter ?'
            ],
            'lead_qualification' => $data['lead_qualification'] ?? null,
            'source' => $data['source'] ?? 'langchain'
        ];
    }

    /**
     * Get fallback response when LangChain service is unavailable
     */
    private function getFallbackResponse(string $query): array
    {
        // Use existing RAG service as fallback
        $ragService = app(RAGService::class);
        
        return [
            'response' => 'Je rencontre actuellement des difficultés techniques. Voici une réponse basée sur nos informations disponibles.',
            'confidence' => 0.3,
            'sources' => [],
            'suggestions' => [
                'Quel est votre rôle dans l\'entreprise ?',
                'Quel est votre budget pour ce projet ?',
                'Dans quel délai souhaitez-vous implémenter ?'
            ],
            'lead_qualification' => null,
            'source' => 'fallback'
        ];
    }

    /**
     * Get default lead qualification when service is unavailable
     */
    private function getDefaultLeadQualification(): array
    {
        return [
            'budget_score' => 5,
            'authority_score' => 5,
            'need_score' => 5,
            'timeline_score' => 5,
            'overall_score' => 5.0,
            'category' => 'Warm',
            'recommendations' => ['Besoin de plus d\'informations']
        ];
    }

    /**
     * Test connection to LangChain service
     */
    public function testConnection(): bool
    {
        try {
            $response = Http::timeout(5)
                ->get($this->pythonServiceUrl . '/health');

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('LangChain connection test failed', [
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Get service status
     */
    public function getStatus(): array
    {
        $isHealthy = $this->isHealthy();
        $metrics = $this->getMetrics();

        return [
            'healthy' => $isHealthy,
            'url' => $this->pythonServiceUrl,
            'metrics' => $metrics,
            'timestamp' => now()->toISOString()
        ];
    }
} 