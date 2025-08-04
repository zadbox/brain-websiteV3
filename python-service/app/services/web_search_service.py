import os
import logging
import asyncio
import aiohttp
from typing import Dict, List, Any, Optional
from datetime import datetime
import json
import re
from urllib.parse import quote_plus
from bs4 import BeautifulSoup

from .cache_service import SearchCacheService, RealtimeInvalidationService

logger = logging.getLogger(__name__)

class WebSearchService:
    """
    Service de recherche web intelligent pour le chatbot BrainGenTech
    Utilise plusieurs APIs de recherche et extrait des informations pertinentes
    """
    
    def __init__(self):
        # Initialiser le cache
        self.cache_service = SearchCacheService(cache_duration_minutes=30)
        self.invalidation_service = RealtimeInvalidationService(self.cache_service)
        
        self.search_apis = {
            'serpapi': {
                'key': os.getenv('SERPAPI_KEY'),
                'url': 'https://serpapi.com/search.json',
                'enabled': bool(os.getenv('SERPAPI_KEY'))
            },
            'bing': {
                'key': os.getenv('BING_SEARCH_KEY'),
                'url': 'https://api.bing.microsoft.com/v7.0/search',
                'enabled': bool(os.getenv('BING_SEARCH_KEY'))
            },
            'duckduckgo': {
                'url': 'https://api.duckduckgo.com/',
                'enabled': True  # API gratuite, pas de clé requise
            }
        }
        
        # Configuration des domaines fiables
        self.trusted_domains = [
            'wikipedia.org', 'bbc.com', 'reuters.com', 'cnn.com',
            'lemonde.fr', 'lefigaro.fr', 'franceinfo.fr',
            'github.com', 'stackoverflow.com', 'medium.com',
            'techcrunch.com', 'wired.com', 'ars-technica.com'
        ]
        
        # Types de requêtes spéciales
        self.special_queries = {
            'actualite': ['news', 'actualité', 'dernières nouvelles', 'breaking news'],
            'sport': ['football', 'match', 'résultat', 'championnat', 'real madrid'],
            'finance': ['bourse', 'crypto', 'bitcoin', 'ethereum', 'cours'],
            'meteo': ['météo', 'temps', 'température', 'prévisions'],
            'tech': ['technologie', 'ia', 'intelligence artificielle', 'startup']
        }
    
    async def search_web(self, query: str, context: Dict[str, Any] = None) -> Dict[str, Any]:
        """
        Effectue une recherche web intelligente avec cache
        """
        try:
            logger.info(f"Starting web search for query: {query}")
            
            # Analyser le type de requête
            query_type = self._analyze_query_type(query)
            
            # Invalidation automatique du cache si nécessaire
            self.invalidation_service.invalidate_category_if_needed(query_type)
            
            # Vérifier le cache en premier
            search_context = {'query_type': query_type, **(context or {})}
            cached_result = self.cache_service.get_cached_result(query, search_context)
            
            if cached_result:
                logger.info(f"Returning cached result for query: {query}")
                return cached_result
            
            # Optimiser la requête pour la recherche
            optimized_query = self._optimize_search_query(query, query_type)
            
            # Effectuer la recherche avec plusieurs APIs
            search_results = await self._multi_api_search(optimized_query, query_type)
            
            # Extraire et traiter les informations
            processed_results = await self._process_search_results(search_results, query)
            
            # Générer une réponse synthétisée
            synthesized_response = await self._synthesize_response(processed_results, query, query_type)
            
            result = {
                'success': True,
                'response': synthesized_response['content'],
                'sources': synthesized_response['sources'],
                'confidence': synthesized_response['confidence'],
                'query_type': query_type,
                'search_timestamp': datetime.now().isoformat(),
                'results_count': len(processed_results),
                'cached': False  # Nouveau résultat
            }
            
            # Mettre en cache le résultat
            self.cache_service.cache_result(query, result, search_context)
            
            return result
            
        except Exception as e:
            logger.error(f"Web search failed: {e}")
            return {
                'success': False,
                'response': self._get_fallback_response(query),
                'sources': [],
                'confidence': 0.3,
                'error': str(e)
            }
    
    def _analyze_query_type(self, query: str) -> str:
        """
        Analyse le type de requête pour optimiser la recherche
        """
        query_lower = query.lower()
        
        for category, keywords in self.special_queries.items():
            if any(keyword in query_lower for keyword in keywords):
                return category
        
        # Détection de patterns spécifiques
        if re.search(r'\b(dernier|dernière|récent|nouveau|latest)\b', query_lower):
            return 'actualite'
        elif re.search(r'\b(comment|pourquoi|que|quel|où|quand)\b', query_lower):
            return 'information'
        elif re.search(r'\b(prix|coût|tarif|budget)\b', query_lower):
            return 'finance'
        
        return 'general'
    
    def _optimize_search_query(self, query: str, query_type: str) -> str:
        """
        Optimise la requête de recherche selon le type
        """
        # Nettoyer la requête
        cleaned_query = re.sub(r'[^\w\s\-\'\"àâäéèêëïîôöùûüÿç]', '', query)
        
        # Ajouter des mots-clés contextuels selon le type
        if query_type == 'actualite':
            cleaned_query += ' news 2024 2025'
        elif query_type == 'sport':
            cleaned_query += ' résultats sport'
        elif query_type == 'tech':
            cleaned_query += ' technology innovation'
        elif query_type == 'finance':
            cleaned_query += ' cours prix marché'
        
        return cleaned_query.strip()
    
    async def _multi_api_search(self, query: str, query_type: str) -> List[Dict[str, Any]]:
        """
        Effectue des recherches avec plusieurs APIs en parallèle
        """
        search_tasks = []
        
        # Recherche SerpAPI (Google)
        if self.search_apis['serpapi']['enabled']:
            search_tasks.append(self._search_serpapi(query, query_type))
        
        # Recherche Bing
        if self.search_apis['bing']['enabled']:
            search_tasks.append(self._search_bing(query, query_type))
        
        # Recherche DuckDuckGo
        if self.search_apis['duckduckgo']['enabled']:
            search_tasks.append(self._search_duckduckgo(query, query_type))
        
        # Exécuter les recherches en parallèle
        results = await asyncio.gather(*search_tasks, return_exceptions=True)
        
        # Filtrer les résultats valides
        valid_results = []
        for result in results:
            if isinstance(result, dict) and result.get('success'):
                valid_results.extend(result.get('results', []))
        
        return valid_results
    
    async def _search_serpapi(self, query: str, query_type: str) -> Dict[str, Any]:
        """
        Recherche via SerpAPI (Google Search)
        """
        try:
            params = {
                'q': query,
                'api_key': self.search_apis['serpapi']['key'],
                'engine': 'google',
                'gl': 'fr',
                'hl': 'fr',
                'num': 10
            }
            
            # Paramètres spéciaux selon le type
            if query_type == 'actualite':
                params['tbm'] = 'nws'  # News search
            elif query_type == 'sport':
                params['tbm'] = 'nws'
            
            async with aiohttp.ClientSession() as session:
                async with session.get(self.search_apis['serpapi']['url'], params=params) as response:
                    if response.status == 200:
                        data = await response.json()
                        return self._parse_serpapi_results(data)
            
        except Exception as e:
            logger.error(f"SerpAPI search failed: {e}")
        
        return {'success': False, 'results': []}
    
    async def _search_bing(self, query: str, query_type: str) -> Dict[str, Any]:
        """
        Recherche via Bing Search API
        """
        try:
            headers = {
                'Ocp-Apim-Subscription-Key': self.search_apis['bing']['key']
            }
            
            params = {
                'q': query,
                'count': 10,
                'mkt': 'fr-FR',
                'safeSearch': 'Moderate'
            }
            
            # Recherche spécialisée selon le type
            if query_type == 'actualite':
                url = 'https://api.bing.microsoft.com/v7.0/news/search'
            else:
                url = self.search_apis['bing']['url']
            
            async with aiohttp.ClientSession() as session:
                async with session.get(url, headers=headers, params=params) as response:
                    if response.status == 200:
                        data = await response.json()
                        return self._parse_bing_results(data, query_type)
            
        except Exception as e:
            logger.error(f"Bing search failed: {e}")
        
        return {'success': False, 'results': []}
    
    async def _search_duckduckgo(self, query: str, query_type: str) -> Dict[str, Any]:
        """
        Recherche via DuckDuckGo Instant Answer API
        """
        try:
            params = {
                'q': query,
                'format': 'json',
                'no_html': '1',
                'skip_disambig': '1'
            }
            
            async with aiohttp.ClientSession() as session:
                async with session.get(self.search_apis['duckduckgo']['url'], params=params) as response:
                    if response.status == 200:
                        data = await response.json()
                        return self._parse_duckduckgo_results(data)
            
        except Exception as e:
            logger.error(f"DuckDuckGo search failed: {e}")
        
        return {'success': False, 'results': []}
    
    def _parse_serpapi_results(self, data: Dict[str, Any]) -> Dict[str, Any]:
        """
        Parse les résultats SerpAPI
        """
        results = []
        
        # Résultats organiques
        for item in data.get('organic_results', [])[:5]:
            results.append({
                'title': item.get('title', ''),
                'snippet': item.get('snippet', ''),
                'url': item.get('link', ''),
                'source': 'google',
                'relevance': self._calculate_relevance(item.get('title', '') + ' ' + item.get('snippet', ''))
            })
        
        # Résultats d'actualités
        for item in data.get('news_results', [])[:3]:
            results.append({
                'title': item.get('title', ''),
                'snippet': item.get('snippet', ''),
                'url': item.get('link', ''),
                'source': 'google_news',
                'date': item.get('date', ''),
                'relevance': self._calculate_relevance(item.get('title', '') + ' ' + item.get('snippet', ''))
            })
        
        return {'success': True, 'results': results}
    
    def _parse_bing_results(self, data: Dict[str, Any], query_type: str) -> Dict[str, Any]:
        """
        Parse les résultats Bing
        """
        results = []
        
        if query_type == 'actualite':
            # Résultats d'actualités
            for item in data.get('value', [])[:5]:
                results.append({
                    'title': item.get('name', ''),
                    'snippet': item.get('description', ''),
                    'url': item.get('url', ''),
                    'source': 'bing_news',
                    'date': item.get('datePublished', ''),
                    'relevance': self._calculate_relevance(item.get('name', '') + ' ' + item.get('description', ''))
                })
        else:
            # Résultats web
            for item in data.get('webPages', {}).get('value', [])[:5]:
                results.append({
                    'title': item.get('name', ''),
                    'snippet': item.get('snippet', ''),
                    'url': item.get('url', ''),
                    'source': 'bing',
                    'relevance': self._calculate_relevance(item.get('name', '') + ' ' + item.get('snippet', ''))
                })
        
        return {'success': True, 'results': results}
    
    def _parse_duckduckgo_results(self, data: Dict[str, Any]) -> Dict[str, Any]:
        """
        Parse les résultats DuckDuckGo
        """
        results = []
        
        # Réponse instantanée
        if data.get('Abstract'):
            results.append({
                'title': data.get('Heading', ''),
                'snippet': data.get('Abstract', ''),
                'url': data.get('AbstractURL', ''),
                'source': 'duckduckgo_instant',
                'relevance': 0.9
            })
        
        # Résultats connexes
        for item in data.get('RelatedTopics', [])[:3]:
            results.append({
                'title': item.get('Text', '').split(' - ')[0] if ' - ' in item.get('Text', '') else item.get('Text', ''),
                'snippet': item.get('Text', ''),
                'url': item.get('FirstURL', ''),
                'source': 'duckduckgo',
                'relevance': self._calculate_relevance(item.get('Text', ''))
            })
        
        return {'success': True, 'results': results}
    
    def _calculate_relevance(self, text: str) -> float:
        """
        Calcule la pertinence d'un résultat
        """
        # Score de base
        score = 0.5
        
        # Boost pour domaines fiables
        if any(domain in text.lower() for domain in self.trusted_domains):
            score += 0.2
        
        # Boost pour contenu récent
        if any(word in text.lower() for word in ['2024', '2025', 'récent', 'nouveau', 'latest']):
            score += 0.1
        
        # Pénalité pour contenu vague
        if len(text.split()) < 10:
            score -= 0.1
        
        return min(max(score, 0.1), 1.0)
    
    async def _process_search_results(self, results: List[Dict[str, Any]], query: str) -> List[Dict[str, Any]]:
        """
        Traite et filtre les résultats de recherche
        """
        # Trier par pertinence
        results.sort(key=lambda x: x.get('relevance', 0), reverse=True)
        
        # Filtrer les doublons
        seen_urls = set()
        filtered_results = []
        
        for result in results[:10]:  # Top 10 results
            url = result.get('url', '')
            if url and url not in seen_urls:
                seen_urls.add(url)
                filtered_results.append(result)
        
        return filtered_results
    
    async def _synthesize_response(self, results: List[Dict[str, Any]], query: str, query_type: str) -> Dict[str, Any]:
        """
        Synthétise une réponse à partir des résultats de recherche
        """
        if not results:
            return {
                'content': self._get_fallback_response(query),
                'sources': [],
                'confidence': 0.3
            }
        
        # Extraire les informations clés
        key_info = []
        sources = []
        
        for result in results[:5]:  # Top 5 results
            if result.get('snippet'):
                key_info.append(result['snippet'])
                sources.append({
                    'title': result.get('title', ''),
                    'url': result.get('url', ''),
                    'source': result.get('source', ''),
                    'relevance': result.get('relevance', 0)
                })
        
        # Générer la réponse synthétisée
        if query_type == 'actualite':
            response = self._generate_news_response(key_info, sources, query)
        elif query_type == 'sport':
            response = self._generate_sports_response(key_info, sources, query)
        else:
            response = self._generate_general_response(key_info, sources, query)
        
        return {
            'content': response,
            'sources': sources,
            'confidence': min(0.8, len(results) * 0.1 + 0.4)
        }
    
    def _generate_news_response(self, info: List[str], sources: List[Dict], query: str) -> str:
        """
        Génère une réponse pour les actualités
        """
        if not info:
            return f"Je n'ai pas trouvé d'informations récentes sur '{query}'. Je vous recommande de consulter des sites d'actualités fiables."
        
        response = f"📰 **Actualités sur '{query}'** :\n\n"
        response += "Voici les dernières informations que j'ai trouvées :\n\n"
        
        for i, snippet in enumerate(info[:3], 1):
            response += f"{i}. {snippet}\n\n"
        
        response += "📍 **Sources fiables pour plus d'informations** :\n"
        for source in sources[:3]:
            response += f"• {source['title']} - {source['url']}\n"
        
        response += "\n💡 *Informations mises à jour automatiquement via recherche web*"
        
        return response
    
    def _generate_sports_response(self, info: List[str], sources: List[Dict], query: str) -> str:
        """
        Génère une réponse pour le sport
        """
        if not info:
            return f"⚽ Je n'ai pas trouvé d'informations récentes sur '{query}'. Pour les derniers résultats sportifs, consultez L'Équipe, ESPN ou les sites officiels."
        
        response = f"⚽ **Informations sportives sur '{query}'** :\n\n"
        
        for i, snippet in enumerate(info[:3], 1):
            response += f"{i}. {snippet}\n\n"
        
        response += "🏆 **Sources recommandées pour le sport** :\n"
        response += "• L'Équipe : www.lequipe.fr\n"
        response += "• ESPN : www.espn.com\n"
        response += "• FlashScore : www.flashscore.fr\n\n"
        
        if sources:
            response += "📍 **Sources trouvées** :\n"
            for source in sources[:2]:
                response += f"• {source['title']} - {source['url']}\n"
        
        return response
    
    def _generate_general_response(self, info: List[str], sources: List[Dict], query: str) -> str:
        """
        Génère une réponse générale
        """
        if not info:
            return f"Je n'ai pas trouvé d'informations suffisantes sur '{query}' dans ma base de données ni sur internet. Pouvez-vous reformuler ou être plus spécifique ?"
        
        response = f"🔍 **Informations trouvées sur '{query}'** :\n\n"
        
        # Synthèse des informations principales
        main_info = info[0] if info else ""
        response += f"{main_info}\n\n"
        
        if len(info) > 1:
            response += "**Informations complémentaires** :\n"
            for snippet in info[1:3]:
                response += f"• {snippet}\n"
            response += "\n"
        
        if sources:
            response += "📚 **Sources** :\n"
            for source in sources[:3]:
                response += f"• {source['title']} - {source['url']}\n"
        
        response += "\n💡 *Informations obtenues via recherche web intelligente*"
        
        return response
    
    def _get_fallback_response(self, query: str) -> str:
        """
        Réponse de fallback quand la recherche échoue
        """
        return f"""Je n'ai pas pu trouver d'informations suffisantes sur '{query}' dans ma base de données et la recherche web n'a pas donné de résultats satisfaisants.

🔍 **Suggestions** :
• Reformulez votre question de manière plus spécifique
• Vérifiez l'orthographe des termes de recherche
• Essayez des mots-clés différents

📞 **Besoin d'aide personnalisée ?**
Nos experts BrainGenTech peuvent vous assister pour des recherches complexes ou des besoins spécifiques en IA et technologie."""

    def is_search_needed(self, query: str, knowledge_base_results: List[Dict] = None) -> bool:
        """
        Détermine si une recherche web est nécessaire
        """
        # Recherche nécessaire si pas de résultats dans la base de données
        if not knowledge_base_results or len(knowledge_base_results) == 0:
            return True
        
        # Recherche nécessaire pour des requêtes d'actualité
        query_lower = query.lower()
        news_keywords = ['dernier', 'récent', 'nouveau', 'actualité', 'news', 'aujourd\'hui', '2024', '2025']
        if any(keyword in query_lower for keyword in news_keywords):
            return True
        
        # Recherche nécessaire pour des scores de pertinence faibles
        if knowledge_base_results:
            avg_score = sum(r.get('score', 0) for r in knowledge_base_results) / len(knowledge_base_results)
            if avg_score < 0.5:
                return True
        
        return False
    
    def get_cache_stats(self) -> Dict[str, Any]:
        """
        Retourne les statistiques du cache de recherche
        """
        return self.cache_service.get_cache_stats()
    
    def clear_search_cache(self):
        """
        Vide le cache de recherche
        """
        self.cache_service.clear_cache()
        logger.info("Search cache cleared")
    
    def invalidate_pattern(self, pattern: str) -> int:
        """
        Invalide les entrées de cache qui correspondent à un pattern
        """
        return self.cache_service.invalidate_query_pattern(pattern)