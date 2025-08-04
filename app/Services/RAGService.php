<?php

namespace App\Services;

use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\Log;

class RAGService
{
    protected $embeddingService;
    protected $cohereService;

    public function __construct(EmbeddingService $embeddingService, CohereService $cohereService)
    {
        $this->embeddingService = $embeddingService;
        $this->cohereService = $cohereService;
    }

    /**
     * Recherche les documents pertinents dans la base de connaissances.
     * Utilise maintenant les embeddings vectoriels en priorité, avec fallback vers mots-clés.
     */
    public function retrieveRelevantDocuments(string $query, int $limit = 3)
    {
        // 1. Essayer la recherche vectorielle d'abord
        $queryEmbedding = $this->embeddingService->generateEmbedding($query);
        
        if ($queryEmbedding) {
            Log::info('Using vector search for query: ' . substr($query, 0, 50));
            
            $vectorResults = $this->embeddingService->searchSimilar('knowledge_chunks', $queryEmbedding, $limit);
            
            if (!empty($vectorResults)) {
                Log::info('Vector search found ' . count($vectorResults) . ' results');
                return $this->processVectorResults($vectorResults);
            }
        }

        // 2. Fallback vers la recherche par mots-clés
        Log::info('Falling back to keyword search for query: ' . substr($query, 0, 50));
        return $this->keywordSearch($query, $limit);
    }

    /**
     * Traite une requête utilisateur et génère une réponse.
     * Utilise maintenant l'API Cohere en priorité avec fallback RAG.
     */
    public function processQuery(string $query, array $context = [], array $leadData = [])
    {
        try {
            // 1. Essayer l'API Cohere d'abord
            if ($this->cohereService->isAvailable()) {
                Log::info('Attempting Cohere API response for query: ' . substr($query, 0, 50));
                
                $aiResponse = $this->cohereService->generateResponse($query, $context, $leadData);
                
                if ($aiResponse && !empty($aiResponse['reply'])) {
                    Log::info('Cohere API response successful');
                    
                    return [
                        'response' => $aiResponse['reply'],
                        'confidence' => $aiResponse['confidence'],
                        'sources' => [],
                        'insights' => [],
                        'suggestions' => $aiResponse['suggestions'],
                        'source' => 'cohere_api'
                    ];
                } else {
                    Log::info('Cohere API failed, falling back to RAG');
                }
            }

            // 2. Gérer les salutations et questions de base
            $basicResponse = $this->handleBasicQueries($query);
            if ($basicResponse) {
                return $basicResponse;
            }

            // 3. Fallback vers RAG statique
            return $this->processStaticRAG($query, $context);

        } catch (\Exception $e) {
            Log::error('RAG processing error: ' . $e->getMessage());
            
            return [
                'response' => 'Désolé, je rencontre une difficulté technique. Pouvez-vous reformuler votre question ?',
                'confidence' => 0.1,
                'sources' => [],
                'insights' => [],
                'suggestions' => [
                    'Quel est votre rôle dans l\'entreprise ?',
                    'Quel est votre budget pour ce projet ?',
                    'Dans quel délai souhaitez-vous implémenter ?'
                ]
            ];
        }
    }

    /**
     * Traite les résultats de recherche vectorielle
     */
    private function processVectorResults(array $vectorResults)
    {
        return collect($vectorResults)->map(function ($result) {
            return (object) [
                'id' => $result['id'],
                'question' => $result['payload']['question'] ?? '',
                'answer' => $result['payload']['answer'] ?? '',
                'category' => $result['payload']['category'] ?? '',
                'score' => $result['score'] ?? 0.5
            ];
        });
    }

    /**
     * Recherche par mots-clés dans la base de connaissances
     */
    private function keywordSearch(string $query, int $limit)
    {
        $keywords = $this->extractKeywords($query);
        
        if (empty($keywords)) {
            return collect();
        }

        // Recherche plus flexible avec LIKE
        $query = KnowledgeBase::query();
        
        foreach ($keywords as $keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('question', 'LIKE', "%{$keyword}%")
                  ->orWhere('answer', 'LIKE', "%{$keyword}%")
                  ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }
        
        $results = $query->limit($limit)->get();
        
        Log::info('Keyword search found ' . $results->count() . ' results for keywords: ' . implode(', ', $keywords));
        
        return $results;
    }

    /**
     * Extrait les mots-clés pertinents d'une requête
     */
    private function extractKeywords(string $query): array
    {
        // Nettoyer la requête
        $query = strtolower(trim($query));
        
        // Mots-clés spécifiques au domaine
        $domainKeywords = [
            'budget', 'prix', 'coût', 'tarif', 'facturation',
            'directeur', 'manager', 'commercial', 'décideur', 'chef',
            'délai', 'temps', 'urgent', 'rapide', 'immédiat',
            'démo', 'démonstration', 'présentation', 'essai',
            'entreprise', 'société', 'pmé', 'startup',
            'ia', 'intelligence', 'artificielle', 'automatisation',
            'vente', 'commercial', 'marketing', 'lead'
        ];
        
        $keywords = [];
        
        // Chercher les mots-clés du domaine
        foreach ($domainKeywords as $keyword) {
            if (strpos($query, $keyword) !== false) {
                $keywords[] = $keyword;
            }
        }
        
        // Si aucun mot-clé spécifique trouvé, utiliser les mots communs
        if (empty($keywords)) {
            $words = preg_split('/\s+/', $query);
            $keywords = array_filter($words, function($word) {
                return strlen($word) > 2 && !in_array($word, ['est', 'sont', 'avez', 'pouvez', 'votre', 'notre']);
            });
        }
        
        return array_slice($keywords, 0, 5); // Limiter à 5 mots-clés
    }

    /**
     * Construit une réponse basée sur les documents trouvés.
     */
    private function buildResponse(string $query, $documents): string
    {
        if ($documents->count() === 1) {
            return $documents->first()->answer;
        }

        // Si plusieurs documents, prendre le plus pertinent
        $bestMatch = $documents->first();
        return $bestMatch->answer;
    }

    /**
     * Calcule le niveau de confiance de la réponse.
     */
    private function calculateConfidence(string $query, $documents): float
    {
        if ($documents->isEmpty()) {
            return 0.0;
        }

        $queryKeywords = $this->extractKeywords($query);
        $bestDocument = $documents->first();
        
        $documentText = strtolower($bestDocument->question . ' ' . $bestDocument->answer);
        $matches = 0;
        
        foreach ($queryKeywords as $keyword) {
            if (strpos($documentText, $keyword) !== false) {
                $matches++;
            }
        }
        
        return min(1.0, $matches / max(1, count($queryKeywords)));
    }

    /**
     * Extrait des insights de la requête et des documents.
     */
    private function extractInsights(string $query, $documents): array
    {
        $insights = [];
        
        // Analyser le type de question
        if (preg_match('/budget|prix|coût/i', $query)) {
            $insights[] = 'Intérêt pour l\'aspect financier';
        }
        
        if (preg_match('/délai|temps|quand/i', $query)) {
            $insights[] = 'Urgence ou planning important';
        }
        
        if (preg_match('/décision|responsable/i', $query)) {
            $insights[] = 'Pouvoir décisionnel';
        }
        
        return $insights;
    }

    /**
     * Génère des questions de suivi pertinentes basées sur le contexte.
     */
    private function generateNextQuestions(string $query, $documents): array
    {
        $questions = [];
        $query = strtolower($query);
        
        // Analyser le contexte de la conversation
        $hasRole = preg_match('/directeur|manager|commercial|chef|responsable/i', $query);
        $hasBudget = preg_match('/budget|prix|coût|tarif/i', $query);
        $hasTimeline = preg_match('/délai|temps|quand|urgent/i', $query);
        $hasCompany = preg_match('/entreprise|société|pmé|startup/i', $query);
        $hasServices = preg_match('/service|solution|produit/i', $query);
        $hasDemo = preg_match('/démo|démonstration|essai/i', $query);
        
        // Suggestions contextuelles intelligentes
        if ($hasRole && !$hasBudget) {
            $questions[] = 'Quel est votre budget pour ce projet ?';
        }
        
        if ($hasRole && !$hasTimeline) {
            $questions[] = 'Dans quel délai souhaitez-vous implémenter ?';
        }
        
        if ($hasBudget && !$hasTimeline) {
            $questions[] = 'Quel est votre délai d\'implémentation ?';
        }
        
        if ($hasServices && !$hasDemo) {
            $questions[] = 'Souhaitez-vous voir une démonstration ?';
        }
        
        if ($hasCompany && !$hasRole) {
            $questions[] = 'Quel est votre rôle dans l\'entreprise ?';
        }
        
        // Suggestions par défaut si aucune correspondance
        if (empty($questions)) {
            if (!$hasRole) {
                $questions[] = 'Quel est votre rôle dans l\'entreprise ?';
            }
            if (!$hasBudget) {
                $questions[] = 'Avez-vous un budget défini ?';
            }
            if (!$hasTimeline) {
                $questions[] = 'Quel est votre planning ?';
            }
        }
        
        // Ajouter des suggestions métier pertinentes
        if ($hasServices) {
            $questions[] = 'Avez-vous des références clients ?';
        }
        
        if ($hasBudget) {
            $questions[] = 'Quelle est la taille de votre équipe commerciale ?';
        }
        
        return array_slice($questions, 0, 3);
    }

    /**
     * Traitement RAG statique (fallback)
     */
    private function processStaticRAG(string $query, array $context = [])
    {
        // Récupérer les documents pertinents
        $documents = $this->retrieveRelevantDocuments($query);
        
        if ($documents->isEmpty()) {
            // Essayer une recherche plus large
            $documents = $this->keywordSearch($query, 5);
            
            if ($documents->isEmpty()) {
                return [
                    'response' => 'Je ne trouve pas d\'information spécifique sur votre question. Pouvez-vous reformuler ou me donner plus de détails ?',
                    'confidence' => 0.3,
                    'sources' => [],
                    'insights' => [],
                    'suggestions' => [
                        'Quel est votre rôle dans l\'entreprise ?',
                        'Quel est votre budget pour ce projet ?',
                        'Dans quel délai souhaitez-vous implémenter ?'
                    ]
                ];
            }
        }

        // Construire la réponse basée sur les documents trouvés
        $response = $this->buildResponse($query, $documents);
        $confidence = $this->calculateConfidence($query, $documents);
        $sources = $documents->pluck('id')->toArray();
        $insights = $this->extractInsights($query, $documents);
        $suggestions = $this->generateNextQuestions($query, $documents);

        return [
            'response' => $response,
            'confidence' => $confidence,
            'sources' => $sources,
            'insights' => $insights,
            'suggestions' => $suggestions,
            'source' => 'static_rag'
        ];
    }

    /**
     * Gère les requêtes de base comme les salutations
     */
    private function handleBasicQueries(string $query): ?array
    {
        $query = strtolower(trim($query));
        
        // Salutations
        $greetings = ['bonjour', 'salut', 'hello', 'hi', 'coucou', 'bonsoir'];
        foreach ($greetings as $greeting) {
            if (strpos($query, $greeting) !== false) {
                return [
                    'response' => '👋 Bonjour ! Je suis votre assistant IA Brain. Comment puis-je vous aider aujourd\'hui ?',
                    'confidence' => 1.0,
                    'sources' => [],
                    'insights' => [],
                    'suggestions' => [
                        'Parlez-moi de vos services',
                        'Comment fonctionne l\'automatisation ?',
                        'Avez-vous des références clients ?'
                    ]
                ];
            }
        }

        // Questions sur l'identité du bot
        $identityQuestions = ['qui êtes-vous', 'qui es-tu', 'que faites-vous', 'que fais-tu', 'présentez-vous'];
        foreach ($identityQuestions as $question) {
            if (strpos($query, $question) !== false) {
                return [
                    'response' => 'Je suis Brain AI, votre assistant intelligent spécialisé dans l\'automatisation des ventes et le lead qualification. Je peux vous aider à comprendre nos solutions et qualifier vos besoins.',
                    'confidence' => 1.0,
                    'sources' => [],
                    'insights' => [],
                    'suggestions' => [
                        'Quels sont vos services ?',
                        'Comment fonctionne l\'automatisation ?',
                        'Avez-vous des références clients ?'
                    ]
                ];
            }
        }

        // Questions sur l'aide
        $helpQuestions = ['aide', 'help', 'comment', 'comment faire'];
        foreach ($helpQuestions as $help) {
            if (strpos($query, $help) !== false) {
                return [
                    'response' => 'Je peux vous aider avec : nos services d\'automatisation, la qualification de vos leads, l\'estimation de budgets, les délais d\'implémentation, et bien plus encore. Que souhaitez-vous savoir ?',
                    'confidence' => 1.0,
                    'sources' => [],
                    'insights' => [],
                    'suggestions' => [
                        'Parlez-moi de vos services',
                        'Comment fonctionne l\'automatisation ?',
                        'Avez-vous des références clients ?'
                    ]
                ];
            }
        }

        // Questions sur les services
        $serviceQuestions = ['services', 'solutions', 'produits', 'parlez-moi de vos', 'que proposez-vous'];
        foreach ($serviceQuestions as $service) {
            if (strpos($query, $service) !== false) {
                return [
                    'response' => 'Nous proposons des solutions d\'intelligence artificielle pour l\'automatisation des ventes et la qualification des leads. Nos services incluent : qualification automatique des prospects, scoring en temps réel, intégration CRM, et analytics avancés.',
                    'confidence' => 1.0,
                    'sources' => [],
                    'insights' => [],
                    'suggestions' => [
                        'Comment fonctionne l\'automatisation ?',
                        'Avez-vous des références clients ?',
                        'Souhaitez-vous voir une démonstration ?'
                    ]
                ];
            }
        }

        return null; // Pas de réponse de base, continuer avec RAG
    }
} 