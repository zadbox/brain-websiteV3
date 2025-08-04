from fastapi import FastAPI, HTTPException, BackgroundTasks
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel, field_validator
from typing import Optional, List, Dict, Any, Union
import os
import logging
import json
import uuid
import asyncio
import time
from datetime import datetime, timedelta
from dotenv import load_dotenv

# LangChain imports
from langchain_huggingface import HuggingFaceEndpoint
from langchain_huggingface import HuggingFaceEmbeddings
from langchain_core.tools import BaseTool
from langchain_core.messages import HumanMessage, AIMessage
from langchain_core.prompts import PromptTemplate
from langchain.agents import create_react_agent
from langchain.memory import ConversationBufferWindowMemory
from langchain_text_splitters import RecursiveCharacterTextSplitter
from langchain_community.document_loaders import TextLoader
from langchain_qdrant import Qdrant
from qdrant_client import QdrantClient
from langchain_groq import ChatGroq

# Monitoring imports
from prometheus_client import Counter, Histogram, Gauge, generate_latest, CONTENT_TYPE_LATEST
import structlog

# Load environment variables
load_dotenv()

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = structlog.get_logger()

# Startup event
from contextlib import asynccontextmanager

@asynccontextmanager
async def lifespan(app: FastAPI):
    """Initialize application on startup and cleanup on shutdown"""
    # Startup
    logger.info("Starting BrainGenTech LangChain API v2.2.0")
    logger.info("Fast vector-based responses initialized: True")
    logger.info(f"Vector store available: {vectorstore is not None}")
    logger.info(f"Max conversations: {Config.MAX_ACTIVE_CONVERSATIONS}")
    logger.info(f"Memory retention: {Config.MAX_MEMORY_HOURS} hours")
    
    yield
    
    # Shutdown
    logger.info("Shutting down BrainGenTech LangChain API")
    # Clear all conversation memories
    conversation_memories.clear()
    ACTIVE_CONVERSATIONS.set(0)
    MEMORY_USAGE.set(0)

# Initialize FastAPI app with lifespan
app = FastAPI(
    title="BrainGenTech LangChain API",
    description="Advanced AI chatbot with LangChain integration, custom tools, and conversation memory",
    version="2.1.0",
    docs_url="/docs",
    redoc_url="/redoc",
    lifespan=lifespan
)

# Add CORS middleware with more specific configuration
app.add_middleware(
    CORSMiddleware,
    allow_origins=os.getenv("ALLOWED_ORIGINS", "*").split(","),
    allow_credentials=True,
    allow_methods=["GET", "POST", "PUT", "DELETE"],
    allow_headers=["*"],
)

# Configuration
class Config:
    HUGGINGFACE_API_KEY = os.getenv("HUGGINGFACE_API_KEY")
    GROQ_API_KEY = os.getenv("GROQ_API_KEY", "gsk_1234567890abcdef")  # Default for testing
    LLM_PROVIDER = os.getenv("LLM_PROVIDER", "groq")
    QDRANT_URL = os.getenv("QDRANT_URL", "http://localhost:6333")
    QDRANT_COLLECTION = os.getenv("QDRANT_COLLECTION", "braingen_tech")
    MAX_MEMORY_HOURS = int(os.getenv("MAX_MEMORY_HOURS", "24"))
    MAX_ACTIVE_CONVERSATIONS = int(os.getenv("MAX_ACTIVE_CONVERSATIONS", "1000"))
    
    @classmethod
    def validate(cls):
        # Groq API key required for LLM functionality
        if cls.LLM_PROVIDER == "groq" and not cls.GROQ_API_KEY:
            logger.warning("GROQ_API_KEY not provided - using fast vector responses only")
        return True

# Validate configuration
Config.validate()

# Groq API Configuration - Direct API calls for better compatibility
groq_available = bool(Config.GROQ_API_KEY and Config.LLM_PROVIDER == "groq")
if groq_available:
    logger.info("Groq API configured for intelligent RAG responses (llama-3.1-8b-instant)")
else:
    logger.info("Using ultra-fast vector-based responses only - no Groq API configured")

# Initialize embeddings with Hugging Face
try:
    embeddings = HuggingFaceEmbeddings(
        model_name="sentence-transformers/all-MiniLM-L6-v2",  # 384-dim
        model_kwargs={'device': 'cpu'}
    )
    logger.info("Hugging Face embeddings initialized successfully")
except Exception as e:
    logger.warning(f"Failed to initialize Hugging Face embeddings: {e}")
    embeddings = None

# Initialize Qdrant client and vector store
try:
    qdrant_client = QdrantClient(host="localhost", port=6333)
    
    if embeddings:
        # Check if collection exists and get its dimension
        try:
            collection_info = qdrant_client.get_collection(Config.QDRANT_COLLECTION)
            existing_dim = collection_info.config.params.vectors.size
            
            # Get embedding dimension by testing a sample
            test_embedding = embeddings.embed_query("test")
            current_dim = len(test_embedding)
            
            logger.info(f"Collection dimension: {existing_dim}, Embedding dimension: {current_dim}")
            
            if existing_dim != current_dim:
                logger.warning(f"Dimension mismatch: collection={existing_dim}, embeddings={current_dim}")
                logger.info("Recreating collection with correct dimensions...")
                
                # Delete existing collection
                qdrant_client.delete_collection(Config.QDRANT_COLLECTION)
                logger.info(f"Deleted existing collection: {Config.QDRANT_COLLECTION}")
                
                # The Qdrant class will create a new collection with correct dimensions
                vectorstore = Qdrant(
                    client=qdrant_client,
                    collection_name=Config.QDRANT_COLLECTION,
                    embeddings=embeddings
                )
                logger.info(f"Created new collection with {current_dim} dimensions")
            else:
                # Dimensions match, use existing collection
                vectorstore = Qdrant(
                    client=qdrant_client,
                    collection_name=Config.QDRANT_COLLECTION,
                    embeddings=embeddings
                )
                logger.info("Vector store initialized with existing collection")
                
        except Exception as collection_error:
            logger.info(f"Collection doesn't exist or error checking: {collection_error}")
            # Create new collection
            vectorstore = Qdrant(
                client=qdrant_client,
                collection_name=Config.QDRANT_COLLECTION,
                embeddings=embeddings
            )
            logger.info("Created new vector store collection")
    else:
        vectorstore = None
        logger.warning("No embeddings available, vector store disabled")
        
except Exception as e:
    logger.warning(f"Vector store initialization failed: {e}")
    vectorstore = None

# Version simplifiée et robuste de ConversationMemoryWithMetadata
class ConversationMemoryWithMetadata:
    def __init__(self, k=10, return_messages=True):
        self.memory = ConversationBufferWindowMemory(k=k, return_messages=return_messages)
        self._created_at = datetime.now()
        self._last_accessed = datetime.now()
        self._message_count = 0
    
    @property
    def created_at(self):
        return self._created_at
    
    @property
    def last_accessed(self):
        return self._last_accessed
    
    @property
    def message_count(self):
        return self._message_count
    
    def save_context(self, inputs, outputs):
        """Save context and update metadata"""
        self.memory.save_context(inputs, outputs)
        self._last_accessed = datetime.now()
        self._message_count += 1
    
    def add_message(self, message):
        """Add message and update metadata"""
        if hasattr(self.memory, 'add_message'):
            self.memory.add_message(message)
        self._last_accessed = datetime.now()
        self._message_count += 1
    
    def load_memory_variables(self, inputs):
        """Load memory variables"""
        return self.memory.load_memory_variables(inputs)
    
    def clear(self):
        """Clear memory"""
        self.memory.clear()
        self._message_count = 0
    
    @property
    def messages(self):
        """Get messages"""
        return self.memory.messages if hasattr(self.memory, 'messages') else []

# Conversation memory storage
conversation_memories: Dict[str, ConversationMemoryWithMetadata] = {}

# Enhanced metrics
REQUEST_COUNT = Counter('chat_requests_total', 'Total chat requests', ['endpoint', 'status'])
REQUEST_DURATION = Histogram('chat_request_duration_seconds', 'Chat request duration', ['endpoint'])
ACTIVE_CONVERSATIONS = Gauge('active_conversations', 'Number of active conversations')
LEAD_QUALIFICATIONS = Counter('lead_qualifications_total', 'Total lead qualifications', ['category'])
MEMORY_USAGE = Gauge('memory_conversations_size', 'Number of stored conversations')
ERROR_COUNT = Counter('errors_total', 'Total errors', ['error_type'])

# Enhanced Pydantic models
class ChatRequest(BaseModel):
    message: str
    context: Optional[Dict[str, Any]] = {}
    lead_data: Optional[Dict[str, Any]] = {}
    session_id: Optional[str] = None
    user_id: Optional[str] = None
    metadata: Optional[Dict[str, Any]] = {}
    
    @field_validator('message')
    @classmethod
    def validate_message(cls, v):
        if not v or not v.strip():
            raise ValueError("Message cannot be empty")
        if len(v) > 10000:
            raise ValueError("Message too long (max 10000 characters)")
        return v.strip()
    
    @field_validator('context', 'lead_data', 'metadata', mode='before')
    @classmethod
    def convert_list_to_dict(cls, v):
        if isinstance(v, list):
            return {}
        return v or {}

class ChatResponse(BaseModel):
    response: str
    confidence: float
    sources: List[str]
    suggestions: List[str]
    lead_qualification: Optional[Dict[str, Any]] = None
    source: str = "langchain"
    session_id: str
    processing_time: float
    timestamp: datetime

class LeadQualificationRequest(BaseModel):
    message: str
    context: Optional[Dict[str, Any]] = {}
    lead_data: Optional[Dict[str, Any]] = {}

class KnowledgeRequest(BaseModel):
    text: str
    metadata: Optional[Dict[str, Any]] = {}
    
    @field_validator('text')
    @classmethod
    def validate_text(cls, v):
        if not v or not v.strip():
            raise ValueError("Text cannot be empty")
        return v.strip()

class SearchRequest(BaseModel):
    query: str
    limit: Optional[int] = 5
    
    @field_validator('limit')
    @classmethod
    def validate_limit(cls, v):
        if v < 1 or v > 50:
            raise ValueError("Limit must be between 1 and 50")
        return v

# Enhanced Custom Tools
class LeadQualificationTool(BaseTool):
    name: str = "lead_qualification"
    description: str = "Qualify a lead using BANT framework (Budget, Authority, Need, Timeline)"
    
    def _run(self, message: str) -> str:
        """Qualify a lead based on the message content"""
        try:
            qualification = self._analyze_bant(message)
            LEAD_QUALIFICATIONS.labels(category=qualification.get('category', 'Unknown')).inc()
            return json.dumps(qualification)
        except Exception as e:
            logger.error(f"Lead qualification error: {e}")
            ERROR_COUNT.labels(error_type='lead_qualification').inc()
            return json.dumps({
                "category": "unknown",
                "confidence": 0.0,
                "bant_score": {"budget": 0, "authority": 0, "need": 0, "timeline": 0},
                "overall_score": 0.0,
                "recommendations": ["Demander plus d'informations"]
            })
    
    def _analyze_bant(self, message: str) -> Dict[str, Any]:
        """Analyze message using BANT framework"""
        message_lower = message.lower()
        
        # Budget analysis
        budget_keywords = ['budget', 'coût', 'prix', 'argent', 'financement', 'investissement']
        budget_score = sum(1 for keyword in budget_keywords if keyword in message_lower) / len(budget_keywords)
        
        # Authority analysis
        authority_keywords = ['décideur', 'responsable', 'directeur', 'manager', 'chef', 'patron']
        authority_score = sum(1 for keyword in authority_keywords if keyword in message_lower) / len(authority_keywords)
        
        # Need analysis
        need_keywords = ['besoin', 'problème', 'difficulté', 'challenge', 'objectif', 'but']
        need_score = sum(1 for keyword in need_keywords if keyword in message_lower) / len(need_keywords)
        
        # Timeline analysis
        timeline_keywords = ['urgent', 'rapidement', 'délai', 'deadline', 'échéance', 'timing']
        timeline_score = sum(1 for keyword in timeline_keywords if keyword in message_lower) / len(timeline_keywords)
        
        # Calculate overall score
        overall_score = (budget_score + authority_score + need_score + timeline_score) / 4
        
        # Determine category
        if overall_score >= 0.8:
            category = "hot"
        elif overall_score >= 0.6:
            category = "warm"
        elif overall_score >= 0.4:
            category = "lukewarm"
        else:
            category = "cold"
        
        # Generate recommendations
        recommendations = self._generate_recommendations(overall_score, category)
        
        return {
            "category": category,
            "confidence": overall_score,
            "bant_score": {
                "budget": budget_score,
                "authority": authority_score,
                "need": need_score,
                "timeline": timeline_score
            },
            "overall_score": overall_score,
            "recommendations": recommendations
        }
    
    def _generate_recommendations(self, score: float, category: str) -> List[str]:
        """Generate recommendations based on score and category"""
        recommendations = []
        
        if score < 0.5:
            recommendations.extend([
                "Demander plus d'informations sur les besoins",
                "Qualifier le budget disponible",
                "Identifier le décideur principal"
            ])
        elif score < 0.7:
            recommendations.extend([
                "Présenter une démonstration",
                "Proposer un devis personnalisé",
                "Planifier un appel de suivi"
            ])
        else:
            recommendations.extend([
                "Présenter une proposition détaillée",
                "Organiser une réunion avec les décideurs",
                "Préparer un plan d'implémentation"
            ])
        
        return recommendations

class BudgetCalculatorTool(BaseTool):
    name: str = "budget_calculator"
    description: str = "Calculate project budget based on requirements and scope"
    
    def _run(self, requirements: str) -> str:
        """Calculate budget based on requirements"""
        try:
            budget = self._estimate_budget(requirements)
            return json.dumps(budget)
        except Exception as e:
            logger.error(f"Budget calculation error: {e}")
            ERROR_COUNT.labels(error_type='budget_calculation').inc()
            return json.dumps({
                "estimated_budget": 0,
                "currency": "EUR",
                "confidence": 0.0,
                "breakdown": {},
                "recommendations": ["Demander plus de détails sur les besoins"]
            })
    
    def _estimate_budget(self, requirements: str) -> Dict[str, Any]:
        """Estimate budget based on requirements"""
        requirements_lower = requirements.lower()
        
        # Base costs
        base_cost = 5000  # EUR
        
        # Additional costs based on requirements
        additional_costs = 0
        
        if any(word in requirements_lower for word in ['site web', 'website', 'web']):
            additional_costs += 3000
        
        if any(word in requirements_lower for word in ['application', 'app', 'mobile']):
            additional_costs += 8000
        
        if any(word in requirements_lower for word in ['e-commerce', 'boutique', 'vente']):
            additional_costs += 5000
        
        if any(word in requirements_lower for word in ['crm', 'gestion', 'administration']):
            additional_costs += 4000
        
        if any(word in requirements_lower for word in ['intelligence artificielle', 'ai', 'machine learning']):
            additional_costs += 10000
        
        if any(word in requirements_lower for word in ['intégration', 'api', 'système']):
            additional_costs += 3000
        
        # Calculate confidence based on detail level
        detail_words = len(requirements.split())
        confidence = min(0.9, 0.3 + (detail_words * 0.02))
        
        total_budget = base_cost + additional_costs
        
        return {
            "estimated_budget": total_budget,
            "currency": "EUR",
            "confidence": confidence,
            "breakdown": {
                "base_cost": base_cost,
                "additional_costs": additional_costs,
                "total": total_budget
            },
            "recommendations": [
                "Budget estimé pour un projet de base",
                "Prix peuvent varier selon la complexité",
                "Devis détaillé disponible sur demande"
            ]
        }

class ServiceRecommendationTool(BaseTool):
    name: str = "service_recommendation"
    description: str = "Recommend BrainGenTech services based on client needs"
    
    def _run(self, needs: str) -> str:
        """Recommend services based on client needs"""
        try:
            recommendations = self._analyze_needs(needs)
            return json.dumps(recommendations)
        except Exception as e:
            logger.error(f"Service recommendation error: {e}")
            ERROR_COUNT.labels(error_type='service_recommendation').inc()
            return json.dumps({
                "services": [],
                "priority": "medium",
                "next_steps": ["Contactez-nous pour une consultation"]
            })
    
    def _analyze_needs(self, needs: str) -> Dict[str, Any]:
        """Analyze needs and recommend services"""
        needs_lower = needs.lower()
        
        services = []
        priority = "medium"
        
        # Web Development
        if any(word in needs_lower for word in ['site web', 'website', 'présence en ligne']):
            services.append({
                "name": "Développement Web",
                "description": "Sites web modernes et responsives",
                "priority": "high"
            })
        
        # Mobile Development
        if any(word in needs_lower for word in ['application mobile', 'app', 'smartphone']):
            services.append({
                "name": "Développement Mobile",
                "description": "Applications iOS et Android",
                "priority": "high"
            })
        
        # E-commerce
        if any(word in needs_lower for word in ['e-commerce', 'boutique en ligne', 'vente en ligne']):
            services.append({
                "name": "Solutions E-commerce",
                "description": "Plateformes de vente en ligne",
                "priority": "high"
            })
        
        # CRM & Management
        if any(word in needs_lower for word in ['crm', 'gestion', 'administration']):
            services.append({
                "name": "Solutions CRM",
                "description": "Gestion de la relation client",
                "priority": "medium"
            })
        
        # AI & Automation
        if any(word in needs_lower for word in ['intelligence artificielle', 'ai', 'automatisation']):
            services.append({
                "name": "Intelligence Artificielle",
                "description": "Solutions IA et automatisation",
                "priority": "high"
            })
        
        # Digital Marketing
        if any(word in needs_lower for word in ['marketing', 'publicité', 'visibilité']):
            services.append({
                "name": "Marketing Digital",
                "description": "Stratégies marketing en ligne",
                "priority": "medium"
            })
        
        # Determine overall priority
        if any(service.get('priority') == 'high' for service in services):
            priority = "high"
        elif not services:
            priority = "low"
        
        # Generate next steps
        next_steps = self._generate_next_steps(priority)
        
        return {
            "services": services,
            "priority": priority,
            "next_steps": next_steps
        }
    
    def _generate_next_steps(self, priority: str) -> List[str]:
        """Generate next steps based on priority"""
        if priority == "high":
            return [
                "Planifier une réunion urgente",
                "Préparer une proposition détaillée",
                "Organiser une démonstration"
            ]
        elif priority == "medium":
            return [
                "Programmer un appel de qualification",
                "Envoyer des informations détaillées",
                "Proposer une consultation gratuite"
            ]
        else:
            return [
                "Maintenir le contact",
                "Envoyer des ressources informatives",
                "Programmer un suivi dans 3 mois"
            ]

# Alternative plus simple - remplacez également la fonction get_conversation_memory :
def get_conversation_memory(session_id: str) -> ConversationMemoryWithMetadata:
    """Get or create conversation memory for session with cleanup"""
    # Clean up if too many active conversations
    if len(conversation_memories) >= Config.MAX_ACTIVE_CONVERSATIONS:
        cleanup_old_memories()
    
    if session_id not in conversation_memories:
        try:
            memory = ConversationMemoryWithMetadata(
                k=10,  # Keep last 10 exchanges
                return_messages=True
            )
            conversation_memories[session_id] = memory
            ACTIVE_CONVERSATIONS.inc()
            MEMORY_USAGE.set(len(conversation_memories))
            logger.info(f"Created new memory for session: {session_id}")
        except Exception as e:
            logger.error(f"Failed to create memory for session {session_id}: {e}")
            # Créer une mémoire de base en cas d'échec
            memory = ConversationMemoryWithMetadata(k=10, return_messages=True)
            conversation_memories[session_id] = memory
    
    # Mettre à jour last_accessed
    memory = conversation_memories[session_id]
    memory._last_accessed = datetime.now()
    
    return memory

# Également, corrigez la fonction cleanup_old_memories pour être plus robuste :
def cleanup_old_memories():
    """Enhanced cleanup with better logging and error handling"""
    current_time = datetime.now()
    sessions_to_remove = []
    
    for session_id, memory in conversation_memories.items():
        try:
            # Vérifier si l'attribut existe avant de l'utiliser
            if hasattr(memory, 'last_accessed'):
                age_hours = (current_time - memory.last_accessed).total_seconds() / 3600
            else:
                # Si pas d'attribut last_accessed, considérer comme ancien
                age_hours = Config.MAX_MEMORY_HOURS + 1
                
            if age_hours > Config.MAX_MEMORY_HOURS:
                sessions_to_remove.append(session_id)
        except Exception as e:
            logger.warning(f"Error checking memory age for session {session_id}: {e}")
            # En cas d'erreur, marquer pour suppression
            sessions_to_remove.append(session_id)
    
    cleaned_count = 0
    for session_id in sessions_to_remove:
        try:
            del conversation_memories[session_id]
            ACTIVE_CONVERSATIONS.dec()
            cleaned_count += 1
        except Exception as e:
            logger.warning(f"Error removing session {session_id}: {e}")
    
    MEMORY_USAGE.set(len(conversation_memories))
    
    if cleaned_count > 0:
        logger.info(f"Cleaned up {cleaned_count} old conversation memories")

# Enhanced endpoints
@app.post("/chat", response_model=ChatResponse)
async def chat(request: ChatRequest, background_tasks: BackgroundTasks):
    """Enhanced chat endpoint with better error handling and monitoring"""
    start_time = datetime.now()
    session_id = request.session_id or str(uuid.uuid4())
    
    REQUEST_COUNT.labels(endpoint='chat', status='started').inc()
    
    try:
        # Get or create memory
        memory = get_conversation_memory(session_id)
        
        # Build enhanced context - version sécurisée
        context = {
            **request.context,
            "user_id": request.user_id,
            "session_info": {
                "created_at": getattr(memory, 'created_at', datetime.now()).isoformat(),
                "message_count": getattr(memory, 'message_count', 0),
                "session_id": session_id
            }
        }
        
        # No LLM testing needed - using pure vector responses
        
        # INTELLIGENT RAG RESPONSE SYSTEM
        try:
            if groq_available:
                # Use intelligent RAG with Groq API (with or without vector search)
                response_text = generate_intelligent_rag_response(request.message, session_id)
                logger.info(f"Intelligent RAG response generated: {len(response_text)} characters")
            else:
                # Fallback to fast responses
                response_text = generate_fast_response(request.message)
                logger.info(f"Fast fallback response generated: {len(response_text)} characters")
                
        except Exception as e:
            logger.error(f"Response generation failed: {e}")
            response_text = "Désolé, je rencontre un problème technique. Contactez-nous au +212 XXX XXX XXX pour une assistance immédiate."
        
        # Extract lead qualification (simplified for now)
        lead_qualification = None
        try:
            # Simple lead qualification without tools for now
            lead_qualification = {
                "category": "prospect",
                "confidence": 0.7,
                "bant_score": {
                    "budget": 0.5,
                    "authority": 0.6,
                    "need": 0.8,
                    "timeline": 0.4
                },
                "overall_score": 0.6,
                "recommendations": ["Demander plus d'informations sur le budget", "Qualifier l'autorité décisionnelle"]
            }
        except Exception as e:
            logger.warning(f"Lead qualification failed: {e}")
        
        # Generate context-aware suggestions (simplified)
        suggestions = [
            "Pouvez-vous me parler de votre entreprise ?",
            "Quel est votre secteur d'activité ?",
            "Avez-vous un budget défini pour ce projet ?",
            "Quel est votre délai pour ce projet ?"
        ]
        
        # Calculate confidence
        confidence = calculate_response_confidence(response_text, request.message)
        
        # Processing time
        processing_time = (datetime.now() - start_time).total_seconds()
        REQUEST_DURATION.labels(endpoint='chat').observe(processing_time)
        REQUEST_COUNT.labels(endpoint='chat', status='success').inc()
        
        # Schedule cleanup
        background_tasks.add_task(cleanup_old_memories)
        
        logger.info("Chat processed successfully", 
                   session_id=session_id,
                   processing_time=processing_time,
                   confidence=confidence,
                   message_length=len(request.message))
        
        return ChatResponse(
            response=response_text,
            confidence=confidence,
            sources=["langchain", "huggingface"],
            suggestions=suggestions,
            lead_qualification=lead_qualification,
            source="langchain",
            session_id=session_id,
            processing_time=processing_time,
            timestamp=datetime.now()
        )
        
    except HTTPException:
        raise
    except Exception as e:
        ERROR_COUNT.labels(error_type='chat_processing').inc()
        REQUEST_COUNT.labels(endpoint='chat', status='error').inc()
        logger.error("Chat processing error", 
                    error=str(e), 
                    session_id=session_id,
                    message_preview=request.message[:100])
        raise HTTPException(status_code=500, detail="Erreur lors du traitement du message")

def generate_smart_suggestions(message: str, lead_qualification: Optional[Dict]) -> List[str]:
    """Generate professional, contextual suggestions for BrainGenTech conversations"""
    message_lower = message.lower()
    suggestions = []
    
    # AI/Technology focused suggestions
    if any(word in message_lower for word in ['ai', 'ia', 'intelligence', 'automation', 'chatbot']):
        suggestions.extend([
            "Découvrez nos solutions IA personnalisées",
            "Demandez une démonstration de nos chatbots",
            "Explorez nos cas d'usage en intelligence artificielle"
        ])
    
    # Services/Solutions suggestions
    if any(word in message_lower for word in ['service', 'solution', 'développement', 'web', 'mobile']):
        suggestions.extend([
            "Consultez notre portfolio de réalisations",
            "Planifiez un audit gratuit de vos besoins",
            "Découvrez nos forfaits tout-en-un"
        ])
    
    # Pricing/Budget suggestions
    if any(word in message_lower for word in ['budget', 'coût', 'prix', 'tarif', 'devis']):
        suggestions.extend([
            "Obtenez un devis personnalisé gratuit",
            "Découvrez nos options de financement",
            "Calculez le ROI de votre projet digital"
        ])
    
    # Urgency/Timeline suggestions
    if any(word in message_lower for word in ['urgent', 'rapidement', 'délai', 'quand']):
        suggestions.extend([
            "Réservez un créneau prioritaire cette semaine",
            "Activez notre processus de démarrage express",
            "Découvrez notre méthodologie agile"
        ])
    
    # Company/Team suggestions
    if any(word in message_lower for word in ['équipe', 'entreprise', 'société', 'qui']):
        suggestions.extend([
            "Rencontrez notre équipe d'experts",
            "Découvrez nos certifications et expertises",
            "Consultez les témoignages de nos clients"
        ])
    
    # Technical suggestions
    if any(word in message_lower for word in ['technique', 'technologie', 'code', 'framework']):
        suggestions.extend([
            "Explorez notre stack technologique",
            "Demandez une architecture personnalisée",
            "Consultez nos bonnes pratiques techniques"
        ])
    
    # Contact/Meeting suggestions
    if any(word in message_lower for word in ['contact', 'rendez-vous', 'appel', 'rencontrer']):
        suggestions.extend([
            "Planifiez un appel stratégique de 30 minutes",
            "Réservez une consultation technique gratuite",
            "Organisez une présentation de nos solutions"
        ])
    
    # Default professional suggestions
    base_suggestions = [
        "Demandez une consultation stratégique gratuite",
        "Explorez nos solutions sur-mesure",
        "Découvrez pourquoi +200 clients nous font confiance",
        "Obtenez un audit gratuit de votre présence digitale",
        "Planifiez un rendez-vous avec nos experts"
    ]
    
    # Lead qualification based suggestions
    if lead_qualification:
        category = lead_qualification.get('category', '').lower()
        if category == 'hot':
            suggestions.extend([
                "Validez votre concept avec nos experts",
                "Lancez votre MVP dès la semaine prochaine",
                "Bénéficiez de nos tarifs préférentiels"
            ])
        elif category == 'warm':
            suggestions.extend([
                "Recevez notre guide de transformation digitale",
                "Participez à notre webinaire expertise",
                "Évaluez vos besoins avec notre questionnaire"
            ])
    
    # Return unique, high-value suggestions
    all_suggestions = suggestions + base_suggestions
    return list(dict.fromkeys(all_suggestions))[:4]  # Max 4 professional suggestions

def generate_intelligent_rag_response(message: str, session_id: str) -> str:
    """Intelligent RAG response using Direct Groq API + Vector Search"""
    start_time = time.time()
    
    try:
        if not Config.GROQ_API_KEY:
            logger.info("Groq API key not available, using fast fallback")
            return generate_fast_response(message)
        
        # 1. Vector search for relevant context (optional if vectorstore available)
        context = ""
        if vectorstore:
            try:
                relevant_docs = vectorstore.similarity_search(message, k=3)
                context = "\n".join([doc.page_content for doc in relevant_docs])
                logger.info(f"Found {len(relevant_docs)} relevant knowledge base entries")
            except Exception as e:
                logger.warning(f"Vector search failed: {e}")
                context = "Base de connaissances temporairement indisponible."
        else:
            context = "Utilisation des connaissances générales BrainGenTech."
        
        # 2. Create intelligent context-aware prompt
        rag_prompt = f"""Tu es l'assistant BrainGenTech. Analyse intelligemment chaque question.

**QUESTION:** "{message}"

**CLASSIFICATION INTELLIGENTE:**
- Mathématiques (2+2, 5+7, etc.) → Réponds directement puis brève mention services
- Sport/Actualités (match Barcelone, score foot, etc.) → Explique limitation puis propose services  
- Géographie/Culture (capitale, histoire, etc.) → Réponds puis courte transition business
- Business/Tech (budget entreprise, services IA, automation) → Mode commercial complet
- Ambiguë (budget barcelone, etc.) → Demande clarification intelligente

**SI BUSINESS - Contexte disponible:**
{context}

**RÉPONSE ADAPTÉE:**
- Question claire générale: Réponse directe + transition douce vers BrainGenTech
- Question business: Utilise contexte + prix + ROI + call-to-action
- Question ambiguë: "Je ne suis pas sûr si vous parlez de [interprétation A] ou [interprétation B]. Si c'est pour votre entreprise..."

**Spécialités:** Agroalimentaire 🌾 | Immobilier 🏠 | Communication 📢
**Ton:** Professionnel, naturel, max 180 mots

**Réponse:**"""

        # 3. Generate response with Direct Groq API
        import httpx
        
        response = httpx.post(
            "https://api.groq.com/openai/v1/chat/completions",
            headers={
                "Authorization": f"Bearer {Config.GROQ_API_KEY}",
                "Content-Type": "application/json"
            },
            json={
                "model": "llama-3.1-8b-instant",
                "messages": [{"role": "user", "content": rag_prompt}],
                "temperature": 0.3,
                "max_tokens": 1024,
                "stream": False
            },
            timeout=10.0
        )
        
        if response.status_code == 200:
            result = response.json()
            content = result["choices"][0]["message"]["content"]
            processing_time = time.time() - start_time
            logger.info(f"Groq RAG response generated in {processing_time:.3f}s")
            return content
        else:
            logger.error(f"Groq API error: {response.status_code} - {response.text}")
            return generate_fast_response(message)
        
    except Exception as e:
        logger.error(f"RAG generation failed: {e}")
        logger.info("Falling back to fast response")
        return generate_fast_response(message)

def generate_fast_response(message: str) -> str:
    """Ultra-fast response generation for BrainGenTech specializations"""
    message_lower = message.lower()
    
    # Instant sector detection
    if any(word in message_lower for word in ["agro", "alimentaire", "ferme", "blockchain", "traçabilité"]):
        return """🌾 **Solutions Agroalimentaires BrainGenTech**

• **Traçabilité Blockchain** : Suivi complet ferme → assiette
• **IA Qualité** : Contrôle automatique 99.9% de précision  
• **Logistique Optimisée** : +40% efficacité, -30% gaspillage

**ROI garanti :** 300% en 6 mois | **Prix :** À partir de 15k€

Démonstration disponible ! Contact : +212 XXX XXX XXX"""
    
    elif any(word in message_lower for word in ["immobilier", "propriété", "location", "gestion", "appartement"]):
        return """🏠 **Solutions Immobilières BrainGenTech**

• **Promotion IA** : +45% ventes, analyse marché automatisée
• **Conciergerie Premium** : Service 24/7, satisfaction 98%
• **Gestion Locative** : +60% efficacité, -40% vacance

**Investissement prédictif :** +85% précision, +200% ROI

Consultation gratuite : contact@braingentech.com"""
    
    elif any(word in message_lower for word in ["communication", "marketing", "chatbot", "contenu", "réseaux"]):
        return """📢 **Solutions Communication BrainGenTech**

• **Chatbots Multilingues** : 50+ langues, disponibilité 24/7
• **Génération de Contenu IA** : +70% temps économisé
• **Analytics Prédictives** : ROI moyen 247%

**Automatisation Marketing** : -80% tâches manuelles, 3x plus efficace

Révolutionnez votre communication ! Appelez maintenant."""
    
    elif any(word in message_lower for word in ["prix", "tarif", "coût", "budget"]):
        return """💰 **Tarification BrainGenTech**

**📦 Packages :**
• **Starter** : 5-15k€ (PME)
• **Professional** : 15-50k€ (Entreprises)  
• **Enterprise** : 50k€+ (Grandes organisations)

**🎯 ROI garanti :** 300% en 6 mois

**✅ Inclus :** Formation + Support 24/7 + Déploiement 2-4 semaines

Devis gratuit en 24h !"""
    
    elif any(word in message_lower for word in ["contact", "téléphone", "email", "rendez-vous"]):
        return """📞 **Contactez BrainGenTech**

**📧 Email :** contact@braingentech.com
**📱 Téléphone :** +212 XXX XXX XXX  
**🌐 Site :** www.braingentech.com

**📅 Services rapides :**
• Consultation gratuite (30 min)
• Devis personnalisé (24h)
• Démonstration live

**Disponible :** Lun-Ven 9h-18h (GMT+1)"""
    
    elif any(word in message_lower for word in ["bonjour", "salut", "hello", "hi"]):
        return """👋 **Bonjour ! Assistant IA BrainGenTech**

**Spécialistes en solutions digitales innovantes :**
• 🌾 **Agroalimentaire** (Blockchain, IA qualité)  
• 🏠 **Immobilier** (Promotion, gestion intelligente)
• 📢 **Communication** (Chatbots, marketing IA)

**Comment puis-je vous aider ?**
• Découvrir nos solutions
• Obtenir un devis
• Planifier une démonstration"""
    
    else:
        return """🚀 **BrainGenTech - Innovation Digitale**

**Solutions IA pour entreprises :**

**🌾 AGROALIMENTAIRE** : Blockchain + IA qualité
**🏠 IMMOBILIER** : Promotion + gestion intelligente  
**📢 COMMUNICATION** : Chatbots + marketing IA

**✅ Garanties :** ROI 300% | Support 24/7 | Déploiement 2-4 semaines

**Contact rapide :** +212 XXX XXX XXX | contact@braingentech.com

Quel secteur vous intéresse ?"""

def generate_intelligent_response(message: str, vectorstore) -> str:
    """
    Generate intelligent, fast responses using vector store knowledge
    Specialized for BrainGenTech company services and expertise
    """
    message_lower = message.lower()
    
    # 1. Search vector store for relevant knowledge
    try:
        # Search for similar content
        retriever = vectorstore.as_retriever(search_kwargs={"k": 3})
        relevant_docs = retriever.get_relevant_documents(message)
        
        # Extract relevant information
        context_info = []
        for doc in relevant_docs:
            context_info.append(doc.page_content)
        
        context = " ".join(context_info)[:1000]  # Limit context size
        
    except Exception as e:
        logger.warning(f"Vector search failed: {e}")
        context = ""
    
    # 2. Detect business sector and intent
    sector = detect_business_sector(message_lower)
    intent = detect_user_intent(message_lower)
    
    # 3. Generate specialized response
    if sector and context:
        return generate_sector_response(message, sector, context, intent)
    elif intent == "greeting":
        return generate_greeting_response()
    elif intent == "pricing":
        return generate_pricing_response()
    elif intent == "contact":
        return generate_contact_response()
    elif intent == "services":
        return generate_services_overview()
    else:
        # Use vector context if available
        if context:
            return generate_contextual_response(message, context)
        else:
            return generate_smart_fallback_response(message)

def detect_business_sector(message: str) -> str:
    """Detect which BrainGenTech sector the question is about"""
    sectors = {
        "agroalimentaire": ["agro", "alimentaire", "nourriture", "ferme", "agriculture", "blockchain", "traçabilité", "qualité", "production"],
        "immobilier": ["immobilier", "propriété", "logement", "appartement", "maison", "location", "vente", "gestion", "locataire"],
        "communication": ["communication", "marketing", "publicité", "chatbot", "contenu", "réseaux", "social", "campagne", "média"]
    }
    
    for sector, keywords in sectors.items():
        if any(keyword in message for keyword in keywords):
            return sector
    return ""

def detect_user_intent(message: str) -> str:
    """Detect user intent for quick response routing"""
    intents = {
        "greeting": ["bonjour", "salut", "hello", "hi", "bonsoir"],
        "pricing": ["prix", "tarif", "coût", "budget", "coûte", "combien"],
        "contact": ["contact", "téléphone", "email", "rendez-vous", "démonstration", "devis"],
        "services": ["service", "solution", "que faites", "proposez", "offrez"],
        "help": ["aide", "help", "comment", "pourquoi", "qu'est-ce"]
    }
    
    for intent, keywords in intents.items():
        if any(keyword in message for keyword in keywords):
            return intent
    return "general"

def generate_sector_response(message: str, sector: str, context: str, intent: str) -> str:
    """Generate specialized response for specific business sector"""
    responses = {
        "agroalimentaire": {
            "base": f"""🌾 **Solutions Agroalimentaires BrainGenTech**

Basé sur votre question sur {message}, voici nos solutions spécialisées :

{context[:500]}

**Nos services phares :**
• **Traçabilité Blockchain** : Suivi complet ferme → assiette
• **IA Qualité** : Contrôle automatique 99.9% de précision  
• **Logistique Optimisée** : +40% efficacité, -30% gaspillage

**ROI garanti :** 300% en 6 mois
**Prix :** À partir de 15k€ pour solutions complètes

Souhaitez-vous une démonstration de nos solutions agroalimentaires ?""",
            "contact": "Parlons de vos besoins agroalimentaires ! Contactez-nous au +212 XXX XXX XXX pour une consultation gratuite."
        },
        "immobilier": {
            "base": f"""🏠 **Solutions Immobilières BrainGenTech**

Pour votre question : "{message}"

{context[:500]}

**Nos spécialités immobilières :**
• **Promotion IA** : +45% ventes, analyse marché automatisée
• **Conciergerie Premium** : Service 24/7, satisfaction 98%
• **Gestion Locative** : +60% efficacité, -40% vacance

**Investissement prédictif :** +85% précision, +200% ROI

Voulez-vous voir comment nous optimisons votre business immobilier ?""",
            "contact": "Discutons de votre projet immobilier ! Réservez votre consultation gratuite."
        },
        "communication": {
            "base": f"""📢 **Solutions Communication BrainGenTech**

Concernant : "{message}"

{context[:500]}

**Nos services communication :**
• **Chatbots Multilingues** : 50+ langues, disponibilité 24/7
• **Génération de Contenu IA** : +70% temps économisé
• **Analytics Prédictives** : ROI moyen 247%

**Automatisation Marketing** : -80% tâches manuelles, 3x plus efficace

Prêt à révolutionner votre communication digitale ?""",
            "contact": "Transformons votre communication ! Planifions un appel stratégique."
        }
    }
    
    if intent == "contact":
        return responses[sector]["contact"]
    else:
        return responses[sector]["base"]

def generate_greeting_response() -> str:
    """Quick friendly greeting"""
    return """👋 **Bonjour ! Je suis l'assistant IA de BrainGenTech**

Nous sommes spécialisés dans les solutions digitales innovantes pour :
• 🌾 **Agroalimentaire** (Blockchain, IA qualité)  
• 🏠 **Immobilier** (Promotion, gestion intelligente)
• 📢 **Communication** (Chatbots, marketing IA)

**Comment puis-je vous aider aujourd'hui ?**
- Découvrir nos solutions
- Obtenir un devis
- Planifier une démonstration"""

def generate_pricing_response() -> str:
    """Quick pricing information"""
    return """💰 **Tarification BrainGenTech - Solutions sur mesure**

**📦 Packages disponibles :**
• **Starter** : 5-15k€ (PME)
• **Professional** : 15-50k€ (Entreprises moyennes)  
• **Enterprise** : 50k€+ (Grandes organisations)

**🎯 ROI garanti :** 300% en 6 mois ou remboursement partiel

**✅ Inclus dans tous les packages :**
- Formation complète
- Support 24/7
- Déploiement 2-4 semaines
- Garantie de performance

**Quel secteur vous intéresse ?** (Agroalimentaire, Immobilier, Communication)"""

def generate_contact_response() -> str:
    """Quick contact information"""  
    return """📞 **Contactez BrainGenTech**

**Consultation gratuite disponible !**

**📧 Email :** contact@braingentech.com
**📱 Téléphone :** +212 XXX XXX XXX  
**🌐 Site web :** www.braingentech.com

**📅 Réservez votre créneau :**
- Démonstration personnalisée (30 min)
- Analyse de vos besoins (gratuite)
- Devis sur mesure (24h)

**Disponibilités :** Du lundi au vendredi, 9h-18h (GMT+1)

Quel service vous intéresse le plus ?"""

def generate_services_overview() -> str:
    """Quick services overview"""
    return """🚀 **Solutions BrainGenTech - Innovation Digitale**

**🌾 AGROALIMENTAIRE**
• Traçabilité Blockchain complète
• IA de contrôle qualité (99.9%)
• Optimisation logistique (+40% efficacité)

**🏠 IMMOBILIER**  
• Promotion intelligente (+45% ventes)
• Conciergerie premium 24/7
• Gestion locative automatisée

**📢 COMMUNICATION**
• Chatbots multilingues (50+ langues)
• Génération de contenu IA
• Analytics prédictives (247% ROI)

**✅ Garanties :** ROI 300% | Déploiement 2-4 semaines | Support 24/7

**Quel secteur vous intéresse ?**"""

def generate_contextual_response(message: str, context: str) -> str:
    """Generate response using vector context"""
    return f"""**BrainGenTech - Réponse spécialisée**

Basé sur votre question : "{message}"

{context[:600]}

**Pour aller plus loin :**
- Consultez nos solutions sectorielles
- Demandez une démonstration personnalisée  
- Obtenez un devis gratuit

**Contact rapide :** +212 XXX XXX XXX ou contact@braingentech.com

Avez-vous des questions spécifiques sur nos services ?"""

def generate_smart_fallback_response(message: str) -> str:
    """Generate professional, detailed fallback responses for BrainGenTech"""
    message_lower = message.lower()
    
    # Greetings
    if any(word in message_lower for word in ['bonjour', 'hello', 'hi', 'salut', 'coucou', 'bonsoir']):
        return "Bonjour et bienvenue chez BrainGenTech ! 🚀 Je suis votre consultant virtuel spécialisé en solutions digitales innovantes. Nous sommes leaders au Maroc dans la transformation numérique des entreprises. Que vous recherchiez du développement web, des applications mobiles, de l'intelligence artificielle ou des stratégies marketing digital, je suis là pour vous accompagner. Comment puis-je vous aider à concrétiser votre vision digitale ?"
    
    # AI/IA questions
    if any(word in message_lower for word in ['ai', 'ia', 'intelligence artificielle', 'artificial intelligence', 'machine learning', 'automation']):
        return "Excellente question ! BrainGenTech est pionnier en intelligence artificielle au Maroc. Nous développons des solutions IA sur-mesure : chatbots intelligents, analyse prédictive, automatisation des processus, vision par ordinateur, et traitement du langage naturel. Nos experts maîtrisent TensorFlow, PyTorch, OpenAI, et les dernières avancées en IA générative. Quel défi business souhaitez-vous résoudre avec l'IA ?"
    
    # Services questions with vector database context
    if any(word in message_lower for word in ['service', 'solution', 'aide', 'assistance', 'offre']):
        return "BrainGenTech vous accompagne dans tous vos projets digitaux avec une expertise 360° :\n\n🌾 **Agroalimentaire** : Traçabilité blockchain, IA qualité alimentaire, optimisation logistique, certification automatisée\n🏢 **Immobilier** : Promotion IA, conciergerie intelligente, gestion locative automatisée, investissement prédictif\n📢 **Communication** : Chatbots multilingues IA (50+ langues), génération contenu automatique, analytics prédictives marketing\n🤖 **Intelligence Artificielle** : LangChain + Cohere LLM, qualification BANT automatique, analyse prédictive ROI 300%\n⚙️ **Solutions Techniques** : Architecture microservices, intégrations CRM/API, déploiement Docker\n\n💰 **Packages disponibles** : Starter (5-15k€), Professional (15-50k€), Enterprise (50k€+) avec garantie ROI et formation incluse.\n\nQuel secteur vous intéresse ? Je peux vous présenter nos success stories et cas d'usage spécifiques !"
    
    # Pricing questions with knowledge base context
    if any(word in message_lower for word in ['tarif', 'prix', 'coût', 'budget', 'devis', 'combien', 'investissement']):
        return "Chez BrainGenTech, nos tarifs s'adaptent à tous les budgets avec des packages transparents :\n\n🚀 **Package Starter (5-15k€)** : Idéal pour PME\n• Chatbot IA multilingue de base\n• Qualification automatique des leads\n• Formation et support inclus\n\n🎯 **Package Professional (15-50k€)** : Pour entreprises moyennes\n• Solutions IA complètes sectorielles\n• Intégrations CRM/API avancées\n• Analytics prédictives et ROI tracking\n\n🏆 **Package Enterprise (50k€+)** : Pour grandes organisations\n• Architecture microservices sur-mesure\n• IA prédictive avancée (blockchain, computer vision)\n• Support premium 24/7 et garantie performance\n\n💰 **Financement disponible** : Paiement étalé 12-36 mois\n📊 **ROI garanti** : 300% en moyenne sous 6 mois ou remboursement partiel\n\nDans quelle fourchette se situe votre budget ? Je peux vous proposer une solution parfaitement adaptée !"
    
    # Technical questions with knowledge base context
    if any(word in message_lower for word in ['technique', 'technologie', 'développement', 'programmation', 'code', 'framework']):
        return "BrainGenTech maîtrise une stack technologique de pointe avec notre architecture propriétaire :\n\n🏗️ **Architecture BrainGenTech**\n• Microservices : Laravel (frontend) + Python FastAPI (IA)\n• Base vectorielle : Qdrant pour recherche sémantique\n• LLM Engine : Cohere + LangChain orchestration\n• Déploiement : Docker + Monitoring Prometheus/Grafana\n\n🤖 **Stack IA Avancée**\n• LangChain pour orchestration IA complexe\n• Support 50+ langues avec embeddings multilingues\n• Qualification BANT automatique intégrée\n• Computer vision + NLP + Analyse prédictive\n\n🔗 **Intégrations Natives**\n• CRM : Salesforce, HubSpot, pipelines personnalisés\n• Marketing : Mailchimp, Klaviyo, automation avancée\n• Business : Slack, Teams, APIs sur-mesure\n• Documentation complète + Support technique 24/7\n\n⚡ **Performance Garantie** : 99.9% uptime, déploiement 2-4 semaines\n\nQuelle intégration technique vous intéresse le plus ?"
    
    # Company questions with success stories from knowledge base
    if any(word in message_lower for word in ['entreprise', 'société', 'équipe', 'qui', 'braingen', 'brain', 'about', 'résultats', 'success']):
        return "BrainGenTech, votre partenaire digital de confiance au Maroc 🇲🇦\n\n🏆 **Leadership & Performance**\n• Pionniers de l'innovation IA depuis 2020\n• +200 projets réussis, 95% de satisfaction client\n• ROI moyen 300% en 6 mois, garantie performance\n• 99.9% uptime système, support 24/7 premium\n\n📊 **Success Stories Vérifiées**\n🌾 PME agroalimentaire : -40% coûts avec traçabilité blockchain\n🏢 Agence immobilière : Ventes doublées avec IA prédictive\n📢 Agence communication : Efficacité triplée avec automatisation IA\n💰 Clients moyens : +70% temps économisé, -80% tâches manuelles\n\n🎯 **Notre Expertise Unique**\n• Qualification BANT automatique (précision 99.9%)\n• Chatbots multilingues 50+ langues\n• Architecture microservices propriétaire\n• Déploiement express 2-4 semaines\n\n🤝 **Équipe d'Excellence**\nDéveloppeurs certifiés, experts IA, consultants ROI, architects cloud\n\nRejoignez +200 entreprises qui nous font déjà confiance ! Voulez-vous découvrir comment nous pouvons transformer votre business ?"
    
    # Contact/support questions
    if any(word in message_lower for word in ['contact', 'rendez-vous', 'appel', 'téléphone', 'email', 'rencontrer']):
        return "Excellente initiative ! Connectons-nous pour discuter de votre projet :\n\n📞 **Consultation gratuite** : Audit de vos besoins en 30 minutes\n💼 **Rendez-vous personnalisé** : Rencontre avec nos experts\n📧 **Devis express** : Estimation détaillée sous 48h\n🚀 **Démarrage rapide** : Lancement possible dès la semaine prochaine\n\nQuelle est votre préférence pour notre premier échange ? Appelez-nous ou planifions un rendez-vous selon votre agenda."
    
    # Web development questions
    if any(word in message_lower for word in ['site web', 'website', 'site internet', 'développement web', 'web']):
        return "Créons ensemble votre présence web d'exception ! 🌟\n\nBrainGenTech développe des sites web qui convertissent :\n\n✨ **Design Premium** : Interfaces modernes et user-friendly\n📱 **Responsive** : Parfait sur tous les écrans\n⚡ **Performance** : Temps de chargement optimisés\n🔍 **SEO intégré** : Visibilité Google garantie\n🛡️ **Sécurité renforcée** : Protection contre toutes les menaces\n📊 **Analytics avancés** : Suivi des performances en temps réel\n\nSite vitrine, e-commerce, application web complexe ? Décrivez-moi votre vision !"
    
    # Mobile app questions
    if any(word in message_lower for word in ['application mobile', 'app mobile', 'mobile app', 'ios', 'android']):
        return "Donnons vie à votre app mobile ! 📱✨\n\nBrainGenTech crée des applications mobiles qui marquent :\n\n🎨 **UX/UI exceptionnelle** : Design intuitif et engageant\n⚡ **Performance native** : Fluidité iOS et Android\n🔄 **Cross-platform** : Une base de code, deux plateformes\n🔔 **Notifications push** : Engagement utilisateur optimisé\n☁️ **Synchronisation cloud** : Données accessibles partout\n📊 **Analytics intégrés** : Comprendre vos utilisateurs\n\nApplication e-commerce, sociale, utilitaire ? Partagez votre concept et découvrons ensemble son potentiel !"
    
    # Sector-specific responses from knowledge base
    if any(word in message_lower for word in ['agroalimentaire', 'alimentaire', 'agriculture', 'traçabilité', 'blockchain']):
        return "Parfait ! BrainGenTech est expert en solutions agroalimentaires avancées :\n\n🔗 **Traçabilité Blockchain** : Suivi complet ferme-à-assiette, enregistrements immuables, transparence totale\n👁️ **IA Qualité Alimentaire** : Vision par ordinateur, détection défauts 99.9%, maintenance prédictive\n🚚 **Optimisation Logistique** : Planification itinéraires, gestion stocks périssables, +40% efficacité -30% gaspillage\n✅ **Certification Automatisée** : Conformité réglementaire auto, pistes d'audit, surveillance temps réel\n\nNos clients agroalimentaires réduisent leurs coûts de 40% en moyenne. Quel défi spécifique voulez-vous résoudre ?"
    
    if any(word in message_lower for word in ['immobilier', 'promotion', 'gestion locative', 'investissement', 'conciergerie']):
        return "Excellent choix ! BrainGenTech révolutionne l'immobilier avec l'IA :\n\n🏗️ **Promotion IA** : Analyse marché automatisée, prix prédictifs, visites virtuelles, +45% ventes -30% temps\n🎩 **Conciergerie Intelligente** : Assistance 24/7, maintenance prédictive, satisfaction locataire 98%\n🏠 **Gestion Locative IA** : Screening intelligent, optimisation loyers, +60% efficacité -40% vacance\n💰 **Investissement Prédictif** : Tendances marché, évaluation risques, +85% précision +200% ROI\n\nNos agences immobilières doublent leurs ventes en moyenne. Quel aspect de l'immobilier vous intéresse ?"
    
    if any(word in message_lower for word in ['communication', 'marketing', 'chatbot', 'contenu', 'réseaux sociaux']):
        return "Fantastique ! BrainGenTech transforme la communication avec l'IA :\n\n🤖 **Chatbots Multilingues IA** : 50+ langues, 24/7, contextuel avancé, 99.9% précision, multicanal\n✍️ **Génération Contenu IA** : Posts sociaux, articles SEO, newsletters, +70% temps économisé +300% engagement\n📊 **Analytics Prédictives** : Tendances marché, optimisation campagnes automatique, ROI 247%\n⚙️ **Automatisation Marketing** : Workflows intelligents, qualification leads, -80% tâches manuelles 3x efficacité\n\nNos agences de communication triplent leur efficacité. Quelle stratégie communication vous préoccupe ?"
    
    # Default professional response with BANT qualification context
    return f"Merci pour votre question ! 💡 Je suis votre consultant IA BrainGenTech.\n\n**Votre message** : '{message[:80]}...'\n\n🎯 **Solutions BrainGenTech adaptées** :\n• Qualification automatique BANT (99.9% précision)\n• ROI garanti 300% sous 6 mois\n• Déploiement express 2-4 semaines\n• Support premium 24/7 inclus\n\n📋 **Pour vous accompagner idéalement**, j'aimerais comprendre :\n• Votre secteur d'activité (agroalimentaire, immobilier, communication ?)\n• Vos objectifs business prioritaires\n• Votre délai et budget approximatif\n\n🚀 **Prochaines étapes** : Consultation gratuite 30min + Devis personnalisé sous 48h\n\nQuel secteur vous concerne le plus ? Je peux vous présenter des cas d'usage concrets et notre garantie ROI !"

def calculate_response_confidence(response: str, original_message: str) -> float:
    """Calculate confidence score for the response"""
    # Simple confidence calculation based on response length and content
    if not response or len(response.strip()) < 10:
        return 0.3
    
    # Higher confidence for longer, more detailed responses
    confidence = min(0.9, 0.5 + (len(response) / 1000))
    
    # Boost confidence if response contains relevant keywords
    relevant_keywords = ['brain', 'tech', 'service', 'aide', 'assister', 'solution']
    if any(keyword in response.lower() for keyword in relevant_keywords):
        confidence += 0.1
    
    return min(0.95, confidence)

@app.post("/qualify-lead")
async def qualify_lead(request: LeadQualificationRequest):
    """Qualify a lead using BANT framework"""
    try:
        qualification_tool = LeadQualificationTool()
        result = qualification_tool._run(request.message)
        return json.loads(result)
    except Exception as e:
        logger.error(f"Lead qualification error: {e}")
        raise HTTPException(status_code=500, detail="Erreur lors de la qualification du lead")

@app.post("/add-knowledge")
async def add_knowledge(request: KnowledgeRequest):
    """Add knowledge to the vector store"""
    if not vectorstore:
        raise HTTPException(status_code=503, detail="Vector store not available")
    
    try:
        # Split text into chunks
        text_splitter = RecursiveCharacterTextSplitter(
            chunk_size=1000,
            chunk_overlap=200
        )
        chunks = text_splitter.split_text(request.text)
        
        # Add to vector store
        vectorstore.add_texts(
            texts=chunks,
            metadatas=[request.metadata or {}] * len(chunks)
        )
        
        return {
            "status": "success",
            "message": f"Added {len(chunks)} chunks to knowledge base",
            "chunks_count": len(chunks)
        }
    except Exception as e:
        logger.error(f"Knowledge addition error: {e}")
        raise HTTPException(status_code=500, detail="Erreur lors de l'ajout de connaissances")

@app.get("/search-knowledge")
async def search_knowledge(query: str, limit: int = 5, include_metadata: bool = True):
    """Search knowledge base"""
    if not vectorstore:
        raise HTTPException(status_code=503, detail="Vector store not available")
    
    try:
        # Search in vector store
        results = vectorstore.similarity_search(query, k=limit)
        
        # Format results
        formatted_results = []
        for i, doc in enumerate(results):
            result = {
                "content": doc.page_content,
                "score": getattr(doc, 'score', 0.0),
                "rank": i + 1
            }
            if include_metadata and hasattr(doc, 'metadata'):
                result["metadata"] = doc.metadata
            formatted_results.append(result)
        
        return {
            "query": query,
            "results": formatted_results,
            "total_results": len(formatted_results)
        }
    except Exception as e:
        logger.error(f"Knowledge search error: {e}")
        raise HTTPException(status_code=500, detail="Erreur lors de la recherche")

@app.get("/health")
async def health_check():
    """Enhanced health check with detailed service status"""
    try:
        # Check Cohere
        cohere_status = "healthy"
        cohere_error = None
        try:
            # Test Cohere with a simple call
            test_response = llm.invoke("Test de santé")
            if not test_response:
                cohere_status = "unhealthy"
                cohere_error = "No response from Cohere"
        except Exception as e:
            cohere_status = "unhealthy"
            cohere_error = str(e)
        
        # Check vector store
        vectorstore_status = "healthy" if vectorstore else "unhealthy"
        
        # Check agent
        agent_status = "healthy"
        
        # Determine overall status
        if cohere_status == "healthy" and vectorstore_status == "healthy" and agent_status == "healthy":
            overall_status = "healthy"
        elif cohere_status == "healthy" or vectorstore_status == "healthy" or agent_status == "healthy":
            overall_status = "degraded"
        else:
            overall_status = "unhealthy"
        
        return {
            "status": overall_status,
            "timestamp": datetime.now().isoformat(),
            "version": "2.1.0",
            "services": {
                "cohere": f"{cohere_status}: {cohere_error}" if cohere_error else cohere_status,
                "agent": agent_status,
                "vectorstore": vectorstore_status
            },
            "metrics": {
                "active_conversations": len(conversation_memories),
                "max_conversations": Config.MAX_ACTIVE_CONVERSATIONS,
                "memory_usage_percent": (len(conversation_memories) / Config.MAX_ACTIVE_CONVERSATIONS) * 100
            }
        }
    except Exception as e:
        logger.error(f"Health check error: {e}")
        return {
            "status": "unhealthy",
            "timestamp": datetime.now().isoformat(),
            "version": "2.1.0",
            "error": str(e)
        }

@app.get("/metrics")
async def get_metrics():
    """Get Prometheus metrics"""
    from fastapi.responses import Response
    return Response(
        content=generate_latest(),
        media_type=CONTENT_TYPE_LATEST
    )

@app.get("/")
async def root():
    """Root endpoint with API information"""
    return {
        "message": "BrainGenTech LangChain API",
        "version": "2.1.0",
        "status": "running",
        "docs": "/docs",
        "health": "/health",
        "metrics": "/metrics"
    }

if __name__ == "__main__":
    import uvicorn
    
    # Configuration for production
    config = {
        "host": "0.0.0.0",
        "port": 8001,  # Force port 8001
        "workers": int(os.getenv("WORKERS", 1)),
        "log_level": os.getenv("LOG_LEVEL", "info").lower(),
        "access_log": True,
        "reload": os.getenv("ENVIRONMENT", "production") == "development"
    }
    
    logger.info("Starting server with configuration", **config)
    uvicorn.run(app, **config) 