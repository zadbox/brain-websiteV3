"""
Document Indexing Utility for BrainGenTechnology RAG System
Handles bulk indexing and updating of knowledge base documents
"""
import sys
import logging
from pathlib import Path
from typing import List, Dict, Any
from datetime import datetime

# Add parent directory to path for imports
sys.path.append(str(Path(__file__).parent.parent))

from langchain_community.document_loaders import DirectoryLoader, TextLoader
from langchain_text_splitters import RecursiveCharacterTextSplitter
from langchain_community.embeddings import HuggingFaceEmbeddings
from langchain_community.vectorstores import Chroma
from langchain.schema import Document

from config.settings import settings, DOCUMENTS_DIR, CHROMA_DIR

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

class DocumentIndexer:
    """
    Document indexing utility for the RAG system
    Handles batch processing and incremental updates
    """
    
    def __init__(self):
        self.embeddings = None
        self.text_splitter = None
        self.vectorstore = None
        
        self._initialize_components()
    
    def _initialize_components(self):
        """Initialize embeddings and text splitter"""
        try:
            # Initialize embeddings
            self.embeddings = HuggingFaceEmbeddings(
                model_name=settings.embeddings_model,
                model_kwargs={'device': settings.embeddings_device},
                encode_kwargs={
                    'normalize_embeddings': True,
                    'batch_size': 16
                }
            )
            
            # Initialize text splitter
            self.text_splitter = RecursiveCharacterTextSplitter(
                chunk_size=settings.chunk_size,
                chunk_overlap=settings.chunk_overlap,
                separators=["\n\n", "\n", ".", "!", "?", ",", " ", ""],
                length_function=len
            )
            
            logger.info("Document indexer components initialized")
            
        except Exception as e:
            logger.error(f"Failed to initialize indexer components: {e}")
            raise
    
    def index_documents(self, force_reindex: bool = False) -> Dict[str, Any]:
        """
        Index all documents in the documents directory
        
        Args:
            force_reindex: If True, rebuild the entire index
        
        Returns:
            Dictionary with indexing results and statistics
        """
        start_time = datetime.now()
        
        try:
            logger.info("Starting document indexing process...")
            
            # Check if we need to rebuild or create new index
            index_exists = (CHROMA_DIR / "chroma.sqlite3").exists()
            
            if force_reindex or not index_exists:
                if index_exists:
                    logger.info("Force reindex requested - rebuilding entire index")
                else:
                    logger.info("No existing index found - creating new index")
                
                # Remove existing index if force reindex
                if force_reindex and index_exists:
                    import shutil
                    shutil.rmtree(CHROMA_DIR)
                
                # Create new index
                result = self._create_new_index()
            else:
                logger.info("Existing index found - performing incremental update")
                result = self._update_existing_index()
            
            # Calculate processing time
            processing_time = (datetime.now() - start_time).total_seconds()
            result["processing_time"] = processing_time
            
            logger.info(f"Document indexing completed in {processing_time:.2f} seconds")
            return result
            
        except Exception as e:
            logger.error(f"Document indexing failed: {e}")
            raise
    
    def _create_new_index(self) -> Dict[str, Any]:
        """Create a new vectorstore index from scratch"""
        try:
            # Ensure directories exist
            CHROMA_DIR.mkdir(parents=True, exist_ok=True)
            
            # Load all documents
            documents = self._load_documents()
            
            if not documents:
                return {
                    "status": "completed",
                    "documents_processed": 0,
                    "chunks_created": 0,
                    "message": "No documents found to index"
                }
            
            # Split documents into chunks
            chunks = self.text_splitter.split_documents(documents)
            
            # Create vectorstore
            self.vectorstore = Chroma.from_documents(
                documents=chunks,
                embedding=self.embeddings,
                persist_directory=str(CHROMA_DIR),
                collection_name="braingentech_knowledge"
            )
            
            # Persist the vectorstore
            self.vectorstore.persist()
            
            return {
                "status": "completed",
                "action": "created_new_index",
                "documents_processed": len(documents),
                "chunks_created": len(chunks),
                "message": f"Successfully indexed {len(documents)} documents into {len(chunks)} chunks"
            }
            
        except Exception as e:
            logger.error(f"Failed to create new index: {e}")
            raise
    
    def _update_existing_index(self) -> Dict[str, Any]:
        """Update existing vectorstore with new or modified documents"""
        try:
            # Load existing vectorstore
            self.vectorstore = Chroma(
                persist_directory=str(CHROMA_DIR),
                embedding_function=self.embeddings,
                collection_name="braingentech_knowledge"
            )
            
            # Get existing document metadata
            existing_docs = self._get_existing_document_info()
            
            # Load current documents
            current_documents = self._load_documents()
            
            # Find new or modified documents
            new_or_modified = self._find_new_or_modified_documents(
                current_documents, 
                existing_docs
            )
            
            if not new_or_modified:
                return {
                    "status": "completed",
                    "action": "no_updates_needed",
                    "documents_processed": 0,
                    "chunks_created": 0,
                    "message": "No new or modified documents found"
                }
            
            # Process new/modified documents
            chunks = self.text_splitter.split_documents(new_or_modified)
            
            # Add new chunks to vectorstore
            self.vectorstore.add_documents(chunks)
            self.vectorstore.persist()
            
            return {
                "status": "completed",
                "action": "updated_existing_index",
                "documents_processed": len(new_or_modified),
                "chunks_created": len(chunks),
                "message": f"Updated index with {len(new_or_modified)} documents ({len(chunks)} chunks)"
            }
            
        except Exception as e:
            logger.error(f"Failed to update existing index: {e}")
            raise
    
    def _load_documents(self) -> List[Document]:
        """Load all documents from the documents directory"""
        try:
            loader = DirectoryLoader(
                str(DOCUMENTS_DIR),
                glob="**/*.md",
                loader_cls=TextLoader,
                loader_kwargs={'encoding': 'utf-8'},
                recursive=True,
                show_progress=True
            )
            
            documents = loader.load()
            
            # Enhance document metadata
            for doc in documents:
                file_path = Path(doc.metadata.get("source", ""))
                doc.metadata.update({
                    "file_name": file_path.name,
                    "file_path": str(file_path),
                    "file_size": file_path.stat().st_size if file_path.exists() else 0,
                    "last_modified": datetime.fromtimestamp(
                        file_path.stat().st_mtime
                    ).isoformat() if file_path.exists() else None,
                    "document_type": self._get_document_type(file_path),
                    "indexed_at": datetime.now().isoformat()
                })
            
            logger.info(f"Loaded {len(documents)} documents")
            return documents
            
        except Exception as e:
            logger.error(f"Failed to load documents: {e}")
            return []
    
    def _get_document_type(self, file_path: Path) -> str:
        """Determine document type based on file path"""
        path_parts = file_path.parts
        
        if "company" in path_parts:
            return "company_info"
        elif "services" in path_parts:
            return "service_description"
        elif "case_studies" in path_parts:
            return "case_study"
        elif "technical" in path_parts:
            return "technical_documentation"
        else:
            return "general"
    
    def _get_existing_document_info(self) -> Dict[str, Dict[str, Any]]:
        """Get information about existing documents in the vectorstore"""
        try:
            # This is a simplified approach - in practice, you might want to
            # store document metadata separately for more efficient tracking
            collection = self.vectorstore._collection
            
            # Get all documents with metadata
            results = collection.get(include=["metadatas"])
            
            existing_docs = {}
            for metadata in results.get("metadatas", []):
                if "source" in metadata:
                    source = metadata["source"]
                    existing_docs[source] = metadata
            
            return existing_docs
            
        except Exception as e:
            logger.warning(f"Could not get existing document info: {e}")
            return {}
    
    def _find_new_or_modified_documents(
        self, 
        current_documents: List[Document],
        existing_docs: Dict[str, Dict[str, Any]]
    ) -> List[Document]:
        """Find documents that are new or have been modified"""
        new_or_modified = []
        
        for doc in current_documents:
            source = doc.metadata.get("source", "")
            
            if source not in existing_docs:
                # New document
                logger.info(f"New document found: {source}")
                new_or_modified.append(doc)
            else:
                # Check if modified
                existing_modified = existing_docs[source].get("last_modified")
                current_modified = doc.metadata.get("last_modified")
                
                if current_modified and existing_modified != current_modified:
                    logger.info(f"Modified document found: {source}")
                    new_or_modified.append(doc)
        
        return new_or_modified
    
    def get_index_statistics(self) -> Dict[str, Any]:
        """Get statistics about the current index"""
        try:
            if not (CHROMA_DIR / "chroma.sqlite3").exists():
                return {
                    "status": "no_index",
                    "message": "No index found"
                }
            
            # Load vectorstore
            vectorstore = Chroma(
                persist_directory=str(CHROMA_DIR),
                embedding_function=self.embeddings,
                collection_name="braingentech_knowledge"
            )
            
            # Get collection statistics
            collection = vectorstore._collection
            count = collection.count()
            
            # Get sample documents to analyze document types
            sample_results = collection.get(
                limit=min(100, count),
                include=["metadatas"]
            )
            
            # Analyze document types
            doc_types = {}
            for metadata in sample_results.get("metadatas", []):
                doc_type = metadata.get("document_type", "unknown")
                doc_types[doc_type] = doc_types.get(doc_type, 0) + 1
            
            return {
                "status": "indexed",
                "total_chunks": count,
                "document_types": doc_types,
                "index_location": str(CHROMA_DIR),
                "embeddings_model": settings.embeddings_model,
                "chunk_size": settings.chunk_size,
                "chunk_overlap": settings.chunk_overlap
            }
            
        except Exception as e:
            logger.error(f"Failed to get index statistics: {e}")
            return {
                "status": "error",
                "message": str(e)
            }

def main():
    """Command-line interface for document indexing"""
    import argparse
    
    parser = argparse.ArgumentParser(description="BrainGenTechnology Document Indexer")
    parser.add_argument(
        "--force-reindex", 
        action="store_true",
        help="Force complete reindexing of all documents"
    )
    parser.add_argument(
        "--stats-only",
        action="store_true",
        help="Show index statistics only"
    )
    
    args = parser.parse_args()
    
    indexer = DocumentIndexer()
    
    if args.stats_only:
        # Show statistics only
        stats = indexer.get_index_statistics()
        print("Index Statistics:")
        for key, value in stats.items():
            print(f"  {key}: {value}")
    else:
        # Perform indexing
        result = indexer.index_documents(force_reindex=args.force_reindex)
        print("Indexing Results:")
        for key, value in result.items():
            print(f"  {key}: {value}")

if __name__ == "__main__":
    main()