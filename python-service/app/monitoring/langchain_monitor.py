import logging
import time
import functools
from typing import Dict, Any, Optional
from datetime import datetime, timedelta
from collections import defaultdict, deque
import threading

logger = logging.getLogger(__name__)

class LangChainMonitor:
    """
    Monitoring system for LangChain performance and metrics
    """
    
    def __init__(self):
        """Initialize the monitoring system"""
        self.metrics = {
            'total_requests': 0,
            'successful_requests': 0,
            'failed_requests': 0,
            'average_response_time': 0.0,
            'response_times': deque(maxlen=1000),
            'error_counts': defaultdict(int),
            'function_calls': defaultdict(int),
            'last_reset': datetime.now()
        }
        
        self.lock = threading.Lock()
        logger.info("LangChain Monitor initialized")
    
    def monitor_performance(self, func):
        """
        Decorator to monitor function performance
        """
        @functools.wraps(func)
        def wrapper(*args, **kwargs):
            start_time = time.time()
            
            try:
                result = func(*args, **kwargs)
                execution_time = time.time() - start_time
                
                # Record successful execution
                with self.lock:
                    self.metrics['total_requests'] += 1
                    self.metrics['successful_requests'] += 1
                    self.metrics['response_times'].append(execution_time)
                    self.metrics['function_calls'][func.__name__] += 1
                    
                    # Update average response time
                    self._update_average_response_time()
                
                logger.info(f"Function {func.__name__} executed successfully in {execution_time:.2f}s")
                
                return result
                
            except Exception as e:
                execution_time = time.time() - start_time
                
                # Record failed execution
                with self.lock:
                    self.metrics['total_requests'] += 1
                    self.metrics['failed_requests'] += 1
                    self.metrics['error_counts'][str(type(e).__name__)] += 1
                    self.metrics['function_calls'][func.__name__] += 1
                
                logger.error(f"Function {func.__name__} failed after {execution_time:.2f}s: {str(e)}")
                raise
        
        return wrapper
    
    def _update_average_response_time(self):
        """Update average response time"""
        if self.metrics['response_times']:
            self.metrics['average_response_time'] = sum(self.metrics['response_times']) / len(self.metrics['response_times'])
    
    def get_metrics(self) -> Dict[str, Any]:
        """Get current metrics"""
        with self.lock:
            return {
                'total_requests': self.metrics['total_requests'],
                'successful_requests': self.metrics['successful_requests'],
                'failed_requests': self.metrics['failed_requests'],
                'success_rate': self._calculate_success_rate(),
                'average_response_time': round(self.metrics['average_response_time'], 3),
                'error_counts': dict(self.metrics['error_counts']),
                'function_calls': dict(self.metrics['function_calls']),
                'uptime': self._calculate_uptime(),
                'last_reset': self.metrics['last_reset'].isoformat()
            }
    
    def _calculate_success_rate(self) -> float:
        """Calculate success rate percentage"""
        total = self.metrics['total_requests']
        if total == 0:
            return 0.0
        return round((self.metrics['successful_requests'] / total) * 100, 2)
    
    def _calculate_uptime(self) -> str:
        """Calculate uptime since last reset"""
        uptime = datetime.now() - self.metrics['last_reset']
        return str(uptime).split('.')[0]  # Remove microseconds
    
    def reset_metrics(self):
        """Reset all metrics"""
        with self.lock:
            self.metrics = {
                'total_requests': 0,
                'successful_requests': 0,
                'failed_requests': 0,
                'average_response_time': 0.0,
                'response_times': deque(maxlen=1000),
                'error_counts': defaultdict(int),
                'function_calls': defaultdict(int),
                'last_reset': datetime.now()
            }
        logger.info("Metrics reset")
    
    def get_performance_summary(self) -> Dict[str, Any]:
        """Get performance summary"""
        metrics = self.get_metrics()
        
        # Calculate additional metrics
        if metrics['response_times']:
            response_times = list(self.metrics['response_times'])
            metrics['min_response_time'] = min(response_times)
            metrics['max_response_time'] = max(response_times)
            metrics['p95_response_time'] = self._calculate_percentile(response_times, 95)
            metrics['p99_response_time'] = self._calculate_percentile(response_times, 99)
        
        return metrics
    
    def _calculate_percentile(self, values: list, percentile: int) -> float:
        """Calculate percentile of values"""
        if not values:
            return 0.0
        
        sorted_values = sorted(values)
        index = (percentile / 100) * (len(sorted_values) - 1)
        
        if index.is_integer():
            return sorted_values[int(index)]
        else:
            lower = sorted_values[int(index)]
            upper = sorted_values[int(index) + 1]
            return lower + (upper - lower) * (index - int(index))
    
    def log_performance_alert(self, threshold: float = 5.0):
        """Log performance alerts for slow operations"""
        if self.metrics['average_response_time'] > threshold:
            logger.warning(f"Performance alert: Average response time {self.metrics['average_response_time']:.2f}s exceeds threshold {threshold}s")
    
    def get_health_status(self) -> Dict[str, str]:
        """Get health status of the system"""
        success_rate = self._calculate_success_rate()
        avg_response_time = self.metrics['average_response_time']
        
        # Determine health status
        if success_rate >= 95 and avg_response_time <= 3.0:
            status = "healthy"
        elif success_rate >= 90 and avg_response_time <= 5.0:
            status = "warning"
        else:
            status = "unhealthy"
        
        return {
            'status': status,
            'success_rate': f"{success_rate}%",
            'avg_response_time': f"{avg_response_time:.2f}s",
            'total_requests': str(self.metrics['total_requests'])
        } 