<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeBase;

class KnowledgeBaseSeeder extends Seeder
{
    public function run()
    {
        $knowledgeData = [
            // === QUALIFICATION BUDGET ===
            [
                'category' => 'budget',
                'question' => 'Quel est votre budget pour ce projet ?',
                'answer' => 'Pour vous proposer la solution la plus adaptée, pouvez-vous préciser votre budget ou une fourchette estimative ? Nos solutions s\'adaptent aux budgets de 5k€ à 500k€ selon vos besoins.',
                'keywords' => ['budget', 'prix', 'coût', 'tarif', 'fourchette', 'estimatif'],
                'context' => ['qualification', 'bant', 'budget'],
                'priority' => 10
            ],
            [
                'category' => 'budget',
                'question' => 'Avez-vous un budget défini ?',
                'answer' => 'Un budget défini est un excellent indicateur de votre engagement. Pouvez-vous me donner une fourchette ? Cela m\'aidera à vous proposer les solutions les plus pertinentes.',
                'keywords' => ['budget défini', 'fourchette', 'engagement', 'pertinent'],
                'context' => ['qualification', 'bant', 'budget'],
                'priority' => 9
            ],
            [
                'category' => 'budget',
                'question' => 'Budget 50000 euros',
                'answer' => 'Excellent ! Avec un budget de 50k€, nous pouvons vous proposer une solution complète incluant l\'automatisation des ventes, l\'IA conversationnelle et l\'analyse prédictive. Souhaitez-vous une démonstration personnalisée ?',
                'keywords' => ['50000', '50k', 'euros', 'solution complète', 'automatisation', 'IA'],
                'context' => ['qualification', 'bant', 'budget', 'high_value'],
                'priority' => 10
            ],

            // === QUALIFICATION AUTHORITY ===
            [
                'category' => 'authority',
                'question' => 'Quel est votre rôle dans l\'entreprise ?',
                'answer' => 'Votre rôle est crucial pour comprendre votre pouvoir décisionnel. Êtes-vous décideur final, influencer ou utilisateur ? Cela m\'aide à adapter ma proposition.',
                'keywords' => ['rôle', 'décideur', 'influenceur', 'utilisateur', 'pouvoir'],
                'context' => ['qualification', 'bant', 'authority'],
                'priority' => 10
            ],
            [
                'category' => 'authority',
                'question' => 'Êtes-vous le décideur final ?',
                'answer' => 'Parfait ! En tant que décideur final, vous pouvez prendre des décisions rapidement. Je peux vous présenter directement nos solutions et organiser une démonstration avec notre équipe commerciale.',
                'keywords' => ['décideur final', 'décision', 'rapidement', 'démonstration'],
                'context' => ['qualification', 'bant', 'authority', 'decision_maker'],
                'priority' => 10
            ],
            [
                'category' => 'authority',
                'question' => 'Directeur commercial',
                'answer' => 'Excellent ! En tant que directeur commercial, vous comprenez l\'importance de l\'automatisation des ventes. Nos solutions peuvent augmenter votre productivité de 40% et améliorer votre taux de conversion.',
                'keywords' => ['directeur commercial', 'automatisation', 'ventes', 'productivité', 'conversion'],
                'context' => ['qualification', 'bant', 'authority', 'sales_leader'],
                'priority' => 9
            ],

            // === QUALIFICATION NEED ===
            [
                'category' => 'need',
                'question' => 'Quels sont vos objectifs ?',
                'answer' => 'Comprendre vos objectifs m\'aide à vous proposer la solution idéale. Voulez-vous augmenter vos ventes, automatiser des processus, ou améliorer la qualification des leads ?',
                'keywords' => ['objectifs', 'ventes', 'automatisation', 'processus', 'qualification'],
                'context' => ['qualification', 'bant', 'need'],
                'priority' => 9
            ],
            [
                'category' => 'need',
                'question' => 'Automatiser les ventes',
                'answer' => 'Parfait ! L\'automatisation des ventes est notre spécialité. Nous proposons des solutions complètes : qualification automatique des leads, suivi CRM intelligent, et IA conversationnelle. Quel aspect vous intéresse le plus ?',
                'keywords' => ['automatisation', 'ventes', 'qualification', 'CRM', 'IA'],
                'context' => ['qualification', 'bant', 'need', 'automation'],
                'priority' => 10
            ],
            [
                'category' => 'need',
                'question' => 'Qualification des leads',
                'answer' => 'La qualification des leads est cruciale ! Notre système RAG analyse automatiquement les conversations pour identifier les prospects les plus prometteurs selon les critères BANT. Voulez-vous voir une démo ?',
                'keywords' => ['qualification', 'leads', 'RAG', 'BANT', 'prospects', 'analyse'],
                'context' => ['qualification', 'bant', 'need', 'lead_qualification'],
                'priority' => 10
            ],

            // === QUALIFICATION TIMELINE ===
            [
                'category' => 'timeline',
                'question' => 'Dans quel délai souhaitez-vous implémenter ?',
                'answer' => 'Le délai d\'implémentation est important pour planifier le projet. Avez-vous une urgence ou pouvez-vous attendre quelques semaines ? Nos solutions peuvent être déployées en 2-4 semaines.',
                'keywords' => ['délai', 'implémentation', 'urgence', 'déploiement', 'semaines'],
                'context' => ['qualification', 'bant', 'timeline'],
                'priority' => 9
            ],
            [
                'category' => 'timeline',
                'question' => 'Urgent besoin',
                'answer' => 'Je comprends l\'urgence ! Nous pouvons accélérer le déploiement en priorité. Notre équipe peut commencer dès cette semaine avec une solution de base, puis l\'enrichir progressivement. Pouvez-vous me donner plus de détails sur votre urgence ?',
                'keywords' => ['urgent', 'accélérer', 'déploiement', 'priorité', 'semaine'],
                'context' => ['qualification', 'bant', 'timeline', 'urgent'],
                'priority' => 10
            ],
            [
                'category' => 'timeline',
                'question' => '3 mois délai',
                'answer' => '3 mois est un délai confortable ! Cela nous permet de vous proposer une solution complète et personnalisée. Nous pouvons planifier une phase pilote de 2 semaines, puis un déploiement progressif. Souhaitez-vous un planning détaillé ?',
                'keywords' => ['3 mois', 'confortable', 'solution complète', 'pilote', 'planning'],
                'context' => ['qualification', 'bant', 'timeline', 'comfortable'],
                'priority' => 8
            ],

            // === SCORING ET QUALIFICATION ===
            [
                'category' => 'scoring',
                'question' => 'Comment fonctionne votre système de qualification ?',
                'answer' => 'Notre système utilise l\'IA pour analyser les conversations en temps réel et calculer un score de qualification basé sur les critères BANT (Budget, Authority, Need, Timeline). Plus le score est élevé, plus le lead est qualifié.',
                'keywords' => ['système', 'qualification', 'IA', 'analyse', 'score', 'BANT'],
                'context' => ['qualification', 'scoring', 'ai_analysis'],
                'priority' => 8
            ],
            [
                'category' => 'scoring',
                'question' => 'Score de qualification',
                'answer' => 'Le score de qualification va de 1 à 10. Score 8-10 : Lead très qualifié, contact immédiat recommandé. Score 5-7 : Lead potentiel, suivi régulier. Score 1-4 : Lead à qualifier davantage.',
                'keywords' => ['score', 'qualification', '1-10', 'très qualifié', 'potentiel'],
                'context' => ['qualification', 'scoring', 'score_explanation'],
                'priority' => 7
            ],

            // === OBJECTIONS ET RÉPONSES ===
            [
                'category' => 'objections',
                'question' => 'C\'est trop cher',
                'answer' => 'Je comprends votre préoccupation sur le prix. Nos solutions génèrent un ROI de 300% en moyenne. Un investissement de 50k€ peut générer 150k€ de revenus supplémentaires. Voulez-vous une analyse ROI personnalisée ?',
                'keywords' => ['cher', 'prix', 'ROI', 'investissement', 'revenus', 'analyse'],
                'context' => ['objections', 'pricing', 'roi'],
                'priority' => 9
            ],
            [
                'category' => 'objections',
                'question' => 'Nous avons déjà un CRM',
                'answer' => 'Excellent ! Notre solution s\'intègre parfaitement avec votre CRM existant. Nous ajoutons une couche d\'IA pour automatiser la qualification et améliorer vos processus actuels. Quelle est votre solution CRM actuelle ?',
                'keywords' => ['CRM', 'intégration', 'IA', 'automatisation', 'processus'],
                'context' => ['objections', 'integration', 'existing_crm'],
                'priority' => 8
            ],
            [
                'category' => 'objections',
                'question' => 'Nous devons réfléchir',
                'answer' => 'Bien sûr, c\'est une décision importante ! Je peux vous envoyer une proposition détaillée et organiser une démonstration avec votre équipe. Quand seriez-vous disponible pour en discuter plus en détail ?',
                'keywords' => ['réfléchir', 'proposition', 'démonstration', 'équipe', 'disponible'],
                'context' => ['objections', 'consideration', 'follow_up'],
                'priority' => 7
            ],

            // === DÉMONSTRATION ET SUIVI ===
            [
                'category' => 'demo',
                'question' => 'Pouvez-vous faire une démonstration ?',
                'answer' => 'Absolument ! Je peux organiser une démonstration personnalisée avec notre équipe technique. Nous adaptons la démo à vos besoins spécifiques. Quel créneau vous conviendrait cette semaine ?',
                'keywords' => ['démonstration', 'personnalisée', 'équipe technique', 'créneau'],
                'context' => ['demo', 'follow_up', 'conversion'],
                'priority' => 9
            ],
            [
                'category' => 'demo',
                'question' => 'Quand pouvez-vous présenter ?',
                'answer' => 'Je peux organiser une présentation dès cette semaine ! Nous proposons des créneaux de 30 minutes adaptés à votre planning. Préférez-vous un créneau matin ou après-midi ?',
                'keywords' => ['présentation', 'cette semaine', 'créneaux', 'planning'],
                'context' => ['demo', 'scheduling', 'conversion'],
                'priority' => 8
            ],

            // === INFORMATIONS ENTREPRISE ===
            [
                'category' => 'company',
                'question' => 'Combien d\'employés dans votre entreprise ?',
                'answer' => 'La taille de votre entreprise m\'aide à adapter nos solutions. Nous proposons des packages adaptés aux PME (10-100 employés) et aux grandes entreprises (100+ employés). Quelle est votre taille actuelle ?',
                'keywords' => ['employés', 'taille', 'PME', 'grandes entreprises', 'packages'],
                'context' => ['qualification', 'company_size', 'packaging'],
                'priority' => 8
            ],
            [
                'category' => 'company',
                'question' => 'Secteur d\'activité',
                'answer' => 'Votre secteur d\'activité est important pour personnaliser nos solutions. Nous avons des expériences dans l\'agroalimentaire, l\'immobilier, la communication et bien d\'autres. Dans quel secteur évoluez-vous ?',
                'keywords' => ['secteur', 'activité', 'agroalimentaire', 'immobilier', 'communication'],
                'context' => ['qualification', 'industry', 'personalization'],
                'priority' => 7
            ],

            // === SERVICES AGROALIMENTAIRE ===
            [
                'category' => 'agroalimentaire',
                'question' => 'Traçabilité blockchain agroalimentaire',
                'answer' => 'Notre solution de traçabilité blockchain offre un suivi complet de vos produits alimentaires de la ferme à l\'assiette. Avec des enregistrements immuables, un monitoring en temps réel, et une transparence totale, vous garantissez la qualité et la sécurité alimentaire.',
                'keywords' => ['blockchain', 'traçabilité', 'alimentaire', 'ferme', 'assiette', 'immuable', 'monitoring', 'qualité'],
                'context' => ['agroalimentaire', 'blockchain', 'traceability', 'food_safety'],
                'priority' => 9
            ],
            [
                'category' => 'agroalimentaire',
                'question' => 'IA qualité alimentaire',
                'answer' => 'Notre système d\'IA pour le contrôle qualité utilise la vision par ordinateur pour détecter automatiquement les défauts, prédire la maintenance des équipements et assurer la conformité réglementaire. Précision de 99.9% et zéro défaut garanti.',
                'keywords' => ['IA', 'qualité', 'vision ordinateur', 'défauts', 'maintenance prédictive', 'conformité', 'précision'],
                'context' => ['agroalimentaire', 'ai_quality', 'computer_vision', 'predictive_maintenance'],
                'priority' => 9
            ],
            [
                'category' => 'agroalimentaire',
                'question' => 'Optimisation logistique alimentaire',
                'answer' => 'Notre IA d\'optimisation logistique améliore votre chaîne d\'approvisionnement avec la planification des itinéraires, la gestion des stocks et la prévision de la demande pour les produits périssables. +40% d\'efficacité, -30% de gaspillage.',
                'keywords' => ['logistique', 'chaîne approvisionnement', 'itinéraires', 'stocks', 'prévision', 'périssables', 'efficacité'],
                'context' => ['agroalimentaire', 'logistics', 'supply_chain', 'route_optimization'],
                'priority' => 8
            ],
            [
                'category' => 'agroalimentaire',
                'question' => 'Certification automatisée alimentaire',
                'answer' => 'Automatisez vos processus de certification avec notre système intelligent. Conformité réglementaire automatique, génération de pistes d\'audit, surveillance en temps réel et automatisation documentaire pour une certification 100% complète.',
                'keywords' => ['certification', 'automatisation', 'conformité', 'audit', 'surveillance', 'documentation', 'réglementaire'],
                'context' => ['agroalimentaire', 'certification', 'compliance', 'automation'],
                'priority' => 8
            ],

            // === SERVICES COMMUNICATION ===
            [
                'category' => 'communication',
                'question' => 'Chatbot multilingue IA',
                'answer' => 'Notre chatbot IA intelligent supporte plus de 50 langues avec une disponibilité 24/7. Compréhension contextuelle avancée, intégration API native et réponses instantanées contextuelles. Précision de 99.9% et support multicanal.',
                'keywords' => ['chatbot', 'multilingue', '50 langues', '24/7', 'contextuel', 'API', 'précision', 'multicanal'],
                'context' => ['communication', 'chatbot', 'multilingual', 'ai_assistant'],
                'priority' => 10
            ],
            [
                'category' => 'communication',
                'question' => 'Génération contenu IA',
                'answer' => 'Créez automatiquement du contenu engageant avec notre IA générative : posts réseaux sociaux, articles SEO, newsletters et optimisation de contenu. Économisez +70% de temps et augmentez l\'engagement de +300%.',
                'keywords' => ['génération', 'contenu', 'posts', 'réseaux sociaux', 'SEO', 'newsletters', 'optimisation', 'engagement'],
                'context' => ['communication', 'content_generation', 'social_media', 'seo'],
                'priority' => 9
            ],
            [
                'category' => 'communication',
                'question' => 'Analytics prédictives marketing',
                'answer' => 'Anticipez les tendances du marché et optimisez automatiquement vos campagnes avec notre IA prédictive. Prédiction de tendances avancée, optimisation automatique et alertes intelligentes. 95% de précision et ROI moyen de 247%.',
                'keywords' => ['analytics', 'prédictives', 'tendances', 'campagnes', 'optimisation', 'alertes', 'ROI', 'précision'],
                'context' => ['communication', 'predictive_analytics', 'marketing_optimization', 'roi'],
                'priority' => 9
            ],
            [
                'category' => 'communication',
                'question' => 'Automatisation marketing',
                'answer' => 'Automatisez vos processus marketing et libérez votre équipe pour les initiatives stratégiques. Conception de workflows intelligents, gestion automatique des campagnes, qualification intelligente des leads. -80% de tâches manuelles, 3x plus efficace.',
                'keywords' => ['automatisation', 'marketing', 'workflows', 'campagnes', 'leads', 'qualification', 'efficacité', 'stratégique'],
                'context' => ['communication', 'marketing_automation', 'workflow_design', 'lead_qualification'],
                'priority' => 8
            ],

            // === SERVICES IMMOBILIER ===
            [
                'category' => 'immobilier',
                'question' => 'Promotion immobilière IA',
                'answer' => 'Notre solution de promotion immobilière intelligente offre une analyse de marché automatisée, des recommandations personnalisées et des stratégies de prix prédictives. Intégration de visites virtuelles. +45% d\'augmentation des ventes, -30% de temps.',
                'keywords' => ['promotion', 'immobilier', 'analyse marché', 'recommandations', 'prix prédictifs', 'visites virtuelles', 'ventes'],
                'context' => ['immobilier', 'property_promotion', 'market_analysis', 'virtual_tours'],
                'priority' => 9
            ],
            [
                'category' => 'immobilier',
                'question' => 'Conciergerie intelligente',
                'answer' => 'Services de conciergerie premium enrichis par l\'IA avec assistance personnalisée, planification de maintenance et optimisation de la satisfaction locataire. Support 24/7, services personnalisés et surveillance de satisfaction. 98% de satisfaction client.',
                'keywords' => ['conciergerie', 'premium', 'assistance', 'maintenance', 'satisfaction', 'locataire', 'personnalisé', '24/7'],
                'context' => ['immobilier', 'concierge_services', 'tenant_satisfaction', 'maintenance'],
                'priority' => 8
            ],
            [
                'category' => 'immobilier',
                'question' => 'Gestion locative IA',
                'answer' => 'Automatisez votre gestion locative avec le screening intelligent des locataires, l\'optimisation de la collecte des loyers et le suivi de la maintenance. IA de sélection, automatisation des encaissements et reporting financier. +60% d\'efficacité, -40% de vacance.',
                'keywords' => ['gestion locative', 'screening', 'locataires', 'loyers', 'maintenance', 'automatisation', 'reporting', 'efficacité'],
                'context' => ['immobilier', 'rental_management', 'tenant_screening', 'rent_collection'],
                'priority' => 9
            ],
            [
                'category' => 'immobilier',
                'question' => 'Investissement prédictif immobilier',
                'answer' => 'Analyse d\'investissement immobilier powered by IA avec prédiction des tendances du marché, évaluation des risques et optimisation de portefeuille. Prédiction des tendances, IA d\'évaluation des risques et prévision de ROI. +85% de précision, +200% de ROI.',
                'keywords' => ['investissement', 'prédictif', 'tendances marché', 'risques', 'portefeuille', 'ROI', 'évaluation', 'précision'],
                'context' => ['immobilier', 'predictive_investment', 'market_trends', 'risk_assessment'],
                'priority' => 9
            ],

            // === CAPACITÉS TECHNIQUES ===
            [
                'category' => 'technical',
                'question' => 'Architecture technique BrainGenTech',
                'answer' => 'Notre architecture microservices utilise Laravel (frontend), Python FastAPI (IA), Qdrant (base vectorielle), et Cohere LLM. Déploiement Docker, monitoring Prometheus/Grafana, et intégration API native pour une performance optimale.',
                'keywords' => ['architecture', 'microservices', 'Laravel', 'Python', 'FastAPI', 'Qdrant', 'Cohere', 'Docker', 'API'],
                'context' => ['technical', 'architecture', 'microservices', 'deployment'],
                'priority' => 7
            ],
            [
                'category' => 'technical',
                'question' => 'Stack technologique IA',
                'answer' => 'Notre stack IA comprend LangChain pour l\'orchestration, Cohere pour les LLM multilingues, Qdrant pour la recherche vectorielle, et des outils personnalisés pour la qualification des leads BANT. Support 50+ langues avec embeddings multilingues.',
                'keywords' => ['stack', 'IA', 'LangChain', 'Cohere', 'multilingue', 'vectorielle', 'BANT', 'embeddings'],
                'context' => ['technical', 'ai_stack', 'langchain', 'multilingual'],
                'priority' => 7
            ],
            [
                'category' => 'technical',
                'question' => 'Intégrations API disponibles',
                'answer' => 'Nous proposons des intégrations natives avec CRM (Salesforce, HubSpot), plateformes marketing (Mailchimp, Klaviyo), outils business (Slack, Teams), et APIs personnalisées. Documentation complète et support technique inclus.',
                'keywords' => ['intégrations', 'API', 'CRM', 'Salesforce', 'HubSpot', 'marketing', 'Slack', 'Teams', 'documentation'],
                'context' => ['technical', 'integrations', 'crm', 'marketing_platforms'],
                'priority' => 8
            ],

            // === CAS D\'USAGE SPÉCIFIQUES ===
            [
                'category' => 'use_cases',
                'question' => 'ROI solutions BrainGenTech',
                'answer' => 'Nos clients obtiennent en moyenne : +300% de ROI en 6 mois, +70% de temps économisé, +40% d\'augmentation des ventes, -80% de tâches manuelles, et 99.9% de disponibilité système. Garantie de performance ou remboursement.',
                'keywords' => ['ROI', '300%', 'temps économisé', 'ventes', 'tâches manuelles', 'disponibilité', 'garantie', 'performance'],
                'context' => ['use_cases', 'roi', 'performance_metrics', 'guarantee'],
                'priority' => 10
            ],
            [
                'category' => 'use_cases',
                'question' => 'Success stories clients',
                'answer' => 'Nos success stories incluent : une PME agroalimentaire qui a réduit ses coûts de 40% avec notre traçabilité blockchain, une agence immobilière qui a doublé ses ventes avec l\'IA prédictive, et une agence de communication qui a triplé son efficacité avec l\'automatisation.',
                'keywords' => ['success stories', 'PME', 'agroalimentaire', 'coûts', 'immobilière', 'ventes doublées', 'communication', 'efficacité'],
                'context' => ['use_cases', 'success_stories', 'case_studies', 'results'],
                'priority' => 9
            ],
            [
                'category' => 'use_cases',
                'question' => 'Déploiement et formation',
                'answer' => 'Déploiement en 2-4 semaines avec formation complète incluse. Phase pilote de 2 semaines, déploiement progressif, formation utilisateurs, support 24/7, et accompagnement change management. 100% de nos clients sont opérationnels en moins d\'un mois.',
                'keywords' => ['déploiement', '2-4 semaines', 'formation', 'pilote', 'progressif', 'support 24/7', 'change management', 'opérationnel'],
                'context' => ['use_cases', 'deployment', 'training', 'support'],
                'priority' => 8
            ],

            // === PRICING ET PACKAGES ===
            [
                'category' => 'pricing',
                'question' => 'Tarification solutions BrainGenTech',
                'answer' => 'Nos packages s\'adaptent à tous les budgets : Starter (5-15k€) pour PME, Professional (15-50k€) pour entreprises moyennes, Enterprise (50k€+) pour grandes organisations. Tous incluent formation, support et garantie ROI.',
                'keywords' => ['tarification', 'packages', 'Starter', '5-15k', 'Professional', '15-50k', 'Enterprise', '50k+', 'formation', 'support'],
                'context' => ['pricing', 'packages', 'pricing_tiers', 'roi_guarantee'],
                'priority' => 10
            ],
            [
                'category' => 'pricing',
                'question' => 'Financement et ROI',
                'answer' => 'Financement disponible avec paiement étalé sur 12-36 mois. ROI garanti dans les 6 mois ou remboursement partiel. Nos solutions se paient d\'elles-mêmes grâce aux économies générées et à l\'augmentation de productivité.',
                'keywords' => ['financement', 'paiement étalé', '12-36 mois', 'ROI garanti', '6 mois', 'remboursement', 'économies', 'productivité'],
                'context' => ['pricing', 'financing', 'roi_guarantee', 'payment_plans'],
                'priority' => 9
            ]
        ];

        foreach ($knowledgeData as $data) {
            KnowledgeBase::create($data);
        }

        $this->command->info('✅ Base de connaissances enrichie avec ' . count($knowledgeData) . ' entrées complètes : qualification BANT, services (agroalimentaire, communication, immobilier), capacités techniques, cas d\'usage et tarification');
    }
} 