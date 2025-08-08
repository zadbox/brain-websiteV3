#!/usr/bin/env python3
"""
Working RAG Server - Simplified version that actually works
Based on the successful simple_rag_test.py approach
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

from fastapi import FastAPI, HTTPException, Response
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

# Import working components
from langchain_groq import ChatGroq
from langchain_community.embeddings import HuggingFaceEmbeddings
from langchain_community.vectorstores import Chroma
from config.settings import settings, CHROMA_DIR
from monitoring import get_metrics
from utils.session_manager import get_session_manager

app = FastAPI(
    title="BrainGenTechnology Working RAG API",
    description="Working RAG system with Groq integration",
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
session_manager = None

def init_system():
    """Initialize the working system"""
    global groq_llm, vectorstore, session_manager
    
    print("🚀 Initializing BrainGenTechnology Working RAG Server...")
    
    # Initialize Groq LLM
    try:
        groq_llm = ChatGroq(
            groq_api_key=settings.groq_api_key,
            model_name=settings.llm_model,
            temperature=0.3,
            max_tokens=1000
        )
        test_response = groq_llm.invoke("Say 'Groq ready' and nothing else.")
        print(f"✅ Groq initialized: {test_response.content}")
    except Exception as e:
        print(f"❌ Groq initialization failed: {e}")
        groq_llm = None
    
    # Initialize vectorstore
    try:
        if (CHROMA_DIR / "chroma.sqlite3").exists():
            embeddings = HuggingFaceEmbeddings(
                model_name="sentence-transformers/all-mpnet-base-v2"
            )
            
            vectorstore = Chroma(
                persist_directory=str(CHROMA_DIR),
                embedding_function=embeddings,
                collection_name="braingentech_knowledge"
            )
            
            doc_count = vectorstore._collection.count()
            print(f"✅ Vectorstore loaded with {doc_count} documents")
        else:
            print("⚠️ No vectorstore found")
            vectorstore = None
    except Exception as e:
        print(f"❌ Vectorstore initialization failed: {e}")
        vectorstore = None
    
    # Initialize Session Manager
    try:
        session_manager = get_session_manager()
        print("✅ Session manager initialized")
    except Exception as e:
        print(f"❌ Session manager initialization failed: {e}")
        session_manager = None
    
    print(f"📊 System Status:")
    print(f"   Groq API: {'✅' if groq_llm else '❌'}")
    print(f"   Vectorstore: {'✅' if vectorstore else '❌'}")
    print(f"   Session Manager: {'✅' if session_manager else '❌'}")

def get_context_for_query(query: str) -> str:
    """Get relevant context from vectorstore"""
    try:
        if vectorstore is None:
            return ""
            
        docs = vectorstore.similarity_search(query, k=3)
        if not docs:
            return ""
            
        context = "\n\n".join([doc.page_content for doc in docs])
        return context[:2000]  # Limit context length
        
    except Exception as e:
        print(f"⚠️ Context retrieval failed: {e}")
        return ""

def create_rag_prompt(query: str, context: str = "") -> str:
    """Create a RAG prompt similar to the working test"""
    base_info = """You are a helpful AI assistant for BrainGenTechnology, a company that provides AI, automation, and blockchain solutions for businesses.

Company services include:
- AI Solutions: RAG systems, chatbots, machine learning, computer vision, predictive analytics
- Automation: RPA, workflow automation, business process optimization, document processing
- Blockchain: Supply chain traceability, smart contracts, digital identity, cryptocurrency integration

Company stats:
• 500+ successful projects delivered
• 98% client satisfaction rate  
• Clients from startups to Fortune 500
• 24/7 support available
• ROI typically achieved within 6-12 months

Contact: contact@braingentech.com"""
    
    if context:
        prompt = f"""{base_info}

RELEVANT COMPANY INFORMATION:
{context}

Question: {query}

Please provide a helpful, professional response about BrainGenTechnology's services. Focus on business value and ask qualifying questions when appropriate. Keep responses concise but informative (2-3 paragraphs max)."""
    else:
        prompt = f"""{base_info}

Question: {query}

Please provide a helpful, professional response about BrainGenTechnology's services. Focus on business value and ask qualifying questions when appropriate."""
    
    return prompt

def create_enhanced_rag_prompt(query: str, context: str, user_context: str, conversation_history: str) -> str:
    """Create enhanced RAG prompt with user context and conversation history"""
    base_info = """You are an intelligent sales assistant for BrainGenTechnology, a leading provider of AI, automation, and blockchain solutions for enterprises.

COMPANY CONTEXT:
{context}

USER CONTEXT (REMEMBER THIS INFORMATION):
{user_context}

YOUR ROLE & OBJECTIVES:
- Engage professionally with international business prospects
- Remember and reference user information from previous messages (name, company, etc.)
- Provide accurate information using ONLY the provided context
- Identify business needs and pain points naturally through conversation
- Ask strategic qualifying questions to understand requirements
- Guide prospects toward appropriate solutions and next steps
- Focus on business value, ROI, and competitive advantages

CONVERSATION GUIDELINES:
- Maintain a professional yet approachable tone
- Always use the user's name when you know it
- Reference previous conversation topics and user details when relevant
- Use industry-standard terminology appropriately
- Emphasize measurable business benefits and success stories
- If information isn't in the context, clearly state limitations
- Suggest relevant case studies or solutions when appropriate
- Encourage next steps (consultation, demo, proposal)

QUALIFICATION FOCUS AREAS:
- Company size and industry vertical
- Current technology challenges and pain points
- Budget awareness and investment timeline
- Decision-making authority and process
- Specific use cases and requirements
- Urgency and implementation timeline

CONVERSATION HISTORY:
{conversation_history}

PROSPECT QUESTION: {query}

RESPONSE INSTRUCTIONS:
Provide a helpful, informative response that:
1. Directly addresses the prospect's question using context information
2. Uses the user's name and references their context when appropriate
3. Identifies potential business value or solutions
4. Naturally includes a qualifying question when appropriate
5. Suggests logical next steps or related topics
6. Maintains engagement while being genuinely helpful

Response:"""

    # Fill in the template
    prompt = base_info.format(
        context=context or "BrainGenTechnology offers comprehensive AI, automation, and blockchain solutions designed to drive business efficiency, accuracy, and profitability with a proven track record of 500+ successful projects and 98% client satisfaction.",
        user_context=user_context or "No previous user information available.",
        conversation_history=conversation_history or "This is the beginning of the conversation.",
        query=query
    )
    
    return prompt

async def process_chat_request(message: str, session_id: str) -> Dict[str, Any]:
    """Process chat request using working approach with session memory"""
    start_time = time.time()
    metrics = get_metrics()
    
    try:
        if groq_llm is None:
            metrics.record_error("llm_unavailable")
            return {
                "success": False,
                "answer": "AI system is initializing. Please try again in a moment.",
                "sources": [],
                "processing_time": time.time() - start_time
            }
        
        # Track message
        metrics.record_message("user")
        
        # Get context from vectorstore with timing
        vector_start = time.time()
        context = get_context_for_query(message)
        vector_duration = time.time() - vector_start
        metrics.record_vector_search(vector_duration)
        
        # Get user context from session manager
        user_context = ""
        conversation_history = ""
        if session_manager:
            try:
                user_context = session_manager.get_user_info_summary(session_id)
                # Get recent conversation history
                history = session_manager.get_conversation_history(session_id)
                if history:
                    # Format last few messages for context
                    recent_messages = history[-6:]  # Last 3 exchanges
                    conversation_history = "\n".join([
                        f"{'User' if msg['role'] == 'user' else 'Assistant'}: {msg['content']}"
                        for msg in recent_messages
                    ])
            except Exception as e:
                print(f"Session context error: {e}")
        
        # Create enhanced prompt with user context
        prompt = create_enhanced_rag_prompt(message, context, user_context, conversation_history)
        
        # Get Groq response with timing
        llm_start = time.time()
        response = groq_llm.invoke(prompt)
        llm_duration = time.time() - llm_start
        
        # Track LLM request
        metrics.record_llm_request("success", settings.llm_model, llm_duration)
        
        # Estimate tokens (rough calculation)
        input_tokens = len(prompt.split()) * 1.3  # Approximate
        output_tokens = len(response.content.split()) * 1.3
        metrics.record_tokens(int(input_tokens), int(output_tokens))
        
        # Track assistant message
        metrics.record_message("assistant")
        
        # Prepare sources
        sources = []
        if context:
            sources.append({
                "source": "BrainGenTechnology Knowledge Base",
                "content": context[:200] + "..." if len(context) > 200 else context
            })
        
        processing_time = time.time() - start_time
        metrics.record_query("success", processing_time)
        
        # Store conversation in session manager
        if session_manager:
            try:
                session_manager.add_message_to_session(
                    session_id=session_id,
                    user_message=message,
                    ai_response=response.content,
                    metadata={"processing_time": processing_time, "sources": sources}
                )
            except Exception as e:
                print(f"Session storage error: {e}")
        
        return {
            "success": True,
            "answer": response.content,
            "sources": sources,
            "processing_time": processing_time
        }
        
    except Exception as e:
        print(f"❌ Chat processing error: {e}")
        import traceback
        traceback.print_exc()
        
        processing_time = time.time() - start_time
        return {
            "success": False,
            "answer": "I'm experiencing a technical issue. Please try again or contact our support team at contact@braingentech.com for assistance.",
            "sources": [],
            "processing_time": processing_time,
            "error": str(e)
        }

@app.on_event("startup")
async def startup_event():
    """Initialize components on startup"""
    init_system()

@app.get("/")
async def root():
    return {
        "message": "BrainGenTechnology Working RAG API",
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
            "llm_model": settings.llm_model,
            "document_count": vectorstore._collection.count() if vectorstore else 0
        }
    }

@app.get("/metrics")
async def metrics_endpoint():
    """Prometheus metrics endpoint"""
    metrics = get_metrics()
    
    # Update system metrics
    if vectorstore:
        try:
            doc_count = vectorstore._collection.count()
            metrics.update_vectorstore_size(doc_count)
        except:
            metrics.update_vectorstore_size(0)
    
    # Set system status
    metrics.rag_up.set(1 if groq_llm is not None else 0)
    
    # Return with proper Content-Type for Prometheus
    return Response(
        content=metrics.get_metrics(),
        media_type="text/plain; version=0.0.4; charset=utf-8"
    )

@app.post("/chat", response_model=ChatResponse)
async def chat_endpoint(request: ChatRequest):
    """Working chat endpoint"""
    
    # Track conversation
    if request.session_id not in conversations:
        conversations[request.session_id] = []
    
    conversations[request.session_id].append({
        "role": "user",
        "content": request.message,
        "timestamp": datetime.now(timezone.utc).isoformat()
    })
    
    # Process chat
    result = await process_chat_request(request.message, request.session_id)
    
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
    
    print("🧠 BrainGenTechnology Working RAG Server")
    print("=" * 50)
    
    uvicorn.run(app, host="0.0.0.0", port=8002, log_level="info")