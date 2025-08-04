from langchain_core.tools import tool
from typing import Optional, Dict, Any
import re
import logging

logger = logging.getLogger(__name__)

@tool
def budget_calculator_tool(message: str, context: Optional[Dict[str, Any]] = None) -> Dict[str, Any]:
    """Calcule une estimation de budget basée sur les besoins exprimés"""
    try:
        message_lower = message.lower()
        
        # Base price categories
        base_prices = {
            'site web': 5000,
            'application mobile': 15000,
            'système de gestion': 25000,
            'intelligence artificielle': 30000,
            'analyse de données': 20000,
            'automatisation': 10000
        }
        
        # Complexity multipliers
        complexity_factors = {
            'simple': 0.7,
            'standard': 1.0,
            'complexe': 1.5,
            'entreprise': 2.0
        }
        
        # Detect service type
        detected_services = []
        estimated_budget = 0
        
        for service, base_price in base_prices.items():
            if any(keyword in message_lower for keyword in service.split()):
                detected_services.append(service)
                estimated_budget += base_price
        
        # Apply complexity factor
        complexity = 'standard'  # default
        for factor_name in complexity_factors.keys():
            if factor_name in message_lower:
                complexity = factor_name
                break
        
        estimated_budget = int(estimated_budget * complexity_factors[complexity])
        
        # Add margin for project management
        estimated_budget = int(estimated_budget * 1.2)
        
        result = {
            'detected_services': detected_services,
            'complexity': complexity,
            'estimated_budget_min': int(estimated_budget * 0.8),
            'estimated_budget_max': int(estimated_budget * 1.2),
            'estimated_budget': estimated_budget,
            'currency': 'EUR',
            'recommendations': f"Budget estimé pour {', '.join(detected_services) if detected_services else 'services détectés'}"
        }
        
        logger.info(f"Budget calculation result: {result}")
        return result
        
    except Exception as e:
        logger.error(f"Error in budget calculation: {str(e)}")
        return {
            'error': str(e),
            'estimated_budget': 0,
            'currency': 'EUR'
        }