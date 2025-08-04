import os
import logging
from typing import Dict, List, Any, Optional
from datetime import datetime

from langchain.chains import LLMChain
from langchain_core.prompts import PromptTemplate
from langchain_cohere import CohereEmbeddings
from langchain_community.vectorstores import Qdrant
from langchain.chains import ConversationalRetrievalChain
from langchain_core.memory import ConversationBufferMemory
from langchain.agents import Tool, AgentExecutor, create_openai_functions_agent
from langchain_core.messages import BaseMessage, HumanMessage, AIMessage
from langchain_cohere import ChatCohere
from qdrant_client import QdrantClient

from app.tools.lead_qualification import lead_qualification_tool
from app.tools.budget_calculator import budget_calculator_tool
from app.tools.service_recommendation import service_recommendation_tool

logger = logging.getLogger(__name__)

class BrainGenTechAgent:
    """
    BrainGenTech Agent using LangChain for intelligent conversation and lead qualification
    """
    
    def __init__(self):
        """Initialize the BrainGenTech Agent with LangChain components"""
        self.setup_components()
        self.setup_chains()
        self.setup_tools()
        self.setup_agent()
        logger.info("BrainGenTech Agent initialized successfully")
    
    def setup_components(self):
        """Setup core LangChain components"""
        try:
            # Initialize Cohere LLM
            self.llm = ChatCohere(
                cohere_api_key=os.getenv('COHERE_API_KEY'),
                model="command-r-plus"
            )
            
            # Initialize embeddings
            self.embeddings = CohereEmbeddings(
                cohere_api_key=os.getenv('COHERE_API_KEY'),
                model="embed-english-v3.0"
            )
            
            # Initialize Qdrant client
            qdrant_url = os.getenv('QDRANT_URL', 'http://localhost:6333')
            self.qdrant_client = QdrantClient(url=qdrant_url)
            
            # Initialize vector store
            self.vectorstore = Qdrant(
                client=self.qdrant_client,
                collection_name="brain_knowledge",
                embeddings=self.embeddings
            )
            
            # Initialize memory
            self.memory = ConversationBufferMemory(
                memory_key="chat_history",
                return_messages=True
            )
            
            logger.info("Core components initialized successfully")
            
        except Exception as e:
            logger.error(f"Failed to setup components: {e}")
            raise
    
    def setup_chains(self):
        """Setup LangChain chains for different use cases"""
        try:
            # General conversation chain
            self.general_chain = ConversationalRetrievalChain.from_llm(
                llm=self.llm,
                retriever=self.vectorstore.as_retriever(search_kwargs={"k": 3}),
                memory=self.memory,
                return_source_documents=True,
                verbose=True
            )
            
            # Lead qualification chain
            lead_prompt_template = PromptTemplate(
                input_variables=["message", "context", "lead_data"],
                template="""
                Tu es un expert en qualification de leads pour BrainGenTech.
                
                Analyse le message suivant selon le framework BANT (Budget, Authority, Need, Timeline):
                
                Message: {message}
                Contexte: {context}
                Données lead: {lead_data}
                
                Fournis une analyse détaillée avec:
                1. Scores BANT (0-10 pour chaque critère)
                2. Score global (0-10)
                3. Catégorie (Hot/Warm/Cold)
                4. Recommandations d'actions
                5. Réponse personnalisée
                
                Format de réponse JSON:
                {{
                    "bant_scores": {{
                        "budget": score,
                        "authority": score,
                        "need": score,
                        "timeline": score
                    }},
                    "overall_score": score,
                    "category": "Hot/Warm/Cold",
                    "recommendations": ["rec1", "rec2"],
                    "response": "Réponse personnalisée"
                }}
                """
            )
            
            self.lead_chain = LLMChain(
                llm=self.llm,
                prompt=lead_prompt_template,
                verbose=True
            )
            
            # Service recommendation chain
            service_prompt_template = PromptTemplate(
                input_variables=["message", "context"],
                template="""
                Tu es un expert en solutions d'IA et d'automatisation pour BrainGenTech.
                
                Basé sur le message suivant, recommande les services les plus appropriés:
                
                Message: {message}
                Contexte: {context}
                
                Services disponibles:
                1. Chatbots Avancés - Assistants IA multilingues
                2. Automatisation des Processus - RPA et workflows
                3. Analyse de Données - Business Intelligence
                4. Intégration CRM - Connecteurs et API
                5. Consultation Stratégique - Roadmap IA
                
                Fournis:
                1. Services recommandés (top 3)
                2. Justification pour chaque service
                3. Estimation de budget indicative
                4. Timeline d'implémentation
                
                Format JSON:
                {{
                    "recommended_services": ["service1", "service2", "service3"],
                    "justifications": {{"service1": "justification", ...}},
                    "budget_estimate": "range",
                    "timeline": "duration",
                    "response": "Réponse détaillée"
                }}
                """
            )
            
            self.service_chain = LLMChain(
                llm=self.llm,
                prompt=service_prompt_template,
                verbose=True
            )
            
            logger.info("Chains setup successfully")
            
        except Exception as e:
            logger.error(f"Failed to setup chains: {e}")
            raise
    
    def setup_tools(self):
        """Setup LangChain tools for specific functionalities"""
        try:
            self.tools = [
                LeadQualificationTool(),
                BudgetCalculatorTool(),
                ServiceRecommendationTool()
            ]
            
            logger.info(f"Setup {len(self.tools)} tools successfully")
            
        except Exception as e:
            logger.error(f"Failed to setup tools: {e}")
            raise
    
    def setup_agent(self):
        """Setup the main agent with tools and memory"""
        try:
            # Create agent prompt
            agent_prompt = PromptTemplate(
                input_variables=["input", "chat_history", "agent_scratchpad"],
                template="""
                Tu es l'assistant IA BrainGenTech, spécialisé dans les solutions d'IA et d'automatisation.
                
                Tu as accès aux outils suivants:
                - lead_qualification: Qualifie les leads selon BANT
                - budget_calculator: Calcule des estimations de budget
                - service_recommendation: Recommande des services appropriés
                
                Historique de conversation: {chat_history}
                
                Question utilisateur: {input}
                
                {agent_scratchpad}
                
                Réponds de manière professionnelle et utile. Utilise les outils quand nécessaire.
                """
            )
            
            # Create agent
            self.agent = create_openai_functions_agent(
                llm=self.llm,
                tools=self.tools,
                prompt=agent_prompt
            )
            
            # Create agent executor
            self.agent_executor = AgentExecutor.from_agent_and_tools(
                agent=self.agent,
                tools=self.tools,
                memory=self.memory,
                verbose=True,
                handle_parsing_errors=True
            )
            
            logger.info("Agent setup successfully")
            
        except Exception as e:
            logger.error(f"Failed to setup agent: {e}")
            raise
    
    def process_query(self, query: str, context: Dict[str, Any] = None, 
                     lead_data: Dict[str, Any] = None, session_id: str = None) -> Dict[str, Any]:
        """
        Process a user query and return a comprehensive response
        """
        try:
            # Enhanced routing logic for all types of questions
            if self._is_lead_question(query):
                return self._process_lead_query(query, context, lead_data)
            elif self._is_service_question(query):
                return self._process_service_query(query, context)
            elif self._is_general_question(query):
                return self._process_general_knowledge_query(query, context)
            else:
                # Default to general conversation with enhanced capabilities
                return self._process_general_query(query, context)
                
        except Exception as e:
            logger.error(f"Error processing query: {e}")
            return self._get_fallback_response(query)
    
    def _is_lead_question(self, query: str) -> bool:
        """Determine if the query is about lead qualification"""
        lead_keywords = [
            'budget', 'coût', 'prix', 'tarif', 'argent',
            'directeur', 'manager', 'décideur', 'ceo', 'responsable',
            'besoin', 'problème', 'challenge', 'défi', 'difficulté',
            'délai', 'timeline', 'planning', 'urgence', 'urgent'
        ]
        
        query_lower = query.lower()
        return any(keyword in query_lower for keyword in lead_keywords)
    
    def _is_service_question(self, query: str) -> bool:
        """Determine if the query is about services"""
        service_keywords = [
            'service', 'solution', 'offre', 'produit',
            'chatbot', 'automatisation', 'ia', 'intelligence',
            'crm', 'analyse', 'consultation', 'braingen', 'brain'
        ]
        
        query_lower = query.lower()
        return any(keyword in query_lower for keyword in service_keywords)
    
    def _is_general_question(self, query: str) -> bool:
        """Determine if the query is a general knowledge question"""
        general_keywords = [
            'comment', 'pourquoi', 'que', 'quel', 'quelle', 'qui', 'où', 'quand',
            'science', 'histoire', 'mathématiques', 'physique', 'chimie',
            'programmation', 'code', 'développement', 'python', 'javascript',
            'expliquer', 'définir', 'qu\'est-ce que', 'c\'est quoi'
        ]
        
        query_lower = query.lower()
        return any(keyword in query_lower for keyword in general_keywords)
    
    def _process_general_query(self, query: str, context: Dict[str, Any] = None) -> Dict[str, Any]:
        """Process general conversation queries"""
        try:
            # Use the general chain for business/company related queries
            result = self.general_chain({"question": query})
            
            # Extract sources
            sources = []
            if hasattr(result, 'source_documents'):
                sources = [doc.metadata.get('source', '') for doc in result.source_documents]
            
            # Generate suggestions
            suggestions = self._generate_suggestions(query, result['answer'])
            
            return {
                'response': result['answer'],
                'confidence': 0.8,
                'sources': sources,
                'suggestions': suggestions,
                'lead_qualification': None,
                'source': 'langchain_general'
            }
            
        except Exception as e:
            logger.error(f"Error in general query processing: {e}")
            return self._get_fallback_response(query)
    
    def _process_general_knowledge_query(self, query: str, context: Dict[str, Any] = None) -> Dict[str, Any]:
        """Process general knowledge questions (science, tech, education, etc.)"""
        try:
            # Enhanced prompt for general knowledge questions
            knowledge_prompt = PromptTemplate(
                input_variables=["question", "context"],
                template="""
                Tu es un assistant IA expert capable de répondre à tous types de questions.
                
                Question: {question}
                Contexte: {context}
                
                Instructions:
                1. Si c'est une question scientifique, technique ou éducative, réponds avec précision et expertise
                2. Fournis des explications claires et structurées
                3. Utilise des exemples concrets quand c'est pertinent
                4. Adapte le niveau de complexité à la question
                5. Sois pédagogue et informatif
                6. Réponds en français sauf si demandé autrement
                
                Types de questions que tu peux traiter:
                - Sciences (physique, chimie, biologie, mathématiques)
                - Technologie (programmation, IA, informatique)
                - Histoire et géographie
                - Culture générale
                - Conseils pratiques
                - Et bien plus encore...
                
                Réponse détaillée:
                """
            )
            
            # Create a temporary chain for general knowledge
            knowledge_chain = LLMChain(
                llm=self.llm,
                prompt=knowledge_prompt,
                verbose=True
            )
            
            # Process the query
            result = knowledge_chain.run(
                question=query,
                context=context or {}
            )
            
            # Generate appropriate suggestions
            suggestions = self._generate_knowledge_suggestions(query)
            
            return {
                'response': result,
                'confidence': 0.9,  # High confidence for general knowledge
                'sources': ['cohere_llm', 'general_knowledge'],
                'suggestions': suggestions,
                'lead_qualification': None,
                'source': 'langchain_knowledge'
            }
            
        except Exception as e:
            logger.error(f"Error in general knowledge processing: {e}")
            return self._get_fallback_response(query)
    
    def _process_lead_query(self, query: str, context: Dict[str, Any] = None, 
                           lead_data: Dict[str, Any] = None) -> Dict[str, Any]:
        """Process lead qualification queries"""
        try:
            # Use the lead qualification chain
            result = self.lead_chain.run(
                message=query,
                context=context or {},
                lead_data=lead_data or {}
            )
            
            # Parse the result (assuming JSON format)
            import json
            try:
                parsed_result = json.loads(result)
            except:
                parsed_result = {
                    'response': result,
                    'bant_scores': {'budget': 5, 'authority': 5, 'need': 5, 'timeline': 5},
                    'overall_score': 5,
                    'category': 'Warm'
                }
            
            return {
                'response': parsed_result.get('response', result),
                'confidence': 0.9,
                'sources': [],
                'suggestions': self._generate_lead_suggestions(parsed_result),
                'lead_qualification': parsed_result,
                'source': 'langchain_lead'
            }
            
        except Exception as e:
            logger.error(f"Error in lead query processing: {e}")
            return self._get_fallback_response(query)
    
    def _process_service_query(self, query: str, context: Dict[str, Any] = None) -> Dict[str, Any]:
        """Process service recommendation queries"""
        try:
            # Use the service recommendation chain
            result = self.service_chain.run(
                message=query,
                context=context or {}
            )
            
            # Parse the result
            import json
            try:
                parsed_result = json.loads(result)
            except:
                parsed_result = {
                    'response': result,
                    'recommended_services': [],
                    'budget_estimate': 'À définir',
                    'timeline': 'À définir'
                }
            
            return {
                'response': parsed_result.get('response', result),
                'confidence': 0.85,
                'sources': [],
                'suggestions': self._generate_service_suggestions(parsed_result),
                'lead_qualification': None,
                'source': 'langchain_service'
            }
            
        except Exception as e:
            logger.error(f"Error in service query processing: {e}")
            return self._get_fallback_response(query)
    
    def _generate_suggestions(self, query: str, response: str) -> List[str]:
        """Generate contextual suggestions based on query and response"""
        suggestions = [
            "Quel est votre rôle dans l'entreprise ?",
            "Quel est votre budget pour ce projet ?",
            "Dans quel délai souhaitez-vous implémenter ?"
        ]
        
        # Customize suggestions based on query content
        if 'budget' in query.lower():
            suggestions = [
                "Pouvez-vous préciser votre fourchette de budget ?",
                "Avez-vous déjà un budget alloué ?",
                "Souhaitez-vous une estimation détaillée ?"
            ]
        elif 'service' in query.lower():
            suggestions = [
                "Quel type de service vous intéresse le plus ?",
                "Avez-vous des besoins spécifiques ?",
                "Souhaitez-vous une démonstration ?"
            ]
        
        return suggestions[:3]
    
    def _generate_knowledge_suggestions(self, query: str) -> List[str]:
        """Generate suggestions for general knowledge questions"""
        query_lower = query.lower()
        
        # Science and technology suggestions
        if any(word in query_lower for word in ['science', 'physique', 'chimie', 'biologie', 'mathématiques']):
            return [
                "Voulez-vous plus de détails techniques ?",
                "Avez-vous des questions connexes ?",
                "Souhaitez-vous des exemples pratiques ?"
            ]
        
        # Programming and tech suggestions
        elif any(word in query_lower for word in ['programmation', 'code', 'développement', 'python', 'javascript']):
            return [
                "Avez-vous besoin d'exemples de code ?",
                "Voulez-vous des ressources d'apprentissage ?",
                "Avez-vous un projet spécifique en tête ?"
            ]
        
        # History and culture suggestions
        elif any(word in query_lower for word in ['histoire', 'culture', 'géographie', 'art']):
            return [
                "Souhaitez-vous plus de contexte historique ?",
                "Avez-vous d'autres questions sur ce sujet ?",
                "Voulez-vous des références pour approfondir ?"
            ]
        
        # Default knowledge suggestions
        else:
            return [
                "Puis-je préciser certains points ?",
                "Avez-vous d'autres questions ?",
                "Voulez-vous plus d'informations ?"
            ]
    
    def _generate_lead_suggestions(self, lead_data: Dict[str, Any]) -> List[str]:
        """Generate suggestions based on lead qualification results"""
        suggestions = []
        
        if lead_data.get('overall_score', 0) >= 8:
            suggestions = [
                "Souhaitez-vous planifier une réunion ?",
                "Avez-vous des questions spécifiques ?",
                "Puis-je vous envoyer une proposition détaillée ?"
            ]
        elif lead_data.get('overall_score', 0) >= 6:
            suggestions = [
                "Pouvez-vous me donner plus de détails ?",
                "Avez-vous un budget en tête ?",
                "Quel est votre délai d'implémentation ?"
            ]
        else:
            suggestions = [
                "Quel est votre rôle dans l'entreprise ?",
                "Avez-vous des besoins spécifiques ?",
                "Quel est votre budget pour ce projet ?"
            ]
        
        return suggestions
    
    def _generate_service_suggestions(self, service_data: Dict[str, Any]) -> List[str]:
        """Generate suggestions based on service recommendations"""
        suggestions = [
            "Souhaitez-vous plus de détails sur ces services ?",
            "Avez-vous des questions spécifiques ?",
            "Puis-je vous proposer une démonstration ?"
        ]
        
        return suggestions
    
    def _get_fallback_response(self, query: str) -> Dict[str, Any]:
        """Get a fallback response when processing fails"""
        return {
            'response': 'Je suis désolé, je rencontre une difficulté technique. Pouvez-vous reformuler votre question ?',
            'confidence': 0.1,
            'sources': [],
            'suggestions': [
                'Quel est votre rôle dans l\'entreprise ?',
                'Quel est votre budget pour ce projet ?',
                'Dans quel délai souhaitez-vous implémenter ?'
            ],
            'lead_qualification': None,
            'source': 'fallback'
        }
    
    def qualify_lead(self, message: str, context: Dict[str, Any] = None, 
                    lead_data: Dict[str, Any] = None) -> Dict[str, Any]:
        """Qualify a lead using the lead qualification tool"""
        try:
            tool = LeadQualificationTool()
            result = tool._run(message, context or {})
            return result
        except Exception as e:
            logger.error(f"Error in lead qualification: {e}")
            return {
                'budget_score': 5,
                'authority_score': 5,
                'need_score': 5,
                'timeline_score': 5,
                'overall_score': 5,
                'category': 'Warm',
                'recommendations': ['Besoin de plus d\'informations']
            }
    
    def add_knowledge(self, text: str, metadata: Dict[str, Any] = None) -> str:
        """Add knowledge to the vector store"""
        try:
            # Add text to vector store
            self.vectorstore.add_texts(
                texts=[text],
                metadatas=[metadata or {}]
            )
            
            logger.info(f"Added knowledge to vector store")
            return "success"
            
        except Exception as e:
            logger.error(f"Error adding knowledge: {e}")
            raise
    
    def search_knowledge(self, query: str, limit: int = 5) -> List[Dict[str, Any]]:
        """Search the knowledge base"""
        try:
            results = self.vectorstore.similarity_search(query, k=limit)
            
            formatted_results = []
            for doc in results:
                formatted_results.append({
                    'content': doc.page_content,
                    'metadata': doc.metadata,
                    'score': getattr(doc, 'score', 0.0)
                })
            
            return formatted_results
            
        except Exception as e:
            logger.error(f"Error searching knowledge: {e}")
            return []
    
    def check_cohere(self) -> bool:
        """Check if Cohere API is available"""
        try:
            # Simple test call
            test_embedding = self.embeddings.embed_query("test")
            return len(test_embedding) > 0
        except Exception as e:
            logger.error(f"Cohere API check failed: {e}")
            return False
    
    def check_qdrant(self) -> bool:
        """Check if Qdrant is available"""
        try:
            # Simple health check
            collections = self.qdrant_client.get_collections()
            return True
        except Exception as e:
            logger.error(f"Qdrant check failed: {e}")
            return False 