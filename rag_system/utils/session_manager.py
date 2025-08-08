"""
Session Memory Manager for BrainGenTechnology RAG System
Handles per-session conversation memory with Redis persistence
"""
import json
import redis
import logging
from typing import Dict, List, Any, Optional
from datetime import datetime, timedelta
from langchain.memory import ConversationBufferWindowMemory
from langchain.schema import BaseMessage, HumanMessage, AIMessage

import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

from config.settings import settings

logger = logging.getLogger(__name__)

class SessionManager:
    """
    Manages conversation sessions with Redis persistence
    Each session maintains its own conversation memory and context
    """
    
    def __init__(self):
        self.session_memories: Dict[str, ConversationBufferWindowMemory] = {}
        self.session_contexts: Dict[str, Dict[str, Any]] = {}
        self.redis_client = None
        self._initialize_redis()
        
    def _initialize_redis(self):
        """Initialize Redis connection for session persistence"""
        try:
            # Try to connect to Redis
            self.redis_client = redis.Redis(
                host='redis',  # Docker service name
                port=6379,
                password=os.getenv('REDIS_PASSWORD', ''),
                db=0,
                decode_responses=True,
                socket_connect_timeout=5,
                socket_timeout=5,
                retry_on_timeout=True,
                health_check_interval=30
            )
            
            # Test connection
            self.redis_client.ping()
            logger.info("Redis connection established for session management")
            
        except Exception as e:
            logger.warning(f"Redis connection failed, using in-memory storage: {e}")
            self.redis_client = None
    
    def get_session_memory(self, session_id: str) -> ConversationBufferWindowMemory:
        """Get or create conversation memory for a session"""
        if session_id not in self.session_memories:
            # Create new memory for this session
            memory = ConversationBufferWindowMemory(
                k=settings.max_conversation_length,
                memory_key="chat_history",
                return_messages=True,
                output_key="answer"
            )
            
            # Load existing conversation from Redis if available
            self._load_session_from_redis(session_id, memory)
            
            self.session_memories[session_id] = memory
            logger.info(f"Created new memory for session {session_id}")
        
        return self.session_memories[session_id]
    
    def get_session_context(self, session_id: str) -> Dict[str, Any]:
        """Get or create context information for a session"""
        if session_id not in self.session_contexts:
            # Load context from Redis if available
            context = self._load_context_from_redis(session_id)
            if not context:
                context = {
                    'session_id': session_id,
                    'created_at': datetime.now().isoformat(),
                    'last_activity': datetime.now().isoformat(),
                    'user_info': {},
                    'conversation_metadata': {},
                    'message_count': 0,
                    'topics_discussed': [],
                    'user_preferences': {}
                }
            
            self.session_contexts[session_id] = context
            logger.info(f"Initialized context for session {session_id}")
        
        return self.session_contexts[session_id]
    
    def update_session_context(self, session_id: str, user_message: str, ai_response: str, metadata: Optional[Dict[str, Any]] = None):
        """Update session context with new interaction"""
        context = self.get_session_context(session_id)
        
        # Update basic info
        context['last_activity'] = datetime.now().isoformat()
        context['message_count'] += 2  # User + AI message
        
        # Extract and store user information from messages
        self._extract_user_info(context, user_message, ai_response)
        
        # Update metadata if provided
        if metadata:
            context['conversation_metadata'].update(metadata)
        
        # Save to Redis
        self._save_context_to_redis(session_id, context)
        
        logger.debug(f"Updated context for session {session_id}")
    
    def _extract_user_info(self, context: Dict[str, Any], user_message: str, ai_response: str):
        """Extract user information from conversation messages"""
        user_message_lower = user_message.lower()
        
        # Extract name information
        if not context['user_info'].get('name'):
            name_patterns = [
                'my name is',
                'i am',
                'i\'m',
                'call me',
                'name\'s'
            ]
            
            for pattern in name_patterns:
                if pattern in user_message_lower:
                    # Try to extract name after the pattern
                    parts = user_message_lower.split(pattern)
                    if len(parts) > 1:
                        potential_name = parts[1].strip().split()[0]
                        if potential_name and len(potential_name) > 1 and potential_name.isalpha():
                            context['user_info']['name'] = potential_name.title()
                            logger.info(f"Extracted user name: {potential_name.title()}")
                            break
        
        # Extract company information
        if not context['user_info'].get('company'):
            company_patterns = [
                'my company',
                'our company',
                'we are',
                'work at',
                'work for',
                'i work at',
                'i work for',
                'company is'
            ]
            
            for pattern in company_patterns:
                if pattern in user_message_lower:
                    # Extract potential company name
                    parts = user_message_lower.split(pattern)
                    if len(parts) > 1:
                        company_part = parts[1].strip()
                        # Take first few words as company name
                        company_words = company_part.split()[:3]  # Max 3 words for company name
                        if company_words:
                            potential_company = ' '.join(company_words).title()
                            context['user_info']['company'] = potential_company
                            logger.info(f"Extracted company: {potential_company}")
                            break
        
        # Extract industry information
        if not context['user_info'].get('industry'):
            industry_keywords = {
                'electric': 'Electric/Energy',
                'electrical': 'Electric/Energy',
                'energy': 'Electric/Energy',
                'power': 'Electric/Energy',
                'manufacturing': 'Manufacturing',
                'fintech': 'FinTech',
                'financial': 'Financial Services',
                'healthcare': 'Healthcare',
                'medical': 'Healthcare',
                'retail': 'Retail',
                'ecommerce': 'E-commerce',
                'real estate': 'Real Estate',
                'construction': 'Construction',
                'technology': 'Technology',
                'software': 'Software/Technology',
                'agriculture': 'Agriculture',
                'automotive': 'Automotive',
                'logistics': 'Logistics/Supply Chain'
            }
            
            for keyword, industry in industry_keywords.items():
                if keyword in user_message_lower:
                    context['user_info']['industry'] = industry
                    logger.info(f"Identified industry: {industry}")
                    break
        
        # Extract contact preferences and business needs
        if 'email' in user_message_lower or '@' in user_message:
            context['user_info']['contact_method'] = 'email'
        
        if any(word in user_message_lower for word in ['phone', 'call', 'mobile']):
            context['user_info']['contact_method'] = 'phone'
        
        # Track topics discussed
        topic_keywords = {
            'ai': 'Artificial Intelligence',
            'automation': 'Business Automation',
            'blockchain': 'Blockchain Solutions',
            'predictive maintenance': 'Predictive Maintenance',
            'machine learning': 'Machine Learning',
            'data analysis': 'Data Analytics',
            'customer service': 'Customer Service',
            'crm': 'CRM Systems',
            'consultation': 'Consultation Request',
            'demo': 'Product Demo',
            'pricing': 'Pricing Information',
            'roi': 'ROI Discussion'
        }
        
        for keyword, topic in topic_keywords.items():
            if keyword in user_message_lower and topic not in context['topics_discussed']:
                context['topics_discussed'].append(topic)
    
    def add_message_to_session(self, session_id: str, user_message: str, ai_response: str, metadata: Optional[Dict[str, Any]] = None):
        """Add a message pair to session memory and update context"""
        memory = self.get_session_memory(session_id)
        
        # Add messages to memory
        memory.chat_memory.add_user_message(user_message)
        memory.chat_memory.add_ai_message(ai_response)
        
        # Update session context
        self.update_session_context(session_id, user_message, ai_response, metadata)
        
        # Save to Redis
        self._save_session_to_redis(session_id, memory)
        
        logger.debug(f"Added message pair to session {session_id}")
    
    def get_conversation_history(self, session_id: str) -> List[Dict[str, str]]:
        """Get formatted conversation history for a session"""
        try:
            memory = self.get_session_memory(session_id)
            messages = memory.chat_memory.messages
            
            history = []
            for message in messages:
                history.append({
                    "role": "user" if isinstance(message, HumanMessage) else "assistant",
                    "content": message.content,
                    "timestamp": getattr(message, "timestamp", datetime.now().isoformat())
                })
            
            return history
        except Exception as e:
            logger.error(f"Error getting conversation history for session {session_id}: {e}")
            return []
    
    def clear_session(self, session_id: str):
        """Clear all data for a session"""
        try:
            # Clear from memory
            if session_id in self.session_memories:
                del self.session_memories[session_id]
            
            if session_id in self.session_contexts:
                del self.session_contexts[session_id]
            
            # Clear from Redis
            if self.redis_client:
                self.redis_client.delete(f"session_memory:{session_id}")
                self.redis_client.delete(f"session_context:{session_id}")
            
            logger.info(f"Cleared all data for session {session_id}")
        except Exception as e:
            logger.error(f"Error clearing session {session_id}: {e}")
    
    def get_user_info_summary(self, session_id: str) -> str:
        """Get a formatted summary of user information for context"""
        context = self.get_session_context(session_id)
        user_info = context.get('user_info', {})
        
        summary_parts = []
        
        if user_info.get('name'):
            summary_parts.append(f"User's name is {user_info['name']}")
        
        if user_info.get('company'):
            summary_parts.append(f"works at {user_info['company']}")
        
        if user_info.get('industry'):
            summary_parts.append(f"in the {user_info['industry']} industry")
        
        if context.get('topics_discussed'):
            topics = ', '.join(context['topics_discussed'])
            summary_parts.append(f"has discussed: {topics}")
        
        if summary_parts:
            return "User context: " + ", ".join(summary_parts) + "."
        
        return ""
    
    def _load_session_from_redis(self, session_id: str, memory: ConversationBufferWindowMemory):
        """Load conversation history from Redis"""
        if not self.redis_client:
            return
        
        try:
            key = f"session_memory:{session_id}"
            data = self.redis_client.get(key)
            
            if data:
                messages_data = json.loads(data)
                for msg_data in messages_data:
                    if msg_data['type'] == 'human':
                        memory.chat_memory.add_user_message(msg_data['content'])
                    else:
                        memory.chat_memory.add_ai_message(msg_data['content'])
                
                logger.info(f"Loaded {len(messages_data)} messages from Redis for session {session_id}")
        
        except Exception as e:
            logger.error(f"Error loading session from Redis: {e}")
    
    def _save_session_to_redis(self, session_id: str, memory: ConversationBufferWindowMemory):
        """Save conversation history to Redis"""
        if not self.redis_client:
            return
        
        try:
            messages_data = []
            for message in memory.chat_memory.messages:
                messages_data.append({
                    'type': 'human' if isinstance(message, HumanMessage) else 'ai',
                    'content': message.content,
                    'timestamp': getattr(message, 'timestamp', datetime.now().isoformat())
                })
            
            key = f"session_memory:{session_id}"
            
            # Set with expiration (24 hours)
            self.redis_client.setex(
                key,
                timedelta(hours=24),
                json.dumps(messages_data)
            )
            
            logger.debug(f"Saved session {session_id} to Redis")
            
        except Exception as e:
            logger.error(f"Error saving session to Redis: {e}")
    
    def _load_context_from_redis(self, session_id: str) -> Optional[Dict[str, Any]]:
        """Load session context from Redis"""
        if not self.redis_client:
            return None
        
        try:
            key = f"session_context:{session_id}"
            data = self.redis_client.get(key)
            
            if data:
                context = json.loads(data)
                logger.info(f"Loaded context from Redis for session {session_id}")
                return context
        
        except Exception as e:
            logger.error(f"Error loading context from Redis: {e}")
        
        return None
    
    def _save_context_to_redis(self, session_id: str, context: Dict[str, Any]):
        """Save session context to Redis"""
        if not self.redis_client:
            return
        
        try:
            key = f"session_context:{session_id}"
            
            # Set with expiration (24 hours)
            self.redis_client.setex(
                key,
                timedelta(hours=24),
                json.dumps(context, default=str)
            )
            
            logger.debug(f"Saved context for session {session_id} to Redis")
            
        except Exception as e:
            logger.error(f"Error saving context to Redis: {e}")
    
    def cleanup_expired_sessions(self):
        """Clean up expired sessions from memory (Redis TTL handles persistence)"""
        try:
            expired_sessions = []
            current_time = datetime.now()
            
            for session_id, context in self.session_contexts.items():
                last_activity = datetime.fromisoformat(context['last_activity'])
                if current_time - last_activity > timedelta(hours=1):  # 1 hour timeout
                    expired_sessions.append(session_id)
            
            for session_id in expired_sessions:
                if session_id in self.session_memories:
                    del self.session_memories[session_id]
                if session_id in self.session_contexts:
                    del self.session_contexts[session_id]
                logger.info(f"Cleaned up expired session {session_id}")
                
        except Exception as e:
            logger.error(f"Error during session cleanup: {e}")

# Global instance
_session_manager_instance = None

def get_session_manager() -> SessionManager:
    """Get singleton session manager instance"""
    global _session_manager_instance
    if _session_manager_instance is None:
        _session_manager_instance = SessionManager()
    return _session_manager_instance