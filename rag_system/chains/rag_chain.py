"""
RAG Chain Implementation with Groq LLM for BrainGenTechnology
Optimized for English-speaking business prospects
"""
from typing import Dict, List, Any, Optional
from langchain_groq import ChatGroq
from langchain_community.embeddings import HuggingFaceEmbeddings
from langchain_community.vectorstores import Chroma
from langchain.chains import ConversationalRetrievalChain
from langchain.memory import ConversationBufferWindowMemory
from langchain.prompts import PromptTemplate
from langchain.schema import Document
from langchain_text_splitters import RecursiveCharacterTextSplitter
from langchain_community.document_loaders import DirectoryLoader, TextLoader
import logging

import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

from config.settings import settings, DOCUMENTS_DIR, CHROMA_DIR
from utils.session_manager import get_session_manager

# Configure logging
logging.basicConfig(level=getattr(logging, settings.log_level))
logger = logging.getLogger(__name__)

class BrainGenRAGChain:
    """
    Advanced RAG Chain for BrainGenTechnology with Groq LLM
    Specialized for business conversations and lead qualification
    """
    
    def __init__(self):
        self.llm = None
        self.embeddings = None
        self.vectorstore = None
        self.retriever = None
        self.session_manager = None
        
        # Initialize components
        self._initialize_llm()
        self._initialize_embeddings()
        self._initialize_vectorstore()
        self._initialize_session_manager()
        
        logger.info("BrainGenRAG Chain initialized successfully")
    
    def _initialize_llm(self):
        """Initialize Groq LLM with optimal settings for business conversations"""
        try:
            self.llm = ChatGroq(
                groq_api_key=settings.groq_api_key,
                model_name=settings.llm_model,
                temperature=settings.llm_temperature,
                max_tokens=settings.llm_max_tokens,
                timeout=settings.llm_timeout,
                max_retries=3,
                streaming=False  # Disable streaming for consistency
            )
            logger.info(f"Groq LLM initialized: {settings.llm_model}")
        except Exception as e:
            logger.error(f"Failed to initialize Groq LLM: {e}")
            raise
    
    def _initialize_embeddings(self):
        """Initialize HuggingFace embeddings optimized for English business content"""
        try:
            self.embeddings = HuggingFaceEmbeddings(
                model_name=settings.embeddings_model,
                model_kwargs={'device': settings.embeddings_device},
                encode_kwargs={
                    'normalize_embeddings': True,
                    'batch_size': 16
                }
            )
            logger.info(f"Embeddings initialized: {settings.embeddings_model}")
        except Exception as e:
            logger.error(f"Failed to initialize embeddings: {e}")
            raise
    
    def _initialize_vectorstore(self):
        """Initialize or load existing Chroma vectorstore"""
        try:
            # Ensure Chroma directory exists
            CHROMA_DIR.mkdir(parents=True, exist_ok=True)
            
            # Load existing vectorstore or create new one
            if (CHROMA_DIR / "chroma.sqlite3").exists():
                self.vectorstore = Chroma(
                    persist_directory=str(CHROMA_DIR),
                    embedding_function=self.embeddings,
                    collection_name="braingentech_knowledge"
                )
                logger.info("Loaded existing Chroma vectorstore")
            else:
                # Create new vectorstore and index documents
                self._index_documents()
                logger.info("Created new Chroma vectorstore")
            
            # Configure retriever
            self.retriever = self.vectorstore.as_retriever(
                search_type="similarity",
                search_kwargs={
                    "k": settings.retrieval_k,
                    "score_threshold": 0.7
                }
            )
            
        except Exception as e:
            logger.error(f"Failed to initialize vectorstore: {e}")
            raise
    
    def _index_documents(self):
        """Index company documents into vectorstore"""
        try:
            logger.info("Starting document indexing...")
            
            # Load documents from all subdirectories
            loader = DirectoryLoader(
                str(DOCUMENTS_DIR),
                glob="**/*.md",
                loader_cls=TextLoader,
                loader_kwargs={'encoding': 'utf-8'},
                recursive=True
            )
            
            documents = loader.load()
            logger.info(f"Loaded {len(documents)} documents")
            
            if not documents:
                logger.warning("No documents found to index")
                return
            
            # Split documents into chunks
            text_splitter = RecursiveCharacterTextSplitter(
                chunk_size=settings.chunk_size,
                chunk_overlap=settings.chunk_overlap,
                separators=["\n\n", "\n", ".", "!", "?", ",", " ", ""],
                length_function=len
            )
            
            chunks = text_splitter.split_documents(documents)
            logger.info(f"Split into {len(chunks)} chunks")
            
            # Create vectorstore
            self.vectorstore = Chroma.from_documents(
                documents=chunks,
                embedding=self.embeddings,
                persist_directory=str(CHROMA_DIR),
                collection_name="braingentech_knowledge"
            )
            
            # Persist the vectorstore
            self.vectorstore.persist()
            logger.info("Documents indexed and vectorstore persisted")
            
        except Exception as e:
            logger.error(f"Failed to index documents: {e}")
            raise
    
    def _initialize_session_manager(self):
        """Initialize session manager for per-session memory"""
        try:
            self.session_manager = get_session_manager()
            logger.info("Session manager initialized")
        except Exception as e:
            logger.error(f"Failed to initialize session manager: {e}")
            raise
    
    def _create_session_qa_chain(self, session_id: str) -> ConversationalRetrievalChain:
        """Create QA chain for a specific session"""
        try:
            # Get session memory
            session_memory = self.session_manager.get_session_memory(session_id)
            
            # Create business-focused prompt template
            system_prompt = self._create_business_prompt()
            
            # Create the conversational retrieval chain for this session
            qa_chain = ConversationalRetrievalChain.from_llm(
                llm=self.llm,
                retriever=self.retriever,
                memory=session_memory,
                return_source_documents=True,
                verbose=settings.api_debug,
                combine_docs_chain_kwargs={
                    "prompt": system_prompt
                },
                condense_question_prompt=self._create_condense_prompt()
            )
            logger.debug(f"Created QA Chain for session {session_id}")
            return qa_chain
        except Exception as e:
            logger.error(f"Failed to create QA chain for session {session_id}: {e}")
            raise
    
    def _create_business_prompt(self) -> PromptTemplate:
        """Create business-optimized prompt template for Groq LLM"""
        template = """You are an intelligent sales assistant for BrainGenTechnology, a leading provider of AI, automation, and blockchain solutions for enterprises.

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
{chat_history}

PROSPECT QUESTION: {question}

RESPONSE INSTRUCTIONS:
Provide a helpful, informative response that:
1. Directly addresses the prospect's question using context information
2. Uses the user's name and references their context when appropriate
3. Identifies potential business value or solutions
4. Naturally includes a qualifying question when appropriate
5. Suggests logical next steps or related topics
6. Maintains engagement while being genuinely helpful

Response:"""

        return PromptTemplate(
            input_variables=["context", "user_context", "chat_history", "question"],
            template=template
        )
    
    def _create_condense_prompt(self) -> PromptTemplate:
        """Create prompt for condensing conversation history"""
        template = """Given the following conversation and a follow-up question, rephrase the follow-up question to be a standalone question that captures the business context and intent.

Chat History:
{chat_history}
Follow Up Input: {question}
Standalone question:"""

        return PromptTemplate(
            input_variables=["chat_history", "question"],
            template=template
        )
    
    async def ask_question(
        self, 
        question: str, 
        session_id: str,
        metadata: Optional[Dict[str, Any]] = None
    ) -> Dict[str, Any]:
        """
        Process a question through the RAG chain with session-based memory
        
        Args:
            question: User's question
            session_id: Unique session identifier
            metadata: Additional context (user agent, referrer, etc.)
        
        Returns:
            Dict containing answer, sources, and conversation metadata
        """
        try:
            logger.info(f"Processing question for session {session_id}")
            
            # Create session-specific QA chain
            qa_chain = self._create_session_qa_chain(session_id)
            
            # Get session memory and context
            session_memory = self.session_manager.get_session_memory(session_id)
            user_context = self.session_manager.get_user_info_summary(session_id)
            
            # Enhance question with session context if needed
            enhanced_question = self._enhance_question(question, metadata)
            
            # Prepare documents for context
            retrieved_docs = self.retriever.get_relevant_documents(enhanced_question)
            context = "\n\n".join([doc.page_content for doc in retrieved_docs[:3]])
            
            # Get response using LLM directly with enhanced context
            response = await self._get_contextual_response(
                question=enhanced_question,
                context=context,
                user_context=user_context,
                chat_history=session_memory.chat_memory.messages,
                session_id=session_id
            )
            
            # Store conversation in session manager
            self.session_manager.add_message_to_session(
                session_id=session_id,
                user_message=question,
                ai_response=response["answer"],
                metadata=metadata
            )
            
            # Extract and format response
            result = {
                "answer": response["answer"],
                "source_documents": [
                    {
                        "content": doc.page_content[:500] + "...",
                        "source": doc.metadata.get("source", "Unknown"),
                        "relevance_score": getattr(doc, 'relevance_score', 0.0)
                    }
                    for doc in retrieved_docs[:3]
                ],
                "session_id": session_id,
                "conversation_length": len(session_memory.chat_memory.messages),
                "timestamp": self._get_timestamp(),
                "metadata": metadata or {}
            }
            
            logger.info(f"Question processed successfully for session {session_id}")
            return result
            
        except Exception as e:
            logger.error(f"Error processing question: {e}")
            return {
                "answer": "I apologize, but I'm experiencing technical difficulties. Please try again or contact our support team for assistance.",
                "error": str(e),
                "session_id": session_id,
                "timestamp": self._get_timestamp()
            }
    
    async def _get_contextual_response(
        self, 
        question: str, 
        context: str, 
        user_context: str, 
        chat_history: List[Any], 
        session_id: str
    ) -> Dict[str, Any]:
        """Get response using LLM with full context"""
        try:
            # Format chat history
            formatted_history = ""
            for msg in chat_history[-6:]:  # Last 6 messages
                role = "Human" if hasattr(msg, 'type') and msg.type == "human" else "Assistant"
                formatted_history += f"{role}: {msg.content}\n"
            
            # Create the prompt
            prompt_template = self._create_business_prompt()
            formatted_prompt = prompt_template.format(
                context=context,
                user_context=user_context,
                chat_history=formatted_history,
                question=question
            )
            
            # Get response from LLM
            response = await self.llm.ainvoke(formatted_prompt)
            
            return {
                "answer": response.content,
                "session_id": session_id
            }
            
        except Exception as e:
            logger.error(f"Error getting contextual response: {e}")
            return {
                "answer": "I apologize, but I'm experiencing technical difficulties. Please try again or contact our support team for assistance.",
                "session_id": session_id
            }
    
    def _enhance_question(self, question: str, metadata: Optional[Dict[str, Any]]) -> str:
        """Enhance question with session context if available"""
        if not metadata:
            return question
        
        enhancements = []
        if metadata.get("pages_visited"):
            enhancements.append(f"Context: User visited pages: {metadata['pages_visited']}")
        
        if metadata.get("referrer"):
            enhancements.append(f"Referrer: {metadata['referrer']}")
        
        if enhancements:
            return f"{question}\n\nAdditional context: {'; '.join(enhancements)}"
        
        return question
    
    def get_conversation_history(self, session_id: str) -> List[Dict[str, str]]:
        """Get formatted conversation history for a session"""
        try:
            return self.session_manager.get_conversation_history(session_id)
        except Exception as e:
            logger.error(f"Error getting conversation history: {e}")
            return []
    
    def clear_conversation(self, session_id: str):
        """Clear conversation memory for a session"""
        try:
            self.session_manager.clear_session(session_id)
            logger.info(f"Cleared conversation for session {session_id}")
        except Exception as e:
            logger.error(f"Error clearing conversation: {e}")
    
    def add_documents(self, documents: List[str], sources: List[str] = None):
        """Add new documents to the vectorstore"""
        try:
            # Create Document objects
            docs = []
            for i, content in enumerate(documents):
                source = sources[i] if sources and i < len(sources) else f"document_{i}"
                docs.append(Document(
                    page_content=content,
                    metadata={"source": source, "type": "dynamic"}
                ))
            
            # Split documents
            text_splitter = RecursiveCharacterTextSplitter(
                chunk_size=settings.chunk_size,
                chunk_overlap=settings.chunk_overlap
            )
            chunks = text_splitter.split_documents(docs)
            
            # Add to vectorstore
            self.vectorstore.add_documents(chunks)
            self.vectorstore.persist()
            
            logger.info(f"Added {len(chunks)} chunks from {len(documents)} documents")
        except Exception as e:
            logger.error(f"Error adding documents: {e}")
            raise
    
    def _get_timestamp(self) -> str:
        """Get current timestamp in ISO format"""
        from datetime import datetime, timezone
        return datetime.now(timezone.utc).isoformat()
    
    def get_system_status(self) -> Dict[str, Any]:
        """Get system status for health checks"""
        return {
            "status": "healthy",
            "llm_model": settings.llm_model,
            "embeddings_model": settings.embeddings_model,
            "vectorstore_type": settings.vector_store_type,
            "document_count": self.vectorstore._collection.count() if self.vectorstore else 0,
            "memory_messages": len(self.memory.chat_memory.messages) if self.memory else 0,
            "timestamp": self._get_timestamp()
        }

# Global instance
_rag_chain_instance = None

def get_rag_chain() -> BrainGenRAGChain:
    """Get singleton RAG chain instance"""
    global _rag_chain_instance
    if _rag_chain_instance is None:
        _rag_chain_instance = BrainGenRAGChain()
    return _rag_chain_instance

# Export for use in API
__all__ = ["BrainGenRAGChain", "get_rag_chain"]