<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CohereService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.cohere.ai/v1';
    protected $model = 'command';

    public function __construct()
    {
        $this->apiKey = config('services.cohere.api_key');
    }

    /**
     * Génère une réponse intelligente avec l'API Cohere
     */
    public function generateResponse(string $message, array $context = [], array $leadData = []): ?array
    {
        if (!$this->apiKey) {
            Log::info('Cohere API key not configured, skipping AI response');
            return null;
        }

        try {
            $prompt = $this->buildPrompt($message, $context, $leadData);
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/generate', [
                    'model' => $this->model,
                    'prompt' => $prompt,
                    'max_tokens' => 500,
                    'temperature' => 0.7,
                    'k' => 0,
                    'stop_sequences' => ['\n\n', 'User:', 'Assistant:'],
                    'return_likelihoods' => 'NONE'
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $generatedText = $data['generations'][0]['text'] ?? '';
                
                if (!empty($generatedText)) {
                    Log::info('Cohere API response generated successfully');
                    
                    return [
                        'reply' => trim($generatedText),
                        'suggestions' => $this->extractSuggestions($generatedText),
                        'confidence' => 0.9,
                        'source' => 'cohere_api'
                    ];
                }
            } else {
                Log::warning('Cohere API request failed: ' . $response->status() . ' - ' . $response->body());
            }

        } catch (\Exception $e) {
            Log::error('Cohere API error: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * Construit le prompt pour l'API Cohere
     */
    protected function buildPrompt(string $message, array $context = [], array $leadData = []): string
    {
        $systemPrompt = "Tu es BRAIN AI, un assistant IA professionnel spécialisé dans l'automatisation d'entreprise, la qualification de leads et les solutions d'IA. Tu aides les entreprises à comprendre comment l'IA peut transformer leurs opérations.

Ton rôle :
- Fournir des réponses intelligentes et professionnelles sur les solutions d'automatisation IA
- Aider à qualifier les leads en comprenant leurs besoins business, budget, timeline et autorité de décision
- Offrir des conseils spécifiques et actionnables sur l'implémentation IA
- Maintenir un ton professionnel et orienté business
- Poser des questions de qualification pertinentes pour mieux comprendre les besoins clients

Domaines d'expertise clés :
- Automatisation IA et optimisation de processus
- Qualification de leads et intelligence commerciale
- Transformation de processus business
- Calcul de ROI et valeur business
- Solutions IA enterprise et intégration

Réponds toujours de manière utile et professionnelle et pose des questions de suivi pertinentes pour mieux qualifier le lead.";

        $prompt = $systemPrompt . "\n\n";
        
        // Ajouter le contexte de la conversation
        if (!empty($context)) {
            $prompt .= "Conversation précédente :\n";
            foreach ($context as $exchange) {
                // Gérer différents formats de contexte
                if (isset($exchange['user']) && isset($exchange['bot'])) {
                    $prompt .= "Utilisateur : " . $exchange['user'] . "\n";
                    $prompt .= "Assistant : " . $exchange['bot'] . "\n";
                } elseif (isset($exchange['sender']) && isset($exchange['content'])) {
                    $role = $exchange['sender'] === 'user' ? 'Utilisateur' : 'Assistant';
                    $prompt .= $role . " : " . $exchange['content'] . "\n";
                } elseif (is_string($exchange)) {
                    $prompt .= "Utilisateur : " . $exchange . "\n";
                }
            }
        }

        // Ajouter les données de qualification si disponibles
        if (!empty($leadData)) {
            $prompt .= "\nInformations de qualification :\n";
            if (!empty($leadData['role'])) $prompt .= "- Rôle : " . $leadData['role'] . "\n";
            if (!empty($leadData['budget'])) $prompt .= "- Budget : " . $leadData['budget'] . "\n";
            if (!empty($leadData['timeline'])) $prompt .= "- Timeline : " . $leadData['timeline'] . "\n";
            if (!empty($leadData['companySize'])) $prompt .= "- Taille entreprise : " . $leadData['companySize'] . "\n";
        }
        
        $prompt .= "\nUtilisateur : " . $message . "\nAssistant :";
        
        return $prompt;
    }

    /**
     * Extrait des suggestions de la réponse générée
     */
    protected function extractSuggestions(string $response): array
    {
        $suggestions = [];
        
        // Suggestions contextuelles basées sur le contenu
        if (strpos($response, 'budget') !== false || strpos($response, 'coût') !== false) {
            $suggestions[] = 'Quel est votre budget pour ce projet ?';
        }
        
        if (strpos($response, 'délai') !== false || strpos($response, 'timeline') !== false) {
            $suggestions[] = 'Dans quel délai souhaitez-vous implémenter ?';
        }
        
        if (strpos($response, 'rôle') !== false || strpos($response, 'fonction') !== false) {
            $suggestions[] = 'Quel est votre rôle dans l\'entreprise ?';
        }
        
        if (strpos($response, 'entreprise') !== false || strpos($response, 'société') !== false) {
            $suggestions[] = 'Combien d\'employés dans votre entreprise ?';
        }
        
        if (strpos($response, 'démo') !== false || strpos($response, 'démonstration') !== false) {
            $suggestions[] = 'Souhaitez-vous voir une démonstration ?';
        }
        
        if (strpos($response, 'références') !== false || strpos($response, 'clients') !== false) {
            $suggestions[] = 'Avez-vous des références clients ?';
        }
        
        // Suggestions par défaut si aucune n'est trouvée
        if (empty($suggestions)) {
            $suggestions = [
                'Parlez-moi de vos services',
                'Comment fonctionne l\'automatisation ?',
                'Avez-vous des références clients ?'
            ];
        }
        
        return array_slice($suggestions, 0, 3);
    }

    /**
     * Vérifie si l'API Cohere est disponible
     */
    public function isAvailable(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Teste la connectivité avec l'API Cohere
     */
    public function testConnection(): bool
    {
        if (!$this->apiKey) {
            return false;
        }

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ])
                ->get($this->baseUrl . '/models');

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Cohere API connection test failed: ' . $e->getMessage());
            return false;
        }
    }
} 