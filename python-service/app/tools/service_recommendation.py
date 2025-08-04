from langchain_core.tools import tool
from typing import Optional, Dict, Any
import re
import logging

logger = logging.getLogger(__name__)

@tool
def service_recommendation_tool(message: str, context: Optional[Dict[str, Any]] = None) -> Dict[str, Any]:
    """Recommandation de services BrainGenTech basée sur les besoins exprimés"""
    try:
        message_lower = message.lower()
        
        # Service categories with keywords
        services = {
            'Agroalimentaire': {
                'keywords': ['agriculture', 'alimentaire', 'ferme', 'culture', 'élevage', 'récolte'],
                'description': 'Solutions IA pour optimiser la production agricole et alimentaire'
            },
            'Communication': {
                'keywords': ['communication', 'marketing', 'publicité', 'contenu', 'social'],
                'description': 'Stratégies de communication et marketing digital'
            },
            'Immobilier': {
                'keywords': ['immobilier', 'propriété', 'location', 'vente', 'bien'],
                'description': 'Solutions technologiques pour le secteur immobilier'
            },
            'Intelligence Artificielle': {
                'keywords': ['ia', 'intelligence artificielle', 'machine learning', 'automatisation'],
                'description': 'Développement de solutions IA personnalisées'
            },
            'Analyse de Données': {
                'keywords': ['données', 'analyse', 'statistiques', 'reporting', 'dashboard'],
                'description': 'Solutions d\'analyse et visualisation de données'
            },
            'Développement Web': {
                'keywords': ['site web', 'application web', 'développement', 'plateforme'],
                'description': 'Création de sites web et applications sur mesure'
            }
        }
        
        # Find matching services
        recommended_services = []
        confidence_scores = {}
        
        for service_name, service_info in services.items():
            score = 0
            matched_keywords = []
            
            for keyword in service_info['keywords']:
                if keyword in message_lower:
                    score += 1
                    matched_keywords.append(keyword)
            
            if score > 0:
                confidence = min(score * 20, 100)  # Max 100%
                recommended_services.append({
                    'service': service_name,
                    'description': service_info['description'],
                    'confidence': confidence,
                    'matched_keywords': matched_keywords
                })
                confidence_scores[service_name] = confidence
        
        # Sort by confidence
        recommended_services.sort(key=lambda x: x['confidence'], reverse=True)
        
        result = {
            'recommended_services': recommended_services[:3],  # Top 3
            'total_matches': len(recommended_services),
            'message_analysis': f"Analysé {len(message.split())} mots",
            'recommendations': f"Services recommandés basés sur votre demande"
        }
        
        logger.info(f"Service recommendation result: {result}")
        return result
        
    except Exception as e:
        logger.error(f"Error in service recommendation: {str(e)}")
        return {
            'error': str(e),
            'recommended_services': [],
            'total_matches': 0
        }