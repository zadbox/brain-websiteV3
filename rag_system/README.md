# BrainGenTechnology RAG System

Advanced Retrieval-Augmented Generation system with lead qualification capabilities, powered by Groq's Llama3-70B model and optimized for English-speaking business prospects.

## 🎯 Features

- **Intelligent Conversational AI**: Context-aware responses using company knowledge base
- **Automated Lead Qualification**: AI-powered analysis of business conversations
- **Groq Integration**: Ultra-fast inference with Llama3-70B-8192 model
- **Multi-Document RAG**: Comprehensive knowledge base with business content
- **RESTful API**: FastAPI-based endpoints with automatic documentation
- **Real-time Processing**: Sub-second response times for chat interactions
- **Scalable Architecture**: Production-ready with monitoring and error handling

## 🏗️ Architecture

```
rag_system/
├── chains/                  # LangChain implementations
│   ├── rag_chain.py        # Main RAG conversation chain
│   └── qualification_chain.py # Lead qualification logic
├── models/                  # Pydantic data models
│   └── lead_qualification.py
├── vectorstore/            # Document storage and search
│   ├── chroma_db/         # Vector database (generated)
│   └── documents/         # Source documents
│       ├── company/       # Company information
│       ├── services/      # Service descriptions
│       ├── case_studies/  # Success stories
│       └── technical/     # Technical documentation
├── api/                    # FastAPI application
│   └── main.py            # API endpoints and server
├── config/                 # Configuration management
│   └── settings.py
├── utils/                  # Utilities and tools
│   └── indexer.py         # Document indexing utility
└── requirements.txt       # Python dependencies
```

## 🚀 Quick Start

### 1. Setup Environment

```bash
# Copy environment template
cp .env.example .env

# Edit .env with your API keys
# Required: GROQ_API_KEY
# Optional: LANGSMITH_API_KEY (for monitoring)
```

### 2. Install & Start

```bash
# Run the startup script (handles everything)
python start_rag_server.py

# Or with custom options
python start_rag_server.py --port 8001 --reload
```

### 3. Test the System

```bash
# Check system health
curl http://localhost:8001/health

# Test chat endpoint
curl -X POST http://localhost:8001/chat \
  -H "Content-Type: application/json" \
  -d '{
    "message": "What AI solutions does BrainGenTechnology offer?",
    "session_id": "test-session-123"
  }'
```

## 📡 API Endpoints

### Chat Endpoint
```http
POST /chat
Content-Type: application/json

{
  "message": "What automation services do you provide?",
  "session_id": "unique-session-id",
  "metadata": {
    "pages_visited": ["/services", "/about"],
    "referrer": "google.com"
  }
}
```

**Response:**
```json
{
  "answer": "BrainGenTechnology provides comprehensive automation services...",
  "session_id": "unique-session-id",
  "sources": [...],
  "conversation_length": 3,
  "timestamp": "2024-01-15T10:30:00Z",
  "processing_time": 0.85
}
```

### Lead Qualification
```http
POST /qualify
Content-Type: application/json

{
  "session_id": "unique-session-id",
  "conversation_history": [
    {"role": "user", "content": "We need AI for our fintech startup"},
    {"role": "assistant", "content": "I can help with that..."}
  ],
  "metadata": {"company_size": "startup"}
}
```

**Response:**
```json
{
  "success": true,
  "qualification": {
    "intent": "consultation",
    "urgency": "medium",
    "company_size": "startup",
    "industry": "fintech",
    "lead_score": 75,
    "sales_ready": true,
    "notes": "Early-stage fintech looking for AI implementation...",
    ...
  },
  "processing_time": 1.2,
  "session_id": "unique-session-id"
}
```

### Other Endpoints
- `GET /health` - System health check
- `GET /conversation/{session_id}` - Get conversation history
- `DELETE /conversation/{session_id}` - Clear conversation
- `POST /documents` - Add documents to knowledge base
- `GET /docs` - Interactive API documentation

## 🔧 Configuration

### Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `GROQ_API_KEY` | *required* | Groq API key for LLM access |
| `LLM_MODEL` | `llama3-70b-8192` | Groq model to use |
| `LLM_TEMPERATURE` | `0.3` | Model temperature (0.0-1.0) |
| `EMBEDDINGS_MODEL` | `all-mpnet-base-v2` | HuggingFace embeddings model |
| `CHUNK_SIZE` | `1000` | Document chunk size for RAG |
| `RETRIEVAL_K` | `3` | Number of relevant chunks to retrieve |
| `API_PORT` | `8001` | Server port |
| `LOG_LEVEL` | `INFO` | Logging level |

### Model Configuration

The system is optimized for business conversations with these settings:

- **Temperature**: 0.3 (professional but engaging responses)
- **Max Tokens**: 2048 (comprehensive answers)
- **Context Window**: 8192 tokens (long conversation memory)
- **Retrieval**: Top-3 most relevant document chunks

## 📊 Lead Qualification

The system automatically analyzes conversations using the BANT framework:

### Qualification Criteria

- **Intent**: information, quote, demo, consultation, support
- **Urgency**: low, medium, high, critical
- **Company Size**: startup, sme, mid_market, enterprise
- **Industry**: fintech, healthcare, retail, manufacturing, etc.
- **Technology Interest**: AI, automation, blockchain, RAG, multi-agent
- **Decision Level**: user, manager, director, c_level, owner

### Scoring Algorithm (0-100)

- **Need Fit (25%)**: How well solutions match requirements
- **Authority (25%)**: Decision-making power of contact
- **Budget (25%)**: Investment readiness indicators
- **Timeline (25%)**: Implementation urgency

### Lead Grades

- **A Grade (80-100)**: Hot leads ready for immediate sales engagement
- **B Grade (60-79)**: Warm leads requiring nurturing
- **C Grade (40-59)**: Cold leads for long-term cultivation
- **D Grade (0-39)**: Poor fit or insufficient information

## 📚 Document Management

### Adding Documents

1. **Manual**: Place Markdown files in `vectorstore/documents/` subdirectories
2. **API**: Use `POST /documents` endpoint
3. **Bulk**: Use the indexer utility

```bash
# Reindex all documents
python utils/indexer.py --force-reindex

# Show index statistics
python utils/indexer.py --stats-only
```

### Document Structure

Organize documents by category:

```
documents/
├── company/           # Company overview, mission, values
├── services/          # Detailed service descriptions
├── case_studies/      # Customer success stories
├── technical/         # Technical specifications
└── industries/        # Industry-specific content
```

## 🔍 Monitoring & Analytics

### Health Monitoring

```bash
# System health
curl http://localhost:8001/health

# Index statistics
python start_rag_server.py --status
```

### LangSmith Integration (Optional)

Enable comprehensive monitoring by setting:

```bash
LANGSMITH_API_KEY=your_key_here
LANGCHAIN_TRACING_V2=true
```

## 🚦 Development

### Development Mode

```bash
# Start with auto-reload
python start_rag_server.py --reload

# Skip indexing during development
python start_rag_server.py --skip-index --reload
```

### Adding New Features

1. **New Document Types**: Add to `vectorstore/documents/`
2. **Custom Qualification Logic**: Modify `chains/qualification_chain.py`
3. **API Endpoints**: Add to `api/main.py`
4. **Configuration**: Update `config/settings.py`

## 🔒 Security Considerations

- **API Keys**: Never commit API keys to version control
- **CORS**: Configure appropriate origins for production
- **Rate Limiting**: Implement rate limiting for public APIs
- **Input Validation**: All inputs are validated using Pydantic models
- **Error Handling**: Graceful error handling with informative messages

## 📈 Performance

### Benchmarks (Local Testing)

- **Chat Response Time**: 0.5-2.0 seconds
- **Document Retrieval**: <100ms
- **Lead Qualification**: 1-3 seconds
- **Concurrent Users**: 50+ (depending on hardware)

### Optimization Tips

1. **Embeddings**: Use GPU for faster embedding generation
2. **Caching**: Implement Redis for conversation caching
3. **Load Balancing**: Deploy multiple instances behind load balancer
4. **Database**: Use PostgreSQL for production conversation storage

## 🐛 Troubleshooting

### Common Issues

**"RAG system not initialized"**
- Check GROQ_API_KEY is set correctly
- Verify internet connection
- Check Groq API quota

**"No documents found to index"**
- Ensure documents exist in `vectorstore/documents/`
- Check file permissions
- Verify file extensions (.md)

**Slow response times**
- Check Groq API status
- Monitor system resources
- Consider GPU acceleration for embeddings

### Debug Mode

```bash
# Enable verbose logging
export LOG_LEVEL=DEBUG
python start_rag_server.py --reload
```

## 🤝 Integration with Laravel

The RAG system is designed to integrate seamlessly with your Laravel application:

### Laravel Controller Example

```php
class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $response = Http::timeout(30)->post('http://localhost:8001/chat', [
            'message' => $request->message,
            'session_id' => session()->getId(),
            'metadata' => [
                'pages_visited' => session('pages_visited', []),
                'referrer' => $request->header('referer')
            ]
        ]);
        
        return response()->json($response->json());
    }
}
```

### Frontend Widget Integration

```javascript
// Chat widget integration
const chatWidget = new BrainGenChatWidget({
    apiEndpoint: '/api/chat',
    sessionId: generateSessionId(),
    welcomeMessage: 'Hi! How can I help you today?'
});
```

## 📞 Support

For technical support or feature requests:

- **Documentation**: http://localhost:8001/docs
- **Issues**: Create GitHub issues for bugs/features
- **Performance**: Monitor with LangSmith for production deployments

---

**BrainGenTechnology RAG System v1.0.0**  
*Intelligent Conversational AI with Advanced Lead Qualification*