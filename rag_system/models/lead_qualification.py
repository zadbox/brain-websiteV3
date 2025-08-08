"""
Lead Qualification Models for BrainGenTechnology RAG System
"""
from pydantic import BaseModel, Field
from typing import List, Literal, Optional, Dict, Any
from datetime import datetime, timezone
from enum import Enum

class IntentType(str, Enum):
    """Types of prospect intentions"""
    INFORMATION = "information"
    QUOTE = "quote"
    DEMO = "demo"
    CONSULTATION = "consultation"
    SUPPORT = "support"
    PARTNERSHIP = "partnership"

class UrgencyLevel(str, Enum):
    """Business urgency levels"""
    LOW = "low"
    MEDIUM = "medium"
    HIGH = "high"
    CRITICAL = "critical"

class CompanySize(str, Enum):
    """Company size categories"""
    STARTUP = "startup"
    SME = "sme"
    MID_MARKET = "mid_market"
    ENTERPRISE = "enterprise"

class Industry(str, Enum):
    """Industry verticals"""
    FINTECH = "fintech"
    HEALTHCARE = "healthcare"
    RETAIL = "retail"
    MANUFACTURING = "manufacturing"
    REAL_ESTATE = "real_estate"
    AGRI_FOOD = "agri_food"
    COMMUNICATION = "communication"
    EDUCATION = "education"
    GOVERNMENT = "government"
    OTHER = "other"

class TechnologyInterest(str, Enum):
    """Technology areas of interest"""
    AI = "ai"
    AUTOMATION = "automation"
    BLOCKCHAIN = "blockchain"
    RAG = "rag"
    MULTI_AGENT = "multi_agent"
    NLP = "nlp"
    COMPUTER_VISION = "computer_vision"
    CHATBOTS = "chatbots"

class DecisionMakerLevel(str, Enum):
    """Decision-making authority levels"""
    USER = "user"
    MANAGER = "manager"
    DIRECTOR = "director"
    C_LEVEL = "c_level"
    OWNER = "owner"
    UNKNOWN = "unknown"

class NextAction(str, Enum):
    """Recommended next steps"""
    NURTURE = "nurture"
    QUALIFY_FURTHER = "qualify_further"
    DEMO = "demo"
    PROPOSAL = "proposal"
    HAND_TO_SALES = "hand_to_sales"
    SCHEDULE_CALL = "schedule_call"

class LeadQualification(BaseModel):
    """
    Comprehensive lead qualification model for English-speaking prospects
    """
    # Basic Intent & Urgency
    intent: IntentType = Field(
        description="Primary prospect intention based on conversation"
    )
    urgency: UrgencyLevel = Field(
        description="Business urgency level inferred from language and timeline mentions"
    )
    
    # Company Information
    company_size: CompanySize = Field(
        description="Estimated company size from context clues"
    )
    industry: Industry = Field(
        description="Industry vertical identified from use cases or mentions"
    )
    company_name: Optional[str] = Field(
        default=None,
        description="Company name if explicitly mentioned"
    )
    
    # Budget & Investment
    budget_indicators: List[str] = Field(
        default=[],
        description="Keywords or phrases indicating budget awareness"
    )
    investment_timeline: Optional[str] = Field(
        default=None,
        description="When they're looking to invest or implement"
    )
    
    # Technical Interest
    technology_interest: List[TechnologyInterest] = Field(
        default=[],
        description="Specific technologies mentioned or areas of interest"
    )
    use_cases_mentioned: List[str] = Field(
        default=[],
        description="Specific use cases or applications discussed"
    )
    
    # Decision Making
    decision_maker_level: DecisionMakerLevel = Field(
        description="Estimated decision-making authority"
    )
    decision_process: Optional[str] = Field(
        default=None,
        description="Information about their decision-making process"
    )
    
    # Pain Points & Challenges
    pain_points: List[str] = Field(
        default=[],
        description="Business challenges explicitly mentioned"
    )
    current_solutions: List[str] = Field(
        default=[],
        description="Existing tools or solutions they're using"
    )
    
    # Geographic & Contact
    geographic_region: Optional[str] = Field(
        default=None,
        description="Geographic location if mentioned"
    )
    timezone: Optional[str] = Field(
        default=None,
        description="Timezone for scheduling purposes"
    )
    preferred_contact_method: Optional[str] = Field(
        default=None,
        description="Email, phone, or other preferred contact method"
    )
    
    # Qualification Score & Action
    lead_score: int = Field(
        description="Lead quality score 0-100 based on BANT criteria",
        ge=0,
        le=100
    )
    next_action: NextAction = Field(
        description="Recommended next step in the sales process"
    )
    sales_ready: bool = Field(
        description="Whether lead is ready for direct sales engagement"
    )
    
    # Additional Context
    notes: str = Field(
        description="Key insights and context for sales team follow-up"
    )
    conversation_quality: int = Field(
        description="Quality of conversation engagement (1-10)",
        ge=1,
        le=10
    )
    follow_up_priority: Literal["low", "medium", "high", "urgent"] = Field(
        description="Priority level for follow-up actions"
    )
    
    # Metadata
    qualification_timestamp: datetime = Field(
        default_factory=lambda: datetime.now(timezone.utc)
    )
    model_confidence: float = Field(
        description="AI model confidence in qualification (0.0-1.0)",
        ge=0.0,
        le=1.0,
        default=0.5
    )

class ConversationSession(BaseModel):
    """Model for tracking conversation sessions"""
    session_id: str
    prospect_id: Optional[str] = None
    start_time: datetime
    last_activity: datetime
    message_count: int = 0
    language: str = "en"
    user_agent: Optional[str] = None
    referrer: Optional[str] = None
    pages_visited: List[str] = []
    qualification: Optional[LeadQualification] = None
    is_active: bool = True

class ChatMessage(BaseModel):
    """Individual chat message model"""
    session_id: str
    message_id: str
    timestamp: datetime
    role: Literal["user", "assistant", "system"]
    content: str
    metadata: Dict[str, Any] = {}

class QualificationResponse(BaseModel):
    """Response model for qualification endpoint"""
    success: bool
    qualification: Optional[LeadQualification] = None
    error_message: Optional[str] = None
    processing_time: float
    session_id: str