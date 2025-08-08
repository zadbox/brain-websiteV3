#!/usr/bin/env python3
"""
Simplified RAG test - direct API calls without complex chains
"""
import sys
import os
import json
sys.path.append('.')

async def simple_chat_test(message: str):
    """Test basic chat functionality"""
    try:
        from langchain_groq import ChatGroq
        from config.settings import settings
        
        # Initialize Groq LLM
        llm = ChatGroq(
            groq_api_key=settings.groq_api_key,
            model_name=settings.llm_model,
            temperature=0.3,
            max_tokens=500
        )
        
        # Simple business prompt
        business_prompt = f"""You are a helpful AI assistant for BrainGenTechnology, a company that provides AI, automation, and blockchain solutions for businesses.

Company services include:
- AI Solutions: RAG systems, chatbots, machine learning, computer vision
- Automation: RPA, workflow automation, business process optimization  
- Blockchain: Supply chain traceability, smart contracts, digital identity

Question: {message}

Please provide a helpful, professional response about BrainGenTechnology's services. Keep it concise and business-focused."""

        # Get response
        response = llm.invoke(business_prompt)
        
        return {
            "success": True,
            "answer": response.content,
            "session_id": "simple_test",
            "sources": [{"source": "Direct AI Response", "content": "Generated using Groq Llama3-70B"}],
            "conversation_length": 1,
            "timestamp": "2024-08-05T23:30:00Z"
        }
        
    except Exception as e:
        print(f"❌ Simple chat error: {e}")
        return {
            "success": False,
            "answer": f"Error: {str(e)}",
            "session_id": "error_test",
            "sources": [],
            "conversation_length": 0,
            "timestamp": "2024-08-05T23:30:00Z"
        }

def sync_chat_test(message: str):
    """Synchronous version for easier testing"""
    try:
        from langchain_groq import ChatGroq
        from config.settings import settings
        
        llm = ChatGroq(
            groq_api_key=settings.groq_api_key,
            model_name=settings.llm_model,
            temperature=0.3,
            max_tokens=500
        )
        
        business_prompt = f"""You are an AI assistant for BrainGenTechnology, a leading provider of AI, automation, and blockchain solutions.

Our main services:
• AI Solutions: Custom AI systems, chatbots, machine learning models
• Business Automation: RPA, workflow optimization, process automation
• Blockchain: Supply chain solutions, smart contracts, digital identity

Question: {message}

Provide a professional, helpful response about our services."""

        response = llm.invoke(business_prompt)
        
        return {
            "success": True,
            "answer": response.content,
            "session_id": "sync_test",
            "sources": [{"source": "BrainGenTechnology Services", "content": "AI, Automation, Blockchain"}],
            "conversation_length": 1,
            "timestamp": "2024-08-05T23:30:00Z",
            "processing_time": 0.5
        }
        
    except Exception as e:
        return {
            "success": False,
            "answer": f"Technical error: {str(e)}. Please contact support at contact@braingentech.com",
            "session_id": "error_test",
            "sources": [],
            "conversation_length": 0,
            "timestamp": "2024-08-05T23:30:00Z",
            "error": str(e)
        }

if __name__ == "__main__":
    print("🧪 Testing Simple RAG Chat...")
    
    test_messages = [
        "What AI solutions does BrainGenTechnology offer?",
        "Tell me about your automation services", 
        "How can blockchain help my business?",
        "What are your pricing options?"
    ]
    
    for i, message in enumerate(test_messages, 1):
        print(f"\n{i}. Testing: {message}")
        print("-" * 50)
        
        result = sync_chat_test(message)
        
        if result["success"]:
            print(f"✅ Success!")
            print(f"📝 Response: {result['answer'][:100]}...")
        else:
            print(f"❌ Failed!")
            print(f"🐛 Error: {result.get('error', 'Unknown error')}")
    
    print("\n" + "=" * 50)
    print("✨ Simple RAG test complete!")