#!/usr/bin/env python3
"""
Simple RAG Server for Testing - Without heavy ML dependencies
"""
import os
import sys
from pathlib import Path
sys.path.append(str(Path(__file__).parent))

from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from typing import Dict, List, Any, Optional
import json
from datetime import datetime, timezone
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

app = FastAPI(
    title="BrainGenTechnology Simple RAG API",
    description="Simple RAG system for testing",
    version="1.0.0"
)

# Configure CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Request/Response Models
class ChatRequest(BaseModel):
    message: str
    session_id: str
    metadata: Optional[Dict[str, Any]] = None

class ChatResponse(BaseModel):
    answer: str
    session_id: str
    sources: List[Dict[str, Any]] = []
    conversation_length: int
    timestamp: str
    processing_time: Optional[float] = None

# Simple responses for testing
SIMPLE_RESPONSES = {
    "hello": "Hello! I'm the BrainGenTechnology AI assistant. How can I help you today?",
    "services": "BrainGenTechnology offers AI solutions, automation services, and blockchain technology. We specialize in RAG systems, chatbots, machine learning, and business process optimization.",
    "contact": "You can contact us at contact@braingentech.com or visit our website for more information.",
    "pricing": "Our pricing varies based on your specific needs. We offer flexible plans from starter packages to enterprise solutions. Would you like to schedule a consultation?",
    "demo": "I'd be happy to arrange a demo for you! Our solutions include AI chatbots, automation tools, and blockchain integration. What specific area interests you most?",
    "default": "Thank you for your question about BrainGenTechnology. We're a leading AI and automation company. Could you tell me more about what you're looking for?"
}

@app.get("/")
async def root():
    return {"message": "BrainGenTechnology RAG API is running"}

@app.get("/health")
async def health_check():
    return {
        "status": "healthy",
        "timestamp": datetime.now(timezone.utc).isoformat(),
        "version": "1.0.0",
        "groq_configured": bool(os.getenv("GROQ_API_KEY", "").strip()),
        "message": "Simple RAG server is operational"
    }

@app.post("/chat", response_model=ChatResponse)
async def chat(request: ChatRequest):
    """Simple chat endpoint that provides basic responses"""
    try:
        start_time = datetime.now()
        
        # Simple keyword-based response
        message_lower = request.message.lower()
        response = SIMPLE_RESPONSES["default"]
        
        for keyword, answer in SIMPLE_RESPONSES.items():
            if keyword != "default" and keyword in message_lower:
                response = answer
                break
        
        # Add some business qualifying questions based on intent
        if any(word in message_lower for word in ["price", "cost", "budget"]):
            response += " What's your expected budget range and timeline for implementation?"
        elif any(word in message_lower for word in ["demo", "show", "see"]):
            response += " What industry are you in, and what specific challenges are you looking to solve?"
        elif any(word in message_lower for word in ["help", "need", "solution"]):
            response += " Could you tell me more about your company size and current pain points?"
        
        end_time = datetime.now()
        processing_time = (end_time - start_time).total_seconds()
        
        return ChatResponse(
            answer=response,
            session_id=request.session_id,
            sources=[{
                "source": "BrainGenTechnology Knowledge Base",
                "type": "simple_response",
                "relevance": 0.9
            }],
            conversation_length=1,
            timestamp=end_time.isoformat(),
            processing_time=processing_time
        )
        
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Chat processing failed: {str(e)}")

@app.get("/metrics")
async def metrics():
    """Simple metrics endpoint"""
    return {
        "requests_total": 1,
        "response_time_avg": 0.1,
        "status": "healthy"
    }

if __name__ == "__main__":
    import uvicorn
    
    print("🚀 Starting BrainGenTechnology Simple RAG Server...")
    print("✅ Basic FastAPI server ready")
    print(f"🔑 Groq API configured: {bool(os.getenv('GROQ_API_KEY', '').strip())}")
    print("📊 Server starting on http://0.0.0.0:8002")
    
    uvicorn.run(
        app,
        host="0.0.0.0",
        port=8002,
        log_level="info"
    )