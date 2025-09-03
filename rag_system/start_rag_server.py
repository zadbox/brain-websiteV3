#!/usr/bin/env python3
"""
Startup script for BrainGenTechnology RAG System
Handles initialization, document indexing, and server startup
"""
import os
import sys
import subprocess
import argparse
from pathlib import Path

# Add current directory to Python path
current_dir = Path(__file__).parent
sys.path.append(str(current_dir))

def check_environment():
    """Check if required environment variables are set"""
    required_vars = ["GROQ_API_KEY"]
    missing_vars = []
    
    # Check for .env file first
    env_file = current_dir / ".env"
    if not env_file.exists():
        env_example = current_dir / ".env.example"
        if env_example.exists():
            print("⚠️  No .env file found. Please create one based on .env.example")
            print(f"   Copy: cp {env_example} {env_file}")
            return False
    
    # Load environment variables from .env file
    try:
        from dotenv import load_dotenv
        load_dotenv(env_file)
    except ImportError:
        print("⚠️  python-dotenv not installed. Installing...")
        subprocess.run([sys.executable, "-m", "pip", "install", "python-dotenv"])
        from dotenv import load_dotenv
        load_dotenv(env_file)
    
    # Check required variables
    for var in required_vars:
        if not os.getenv(var):
            missing_vars.append(var)
    
    if missing_vars:
        print("❌ Missing required environment variables:")
        for var in missing_vars:
            print(f"   - {var}")
        print("\nPlease set these variables in your .env file")
        return False
    
    print("✅ Environment configuration validated")
    return True

def install_dependencies():
    """Install Python dependencies"""
    requirements_file = current_dir / "requirements.txt"
    
    if not requirements_file.exists():
        print("❌ requirements.txt not found")
        return False
    
    print("📦 Installing Python dependencies...")
    try:
        subprocess.run([
            sys.executable, "-m", "pip", "install", "-r", str(requirements_file)
        ], check=True)
        print("✅ Dependencies installed successfully")
        return True
    except subprocess.CalledProcessError as e:
        print(f"❌ Failed to install dependencies: {e}")
        return False

def index_documents(force_reindex=False):
    """Index documents for the RAG system"""
    print("📚 Indexing documents for RAG system...")
    
    try:
        from utils.indexer import DocumentIndexer
        
        indexer = DocumentIndexer()
        result = indexer.index_documents(force_reindex=force_reindex)
        
        print("✅ Document indexing completed:")
        for key, value in result.items():
            if key != "processing_time":
                print(f"   - {key}: {value}")
        print(f"   - Processing time: {result.get('processing_time', 0):.2f}s")
        
        return True
        
    except Exception as e:
        print(f"❌ Document indexing failed: {e}")
        return False

def start_server(port=8001, reload=False):
    """Start the FastAPI server"""
    print(f"🚀 Starting RAG API server on port {port}...")
    
    try:
        import uvicorn
        
        # Set the Python path for the server
        os.environ["PYTHONPATH"] = str(current_dir)
        
        # Start the server
        uvicorn.run(
            "api.main:app",
            host="0.0.0.0",
            port=port,
            reload=reload,
            log_level="info"
        )
        
    except KeyboardInterrupt:
        print("\n🛑 Server stopped by user")
    except Exception as e:
        print(f"❌ Failed to start server: {e}")
        return False

def show_status():
    """Show system status and information"""
    print("📊 BrainGenTechnology RAG System Status")
    print("=" * 50)
    
    # Check environment
    env_status = "✅ OK" if check_environment() else "❌ Issues"
    print(f"Environment: {env_status}")
    
    # Check if documents exist
    docs_dir = current_dir / "vectorstore" / "documents"
    doc_count = len(list(docs_dir.rglob("*.md"))) if docs_dir.exists() else 0
    print(f"Documents available: {doc_count}")
    
    # Check if vector store exists
    chroma_dir = current_dir / "vectorstore" / "chroma_db"
    index_status = "✅ Indexed" if (chroma_dir / "chroma.sqlite3").exists() else "❌ Not indexed"
    print(f"Vector store: {index_status}")
    
    # Show index statistics if available
    if (chroma_dir / "chroma.sqlite3").exists():
        try:
            from utils.indexer import DocumentIndexer
            indexer = DocumentIndexer()
            stats = indexer.get_index_statistics()
            print(f"Total chunks: {stats.get('total_chunks', 'Unknown')}")
            print(f"Embeddings model: {stats.get('embeddings_model', 'Unknown')}")
        except Exception as e:
            print(f"Could not get index statistics: {e}")

def main():
    """Main startup function"""
    parser = argparse.ArgumentParser(description="BrainGenTechnology RAG System Startup")
    parser.add_argument("--port", "-p", type=int, default=8001, help="Server port (default: 8001)")
    parser.add_argument("--reload", action="store_true", help="Enable auto-reload for development")
    parser.add_argument("--force-reindex", action="store_true", help="Force complete reindexing")
    parser.add_argument("--install-deps", action="store_true", help="Install dependencies only")
    parser.add_argument("--index-only", action="store_true", help="Index documents only")
    parser.add_argument("--status", action="store_true", help="Show system status")
    parser.add_argument("--skip-index", action="store_true", help="Skip document indexing")
    
    args = parser.parse_args()
    
    print("🧠 BrainGenTechnology RAG System")
    print("=" * 50)
    
    # Show status only
    if args.status:
        show_status()
        return
    
    # Install dependencies only
    if args.install_deps:
        if not install_dependencies():
            sys.exit(1)
        return
    
    # Check environment first
    if not check_environment():
        sys.exit(1)
    
    # Install dependencies
    if not install_dependencies():
        sys.exit(1)
    
    # Index documents
    if not args.skip_index:
        if not index_documents(force_reindex=args.force_reindex):
            print("⚠️  Document indexing failed, but continuing with server startup...")
    
    # Index only mode
    if args.index_only:
        return
    
    # Start server
    print("\n" + "=" * 50)
    print("🌐 API Endpoints:")
    print(f"   - Documentation: http://localhost:{args.port}/docs")
    print(f"   - Health Check: http://localhost:{args.port}/health")
    print(f"   - Chat Endpoint: http://localhost:{args.port}/chat")
    print(f"   - Qualification: http://localhost:{args.port}/qualify")
    print("=" * 50)
    
    start_server(port=args.port, reload=args.reload)

if __name__ == "__main__":
    main()