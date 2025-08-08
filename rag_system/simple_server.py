#!/usr/bin/env python3
"""
Simplified RAG Server that actually works
Bypasses complex chains and uses direct Groq API calls
"""
import sys
import os
from pathlib import Path
sys.path.append(str(Path(__file__).parent))

import asyncio
import json
import time
from datetime import datetime, timezone
from typing import Dict, List, Any, Optional

from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

# Try imports with fallbacks
try:
    from langchain_groq import ChatGroq
    from langchain_community.embeddings import HuggingFaceEmbeddings
    from langchain_community.vectorstores import Chroma
    from config.settings import settings, CHROMA_DIR
    IMPORTS_OK = True
except Exception as e:
    print(f"⚠️ Import warning: {e}")
    IMPORTS_OK = False

app = FastAPI(
    title="BrainGenTechnology Simple RAG API",
    description="Simplified RAG system with direct Groq integration",
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

# Global variables
groq_llm = None
vectorstore = None
conversations = {}

def initialize_groq():
    """Initialize Groq LLM"""
    global groq_llm
    try:
        if not IMPORTS_OK:
            return False
            
        groq_llm = ChatGroq(
            groq_api_key=settings.groq_api_key,
            model_name=settings.llm_model,
            temperature=0.3,
            max_tokens=1000,
            timeout=30
        )
        
        # Test the connection
        test_response = groq_llm.invoke("Say 'Groq connected' and nothing else.")
        print(f"✅ Groq initialized: {test_response.content}")
        return True
        
    except Exception as e:
        print(f"❌ Groq initialization failed: {e}")
        return False

def initialize_vectorstore():
    """Initialize vectorstore if available"""
    global vectorstore
    try:
        if not IMPORTS_OK:
            return False
            
        if (CHROMA_DIR / "chroma.sqlite3").exists():
            embeddings = HuggingFaceEmbeddings(
                model_name="sentence-transformers/all-mpnet-base-v2"
            )
            
            vectorstore = Chroma(
                persist_directory=str(CHROMA_DIR),
                embedding_function=embeddings,
                collection_name="braingentech_knowledge"
            )
            
            print(f"✅ Vectorstore loaded with {vectorstore._collection.count()} documents")
            return True
        else:
            print("⚠️ No vectorstore found")
            return False
            
    except Exception as e:
        print(f"❌ Vectorstore initialization failed: {e}")
        return False

def get_relevant_context(query: str, k: int = 3) -> str:
    """Get relevant context from vectorstore"""
    try:
        if vectorstore is None:
            return ""
            
        docs = vectorstore.similarity_search(query, k=k)
        if not docs:
            return ""
            
        context = "\n\n".join([doc.page_content for doc in docs])
        return context[:2000]  # Limit context length
        
    except Exception as e:
        print(f"⚠️ Context retrieval failed: {e}")
        return ""

def create_business_prompt(query: str, context: str = "") -> str:
    """Create a business-focused prompt"""
    base_knowledge = """
BrainGenTechnology is a leading provider of AI, automation, and blockchain solutions for enterprises.

KEY SERVICES:
• AI Solutions: RAG systems, chatbots, machine learning, computer vision, predictive analytics
• Automation: RPA, workflow automation, business process optimization, document processing
• Blockchain: Supply chain traceability, smart contracts, digital identity, cryptocurrency integration

COMPANY STATS:
• 500+ successful projects delivered
• 98% client satisfaction rate
• Clients from startups to Fortune 500
• 24/7 support available
• ROI typically achieved within 6-12 months

CONTACT: contact@braingentech.com
"""
    
    if context:
        prompt = f"""You are a professional AI assistant for BrainGenTechnology. Use the information below to answer questions about our services.

COMPANY INFORMATION:
{base_knowledge}

RELEVANT CONTEXT:
{context}

QUESTION: {query}

INSTRUCTIONS:
- Provide helpful, professional responses about BrainGenTechnology services
- Focus on business value and ROI
- Ask qualifying questions when appropriate
- If you don't know something, be honest but offer to connect them with our team
- Keep responses concise but informative (2-3 paragraphs max)

RESPONSE:"""
    else:
        prompt = f"""You are a professional AI assistant for BrainGenTechnology. Answer questions about our AI, automation, and blockchain services.

COMPANY INFORMATION:
{base_knowledge}

QUESTION: {query}

Provide a helpful, professional response about BrainGenTechnology's services. Focus on business value and ask qualifying questions when appropriate.

RESPONSE:"""
    
    return prompt

async def generate_response(message: str, session_id: str) -> Dict[str, Any]:
    """Generate response using Groq"""
    start_time = time.time()
    
    try:
        if groq_llm is None:
            return {
                "success": False,
                "answer": "AI system is initializing. Please try again in a moment.",
                "sources": [],
                "processing_time": time.time() - start_time
            }
        
        # Get relevant context
        context = get_relevant_context(message)
        
        # Create prompt
        prompt = create_business_prompt(message, context)
        
        # Get Groq response
        response = groq_llm.invoke(prompt)
        
        # Prepare sources
        sources = []
        if context:
            sources.append({
                "source": "BrainGenTechnology Knowledge Base",
                "content": context[:200] + "..." if len(context) > 200 else context
            })
        
        processing_time = time.time() - start_time
        
        return {
            "success": True,
            "answer": response.content,
            "sources": sources,
            "processing_time": processing_time
        }
        
    except Exception as e:
        print(f"❌ Response generation failed: {e}")
        processing_time = time.time() - start_time
        
        return {
            "success": False,
            "answer": f"I'm experiencing a technical issue. Please try again or contact our support team at contact@braingentech.com for assistance.",
            "sources": [],
            "processing_time": processing_time,
            "error": str(e)
        }

@app.on_event("startup")
async def startup_event():
    """Initialize components on startup"""
    print("🚀 Starting BrainGenTechnology Simple RAG Server...")
    
    if IMPORTS_OK:
        groq_ready = initialize_groq()
        vectorstore_ready = initialize_vectorstore()
        
        print(f"📊 System Status:")
        print(f"   Groq API: {'✅' if groq_ready else '❌'}")
        print(f"   Vectorstore: {'✅' if vectorstore_ready else '❌'}")
        print(f"   Imports: {'✅' if IMPORTS_OK else '❌'}")
    else:
        print("❌ Dependencies not available - running in fallback mode")

@app.get("/")
async def root():
    return {
        "message": "BrainGenTechnology Simple RAG API",
        "version": "1.0.0",
        "status": "running"
    }

@app.get("/health")
async def health_check():
    global groq_llm, vectorstore
    
    return {
        "status": "healthy" if groq_llm is not None else "degraded",
        "version": "1.0.0",
        "timestamp": datetime.now(timezone.utc).isoformat(),
        "system_info": {
            "groq_available": groq_llm is not None,
            "vectorstore_available": vectorstore is not None,
            "imports_ok": IMPORTS_OK,
            "llm_model": settings.llm_model if IMPORTS_OK else "unavailable",
            "document_count": vectorstore._collection.count() if vectorstore else 0
        }
    }

@app.post("/chat", response_model=ChatResponse)
async def chat_endpoint(request: ChatRequest):
    """Simple chat endpoint"""
    
    # Track conversation
    if request.session_id not in conversations:
        conversations[request.session_id] = []
    
    conversations[request.session_id].append({
        "role": "user",
        "content": request.message,
        "timestamp": datetime.now(timezone.utc).isoformat()
    })
    
    # Generate response
    result = await generate_response(request.message, request.session_id)
    
    if result["success"]:
        conversations[request.session_id].append({
            "role": "assistant", 
            "content": result["answer"],
            "timestamp": datetime.now(timezone.utc).isoformat()
        })
    
    return ChatResponse(
        answer=result["answer"],
        session_id=request.session_id,
        sources=result.get("sources", []),
        conversation_length=len(conversations[request.session_id]),
        timestamp=datetime.now(timezone.utc).isoformat(),
        processing_time=result.get("processing_time", 0)
    )

@app.post("/qualify")
async def qualify_lead(request: dict):
    """Simple lead qualification"""
    session_id = request.get("session_id", "unknown")
    conversation = conversations.get(session_id, [])
    
    # Simple qualification based on conversation length and content
    score = min(len(conversation) * 15, 100)
    
    qualification = {
        "intent": "information",
        "urgency": "medium",
        "company_size": "sme",
        "lead_score": score,
        "sales_ready": score >= 60,
        "notes": f"Engaged in {len(conversation)} message conversation"
    }
    
    return {
        "success": True,
        "qualification": qualification,
        "session_id": session_id,
        "processing_time": 0.5
    }

if __name__ == "__main__":
    import uvicorn
    
    print("🧠 BrainGenTechnology Simple RAG Server")
    print("=" * 50)
    
    uvicorn.run(app, host="0.0.0.0", port=8002, log_level="info")