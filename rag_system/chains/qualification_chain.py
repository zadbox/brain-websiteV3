"""
Lead Qualification Chain with Groq LLM
Specialized for analyzing business conversations and qualifying leads
"""
import json
import logging
from typing import Dict, Any, Optional, List
from datetime import datetime, timezone

from langchain_groq import ChatGroq
from langchain.chains import LLMChain
from langchain.prompts import PromptTemplate
from langchain.output_parsers import PydanticOutputParser, OutputFixingParser
from langchain.schema import OutputParserException

import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

from models.lead_qualification import (
    LeadQualification, 
    QualificationResponse,
    ConversationSession,
    ChatMessage
)
from config.settings import settings

# Configure logging
logger = logging.getLogger(__name__)

class LeadQualificationChain:
    """
    Advanced lead qualification system using Groq LLM
    Analyzes business conversations to extract qualification data
    """
    
    def __init__(self):
        self.llm = None
        self.qualification_chain = None
        self.parser = None
        self.fixing_parser = None
        
        # Initialize components
        self._initialize_llm()
        self._initialize_parser()
        self._initialize_chain()
        
        logger.info("Lead Qualification Chain initialized successfully")
    
    def _initialize_llm(self):
        """Initialize Groq LLM for qualification analysis"""
        try:
            self.llm = ChatGroq(
                groq_api_key=settings.groq_api_key,
                model_name=settings.llm_model,
                temperature=0.1,  # Lower temperature for consistent analysis
                max_tokens=1500,  # Sufficient for qualification output
                timeout=settings.qualification_timeout,
                max_retries=2
            )
            logger.info("Groq LLM initialized for qualification")
        except Exception as e:
            logger.error(f"Failed to initialize qualification LLM: {e}")
            raise
    
    def _initialize_parser(self):
        """Initialize Pydantic output parser for structured responses"""
        try:
            self.parser = PydanticOutputParser(pydantic_object=LeadQualification)
            
            # Create fixing parser to handle malformed JSON
            self.fixing_parser = OutputFixingParser.from_llm(
                parser=self.parser,
                llm=self.llm
            )
            logger.info("Output parsers initialized")
        except Exception as e:
            logger.error(f"Failed to initialize parsers: {e}")
            raise
    
    def _initialize_chain(self):
        """Initialize the qualification analysis chain"""
        try:
            # Create comprehensive qualification prompt
            qualification_prompt = self._create_qualification_prompt()
            
            self.qualification_chain = LLMChain(
                llm=self.llm,
                prompt=qualification_prompt,
                verbose=settings.api_debug
            )
            logger.info("Qualification chain initialized")
        except Exception as e:
            logger.error(f"Failed to initialize qualification chain: {e}")
            raise
    
    def _create_qualification_prompt(self) -> PromptTemplate:
        """Create comprehensive qualification analysis prompt"""
        
        template = """You are an expert sales analyst specializing in B2B lead qualification for technology companies. Analyze the following business conversation and extract comprehensive qualification data.

CONVERSATION TO ANALYZE:
{{conversation_history}}

QUALIFICATION FRAMEWORK:
Use BANT (Budget, Authority, Need, Timeline) methodology enhanced with modern B2B qualification criteria:

1. INTENT ANALYSIS:
   - information: Seeking general information about services
   - quote: Requesting pricing or formal proposals
   - demo: Interested in product demonstrations
   - consultation: Seeking strategic advice or planning
   - support: Technical support or service issues
   - partnership: Exploring partnership opportunities

2. URGENCY ASSESSMENT:
   - low: No specific timeline mentioned
   - medium: 3-6 month timeline or "planning for next year"
   - high: 1-3 month timeline or "need soon"
   - critical: Immediate need or "urgent" language

3. COMPANY SIZE INDICATORS:
   - startup: "early stage", "just started", <10 employees
   - sme: "small business", 10-50 employees, limited budget mentions
   - mid_market: 50-500 employees, department mentions, structured processes
   - enterprise: 500+ employees, multiple departments, complex requirements

4. TECHNOLOGY INTEREST:
   - ai: Artificial intelligence, machine learning, chatbots
   - automation: Process automation, RPA, workflow optimization
   - blockchain: Distributed ledger, smart contracts, cryptocurrency
   - rag: Knowledge management, document search, Q&A systems
   - multi_agent: Complex AI systems, orchestration

5. INDUSTRY CLASSIFICATION:
   - fintech: Financial services, banks, payments, investments, fintech companies
   - healthcare: Medical, hospitals, clinics, health tech, pharmaceuticals
   - retail: E-commerce, stores, consumer products, marketplaces
   - manufacturing: Factories, production, supply chain, industrial automation
   - real_estate: Property management, real estate, construction, architecture
   - agri_food: Agriculture, food processing, farming, supply chain
   - communication: Marketing, advertising, media, telecommunications
   - education: Schools, universities, training, e-learning platforms
   - government: Public sector, municipalities, agencies, compliance
   - other: Industries not clearly fitting above categories

6. DECISION MAKER LEVEL:
   - user: End user, no buying authority
   - manager: Department manager, limited budget authority
   - director: Department director, significant budget authority
   - c_level: C-suite executive, full buying authority
   - owner: Business owner, complete decision authority
   - unknown: No clear indication of authority level

7. LEAD SCORING (0-100):
   - Need fit (0-25): How well our solutions match their needs
   - Authority (0-25): Decision-making power of the contact
   - Budget (0-25): Budget availability and investment readiness
   - Timeline (0-25): Urgency and implementation timeline

ANALYSIS INSTRUCTIONS:
- Extract specific keywords and phrases that support your assessment
- Look for explicit mentions of company details, pain points, and requirements
- Identify industry-specific challenges and use cases
- Note any mentions of current solutions, competitors, or alternatives
- Pay attention to language indicating buying readiness and urgency
- Consider geographic location for regional considerations
- Assess conversation quality and engagement level

IMPORTANT NOTES:
- Base assessments ONLY on information explicitly mentioned in the conversation
- Use "unknown" or empty lists when information is not available
- Provide specific quotes or keywords in relevant fields
- Be conservative in scoring - require clear evidence for high scores
- Focus on business impact and measurable outcomes

RESPONSE FORMAT:
Respond with a JSON object containing these exact fields:
- "intent": one of ["information", "quote", "demo", "consultation", "support", "partnership"]
- "urgency": one of ["low", "medium", "high", "critical"] 
- "company_size": one of ["startup", "sme", "mid_market", "enterprise"]
- "industry": one of ["fintech", "healthcare", "retail", "manufacturing", "real_estate", "agri_food", "communication", "education", "government", "other"]
- "company_name": string or null if not mentioned
- "budget_indicators": array of strings
- "investment_timeline": string or null
- "technology_interest": array from ["ai", "automation", "blockchain", "rag", "multi_agent", "nlp", "computer_vision", "chatbots"]
- "use_cases_mentioned": array of strings
- "decision_maker_level": one of ["user", "manager", "director", "c_level", "owner", "unknown"]
- "decision_process": string or null
- "pain_points": array of strings
- "current_solutions": array of strings
- "geographic_region": string or null
- "timezone": string or null
- "preferred_contact_method": string or null
- "lead_score": integer from 0-100
- "next_action": one of ["nurture", "qualify_further", "demo", "proposal", "hand_to_sales", "schedule_call"]
- "sales_ready": boolean
- "notes": string with key insights
- "conversation_quality": integer from 1-10
- "follow_up_priority": one of ["low", "medium", "high", "urgent"]
- "qualification_timestamp": current ISO timestamp
- "model_confidence": float from 0.0-1.0

CRITICAL: Respond ONLY with valid JSON. No explanatory text before or after."""

        return PromptTemplate(
            input_variables=["conversation_history"],
            template=template
        )
    
    async def qualify_lead(
        self,
        conversation_history: List[Dict[str, str]],
        session_id: str,
        metadata: Optional[Dict[str, Any]] = None
    ) -> QualificationResponse:
        """
        Analyze conversation and generate lead qualification
        
        Args:
            conversation_history: List of conversation messages
            session_id: Unique session identifier
            metadata: Additional context (pages visited, referrer, etc.)
        
        Returns:
            QualificationResponse with qualification data or error info
        """
        start_time = datetime.now(timezone.utc)
        
        try:
            logger.info(f"Starting lead qualification for session {session_id}")
            
            # Format conversation for analysis
            formatted_conversation = self._format_conversation(
                conversation_history, 
                metadata
            )
            
            # Run qualification analysis
            result = await self.qualification_chain.acall({
                "conversation_history": formatted_conversation
            })
            
            # Parse JSON response with error handling
            import json
            try:
                # Clean the response text
                response_text = result["text"].strip()
                
                # Try to extract JSON if it's wrapped in other text
                if '{' in response_text and '}' in response_text:
                    start = response_text.find('{')
                    end = response_text.rfind('}') + 1
                    json_text = response_text[start:end]
                else:
                    json_text = response_text
                
                qualification_data = json.loads(json_text)
                qualification = LeadQualification(**qualification_data)
                
            except json.JSONDecodeError as e:
                logger.error(f"JSON parsing failed for session {session_id}: {e}")
                logger.error(f"Raw response: {result['text']}")
                
                # Raise exception to trigger working_server.py fallback instead
                raise Exception(f"JSON parsing failed: {e}")
                
            except Exception as e:
                logger.error(f"Qualification parsing failed: {e}")
                raise
            
            # Calculate processing time
            processing_time = (datetime.now(timezone.utc) - start_time).total_seconds()
            
            # Enhance qualification with session context
            qualification = self._enhance_qualification(
                qualification, 
                session_id, 
                metadata
            )
            
            logger.info(
                f"Lead qualification completed for session {session_id} "
                f"(score: {qualification.lead_score}, ready: {qualification.sales_ready})"
            )
            
            return QualificationResponse(
                success=True,
                qualification=qualification,
                processing_time=processing_time,
                session_id=session_id
            )
            
        except OutputParserException as e:
            logger.error(f"Output parsing error for session {session_id}: {e}")
            processing_time = (datetime.now(timezone.utc) - start_time).total_seconds()
            
            return QualificationResponse(
                success=False,
                error_message=f"Failed to parse qualification output: {str(e)}",
                processing_time=processing_time,
                session_id=session_id
            )
            
        except Exception as e:
            logger.error(f"Qualification error for session {session_id}: {e}")
            processing_time = (datetime.now(timezone.utc) - start_time).total_seconds()
            
            return QualificationResponse(
                success=False,
                error_message=f"Qualification analysis failed: {str(e)}",
                processing_time=processing_time,
                session_id=session_id
            )
    
    def _format_conversation(
        self, 
        conversation_history: List[Dict[str, str]], 
        metadata: Optional[Dict[str, Any]]
    ) -> str:
        """Format conversation history for analysis"""
        
        formatted_lines = []
        
        # Add metadata context if available
        if metadata:
            formatted_lines.append("=== SESSION CONTEXT ===")
            if metadata.get("pages_visited"):
                formatted_lines.append(f"Pages visited: {metadata['pages_visited']}")
            if metadata.get("referrer"):
                formatted_lines.append(f"Referrer: {metadata['referrer']}")
            if metadata.get("user_agent"):
                formatted_lines.append(f"Device/Browser: {metadata['user_agent']}")
            formatted_lines.append("")
        
        # Add conversation messages
        formatted_lines.append("=== CONVERSATION HISTORY ===")
        
        for i, message in enumerate(conversation_history):
            role = message.get("role", "unknown")
            content = message.get("content", "")
            timestamp = message.get("timestamp", "")
            
            # Format role display
            role_display = {
                "user": "PROSPECT",
                "assistant": "AGENT",
                "system": "SYSTEM"
            }.get(role, role.upper())
            
            formatted_lines.append(f"[{i+1}] {role_display}: {content}")
            if timestamp:
                formatted_lines.append(f"    Time: {timestamp}")
            formatted_lines.append("")
        
        return "\n".join(formatted_lines)
    
    def _enhance_qualification(
        self,
        qualification: LeadQualification,
        session_id: str,
        metadata: Optional[Dict[str, Any]]
    ) -> LeadQualification:
        """Enhance qualification with session-specific data"""
        
        # Set model confidence based on conversation quality
        confidence = min(0.9, max(0.3, qualification.conversation_quality / 10.0))
        qualification.model_confidence = confidence
        
        # Extract geographic information from metadata if available
        if metadata and not qualification.geographic_region:
            # Could extract from IP geolocation, user agent, etc.
            pass
        
        # Set follow-up priority based on lead score and sales readiness
        if qualification.lead_score >= 80 and qualification.sales_ready:
            qualification.follow_up_priority = "urgent"
        elif qualification.lead_score >= 60:
            qualification.follow_up_priority = "high"
        elif qualification.lead_score >= 40:
            qualification.follow_up_priority = "medium"
        else:
            qualification.follow_up_priority = "low"
        
        return qualification
    
    def get_qualification_insights(
        self, 
        qualification: LeadQualification
    ) -> Dict[str, Any]:
        """Generate actionable insights from qualification data"""
        
        insights = {
            "lead_grade": self._calculate_lead_grade(qualification.lead_score),
            "priority_actions": self._get_priority_actions(qualification),
            "recommended_content": self._get_content_recommendations(qualification),
            "follow_up_timing": self._get_follow_up_timing(qualification),
            "sales_handoff_readiness": qualification.sales_ready,
            "qualification_summary": self._generate_summary(qualification)
        }
        
        return insights
    
    def _calculate_lead_grade(self, score: int) -> str:
        """Convert lead score to letter grade"""
        if score >= 80:
            return "A"
        elif score >= 60:
            return "B"
        elif score >= 40:
            return "C"
        else:
            return "D"
    
    def _get_priority_actions(self, qualification: LeadQualification) -> List[str]:
        """Get recommended priority actions based on qualification"""
        actions = []
        
        if qualification.sales_ready:
            actions.append("Schedule immediate sales call")
        
        if qualification.intent in ["demo", "consultation"]:
            actions.append("Prepare technical demonstration")
        
        if qualification.intent == "quote":
            actions.append("Prepare formal proposal")
        
        if qualification.urgency in ["high", "critical"]:
            actions.append("Fast-track response within 24 hours")
        
        if qualification.company_size == "enterprise":
            actions.append("Involve senior sales executive")
        
        if not actions:
            actions.append("Continue nurturing with relevant content")
        
        return actions
    
    def _get_content_recommendations(self, qualification: LeadQualification) -> List[str]:
        """Recommend relevant content based on interests and industry"""
        content = []
        
        # Technology-specific content
        for tech in qualification.technology_interest:
            if tech == "ai":
                content.append("AI Solutions Case Studies")
            elif tech == "automation":
                content.append("Process Automation ROI Calculator")
            elif tech == "blockchain":
                content.append("Blockchain Implementation Guide")
        
        # Industry-specific content
        industry_content = {
            "fintech": "FinTech Compliance and AI Solutions",
            "healthcare": "Healthcare AI and Privacy Compliance",
            "retail": "Retail Automation and Customer Analytics",
            "manufacturing": "Industry 4.0 and Smart Manufacturing"
        }
        
        if qualification.industry in industry_content:
            content.append(industry_content[qualification.industry])
        
        return content or ["General AI and Automation Overview"]
    
    def _get_follow_up_timing(self, qualification: LeadQualification) -> str:
        """Recommend follow-up timing based on urgency and engagement"""
        if qualification.urgency == "critical":
            return "Within 2 hours"
        elif qualification.urgency == "high":
            return "Within 24 hours"
        elif qualification.urgency == "medium":
            return "Within 3 days"
        else:
            return "Within 1 week"
    
    def _generate_summary(self, qualification: LeadQualification) -> str:
        """Generate human-readable qualification summary"""
        summary_parts = []
        
        # Company and role
        company_desc = f"{qualification.company_size.value} company"
        if qualification.company_name:
            company_desc = f"{qualification.company_name} ({company_desc})"
        
        summary_parts.append(f"Contact from {company_desc}")
        
        # Intent and urgency
        intent_desc = f"seeking {qualification.intent.value}"
        if qualification.urgency != "low":
            intent_desc += f" with {qualification.urgency.value} urgency"
        
        summary_parts.append(intent_desc)
        
        # Technology interests
        if qualification.technology_interest:
            tech_list = ", ".join([t.value.upper() for t in qualification.technology_interest])
            summary_parts.append(f"interested in {tech_list}")
        
        # Lead score and readiness
        summary_parts.append(f"Lead score: {qualification.lead_score}/100")
        
        if qualification.sales_ready:
            summary_parts.append("READY FOR SALES ENGAGEMENT")
        
        return ". ".join([part.capitalize() for part in summary_parts]) + "."

# Global instance
_qualification_chain_instance = None

def get_qualification_chain() -> LeadQualificationChain:
    """Get singleton qualification chain instance"""
    global _qualification_chain_instance
    if _qualification_chain_instance is None:
        _qualification_chain_instance = LeadQualificationChain()
    return _qualification_chain_instance

# Export for use in API
__all__ = ["LeadQualificationChain", "get_qualification_chain"]