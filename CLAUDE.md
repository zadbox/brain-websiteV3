# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

BrainGenTech is an advanced AI chatbot system built with Laravel and Python microservices. The system integrates:
- Laravel frontend with Blade templates and modern CSS/JS
- Python FastAPI service with LangChain, Cohere LLM, and Qdrant vector database
- Advanced chatbot with lead qualification (BANT framework)
- Knowledge base with vector search capabilities
- Real-time conversation memory management

## Architecture

The system follows a microservices architecture:
```
Frontend (Laravel) → Laravel API → Python FastAPI → Vector Store (Qdrant) → Cohere LLM
```

### Key Services
- **Laravel App** (Port 8000): Web interface, API controllers, Blade views
- **Python API** (Port 8001): LangChain service with AI processing
- **Qdrant** (Port 6333): Vector database for knowledge base
- **SQLite/MySQL**: Laravel application database

## Commands

### Laravel Commands
- `php artisan serve` - Start Laravel development server on port 8000
- `php artisan serve --port=8080` - Start server on custom port
- `./start-server.sh` - Quick setup and launch script (recommended for first-time setup)
- `./start-all-services.sh` - Start all services (Laravel + Python + Qdrant)

### Database Commands
- `php artisan migrate` - Run database migrations
- `php artisan migrate:fresh` - Drop and recreate all tables
- `php artisan db:seed --class=KnowledgeBaseSeeder` - Seed the knowledge base
- `php artisan key:generate` - Generate application key

### Frontend Development
- `npm run dev` - Start Vite development server
- `npm run build` - Build assets for production
- Vite handles Tailwind CSS compilation automatically

### Python Service
```bash
# Navigate to Python service
cd python-service

# Install dependencies
pip install -r requirements.txt

# Run the FastAPI service
python main.py

# Initialize vector store with knowledge
python init_vectorstore.py

# Add knowledge to vector store
python add_knowledge.py
```

### Docker Development
```bash
# Start all services with monitoring
docker-compose up -d

# View logs
docker-compose logs langchain
docker-compose logs laravel

# Stop services
docker-compose down
```

### Testing
- `php artisan test` - Run PHPUnit tests
- `./vendor/bin/phpunit` - Alternative test runner

### Code Quality
- `./vendor/bin/pint` - Run Laravel Pint (PHP CS Fixer) for code formatting

## Architecture Overview

### Tech Stack
- **Backend**: Laravel 11 with PHP 8.2+
- **Database**: SQLite (development), supports MySQL/PostgreSQL for production
- **Frontend**: Vite + Tailwind CSS + Vanilla JavaScript
- **Email**: Laravel Mail with SMTP support
- **AI/ML**: Python FastAPI with LangChain, Cohere LLM, Qdrant vector database

### Project Structure
```
app/Http/Controllers/
├── IndexController.php - Main page controller with all route handlers
├── ChatbotController.php - AI chatbot API endpoints
app/Services/ - AI and business logic services
├── RAGService.php - Retrieval Augmented Generation
├── CohereService.php - Cohere LLM integration
├── EmbeddingService.php - Text embeddings
├── LangChainService.php - LangChain integration
└── LeadQualificationService.php - BANT lead scoring
app/Models/
├── KnowledgeBase.php - Knowledge base model
routes/
├── web.php - Web routes
├── api.php - API routes for chatbot
database/migrations/
├── *_create_knowledge_base_table.php - Knowledge base schema
database/seeders/
├── KnowledgeBaseSeeder.php - Knowledge base data
python-service/ - FastAPI microservice
├── main.py - FastAPI application
├── app/services/brain_agent.py - Core AI agent
├── app/tools/ - Custom LangChain tools
└── requirements.txt - Python dependencies
resources/views/ - Blade templates (preserved from current version)
public/assets/css/modern-ai.css - AI chatbot styles
```

### Key Components

#### Controllers
- `IndexController.php` - Handles all page routes (index, about, services, contact, etc.)
- `ChatbotController.php` - Comprehensive chatbot API with lead qualification, knowledge search, and status endpoints

#### AI Services
- `RAGService.php` - Retrieval Augmented Generation with vector search
- `CohereService.php` - Cohere LLM API integration
- `EmbeddingService.php` - Text embedding generation
- `LangChainService.php` - LangChain framework integration
- `LeadQualificationService.php` - BANT framework lead scoring

#### Python Microservice
- **FastAPI service** on port 8001 with LangChain integration
- **Custom tools** for budget calculation, lead qualification, service recommendations
- **Vector database** integration with Qdrant for semantic search
- **Conversation memory** management with automatic cleanup

#### Views & Templates
- Blade templating engine with layouts preserved from current version
- Multiple layout versions for different page styles
- Partial components for header, footer, and advanced chatbot widget
- Service pages organized under `services/` directory

#### Frontend Assets
- Custom CSS in `public/assets/css/index-page.css` (preserved)
- Modern AI styles in `public/assets/css/modern-ai.css` (new)
- Custom JavaScript preserved from current version
- Animated neural network background using HTML5 Canvas
- Advanced chatbot UI with real-time messaging

#### API Endpoints
- `POST /api/chatbot/message` - Send message to chatbot
- `GET /api/chatbot/status` - Check service status
- `GET /api/chatbot/config` - Get configuration
- `POST /api/chatbot/qualify-lead` - Lead qualification
- `GET /api/chatbot/search-knowledge` - Knowledge search

### Configuration
- Environment variables documented in `.env.example`
- New variables: `LANGCHAIN_SERVICE_URL`, `COHERE_API_KEY`, `QDRANT_URL`
- Tailwind config includes custom color palette, fonts, and animations
- Vite config set up for Laravel integration with Tailwind CSS

### Database
- Uses SQLite for development (file: `database/database.sqlite`)
- Standard Laravel migrations plus knowledge base schema
- `KnowledgeBase` model for AI knowledge management
- Vector embeddings stored in Qdrant

### Contact Form Processing
The contact form is handled directly in `routes/web.php` with validation and email sending. Form fields:
- `user-name`, `user-email`, `user-subject`, `user-message`

### AI System Features
- **Conversation Context**: Maintains conversation history and context
- **Lead Qualification**: BANT framework scoring (Budget, Authority, Need, Timeline)
- **Knowledge Search**: Vector similarity search across knowledge base
- **Smart Suggestions**: Context-aware response suggestions
- **Real-time Processing**: Sub-second response times with confidence scoring

### Environment Setup
Required environment variables:
```bash
LANGCHAIN_SERVICE_URL=http://localhost:8001
LANGCHAIN_TIMEOUT=30
QDRANT_URL=http://localhost:6333
QDRANT_COLLECTION=knowledge_chunks
COHERE_API_KEY=your_cohere_api_key_here
```

### Quick Start Notes
- Use `./start-all-services.sh` to start Laravel + Python + Qdrant services
- Use `./start-server.sh` for Laravel-only development
- Seed knowledge base: `php artisan db:seed --class=KnowledgeBaseSeeder`
- Initialize vector store: `cd python-service && python init_vectorstore.py`
- The application serves on `http://127.0.0.1:8080` by default
- Python API serves on `http://localhost:8001`
- Qdrant serves on `http://localhost:6333`