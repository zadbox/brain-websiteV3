from langchain_core.tools import tool
from typing import Optional, Dict, Any
import re
import logging

logger = logging.getLogger(__name__)

def _analyze_budget(message: str) -> int:
    """Analyze budget indicators in message"""
    budget_keywords = ['budget', 'prix', 'coût', 'tarif', 'investissement', 'financement']
    score = 0
    for keyword in budget_keywords:
        if keyword in message:
            score += 1
    return min(score * 2, 10)

def _analyze_authority(message: str) -> int:
    """Analyze authority indicators in message"""
    authority_keywords = ['directeur', 'manager', 'responsable', 'décision', 'approuver']
    score = 0
    for keyword in authority_keywords:
        if keyword in message:
            score += 2
    return min(score, 10)

def _analyze_need(message: str) -> int:
    """Analyze need indicators in message"""
    need_keywords = ['problème', 'besoin', 'solution', 'améliorer', 'optimiser']
    score = 0
    for keyword in need_keywords:
        if keyword in message:
            score += 2
    return min(score, 10)

def _analyze_timeline(message: str) -> int:
    """Analyze timeline indicators in message"""
    timeline_keywords = ['urgent', 'rapidement', 'bientôt', 'délai', 'planning']
    score = 0
    for keyword in timeline_keywords:
        if keyword in message:
            score += 2
    return min(score, 10)

@tool
def lead_qualification_tool(message: str, context: Optional[Dict[str, Any]] = None) -> Dict[str, Any]:
    """Qualifie un lead selon le framework BANT (Budget, Authority, Need, Timeline)"""
    try:
        # Initialize scores
        bant_scores = {
            'budget': 0,
            'authority': 0,
            'need': 0,
            'timeline': 0
        }
        
        message_lower = message.lower()
        
        # BANT Analysis
        bant_scores['budget'] = _analyze_budget(message_lower)
        bant_scores['authority'] = _analyze_authority(message_lower)
        bant_scores['need'] = _analyze_need(message_lower)
        bant_scores['timeline'] = _analyze_timeline(message_lower)
        
        # Calculate overall score
        overall_score = sum(bant_scores.values()) / len(bant_scores)
        
        # Categorize lead
        if overall_score >= 7:
            category = "High Quality Lead"
            priority = "high"
        elif overall_score >= 4:
            category = "Medium Quality Lead"
            priority = "medium"
        else:
            category = "Low Quality Lead"
            priority = "low"
            
        result = {
            'bant_scores': bant_scores,
            'overall_score': round(overall_score, 2),
            'category': category,
            'priority': priority,
            'recommendations': f"Lead qualifié comme {category.lower()}"
        }
        
        logger.info(f"Lead qualification result: {result}")
        return result
        
    except Exception as e:
        logger.error(f"Error in lead qualification: {str(e)}")
        return {
            'error': str(e),
            'bant_scores': {'budget': 0, 'authority': 0, 'need': 0, 'timeline': 0},
            'overall_score': 0,
            'category': 'Error',
            'priority': 'low'
        }