#!/usr/bin/env python3
"""
Simple test script for Groq API
"""
import sys
import os
sys.path.append('.')

def test_groq():
    try:
        from langchain_groq import ChatGroq
        from config.settings import settings
        print("✅ Imports successful")
        
        # Test Groq connection
        llm = ChatGroq(
            groq_api_key=settings.groq_api_key,
            model_name=settings.llm_model,
            temperature=0.3,
            max_tokens=100
        )
        print("✅ Groq LLM initialized")
        
        # Test simple call
        response = llm.invoke("Say 'Hello from Groq API' and nothing else.")
        print(f"✅ Groq Response: {response.content}")
        
        return True
        
    except Exception as e:
        print(f"❌ Error: {e}")
        import traceback
        traceback.print_exc()
        return False

def test_embeddings():
    try:
        from langchain_community.embeddings import HuggingFaceEmbeddings
        print("✅ Embeddings import successful")
        
        embeddings = HuggingFaceEmbeddings(
            model_name="sentence-transformers/all-mpnet-base-v2"
        )
        print("✅ Embeddings initialized")
        
        # Test embedding
        test_text = "This is a test"
        embedding = embeddings.embed_query(test_text)
        print(f"✅ Embedding generated: {len(embedding)} dimensions")
        
        return True
        
    except Exception as e:
        print(f"❌ Embeddings Error: {e}")
        return False

def test_vectorstore():
    try:
        from langchain_community.vectorstores import Chroma
        from config.settings import CHROMA_DIR
        print("✅ Vectorstore import successful")
        
        # Check if vectorstore exists
        if os.path.exists(CHROMA_DIR / "chroma.sqlite3"):
            print(f"✅ Vectorstore found at {CHROMA_DIR}")
            return True
        else:
            print(f"❌ Vectorstore not found at {CHROMA_DIR}")
            return False
            
    except Exception as e:
        print(f"❌ Vectorstore Error: {e}")
        return False

if __name__ == "__main__":
    print("🧪 Testing RAG Components...")
    print("=" * 50)
    
    print("1. Testing Groq API...")
    groq_ok = test_groq()
    
    print("\n2. Testing Embeddings...")
    embeddings_ok = test_embeddings()
    
    print("\n3. Testing Vectorstore...")
    vectorstore_ok = test_vectorstore()
    
    print("\n" + "=" * 50)
    print("📊 Test Results:")
    print(f"   Groq API: {'✅' if groq_ok else '❌'}")
    print(f"   Embeddings: {'✅' if embeddings_ok else '❌'}")
    print(f"   Vectorstore: {'✅' if vectorstore_ok else '❌'}")
    
    if all([groq_ok, embeddings_ok, vectorstore_ok]):
        print("\n🎉 All components working!")
    else:
        print("\n⚠️  Some components need attention")