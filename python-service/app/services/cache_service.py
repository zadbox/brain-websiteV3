import json
import hashlib
import logging
from typing import Dict, Any, Optional
from datetime import datetime, timedelta
import os

logger = logging.getLogger(__name__)

class SearchCacheService:
    """
    Service de cache intelligent pour les recherches web
    Évite les appels répétitifs aux APIs et améliore les performances
    """
    
    def __init__(self, cache_duration_minutes: int = 30):
        self.cache_duration = timedelta(minutes=cache_duration_minutes)
        self.cache_file = "search_cache.json"
        self.memory_cache = {}
        self.max_cache_size = 1000  # Limite du cache en mémoire
        
        # Charger le cache depuis le fichier
        self._load_cache_from_file()
    
    def _generate_cache_key(self, query: str, context: Dict[str, Any] = None) -> str:
        """
        Génère une clé de cache unique pour une requête
        """
        # Normaliser la requête
        normalized_query = query.lower().strip()
        
        # Inclure le contexte pertinent dans la clé
        context_str = ""
        if context:
            relevant_context = {
                'query_type': context.get('query_type', ''),
                'domain': context.get('domain', '')
            }
            context_str = json.dumps(relevant_context, sort_keys=True)
        
        # Créer une clé hash
        cache_input = f"{normalized_query}|{context_str}"
        return hashlib.md5(cache_input.encode()).hexdigest()
    
    def get_cached_result(self, query: str, context: Dict[str, Any] = None) -> Optional[Dict[str, Any]]:
        """
        Récupère un résultat du cache s'il existe et est valide
        """
        cache_key = self._generate_cache_key(query, context)
        
        # Vérifier le cache en mémoire d'abord
        if cache_key in self.memory_cache:
            cache_entry = self.memory_cache[cache_key]
            if self._is_cache_valid(cache_entry):
                logger.info(f"Cache hit (memory) for query: {query[:50]}...")
                return cache_entry['result']
            else:
                # Supprimer l'entrée expirée
                del self.memory_cache[cache_key]
        
        return None
    
    def cache_result(self, query: str, result: Dict[str, Any], context: Dict[str, Any] = None):
        """
        Met en cache un résultat de recherche
        """
        cache_key = self._generate_cache_key(query, context)
        
        cache_entry = {
            'query': query,
            'result': result,
            'context': context,
            'timestamp': datetime.now().isoformat(),
            'expires_at': (datetime.now() + self.cache_duration).isoformat()
        }
        
        # Ajouter au cache en mémoire
        self.memory_cache[cache_key] = cache_entry
        
        # Limiter la taille du cache
        if len(self.memory_cache) > self.max_cache_size:
            self._cleanup_old_entries()
        
        # Sauvegarder périodiquement dans un fichier
        if len(self.memory_cache) % 10 == 0:  # Tous les 10 ajouts
            self._save_cache_to_file()
        
        logger.info(f"Cached result for query: {query[:50]}...")
    
    def _is_cache_valid(self, cache_entry: Dict[str, Any]) -> bool:
        """
        Vérifie si une entrée de cache est encore valide
        """
        try:
            expires_at = datetime.fromisoformat(cache_entry['expires_at'])
            return datetime.now() < expires_at
        except (KeyError, ValueError):
            return False
    
    def _cleanup_old_entries(self):
        """
        Nettoie les entrées expirées du cache
        """
        current_time = datetime.now()
        expired_keys = []
        
        for key, entry in self.memory_cache.items():
            if not self._is_cache_valid(entry):
                expired_keys.append(key)
        
        for key in expired_keys:
            del self.memory_cache[key]
        
        logger.info(f"Cleaned up {len(expired_keys)} expired cache entries")
    
    def _load_cache_from_file(self):
        """
        Charge le cache depuis un fichier JSON
        """
        try:
            if os.path.exists(self.cache_file):
                with open(self.cache_file, 'r', encoding='utf-8') as f:
                    file_cache = json.load(f)
                
                # Filtrer les entrées valides
                valid_entries = 0
                for key, entry in file_cache.items():
                    if self._is_cache_valid(entry):
                        self.memory_cache[key] = entry
                        valid_entries += 1
                
                logger.info(f"Loaded {valid_entries} valid cache entries from file")
        
        except (json.JSONDecodeError, FileNotFoundError, Exception) as e:
            logger.warning(f"Could not load cache from file: {e}")
    
    def _save_cache_to_file(self):
        """
        Sauvegarde le cache dans un fichier JSON
        """
        try:
            # Ne sauvegarder que les entrées valides
            valid_cache = {}
            for key, entry in self.memory_cache.items():
                if self._is_cache_valid(entry):
                    valid_cache[key] = entry
            
            with open(self.cache_file, 'w', encoding='utf-8') as f:
                json.dump(valid_cache, f, indent=2, ensure_ascii=False)
            
            logger.info(f"Saved {len(valid_cache)} cache entries to file")
        
        except Exception as e:
            logger.error(f"Could not save cache to file: {e}")
    
    def clear_cache(self):
        """
        Vide complètement le cache
        """
        self.memory_cache.clear()
        
        try:
            if os.path.exists(self.cache_file):
                os.remove(self.cache_file)
        except Exception as e:
            logger.error(f"Could not remove cache file: {e}")
        
        logger.info("Cache cleared completely")
    
    def get_cache_stats(self) -> Dict[str, Any]:
        """
        Retourne des statistiques sur le cache
        """
        total_entries = len(self.memory_cache)
        valid_entries = sum(1 for entry in self.memory_cache.values() if self._is_cache_valid(entry))
        expired_entries = total_entries - valid_entries
        
        # Calculer l'âge moyen des entrées
        if self.memory_cache:
            ages = []
            current_time = datetime.now()
            
            for entry in self.memory_cache.values():
                try:
                    timestamp = datetime.fromisoformat(entry['timestamp'])
                    age_minutes = (current_time - timestamp).total_seconds() / 60
                    ages.append(age_minutes)
                except (KeyError, ValueError):
                    continue
            
            avg_age_minutes = sum(ages) / len(ages) if ages else 0
        else:
            avg_age_minutes = 0
        
        return {
            'total_entries': total_entries,
            'valid_entries': valid_entries,
            'expired_entries': expired_entries,
            'cache_hit_potential': f"{(valid_entries/total_entries*100):.1f}%" if total_entries > 0 else "0%",
            'average_age_minutes': round(avg_age_minutes, 2),
            'cache_duration_minutes': self.cache_duration.total_seconds() / 60,
            'max_cache_size': self.max_cache_size
        }
    
    def invalidate_query_pattern(self, pattern: str):
        """
        Invalide toutes les entrées de cache qui correspondent à un pattern
        Utile pour invalider les caches d'actualités par exemple
        """
        invalidated_count = 0
        keys_to_remove = []
        
        for key, entry in self.memory_cache.items():
            query = entry.get('query', '').lower()
            if pattern.lower() in query:
                keys_to_remove.append(key)
        
        for key in keys_to_remove:
            del self.memory_cache[key]
            invalidated_count += 1
        
        logger.info(f"Invalidated {invalidated_count} cache entries matching pattern: {pattern}")
        return invalidated_count

class RealtimeInvalidationService:
    """
    Service qui invalide automatiquement les caches pour certains types de contenu
    """
    
    def __init__(self, cache_service: SearchCacheService):
        self.cache_service = cache_service
        
        # Patterns qui nécessitent une invalidation fréquente
        self.invalidation_patterns = {
            'sport': ['match', 'résultat', 'score', 'championnat'],
            'finance': ['cours', 'prix', 'bitcoin', 'crypto', 'bourse'],
            'news': ['actualité', 'breaking', 'news', 'urgent'],
            'weather': ['météo', 'temps', 'température']
        }
        
        # Fréquences d'invalidation (en minutes)
        self.invalidation_frequencies = {
            'sport': 15,      # Invalider toutes les 15 minutes
            'finance': 10,    # Invalider toutes les 10 minutes
            'news': 5,        # Invalider toutes les 5 minutes
            'weather': 30     # Invalider toutes les 30 minutes
        }
        
        self.last_invalidation = {}
    
    def should_invalidate_cache(self, category: str) -> bool:
        """
        Détermine si le cache pour une catégorie doit être invalidé
        """
        if category not in self.invalidation_frequencies:
            return False
        
        last_time = self.last_invalidation.get(category)
        if not last_time:
            return True
        
        frequency_minutes = self.invalidation_frequencies[category]
        time_since_last = datetime.now() - last_time
        
        return time_since_last.total_seconds() / 60 >= frequency_minutes
    
    def invalidate_category_if_needed(self, category: str):
        """
        Invalide le cache d'une catégorie si nécessaire
        """
        if not self.should_invalidate_cache(category):
            return 0
        
        patterns = self.invalidation_patterns.get(category, [])
        total_invalidated = 0
        
        for pattern in patterns:
            count = self.cache_service.invalidate_query_pattern(pattern)
            total_invalidated += count
        
        self.last_invalidation[category] = datetime.now()
        
        if total_invalidated > 0:
            logger.info(f"Auto-invalidated {total_invalidated} {category} cache entries")
        
        return total_invalidated
    
    def run_periodic_invalidation(self):
        """
        Lance l'invalidation périodique pour toutes les catégories
        """
        total_invalidated = 0
        
        for category in self.invalidation_patterns.keys():
            count = self.invalidate_category_if_needed(category)
            total_invalidated += count
        
        return total_invalidated