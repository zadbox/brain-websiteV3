#!/usr/bin/env python3
"""
Script to add knowledge base data to the vector store
"""

import os
import sys
import requests
import json
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

# Knowledge base data from the Laravel seeder
KNOWLEDGE_DATA = [
    # === QUALIFICATION BUDGET ===
    {
        "text": "Quel est votre budget pour ce projet ? Pour vous proposer la solution la plus adaptée, pouvez-vous préciser votre budget ou une fourchette estimative ? Nos solutions s'adaptent aux budgets de 5k€ à 500k€ selon vos besoins.",
        "metadata": {"category": "budget", "keywords": ["budget", "prix", "coût", "tarif", "fourchette", "estimatif"], "context": ["qualification", "bant", "budget"], "priority": 10}
    },
    {
        "text": "Avez-vous un budget défini ? Un budget défini est un excellent indicateur de votre engagement. Pouvez-vous me donner une fourchette ? Cela m'aidera à vous proposer les solutions les plus pertinentes.",
        "metadata": {"category": "budget", "keywords": ["budget défini", "fourchette", "engagement", "pertinent"], "context": ["qualification", "bant", "budget"], "priority": 9}
    },
    {
        "text": "Budget 50000 euros. Excellent ! Avec un budget de 50k€, nous pouvons vous proposer une solution complète incluant l'automatisation des ventes, l'IA conversationnelle et l'analyse prédictive. Souhaitez-vous une démonstration personnalisée ?",
        "metadata": {"category": "budget", "keywords": ["50000", "50k", "euros", "solution complète", "automatisation", "IA"], "context": ["qualification", "bant", "budget", "high_value"], "priority": 10}
    },

    # === QUALIFICATION AUTHORITY ===
    {
        "text": "Quel est votre rôle dans l'entreprise ? Votre rôle est crucial pour comprendre votre pouvoir décisionnel. Êtes-vous décideur final, influencer ou utilisateur ? Cela m'aide à adapter ma proposition.",
        "metadata": {"category": "authority", "keywords": ["rôle", "décideur", "influenceur", "utilisateur", "pouvoir"], "context": ["qualification", "bant", "authority"], "priority": 10}
    },
    {
        "text": "Êtes-vous le décideur final ? Parfait ! En tant que décideur final, vous pouvez prendre des décisions rapidement. Je peux vous présenter directement nos solutions et organiser une démonstration avec notre équipe commerciale.",
        "metadata": {"category": "authority", "keywords": ["décideur final", "décision", "rapidement", "démonstration"], "context": ["qualification", "bant", "authority", "decision_maker"], "priority": 10}
    },
    {
        "text": "Directeur commercial. Excellent ! En tant que directeur commercial, vous comprenez l'importance de l'automatisation des ventes. Nos solutions peuvent augmenter votre productivité de 40% et améliorer votre taux de conversion.",
        "metadata": {"category": "authority", "keywords": ["directeur commercial", "automatisation", "ventes", "productivité", "conversion"], "context": ["qualification", "bant", "authority", "sales_leader"], "priority": 9}
    },

    # === QUALIFICATION NEED ===
    {
        "text": "Quels sont vos objectifs ? Comprendre vos objectifs m'aide à vous proposer la solution idéale. Voulez-vous augmenter vos ventes, automatiser des processus, ou améliorer la qualification des leads ?",
        "metadata": {"category": "need", "keywords": ["objectifs", "ventes", "automatisation", "processus", "qualification"], "context": ["qualification", "bant", "need"], "priority": 9}
    },
    {
        "text": "Automatiser les ventes. Parfait ! L'automatisation des ventes est notre spécialité. Nous proposons des solutions complètes : qualification automatique des leads, suivi CRM intelligent, et IA conversationnelle. Quel aspect vous intéresse le plus ?",
        "metadata": {"category": "need", "keywords": ["automatisation", "ventes", "qualification", "CRM", "IA"], "context": ["qualification", "bant", "need", "automation"], "priority": 10}
    },
    {
        "text": "Qualification des leads. La qualification des leads est cruciale ! Notre système RAG analyse automatiquement les conversations pour identifier les prospects les plus prometteurs selon les critères BANT. Voulez-vous voir une démo ?",
        "metadata": {"category": "need", "keywords": ["qualification", "leads", "RAG", "BANT", "prospects", "analyse"], "context": ["qualification", "bant", "need", "lead_qualification"], "priority": 10}
    },

    # === QUALIFICATION TIMELINE ===
    {
        "text": "Dans quel délai souhaitez-vous implémenter ? Le délai d'implémentation est important pour planifier le projet. Avez-vous une urgence ou pouvez-vous attendre quelques semaines ? Nos solutions peuvent être déployées en 2-4 semaines.",
        "metadata": {"category": "timeline", "keywords": ["délai", "implémentation", "urgence", "déploiement", "semaines"], "context": ["qualification", "bant", "timeline"], "priority": 9}
    },
    {
        "text": "Urgent besoin. Je comprends l'urgence ! Nous pouvons accélérer le déploiement en priorité. Notre équipe peut commencer dès cette semaine avec une solution de base, puis l'enrichir progressivement. Pouvez-vous me donner plus de détails sur votre urgence ?",
        "metadata": {"category": "timeline", "keywords": ["urgent", "accélérer", "déploiement", "priorité", "semaine"], "context": ["qualification", "bant", "timeline", "urgent"], "priority": 10}
    },
    {
        "text": "3 mois délai. 3 mois est un délai confortable ! Cela nous permet de vous proposer une solution complète et personnalisée. Nous pouvons planifier une phase pilote de 2 semaines, puis un déploiement progressif. Souhaitez-vous un planning détaillé ?",
        "metadata": {"category": "timeline", "keywords": ["3 mois", "confortable", "solution complète", "pilote", "planning"], "context": ["qualification", "bant", "timeline", "comfortable"], "priority": 8}
    },

    # === SCORING ET QUALIFICATION ===
    {
        "text": "Comment fonctionne votre système de qualification ? Notre système utilise l'IA pour analyser les conversations en temps réel et calculer un score de qualification basé sur les critères BANT (Budget, Authority, Need, Timeline). Plus le score est élevé, plus le lead est qualifié.",
        "metadata": {"category": "scoring", "keywords": ["système", "qualification", "IA", "analyse", "score", "BANT"], "context": ["qualification", "scoring", "ai_analysis"], "priority": 8}
    },
    {
        "text": "Score de qualification. Le score de qualification va de 1 à 10. Score 8-10 : Lead très qualifié, contact immédiat recommandé. Score 5-7 : Lead potentiel, suivi régulier. Score 1-4 : Lead à qualifier davantage.",
        "metadata": {"category": "scoring", "keywords": ["score", "qualification", "1-10", "très qualifié", "potentiel"], "context": ["qualification", "scoring", "score_explanation"], "priority": 7}
    },

    # === OBJECTIONS ET RÉPONSES ===
    {
        "text": "C'est trop cher. Je comprends votre préoccupation sur le prix. Nos solutions génèrent un ROI de 300% en moyenne. Un investissement de 50k€ peut générer 150k€ de revenus supplémentaires. Voulez-vous une analyse ROI personnalisée ?",
        "metadata": {"category": "objections", "keywords": ["cher", "prix", "ROI", "investissement", "revenus", "analyse"], "context": ["objections", "pricing", "roi"], "priority": 9}
    },
    {
        "text": "Nous avons déjà un CRM. Excellent ! Notre solution s'intègre parfaitement avec votre CRM existant. Nous ajoutons une couche d'IA pour automatiser la qualification et améliorer vos processus actuels. Quelle est votre solution CRM actuelle ?",
        "metadata": {"category": "objections", "keywords": ["CRM", "intégration", "IA", "automatisation", "processus"], "context": ["objections", "integration", "existing_crm"], "priority": 8}
    },
    {
        "text": "Nous devons réfléchir. Bien sûr, c'est une décision importante ! Je peux vous envoyer une proposition détaillée et organiser une démonstration avec votre équipe. Quand seriez-vous disponible pour en discuter plus en détail ?",
        "metadata": {"category": "objections", "keywords": ["réfléchir", "proposition", "démonstration", "équipe", "disponible"], "context": ["objections", "consideration", "follow_up"], "priority": 7}
    },

    # === DÉMONSTRATION ET SUIVI ===
    {
        "text": "Pouvez-vous faire une démonstration ? Absolument ! Je peux organiser une démonstration personnalisée avec notre équipe technique. Nous adaptons la démo à vos besoins spécifiques. Quel créneau vous conviendrait cette semaine ?",
        "metadata": {"category": "demo", "keywords": ["démonstration", "personnalisée", "équipe technique", "créneau"], "context": ["demo", "follow_up", "conversion"], "priority": 9}
    },
    {
        "text": "Quand pouvez-vous présenter ? Je peux organiser une présentation dès cette semaine ! Nous proposons des créneaux de 30 minutes adaptés à votre planning. Préférez-vous un créneau matin ou après-midi ?",
        "metadata": {"category": "demo", "keywords": ["présentation", "cette semaine", "créneaux", "planning"], "context": ["demo", "scheduling", "conversion"], "priority": 8}
    },

    # === INFORMATIONS ENTREPRISE ===
    {
        "text": "Combien d'employés dans votre entreprise ? La taille de votre entreprise m'aide à adapter nos solutions. Nous proposons des packages adaptés aux PME (10-100 employés) et aux grandes entreprises (100+ employés). Quelle est votre taille actuelle ?",
        "metadata": {"category": "company", "keywords": ["employés", "taille", "PME", "grandes entreprises", "packages"], "context": ["qualification", "company_size", "packaging"], "priority": 8}
    },
    {
        "text": "Secteur d'activité. Votre secteur d'activité est important pour personnaliser nos solutions. Nous avons des expériences dans l'agroalimentaire, l'immobilier, la communication et bien d'autres. Dans quel secteur évoluez-vous ?",
        "metadata": {"category": "company", "keywords": ["secteur", "activité", "agroalimentaire", "immobilier", "communication"], "context": ["qualification", "industry", "personalization"], "priority": 7}
    },

    # === SERVICES BRAINGEN TECH ===
    {
        "text": "Nos services incluent l'automatisation des ventes, l'IA conversationnelle, l'analyse prédictive, et la qualification automatique des leads. Nous proposons des solutions complètes pour digitaliser vos processus commerciaux.",
        "metadata": {"category": "services", "keywords": ["services", "automatisation", "IA", "analyse", "qualification", "digitalisation"], "context": ["services", "overview"], "priority": 10}
    },
    {
        "text": "L'automatisation des ventes permet d'augmenter votre productivité de 40% en automatisant la qualification des leads, le suivi CRM, et la génération de rapports. Nos solutions s'intègrent avec tous les CRM du marché.",
        "metadata": {"category": "services", "keywords": ["automatisation", "ventes", "productivité", "qualification", "CRM", "rapports"], "context": ["services", "sales_automation"], "priority": 9}
    },
    {
        "text": "L'IA conversationnelle améliore l'engagement client en fournissant des réponses instantanées et personnalisées. Notre chatbot qualifie automatiquement les leads selon les critères BANT et génère des suggestions intelligentes.",
        "metadata": {"category": "services", "keywords": ["IA", "conversationnelle", "engagement", "réponses", "qualification", "BANT"], "context": ["services", "ai_chatbot"], "priority": 9}
    },
    {
        "text": "L'analyse prédictive vous aide à identifier les prospects les plus prometteurs et à optimiser vos campagnes marketing. Nos algorithmes analysent les comportements et prédisent les chances de conversion.",
        "metadata": {"category": "services", "keywords": ["analyse", "prédictive", "prospects", "campagnes", "marketing", "conversion"], "context": ["services", "predictive_analytics"], "priority": 8}
    }
]

def add_knowledge_to_vectorstore():
    """Add knowledge data to the vector store via the API"""
    
    api_url = "http://localhost:8001/add-knowledge"
    
    print("🔄 Adding knowledge to vector store...")
    
    success_count = 0
    error_count = 0
    
    for i, knowledge in enumerate(KNOWLEDGE_DATA, 1):
        try:
            response = requests.post(
                api_url,
                json=knowledge,
                headers={"Content-Type": "application/json"},
                timeout=10
            )
            
            if response.status_code == 200:
                success_count += 1
                print(f"✅ Added knowledge {i}/{len(KNOWLEDGE_DATA)}: {knowledge['text'][:50]}...")
            else:
                error_count += 1
                print(f"❌ Failed to add knowledge {i}: {response.status_code} - {response.text}")
                
        except Exception as e:
            error_count += 1
            print(f"❌ Error adding knowledge {i}: {str(e)}")
    
    print(f"\n📊 Summary:")
    print(f"✅ Successfully added: {success_count}")
    print(f"❌ Errors: {error_count}")
    print(f"📝 Total processed: {len(KNOWLEDGE_DATA)}")

if __name__ == "__main__":
    add_knowledge_to_vectorstore() 