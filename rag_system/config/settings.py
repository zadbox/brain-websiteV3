"""
Configuration settings for BrainGenTechnology RAG System
"""
from pathlib import Path
from pydantic_settings import BaseSettings
from typing import Optional

class Settings(BaseSettings):
    """Application settings loaded from environment variables"""
    
    # API Keys
    groq_api_key: str
    langsmith_api_key: Optional[str] = None
    
    # Model Configuration
    llm_model: str = "llama-3.1-70b-versatile"
    llm_temperature: float = 0.3
    llm_max_tokens: int = 2048
    llm_timeout: int = 60
    
    # Embeddings Configuration
    embeddings_model: str = "sentence-transformers/all-mpnet-base-v2"
    embeddings_device: str = "cpu"
    
    # Vector Store Configuration
    vector_store_type: str = "chroma"
    chroma_persist_directory: str = "rag_system/vectorstore/chroma_db"
    chunk_size: int = 1000
    chunk_overlap: int = 200
    retrieval_k: int = 3
    
    # API Configuration
    api_host: str = "0.0.0.0"
    api_port: int = 8002
    api_debug: bool = False
    
    # Lead Qualification
    lead_score_threshold: int = 60
    qualification_timeout: int = 30
    
    # Session Management
    session_timeout_minutes: int = 60
    max_conversation_length: int = 20
    
    # Monitoring
    langchain_tracing: bool = False
    log_level: str = "INFO"
    
    # Business Configuration
    company_name: str = "BrainGenTechnology"
    supported_languages: list = ["en"]
    business_hours: str = "9 AM - 6 PM EST"
    contact_email: str = "contact@braingentech.com"
    
    model_config = {
        "env_file": ".env",
        "case_sensitive": False,
        "env_prefix": "",
        "extra": "ignore"
    }

# Global settings instance
settings = Settings()

# Derived paths
BASE_DIR = Path(__file__).parent.parent
DOCUMENTS_DIR = BASE_DIR / "vectorstore" / "documents"
CHROMA_DIR = BASE_DIR / "vectorstore" / "chroma_db"