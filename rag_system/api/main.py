"""
FastAPI Application for BrainGenTechnology RAG System
Provides chat and lead qualification endpoints with LangServe integration
"""
import os
import sys
import uvicorn
from fastapi import FastAPI, HTTPException, Depends, BackgroundTasks
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
from contextlib import asynccontextmanager
import logging
from typing import Dict, Any, Optional
from datetime import datetime, timezone

# Add parent directory to path for imports
current_dir = os.path.dirname(os.path.abspath(__file__))
parent_dir = os.path.dirname(current_dir)
sys.path.insert(0, parent_dir)

try:
    from chains.rag_chain import get_rag_chain, BrainGenRAGChain
    from chains.qualification_chain import get_qualification_chain, LeadQualificationChain
    from models.lead_qualification import (
        ConversationSession, 
        ChatMessage, 
        QualificationResponse
    )
    from config.settings import settings
except ImportError as e:
    print(f"Import error: {e}")
    print("Current working directory:", os.getcwd())
    print("Python path:", sys.path)
    raise

# Configure logging
logging.basicConfig(
    level=getattr(logging, settings.log_level),
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)

# Global instances
rag_chain: Optional[BrainGenRAGChain] = None
qualification_chain: Optional[LeadQualificationChain] = None

@asynccontextmanager
async def lifespan(app: FastAPI):
    """Application lifespan manager"""
    global rag_chain, qualification_chain
    
    logger.info("Starting BrainGenTechnology RAG API...")
    
    try:
        # Initialize chains
        rag_chain = get_rag_chain()
        qualification_chain = get_qualification_chain()
        
        logger.info("RAG system initialized successfully")
        yield
        
    except Exception as e:
        logger.error(f"Failed to initialize RAG system: {e}")
        raise
    finally:
        logger.info("Shutting down BrainGenTechnology RAG API...")

# Create FastAPI app
app = FastAPI(
    title="BrainGenTechnology RAG API",
    description="Intelligent conversational AI with lead qualification for BrainGenTechnology",
    version="1.0.0",
    docs_url="/docs",
    redoc_url="/redoc",
    lifespan=lifespan
)

# Configure CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Configure appropriately for production
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Request/Response Models
from pydantic import BaseModel, Field
from typing import List

class ChatRequest(BaseModel):
    """Request model for chat endpoint"""
    message: str = Field(..., min_length=1, max_length=2000, description="User's message")
    session_id: str = Field(..., min_length=1, description="Unique session identifier")
    metadata: Optional[Dict[str, Any]] = Field(default=None, description="Additional context")

class ChatResponse(BaseModel):
    """Response model for chat endpoint"""
    answer: str = Field(..., description="AI assistant's response")
    session_id: str = Field(..., description="Session identifier")
    sources: List[Dict[str, Any]] = Field(default=[], description="Source documents")
    conversation_length: int = Field(..., description="Number of messages in conversation")
    timestamp: str = Field(..., description="Response timestamp")
    processing_time: Optional[float] = Field(default=None, description="Processing time in seconds")

class QualificationRequest(BaseModel):
    """Request model for qualification endpoint"""
    session_id: str = Field(..., description="Session identifier to qualify")
    conversation_history: List[Dict[str, str]] = Field(..., description="Full conversation history")
    metadata: Optional[Dict[str, Any]] = Field(default=None, description="Additional context")

class HealthResponse(BaseModel):
    """Health check response model"""
    status: str
    version: str
    timestamp: str
    system_info: Dict[str, Any]

# Dependency injection
async def get_rag_chain_instance() -> BrainGenRAGChain:
    """Get RAG chain instance"""
    if rag_chain is None:
        raise HTTPException(status_code=503, detail="RAG system not initialized")
    return rag_chain

async def get_qualification_chain_instance() -> LeadQualificationChain:
    """Get qualification chain instance"""
    if qualification_chain is None:
        raise HTTPException(status_code=503, detail="Qualification system not initialized")
    return qualification_chain

# API Endpoints

@app.get("/", response_model=Dict[str, str])
async def root():
    """Root endpoint"""
    return {
        "message": "BrainGenTechnology RAG API",
        "version": "1.0.0",
        "docs": "/docs",
        "health": "/health"
    }

@app.get("/health", response_model=HealthResponse)
async def health_check(
    rag: BrainGenRAGChain = Depends(get_rag_chain_instance)
):
    """Health check endpoint"""
    try:
        system_status = rag.get_system_status()
        
        return HealthResponse(
            status="healthy",
            version="1.0.0",
            timestamp=datetime.now(timezone.utc).isoformat(),
            system_info=system_status
        )
    except Exception as e:
        logger.error(f"Health check failed: {e}")
        raise HTTPException(status_code=503, detail=f"System unhealthy: {str(e)}")

@app.post("/chat", response_model=ChatResponse)
async def chat_endpoint(
    request: ChatRequest,
    background_tasks: BackgroundTasks,
    rag: BrainGenRAGChain = Depends(get_rag_chain_instance)
):
    """
    Main chat endpoint for conversational AI
    Processes user messages and returns intelligent responses
    """
    start_time = datetime.now(timezone.utc)
    
    try:
        logger.info(f"Processing chat request for session {request.session_id}")
        
        # Validate request
        if not request.message.strip():
            raise HTTPException(status_code=400, detail="Message cannot be empty")
        
        # Process question through RAG chain
        result = await rag.ask_question(
            question=request.message,
            session_id=request.session_id,
            metadata=request.metadata
        )
        
        # Calculate processing time
        processing_time = (datetime.now(timezone.utc) - start_time).total_seconds()
        
        # Format response
        response = ChatResponse(
            answer=result["answer"],
            session_id=result["session_id"],
            sources=result.get("source_documents", []),
            conversation_length=result.get("conversation_length", 0),
            timestamp=result["timestamp"],
            processing_time=processing_time
        )
        
        # Add background task for analytics/logging
        background_tasks.add_task(
            log_conversation,
            request.session_id,
            request.message,
            result["answer"],
            processing_time
        )
        
        logger.info(f"Chat request completed for session {request.session_id}")
        return response
        
    except Exception as e:
        logger.error(f"Chat endpoint error: {e}")
        
        # Return graceful error response
        processing_time = (datetime.now(timezone.utc) - start_time).total_seconds()
        
        return ChatResponse(
            answer="I apologize, but I'm experiencing technical difficulties. Please try again or contact our support team for assistance.",
            session_id=request.session_id,
            sources=[],
            conversation_length=0,
            timestamp=datetime.now(timezone.utc).isoformat(),
            processing_time=processing_time
        )

@app.post("/qualify", response_model=QualificationResponse)
async def qualify_lead_endpoint(
    request: QualificationRequest,
    background_tasks: BackgroundTasks,
    qualification: LeadQualificationChain = Depends(get_qualification_chain_instance)
):
    """
    Lead qualification endpoint
    Analyzes conversation history to generate lead qualification data
    """
    try:
        logger.info(f"Processing qualification request for session {request.session_id}")
        
        # Validate request
        if not request.conversation_history:
            raise HTTPException(status_code=400, detail="Conversation history cannot be empty")
        
        # Process qualification
        result = await qualification.qualify_lead(
            conversation_history=request.conversation_history,
            session_id=request.session_id,
            metadata=request.metadata
        )
        
        # Add background task for CRM integration, notifications, etc.
        if result.success and result.qualification:
            background_tasks.add_task(
                process_qualified_lead,
                result.qualification,
                request.session_id
            )
        
        logger.info(f"Qualification completed for session {request.session_id}")
        return result
        
    except Exception as e:
        logger.error(f"Qualification endpoint error: {e}")
        raise HTTPException(status_code=500, detail=f"Qualification failed: {str(e)}")

@app.get("/conversation/{session_id}")
async def get_conversation_history(
    session_id: str,
    rag: BrainGenRAGChain = Depends(get_rag_chain_instance)
):
    """Get conversation history for a session"""
    try:
        history = rag.get_conversation_history(session_id)
        return {
            "session_id": session_id,
            "conversation_history": history,
            "message_count": len(history),
            "timestamp": datetime.now(timezone.utc).isoformat()
        }
    except Exception as e:
        logger.error(f"Error getting conversation history: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.delete("/conversation/{session_id}")
async def clear_conversation(
    session_id: str,
    rag: BrainGenRAGChain = Depends(get_rag_chain_instance)
):
    """Clear conversation history for a session"""
    try:
        rag.clear_conversation(session_id)
        return {
            "message": f"Conversation cleared for session {session_id}",
            "timestamp": datetime.now(timezone.utc).isoformat()
        }
    except Exception as e:
        logger.error(f"Error clearing conversation: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/documents")
async def add_documents(
    documents: List[str],
    sources: Optional[List[str]] = None,
    rag: BrainGenRAGChain = Depends(get_rag_chain_instance)
):
    """Add new documents to the knowledge base"""
    try:
        rag.add_documents(documents, sources)
        return {
            "message": f"Added {len(documents)} documents to knowledge base",
            "timestamp": datetime.now(timezone.utc).isoformat()
        }
    except Exception as e:
        logger.error(f"Error adding documents: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.get("/qualification/insights/{session_id}")
async def get_qualification_insights(
    session_id: str,
    qualification: LeadQualificationChain = Depends(get_qualification_chain_instance)
):
    """Get actionable insights for a qualified lead"""
    try:
        # This would typically fetch qualification from database
        # For now, return placeholder response
        return {
            "session_id": session_id,
            "message": "Insights endpoint - implementation depends on qualification storage",
            "timestamp": datetime.now(timezone.utc).isoformat()
        }
    except Exception as e:
        logger.error(f"Error getting qualification insights: {e}")
        raise HTTPException(status_code=500, detail=str(e))

# Background Tasks

async def log_conversation(
    session_id: str,
    user_message: str,
    ai_response: str,
    processing_time: float
):
    """Background task to log conversation for analytics"""
    try:
        # This would typically log to database, analytics service, etc.
        logger.info(
            f"Conversation logged - Session: {session_id}, "
            f"Processing time: {processing_time:.2f}s"
        )
    except Exception as e:
        logger.error(f"Error logging conversation: {e}")

async def process_qualified_lead(
    qualification: Any,  # LeadQualification object
    session_id: str
):
    """Background task to process qualified leads"""
    try:
        # This would typically:
        # - Save to CRM
        # - Send notifications
        # - Trigger marketing automation
        # - Update lead scoring systems
        
        logger.info(
            f"Qualified lead processed - Session: {session_id}, "
            f"Score: {qualification.lead_score}, "
            f"Sales ready: {qualification.sales_ready}"
        )
        
        # Placeholder for CRM integration
        if qualification.sales_ready:
            logger.info(f"High-priority lead alert sent for session {session_id}")
            
    except Exception as e:
        logger.error(f"Error processing qualified lead: {e}")

# Exception Handlers

@app.exception_handler(HTTPException)
async def http_exception_handler(request, exc):
    """Custom HTTP exception handler"""
    logger.warning(f"HTTP {exc.status_code}: {exc.detail}")
    return JSONResponse(
        status_code=exc.status_code,
        content={
            "error": exc.detail,
            "timestamp": datetime.now(timezone.utc).isoformat(),
            "path": str(request.url)
        }
    )

@app.exception_handler(Exception)
async def general_exception_handler(request, exc):
    """General exception handler"""
    logger.error(f"Unhandled exception: {exc}")
    return JSONResponse(
        status_code=500,
        content={
            "error": "Internal server error",
            "timestamp": datetime.now(timezone.utc).isoformat(),
            "path": str(request.url)
        }
    )

# Development server
if __name__ == "__main__":
    uvicorn.run(
        "main:app",
        host=settings.api_host,
        port=settings.api_port,
        reload=settings.api_debug,
        log_level=settings.log_level.lower()
    )