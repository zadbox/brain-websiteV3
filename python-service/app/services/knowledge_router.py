import logging
from typing import Dict, List, Any, Optional, Tuple
from datetime import datetime
import re

from .web_search_service import WebSearchService

logger = logging.getLogger(__name__)

class KnowledgeRouter:
    """
    Routeur intelligent qui décide entre base de données locale et recherche web
    """
    
    def __init__(self, vectorstore=None):
        self.vectorstore = vectorstore
        self.web_search = WebSearchService()
        
        # Patterns qui nécessitent une recherche web
        self.web_search_patterns = [
            # Actualités et événements récents
            r'\b(dernier|dernière|récent|nouveau|latest|aujourd[\'\']?hui|cette semaine|ce mois)\b',
            r'\b(actualité|news|breaking|urgent)\b',
            r'\b(2024|2025)\b',
            
            # Sports en temps réel
            r'\b(match|résultat|score|championnat|ligue|coupe)\b.*\b(aujourd[\'\']?hui|hier|demain)\b',
            r'\b(real madrid|psg|manchester|barcelona).*\b(match|résultat)\b',
            
            # Finance et crypto en temps réel
            r'\b(cours|prix|cotation).*\b(bitcoin|ethereum|crypto|bourse)\b',
            r'\b(crypto|bitcoin|ethereum).*\b(prix|cours|valeur)\b',
            
            # Météo
            r'\b(météo|temps|température|prévisions)\b',
            
            # Événements spécifiques
            r'\b(élection|covid|guerre|pandémie|crise)\b.*\b(dernier|récent|actualité)\b',
        ]
        
        # Mots-clés qui indiquent un besoin de données temps réel
        self.realtime_keywords = [
            'maintenant', 'actuellement', 'en ce moment', 'live', 'direct',
            'dernier', 'dernière', 'récent', 'récente', 'nouveau', 'nouvelle',
            'aujourd\'hui', 'hier', 'demain', 'cette semaine', 'ce mois',
            'breaking', 'urgent', 'flash', 'alerte'
        ]
        
        # Domaines de connaissances statiques (pas besoin de recherche web)
        self.static_knowledge_domains = [
            'mathématiques', 'physique', 'chimie', 'biologie', 'histoire ancienne',
            'littérature', 'philosophie', 'géographie', 'programmation de base',
            'concepts généraux', 'définitions'
        ]
    
    async def route_query(self, query: str, context: Dict[str, Any] = None) -> Dict[str, Any]:
        """
        Route une requête vers la source d'information appropriée
        """
        try:
            logger.info(f"Routing query: {query}")
            
            # 1. Analyser la requête
            query_analysis = self._analyze_query(query)
            
            # 2. Chercher dans la base de données locale
            local_results = await self._search_local_knowledge(query)
            
            # 3. Décider si une recherche web est nécessaire
            needs_web_search = self._needs_web_search(query, query_analysis, local_results)
            
            if needs_web_search:
                logger.info("Web search required - fetching real-time information")
                
                # 4. Effectuer la recherche web
                web_results = await self.web_search.search_web(query, context)
                
                if web_results['success']:
                    # 5. Combiner les résultats locaux et web
                    combined_response = self._combine_results(local_results, web_results, query_analysis)
                    return combined_response
                else:
                    # Fallback vers les résultats locaux si la recherche web échoue
                    logger.warning("Web search failed, using local results")
                    return self._format_local_response(local_results, query)
            else:
                logger.info("Using local knowledge base")
                return self._format_local_response(local_results, query)
                
        except Exception as e:
            logger.error(f"Knowledge routing failed: {e}")
            return {
                'success': False,
                'response': f"Je rencontre des difficultés pour traiter votre question sur '{query}'. Pouvez-vous reformuler ?",
                'sources': [],
                'confidence': 0.2,
                'routing_error': str(e)
            }
    
    def _analyze_query(self, query: str) -> Dict[str, Any]:
        """
        Analyse la requête pour déterminer ses caractéristiques
        """
        query_lower = query.lower()
        
        analysis = {
            'needs_realtime': False,
            'is_news_related': False,
            'is_sports_related': False,
            'is_finance_related': False,
            'is_weather_related': False,
            'has_temporal_keywords': False,
            'domain': 'general',
            'urgency': 'normal'
        }
        
        # Détection de mots-clés temps réel
        analysis['has_temporal_keywords'] = any(
            keyword in query_lower for keyword in self.realtime_keywords
        )
        
        # Détection de patterns spéciaux
        for pattern in self.web_search_patterns:
            if re.search(pattern, query_lower, re.IGNORECASE):
                analysis['needs_realtime'] = True
                break
        
        # Classification par domaine
        if any(word in query_lower for word in ['actualité', 'news', 'breaking', 'urgent']):
            analysis['is_news_related'] = True
            analysis['domain'] = 'news'
            analysis['urgency'] = 'high'
        
        elif any(word in query_lower for word in ['match', 'football', 'sport', 'résultat', 'championnat']):
            analysis['is_sports_related'] = True
            analysis['domain'] = 'sports'
        
        elif any(word in query_lower for word in ['bitcoin', 'crypto', 'bourse', 'cours', 'cotation']):
            analysis['is_finance_related'] = True
            analysis['domain'] = 'finance'
        
        elif any(word in query_lower for word in ['météo', 'temps', 'température', 'prévisions']):
            analysis['is_weather_related'] = True
            analysis['domain'] = 'weather'
            analysis['needs_realtime'] = True
        
        # Vérification de domaines statiques
        for domain in self.static_knowledge_domains:
            if domain in query_lower:
                analysis['needs_realtime'] = False
                analysis['domain'] = 'static'
                break
        
        return analysis
    
    async def _search_local_knowledge(self, query: str) -> List[Dict[str, Any]]:
        """
        Recherche dans la base de connaissances locale
        """
        if not self.vectorstore:
            return []
        
        try:
            # Recherche de similarité
            results = self.vectorstore.similarity_search_with_score(query, k=5)
            
            formatted_results = []
            for doc, score in results:
                formatted_results.append({
                    'content': doc.page_content,
                    'metadata': doc.metadata,
                    'score': score,
                    'source': 'local_knowledge'
                })
            
            return formatted_results
            
        except Exception as e:
            logger.error(f"Local knowledge search failed: {e}")
            return []
    
    def _needs_web_search(self, query: str, analysis: Dict[str, Any], local_results: List[Dict]) -> bool:
        """
        Détermine si une recherche web est nécessaire
        """
        # Toujours chercher sur le web pour les requêtes temps réel
        if analysis['needs_realtime'] or analysis['has_temporal_keywords']:
            return True
        
        # Chercher sur le web pour les domaines spécialisés
        if analysis['domain'] in ['news', 'sports', 'finance', 'weather']:
            return True
        
        # Chercher sur le web si pas de résultats locaux pertinents
        if not local_results:
            return True
        
        # Chercher sur le web si les résultats locaux ont un score faible
        if local_results:
            avg_score = sum(r.get('score', 0) for r in local_results) / len(local_results)
            if avg_score > 0.8:  # Seuil élevé = résultats peu pertinents
                return True
        
        # Ne pas chercher sur le web pour les domaines statiques
        if analysis['domain'] == 'static':
            return False
        
        # Critères spéciaux pour certaines requêtes
        query_lower = query.lower()
        
        # Questions techniques spécifiques à BrainGenTech
        if any(word in query_lower for word in ['braingen', 'brain gen', 'nos services', 'notre entreprise']):
            return False
        
        # Questions de programmation de base
        if any(word in query_lower for word in ['comment programmer', 'syntaxe', 'algorithme de base']):
            return False
        
        # Par défaut, utiliser la recherche web pour améliorer les réponses
        return len(local_results) < 3
    
    def _combine_results(self, local_results: List[Dict], web_results: Dict[str, Any], analysis: Dict[str, Any]) -> Dict[str, Any]:
        """
        Combine les résultats locaux et web pour une réponse optimale
        """
        if not web_results['success']:
            return self._format_local_response(local_results, "")
        
        # Priorité aux résultats web pour les requêtes temps réel
        if analysis['needs_realtime'] or analysis['domain'] in ['news', 'sports', 'finance', 'weather']:
            response = web_results['response']
            
            # Ajouter des informations locales pertinentes si disponibles
            if local_results and any(r['score'] < 0.5 for r in local_results):
                response += "\n\n📚 **Informations complémentaires de notre base de connaissances** :\n"
                for result in local_results[:2]:
                    if result['score'] < 0.5:  # Score faible = plus pertinent
                        response += f"• {result['content'][:200]}...\n"
        else:
            # Combiner intelligemment les sources
            response = "🧠 **Réponse enrichie** :\n\n"
            
            # Commencer par les informations locales
            if local_results:
                response += "**De notre base de connaissances** :\n"
                response += local_results[0]['content'][:300] + "...\n\n"
            
            # Ajouter les informations web
            response += "**Informations mises à jour du web** :\n"
            response += web_results['response']
        
        # Combiner les sources
        all_sources = []
        if local_results:
            all_sources.extend([{'title': 'Base de connaissances BrainGenTech', 'source': 'local', 'url': ''}])
        
        all_sources.extend(web_results.get('sources', []))
        
        return {
            'success': True,
            'response': response,
            'sources': all_sources,
            'confidence': max(web_results.get('confidence', 0.5), 0.7),
            'routing_method': 'combined',
            'local_results_count': len(local_results),
            'web_search_used': True
        }
    
    def _format_local_response(self, local_results: List[Dict], query: str) -> Dict[str, Any]:
        """
        Formate une réponse basée uniquement sur les résultats locaux
        """
        if not local_results:
            return {
                'success': False,
                'response': f"Je n'ai pas trouvé d'informations sur '{query}' dans ma base de connaissances. Souhaitez-vous que je recherche sur internet ?",
                'sources': [],
                'confidence': 0.1,
                'routing_method': 'local_only'
            }
        
        # Utiliser le meilleur résultat local
        best_result = min(local_results, key=lambda x: x.get('score', 1.0))
        
        response = best_result['content']
        
        # Ajouter des informations supplémentaires si pertinentes
        if len(local_results) > 1:
            response += "\n\n**Informations complémentaires** :\n"
            for result in local_results[1:3]:
                if result['score'] < 0.7:  # Assez pertinent
                    response += f"• {result['content'][:150]}...\n"
        
        # Calculer la confiance basée sur les scores
        avg_score = sum(r.get('score', 1.0) for r in local_results) / len(local_results)
        confidence = max(0.3, 1.0 - avg_score)  # Convertir score en confiance
        
        return {
            'success': True,
            'response': response,
            'sources': [{'title': 'Base de connaissances BrainGenTech', 'source': 'local', 'url': ''}],
            'confidence': confidence,
            'routing_method': 'local_only',
            'local_results_count': len(local_results),
            'web_search_used': False
        }