<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmbeddingService
{
    private $cohereApiKey;
    private $qdrantUrl;

    public function __construct()
    {
        $this->cohereApiKey = env('COHERE_API_KEY');
        $this->qdrantUrl = env('QDRANT_URL', 'http://localhost:6333');
    }

    /**
     * Génère un embedding pour un texte donné
     */
    public function generateEmbedding(string $text): ?array
    {
        if (empty($this->cohereApiKey)) {
            if (class_exists('Log')) {
                Log::warning('Cohere API key not configured for embeddings');
            }
            return null;
        }

        try {
            $response = Http::timeout(10)->withHeaders([
                'Authorization' => 'Bearer ' . $this->cohereApiKey,
                'Content-Type' => 'application/json'
            ])->post('https://api.cohere.ai/v1/embed', [
                'texts' => [$text],
                'model' => 'embed-english-v3.0',
                'input_type' => 'search_document'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['embeddings'][0] ?? null;
            }

            if (class_exists('Log')) {
                Log::error('Cohere embedding API error: ' . $response->body());
            }
            return null;

        } catch (\Exception $e) {
            if (class_exists('Log')) {
                Log::error('Embedding generation failed: ' . $e->getMessage());
            }
            return null;
        }
    }

    /**
     * Recherche des vecteurs similaires dans Qdrant
     */
    public function searchSimilar(string $collection, array $queryVector, int $limit = 3): array
    {
        try {
            $response = Http::timeout(10)->post($this->qdrantUrl . "/collections/{$collection}/points/search", [
                'vector' => $queryVector,
                'limit' => $limit,
                'with_payload' => true,
                'with_vector' => false
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['result'] ?? [];
            }

            if (class_exists('Log')) {
                Log::warning('Qdrant search failed: ' . $response->body());
            }
            return [];

        } catch (\Exception $e) {
            if (class_exists('Log')) {
                Log::error('Qdrant search error: ' . $e->getMessage());
            }
            return [];
        }
    }

    /**
     * Stocke un embedding dans Qdrant
     */
    public function storeEmbedding(string $collection, string $id, array $vector, array $payload = []): bool
    {
        try {
            // Convertir l'ID en entier si possible
            $numericId = is_numeric($id) ? (int)$id : crc32($id);
            
            $response = Http::timeout(10)->post($this->qdrantUrl . "/collections/{$collection}/points", [
                'ids' => [$numericId],
                'vectors' => [$vector],
                'payloads' => [$payload]
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            if (class_exists('Log')) {
                Log::error('Qdrant storage failed: ' . $e->getMessage());
            }
            return false;
        }
    }

    /**
     * Crée une collection dans Qdrant
     */
    public function createCollection(string $collection, int $vectorSize = 1024): bool
    {
        try {
            $response = Http::timeout(10)->put($this->qdrantUrl . "/collections/{$collection}", [
                'vectors' => [
                    'size' => $vectorSize,
                    'distance' => 'Cosine'
                ]
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            if (class_exists('Log')) {
                Log::error('Qdrant collection creation failed: ' . $e->getMessage());
            }
            return false;
        }
    }

    /**
     * Vérifie si une collection existe
     */
    public function collectionExists(string $collection): bool
    {
        try {
            $response = Http::timeout(10)->get($this->qdrantUrl . "/collections/{$collection}");
            return $response->successful();

        } catch (\Exception $e) {
            return false;
        }
    }
} 