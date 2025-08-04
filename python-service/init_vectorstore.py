#!/usr/bin/env python3
"""
Script to initialize the Qdrant collection and vector store
"""

import os
import sys
from dotenv import load_dotenv
from qdrant_client import QdrantClient
from qdrant_client.models import Distance, VectorParams
from langchain_cohere import CohereEmbeddings

# Load environment variables
load_dotenv()

def init_vectorstore():
    """Initialize the Qdrant collection and vector store"""
    
    # Configuration
    QDRANT_URL = os.getenv("QDRANT_URL", "http://localhost:6333")
    QDRANT_COLLECTION = os.getenv("QDRANT_COLLECTION", "braingen_tech")
    COHERE_API_KEY = os.getenv("COHERE_API_KEY")
    
    if not COHERE_API_KEY:
        print("❌ COHERE_API_KEY is required")
        return False
    
    try:
        # Initialize Qdrant client
        print(f"🔗 Connecting to Qdrant at {QDRANT_URL}...")
        client = QdrantClient(host="localhost", port=6333)
        
        # Check if collection exists
        collections = client.get_collections()
        collection_names = [col.name for col in collections.collections]
        
        if QDRANT_COLLECTION in collection_names:
            print(f"✅ Collection '{QDRANT_COLLECTION}' already exists")
            return True
        
        # Create collection
        print(f"🔄 Creating collection '{QDRANT_COLLECTION}'...")
        
        # Initialize embeddings to get vector size
        embeddings = CohereEmbeddings(
            cohere_api_key=COHERE_API_KEY,
            model="embed-multilingual-v3.0"
        )
        
        # Get vector size by creating a test embedding
        test_embedding = embeddings.embed_query("test")
        vector_size = len(test_embedding)
        
        # Create collection
        client.create_collection(
            collection_name=QDRANT_COLLECTION,
            vectors_config=VectorParams(
                size=vector_size,
                distance=Distance.COSINE
            )
        )
        
        print(f"✅ Collection '{QDRANT_COLLECTION}' created successfully with vector size {vector_size}")
        return True
        
    except Exception as e:
        print(f"❌ Error initializing vector store: {e}")
        return False

if __name__ == "__main__":
    success = init_vectorstore()
    if success:
        print("🎉 Vector store initialization completed successfully!")
    else:
        print("💥 Vector store initialization failed!")
        sys.exit(1) 