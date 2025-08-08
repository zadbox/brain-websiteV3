"""
Prometheus metrics exporter for RAG System
Tracks AI/ML specific metrics and business KPIs
"""
import time
import logging
from typing import Dict, Any, Optional
from datetime import datetime, timezone
from prometheus_client import Counter, Histogram, Gauge, Info, CollectorRegistry, generate_latest

# Configure logging
logger = logging.getLogger(__name__)

class RAGMetrics:
    """
    Prometheus metrics collector for RAG system
    Tracks performance, accuracy, and business metrics
    """
    
    def __init__(self, registry: Optional[CollectorRegistry] = None):
        self.registry = registry or CollectorRegistry()
        self._initialize_metrics()
        
    def _initialize_metrics(self):
        """Initialize all Prometheus metrics"""
        
        # System Health Metrics
        self.rag_up = Gauge(
            'rag_system_up', 
            'RAG system availability',
            registry=self.registry
        )
        
        # Query Performance Metrics
        self.query_duration = Histogram(
            'rag_query_duration_seconds',
            'RAG query processing time',
            buckets=[0.1, 0.5, 1.0, 2.0, 5.0, 10.0, 30.0],
            registry=self.registry
        )
        
        self.queries_total = Counter(
            'rag_queries_total',
            'Total RAG queries processed',
            ['status'],
            registry=self.registry
        )
        
        # Vector Search Metrics
        self.vector_search_duration = Histogram(
            'vector_search_duration_seconds',
            'Vector database search time',
            buckets=[0.01, 0.05, 0.1, 0.5, 1.0, 2.0],
            registry=self.registry
        )
        
        self.vector_searches_total = Counter(
            'vector_searches_total',
            'Total vector searches performed',
            registry=self.registry
        )
        
        # LLM API Metrics
        self.llm_api_duration = Histogram(
            'llm_api_duration_seconds',
            'LLM API response time',
            buckets=[0.5, 1.0, 2.0, 5.0, 10.0, 20.0, 30.0],
            registry=self.registry
        )
        
        self.llm_api_requests_total = Counter(
            'llm_api_requests_total',
            'Total LLM API requests',
            ['status', 'model'],
            registry=self.registry
        )
        
        self.llm_tokens_processed_total = Counter(
            'llm_tokens_processed_total',
            'Total tokens processed by LLM',
            ['type'],  # 'input' or 'output'
            registry=self.registry
        )
        
        # Qualification Metrics
        self.lead_qualifications_total = Counter(
            'lead_qualifications_total',
            'Total lead qualifications performed',
            ['status'],
            registry=self.registry
        )
        
        self.qualification_duration = Histogram(
            'qualification_duration_seconds',
            'Lead qualification processing time',
            buckets=[1.0, 2.0, 5.0, 10.0, 20.0, 30.0],
            registry=self.registry
        )
        
        self.lead_scores = Histogram(
            'lead_scores',
            'Distribution of lead scores',
            buckets=[0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
            registry=self.registry
        )
        
        # Business Metrics
        self.conversations_total = Counter(
            'chat_conversations_total',
            'Total chat conversations',
            registry=self.registry
        )
        
        self.messages_total = Counter(
            'chat_messages_total',
            'Total chat messages',
            ['role'],  # 'user' or 'assistant'
            registry=self.registry
        )
        
        self.conversation_duration = Histogram(
            'conversation_duration_seconds',
            'Conversation duration',
            buckets=[30, 60, 120, 300, 600, 1200, 1800],
            registry=self.registry
        )
        
        self.active_sessions = Gauge(
            'active_chat_sessions',
            'Currently active chat sessions',
            registry=self.registry
        )
        
        # Model Performance Metrics
        self.model_confidence = Gauge(
            'model_confidence_current',
            'Current model confidence score',
            registry=self.registry
        )
        
        self.conversation_quality = Gauge(
            'conversation_quality_current',
            'Current conversation quality score',
            registry=self.registry
        )
        
        # System Resource Metrics
        self.memory_usage = Gauge(
            'rag_memory_usage_bytes',
            'RAG system memory usage',
            registry=self.registry
        )
        
        self.vectorstore_size = Gauge(
            'vectorstore_documents_count',
            'Number of documents in vector store',
            registry=self.registry
        )
        
        # Error Metrics
        self.errors_total = Counter(
            'rag_errors_total',
            'Total RAG system errors',
            ['error_type'],
            registry=self.registry
        )
        
        # Set system as up
        self.rag_up.set(1)
        
        logger.info("RAG metrics initialized successfully")
    
    # Context Managers for timing operations
    def time_rag_query(self):
        """Context manager for timing RAG queries"""
        return self.query_duration.time()
    
    def time_vector_search(self):
        """Context manager for timing vector searches"""
        return self.vector_search_duration.time()
    
    def time_llm_api(self):
        """Context manager for timing LLM API calls"""
        return self.llm_api_duration.time()
    
    def time_qualification(self):
        """Context manager for timing qualification"""
        return self.qualification_duration.time()
    
    # Metric update methods
    def record_query(self, status: str = "success", duration: Optional[float] = None):
        """Record a RAG query"""
        self.queries_total.labels(status=status).inc()
        if duration:
            self.query_duration.observe(duration)
    
    def record_vector_search(self, duration: Optional[float] = None):
        """Record a vector search"""
        self.vector_searches_total.inc()
        if duration:
            self.vector_search_duration.observe(duration)
    
    def record_llm_request(self, status: str, model: str, duration: Optional[float] = None):
        """Record an LLM API request"""
        self.llm_api_requests_total.labels(status=status, model=model).inc()
        if duration:
            self.llm_api_duration.observe(duration)
    
    def record_tokens(self, input_tokens: int, output_tokens: int):
        """Record token usage"""
        self.llm_tokens_processed_total.labels(type="input").inc(input_tokens)
        self.llm_tokens_processed_total.labels(type="output").inc(output_tokens)
    
    def record_qualification(self, status: str, lead_score: int, duration: Optional[float] = None):
        """Record a lead qualification"""
        self.lead_qualifications_total.labels(status=status).inc()
        self.lead_scores.observe(lead_score)
        if duration:
            self.qualification_duration.observe(duration)
    
    def record_conversation_start(self):
        """Record start of a new conversation"""
        self.conversations_total.inc()
        self.active_sessions.inc()
    
    def record_conversation_end(self, duration: float):
        """Record end of a conversation"""
        self.active_sessions.dec()
        self.conversation_duration.observe(duration)
    
    def record_message(self, role: str):
        """Record a chat message"""
        self.messages_total.labels(role=role).inc()
    
    def update_model_metrics(self, confidence: float, quality: int):
        """Update model performance metrics"""
        self.model_confidence.set(confidence)
        self.conversation_quality.set(quality)
    
    def record_error(self, error_type: str):
        """Record an error"""
        self.errors_total.labels(error_type=error_type).inc()
    
    def update_vectorstore_size(self, document_count: int):
        """Update vector store size"""
        self.vectorstore_size.set(document_count)
    
    def get_metrics(self) -> str:
        """Generate Prometheus metrics output"""
        return generate_latest(self.registry).decode('utf-8')

# Global metrics instance
_metrics_instance: Optional[RAGMetrics] = None

def get_metrics() -> RAGMetrics:
    """Get global metrics instance"""
    global _metrics_instance
    if _metrics_instance is None:
        _metrics_instance = RAGMetrics()
    return _metrics_instance

def reset_metrics():
    """Reset global metrics (for testing)"""
    global _metrics_instance
    _metrics_instance = None

# Decorator for automatic timing
def timed_operation(metric_name: str):
    """Decorator for timing operations"""
    def decorator(func):
        def wrapper(*args, **kwargs):
            metrics = get_metrics()
            start_time = time.time()
            try:
                result = func(*args, **kwargs)
                duration = time.time() - start_time
                
                # Record based on metric name
                if metric_name == "query":
                    metrics.record_query("success", duration)
                elif metric_name == "vector_search":
                    metrics.record_vector_search(duration)
                elif metric_name == "qualification":
                    # Assume result contains lead_score
                    score = getattr(result, 'lead_score', 50) if hasattr(result, 'lead_score') else 50
                    metrics.record_qualification("success", score, duration)
                
                return result
            except Exception as e:
                duration = time.time() - start_time
                if metric_name == "query":
                    metrics.record_query("error", duration)
                elif metric_name == "qualification":
                    metrics.record_qualification("error", 0, duration)
                metrics.record_error(str(type(e).__name__))
                raise
        return wrapper
    return decorator