<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LeadQualificationService
{
    protected $ragService;

    public function __construct(RAGService $ragService)
    {
        $this->ragService = $ragService;
    }

    /**
     * Met à jour les données du lead avec les informations de qualification
     */
    public function updateLeadData(array &$leadData, array $qualification): void
    {
        // Mise à jour des scores BANT
        if (isset($qualification['bant_score'])) {
            $leadData['bant_scores'] = $qualification['bant_score'];
        }

        // Mise à jour du score global
        if (isset($qualification['overall_score'])) {
            $leadData['overall_score'] = $qualification['overall_score'];
        }

        // Mise à jour de la catégorie
        if (isset($qualification['category'])) {
            $leadData['category'] = $qualification['category'];
        }

        // Mise à jour du niveau de confiance
        if (isset($qualification['confidence'])) {
            $leadData['confidence'] = $qualification['confidence'];
        }

        // Mise à jour des insights
        if (isset($qualification['insights'])) {
            $leadData['insights'] = $qualification['insights'];
        }

        // Mise à jour des recommandations
        if (isset($qualification['recommendations'])) {
            $leadData['recommendations'] = $qualification['recommendations'];
        }

        // Mise à jour des actions suivantes
        if (isset($qualification['next_actions'])) {
            $leadData['next_actions'] = $qualification['next_actions'];
        }

        // Timestamp de la dernière qualification
        $leadData['last_qualified_at'] = now()->toISOString();

        Log::info('Lead data updated with qualification', [
            'overall_score' => $leadData['overall_score'] ?? null,
            'category' => $leadData['category'] ?? null,
            'confidence' => $leadData['confidence'] ?? null
        ]);
    }

    /**
     * Qualifie automatiquement un lead basé sur la conversation
     */
    public function qualifyLead(array $conversation, array $leadData = []): array
    {
        $qualification = [
            'bant_score' => $this->calculateBANTScore($conversation, $leadData),
            'overall_score' => 0,
            'category' => 'unqualified',
            'confidence' => 0,
            'insights' => [],
            'recommendations' => [],
            'next_actions' => []
        ];

        // Calcul du score global
        $qualification['overall_score'] = $this->calculateOverallScore($qualification['bant_score']);
        
        // Catégorisation
        $qualification['category'] = $this->categorizeLead($qualification['overall_score']);
        
        // Niveau de confiance
        $qualification['confidence'] = $this->calculateConfidence($conversation);
        
        // Insights et recommandations
        $qualification['insights'] = $this->extractInsights($conversation, $qualification['bant_score']);
        $qualification['recommendations'] = $this->generateRecommendations($qualification);
        $qualification['next_actions'] = $this->suggestNextActions($qualification);

        return $qualification;
    }

    /**
     * Calcule le score BANT (Budget, Authority, Need, Timeline)
     */
    private function calculateBANTScore(array $conversation, array $leadData): array
    {
        $bant = [
            'budget' => ['score' => 0, 'confidence' => 0, 'details' => []],
            'authority' => ['score' => 0, 'confidence' => 0, 'details' => []],
            'need' => ['score' => 0, 'confidence' => 0, 'details' => []],
            'timeline' => ['score' => 0, 'confidence' => 0, 'details' => []]
        ];

        $conversationText = $this->extractConversationText($conversation);

        // Analyse BUDGET
        $bant['budget'] = $this->analyzeBudget($conversationText, $leadData);
        
        // Analyse AUTHORITY
        $bant['authority'] = $this->analyzeAuthority($conversationText, $leadData);
        
        // Analyse NEED
        $bant['need'] = $this->analyzeNeed($conversationText, $leadData);
        
        // Analyse TIMELINE
        $bant['timeline'] = $this->analyzeTimeline($conversationText, $leadData);

        return $bant;
    }

    /**
     * Analyse le budget
     */
    private function analyzeBudget(string $text, array $leadData): array
    {
        $score = 0;
        $confidence = 0;
        $details = [];

        $lowerText = strtolower($text);

        // Détection de budget spécifique
        if (preg_match('/(\d+)\s*(k|m|euros?|€)/i', $text, $matches)) {
            $amount = (int)$matches[1];
            $unit = strtolower($matches[2]);
            
            if ($unit === 'k' || $unit === 'euros' || $unit === 'euro' || $unit === '€') {
                $amount = $amount * 1000;
            } elseif ($unit === 'm') {
                $amount = $amount * 1000000;
            }

            if ($amount >= 50000) {
                $score = 10;
                $confidence = 0.9;
                $details[] = "Budget élevé détecté: {$amount}€";
            } elseif ($amount >= 20000) {
                $score = 7;
                $confidence = 0.8;
                $details[] = "Budget moyen détecté: {$amount}€";
            } elseif ($amount >= 5000) {
                $score = 5;
                $confidence = 0.7;
                $details[] = "Budget bas détecté: {$amount}€";
            } else {
                $score = 2;
                $confidence = 0.6;
                $details[] = "Budget très bas détecté: {$amount}€";
            }
        }

        // Détection de fourchette de budget
        if (preg_match('/(\d+)\s*-\s*(\d+)\s*(k|m|euros?|€)/i', $text, $matches)) {
            $min = (int)$matches[1];
            $max = (int)$matches[2];
            $score = 6;
            $confidence = 0.7;
            $details[] = "Fourchette de budget: {$min}-{$max}€";
        }

        // Détection de budget défini
        if (preg_match('/budget\s+défini|budget\s+alloué|budget\s+prévu/i', $text)) {
            $score = max($score, 6);
            $confidence = max($confidence, 0.6);
            $details[] = "Budget défini mentionné";
        }

        // Détection d'absence de budget
        if (preg_match('/pas\s+de\s+budget|budget\s+limite|budget\s+serre/i', $text)) {
            $score = 1;
            $confidence = 0.8;
            $details[] = "Budget limité ou absent";
        }

        return [
            'score' => min($score, 10),
            'confidence' => min($confidence, 1.0),
            'details' => $details
        ];
    }

    /**
     * Analyse l'autorité décisionnelle
     */
    private function analyzeAuthority(string $text, array $leadData): array
    {
        $score = 0;
        $confidence = 0;
        $details = [];

        $lowerText = strtolower($text);

        // Rôles décisionnels
        $decisionRoles = [
            'directeur' => 10,
            'manager' => 8,
            'chef' => 8,
            'président' => 10,
            'pdg' => 10,
            'ceo' => 10,
            'cfo' => 9,
            'cto' => 9,
            'responsable' => 7
        ];

        foreach ($decisionRoles as $role => $roleScore) {
            if (preg_match("/\b{$role}\b/i", $text)) {
                $score = max($score, $roleScore);
                $confidence = 0.8;
                $details[] = "Rôle décisionnel détecté: {$role}";
                break;
            }
        }

        // Indicateurs de pouvoir décisionnel
        if (preg_match('/décideur\s+final|pouvoir\s+décisionnel|prendre\s+la\s+décision/i', $text)) {
            $score = max($score, 9);
            $confidence = max($confidence, 0.9);
            $details[] = "Pouvoir décisionnel confirmé";
        }

        // Indicateurs d'influenceur
        if (preg_match('/influenceur|recommandation|conseil/i', $text)) {
            $score = max($score, 6);
            $confidence = max($confidence, 0.7);
            $details[] = "Rôle d'influenceur détecté";
        }

        // Indicateurs d'utilisateur final
        if (preg_match('/utilisateur|opérateur|technicien/i', $text)) {
            $score = max($score, 3);
            $confidence = max($confidence, 0.6);
            $details[] = "Utilisateur final détecté";
        }

        return [
            'score' => min($score, 10),
            'confidence' => min($confidence, 1.0),
            'details' => $details
        ];
    }

    /**
     * Analyse le besoin
     */
    private function analyzeNeed(string $text, array $leadData): array
    {
        $score = 0;
        $confidence = 0;
        $details = [];

        $lowerText = strtolower($text);

        // Besoins critiques
        $criticalNeeds = [
            'automatisation' => 9,
            'qualification' => 8,
            'productivité' => 7,
            'efficacité' => 7,
            'optimisation' => 7,
            'croissance' => 8,
            'ventes' => 8,
            'leads' => 9
        ];

        foreach ($criticalNeeds as $need => $needScore) {
            if (preg_match("/\b{$need}\b/i", $text)) {
                $score = max($score, $needScore);
                $confidence = 0.8;
                $details[] = "Besoin critique détecté: {$need}";
            }
        }

        // Urgence
        if (preg_match('/urgent|immédiat|rapidement|dès\s+que\s+possible/i', $text)) {
            $score = max($score, 9);
            $confidence = max($confidence, 0.9);
            $details[] = "Urgence détectée";
        }

        // Problèmes actuels
        if (preg_match('/problème|difficulté|défi|challenge/i', $text)) {
            $score = max($score, 7);
            $confidence = max($confidence, 0.7);
            $details[] = "Problèmes actuels mentionnés";
        }

        // Objectifs business
        if (preg_match('/objectif|but|cible|résultat/i', $text)) {
            $score = max($score, 6);
            $confidence = max($confidence, 0.6);
            $details[] = "Objectifs business mentionnés";
        }

        return [
            'score' => min($score, 10),
            'confidence' => min($confidence, 1.0),
            'details' => $details
        ];
    }

    /**
     * Analyse le délai
     */
    private function analyzeTimeline(string $text, array $leadData): array
    {
        $score = 0;
        $confidence = 0;
        $details = [];

        $lowerText = strtolower($text);

        // Délais urgents
        if (preg_match('/urgent|immédiat|dès\s+que\s+possible|cette\s+semaine/i', $text)) {
            $score = 10;
            $confidence = 0.9;
            $details[] = "Délai urgent détecté";
        }

        // Délais courts
        if (preg_match('/(\d+)\s*(semaine|mois).*implément/i', $text, $matches)) {
            $time = (int)$matches[1];
            $unit = $matches[2];
            
            if ($unit === 'semaine' && $time <= 4) {
                $score = 8;
                $confidence = 0.8;
                $details[] = "Délai court: {$time} semaines";
            } elseif ($unit === 'mois' && $time <= 3) {
                $score = 7;
                $confidence = 0.7;
                $details[] = "Délai moyen: {$time} mois";
            }
        }

        // Délais longs
        if (preg_match('/(\d+)\s*mois.*implément/i', $text, $matches)) {
            $time = (int)$matches[1];
            if ($time > 6) {
                $score = 3;
                $confidence = 0.6;
                $details[] = "Délai long: {$time} mois";
            }
        }

        // Pas de délai défini
        if (preg_match('/pas\s+de\s+délai|pas\s+pressé|pas\s+urgent/i', $text)) {
            $score = 2;
            $confidence = 0.7;
            $details[] = "Aucun délai défini";
        }

        return [
            'score' => min($score, 10),
            'confidence' => min($confidence, 1.0),
            'details' => $details
        ];
    }

    /**
     * Calcule le score global
     */
    private function calculateOverallScore(array $bantScore): float
    {
        $weights = [
            'budget' => 0.3,
            'authority' => 0.25,
            'need' => 0.25,
            'timeline' => 0.2
        ];

        $overallScore = 0;
        foreach ($weights as $criterion => $weight) {
            $overallScore += $bantScore[$criterion]['score'] * $weight;
        }

        return round($overallScore, 1);
    }

    /**
     * Catégorise le lead
     */
    private function categorizeLead(float $score): string
    {
        if ($score >= 8.0) return 'hot_lead';
        if ($score >= 6.0) return 'warm_lead';
        if ($score >= 4.0) return 'qualified_lead';
        return 'unqualified_lead';
    }

    /**
     * Calcule le niveau de confiance
     */
    private function calculateConfidence(array $conversation): float
    {
        $messageCount = count($conversation);
        $confidence = min($messageCount * 0.1, 0.9); // Plus de messages = plus de confiance
        
        return round($confidence, 2);
    }

    /**
     * Extrait les insights
     */
    private function extractInsights(array $conversation, array $bantScore): array
    {
        $insights = [];

        // Insights sur le budget
        if ($bantScore['budget']['score'] >= 7) {
            $insights[] = "Budget bien défini - Lead à forte valeur";
        } elseif ($bantScore['budget']['score'] <= 3) {
            $insights[] = "Budget limité - Nécessite une approche différente";
        }

        // Insights sur l'autorité
        if ($bantScore['authority']['score'] >= 8) {
            $insights[] = "Décideur identifié - Contact direct possible";
        } elseif ($bantScore['authority']['score'] <= 4) {
            $insights[] = "Utilisateur final - Nécessite approbation hiérarchique";
        }

        // Insights sur le besoin
        if ($bantScore['need']['score'] >= 8) {
            $insights[] = "Besoin critique identifié - Opportunité immédiate";
        }

        // Insights sur le délai
        if ($bantScore['timeline']['score'] >= 8) {
            $insights[] = "Délai urgent - Action rapide requise";
        }

        return $insights;
    }

    /**
     * Génère des recommandations
     */
    private function generateRecommendations(array $qualification): array
    {
        $recommendations = [];

        if ($qualification['category'] === 'hot_lead') {
            $recommendations[] = "Contact immédiat recommandé";
            $recommendations[] = "Préparer une proposition personnalisée";
            $recommendations[] = "Organiser une démonstration technique";
        } elseif ($qualification['category'] === 'warm_lead') {
            $recommendations[] = "Suivi régulier (2-3 fois par semaine)";
            $recommendations[] = "Enrichir les informations manquantes";
            $recommendations[] = "Présenter des cas d'usage pertinents";
        } elseif ($qualification['category'] === 'qualified_lead') {
            $recommendations[] = "Nurturing sur le long terme";
            $recommendations[] = "Contenu éducatif et démonstrations";
            $recommendations[] = "Suivi mensuel";
        } else {
            $recommendations[] = "Qualification supplémentaire nécessaire";
            $recommendations[] = "Contenu de sensibilisation";
            $recommendations[] = "Suivi trimestriel";
        }

        return $recommendations;
    }

    /**
     * Suggère les prochaines actions
     */
    private function suggestNextActions(array $qualification): array
    {
        $actions = [];

        if ($qualification['category'] === 'hot_lead') {
            $actions[] = "Appel téléphonique immédiat";
            $actions[] = "Envoi de proposition commerciale";
            $actions[] = "Démonstration technique";
        } elseif ($qualification['category'] === 'warm_lead') {
            $actions[] = "Email de suivi personnalisé";
            $actions[] = "Webinaire ou démonstration";
            $actions[] = "Appel de qualification";
        } else {
            $actions[] = "Email de nurturing";
            $actions[] = "Contenu éducatif";
            $actions[] = "Suivi automatisé";
        }

        return $actions;
    }

    /**
     * Extrait le texte de la conversation
     */
    private function extractConversationText(array $conversation): string
    {
        $text = '';
        foreach ($conversation as $message) {
            if (isset($message['content'])) {
                $text .= ' ' . $message['content'];
            }
        }
        return trim($text);
    }
} 