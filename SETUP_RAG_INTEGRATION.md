# 🧠 RAG Chat Integration Setup Guide

This guide will help you set up the complete RAG (Retrieval-Augmented Generation) chat system with your Laravel application.

## 🎯 What You Get

✅ **Intelligent AI Chat Widget** - Professional chat interface with Groq Llama3-70B  
✅ **Automated Lead Qualification** - AI-powered prospect analysis using BANT methodology  
✅ **Real-time Conversations** - Sub-second response times with context awareness  
✅ **Business-focused Content** - Trained on your company's services and solutions  
✅ **CRM Integration Ready** - Database storage and qualification tracking  
✅ **Mobile Responsive** - Works perfectly on all devices  

## 🚀 Quick Setup (5 Steps)

### Step 1: Get Your Groq API Key

1. Visit [console.groq.com](https://console.groq.com)
2. Sign up/login to your account
3. Go to API Keys section
4. Create a new API key
5. Copy the key (starts with `gsk_...`)

### Step 2: Configure RAG System

```bash
# Navigate to RAG system directory
cd rag_system

# Copy environment template
cp .env.example .env

# Edit .env file with your API key
# Replace: GROQ_API_KEY=gsk_test_key_replace_with_actual_key
# With: GROQ_API_KEY=your_actual_groq_api_key_here
```

### Step 3: Install Python Dependencies

```bash
# Install Python packages
pip install -r requirements.txt

# Or if you prefer virtual environment:
python -m venv venv
source venv/bin/activate  # On Windows: venv\Scripts\activate
pip install -r requirements.txt
```

### Step 4: Setup Laravel Database

```bash
# Run the migration to create chat tables
php artisan migrate

# The migration creates:
# - chat_conversations (session tracking)
# - chat_messages (message history)  
# - lead_qualifications (prospect data)
```

### Step 5: Start Both Systems

```bash
# Terminal 1: Start RAG API Server
cd rag_system
python start_rag_server.py

# Terminal 2: Start Laravel Server  
php artisan serve --port=8080
```

## 🌐 Testing Your Setup

### 1. Check RAG System Health
```bash
curl http://localhost:8001/health
```

### 2. Check Laravel Integration
```bash
curl http://localhost:8080/api/chat/health
```

### 3. Test Chat Widget
1. Visit your Laravel application: `http://localhost:8080`
2. Look for the blue chat button in bottom-right corner
3. Click to open and send a test message like:
   - "What AI solutions do you offer?"
   - "Tell me about your automation services"
   - "I need help with blockchain implementation"

## 🎨 Chat Widget Features

### Professional Design
- **Modern UI**: Clean, business-focused design
- **Dark/Light Themes**: Matches your brand
- **Mobile Responsive**: Perfect on all screen sizes
- **Accessibility**: Full keyboard navigation and screen reader support

### Advanced Functionality
- **Typing Indicators**: Shows when AI is responding
- **Message History**: Persistent conversation context
- **Source Citations**: References to company documents
- **Lead Qualification**: Automatic prospect scoring
- **Error Handling**: Graceful fallbacks when offline

### Business Intelligence
- **Intent Detection**: Identifies what prospects want (demo, quote, info)
- **Company Sizing**: Startup, SME, mid-market, enterprise
- **Urgency Assessment**: Timeline and priority scoring
- **Technology Interests**: AI, automation, blockchain preferences
- **Decision Authority**: Identifies decision-maker level

## 📊 Lead Qualification Dashboard

The system automatically qualifies leads using:

### BANT Scoring (0-100 points)
- **Budget (25%)**: Investment readiness indicators
- **Authority (25%)**: Decision-making power assessment  
- **Need (25%)**: Fit with your solutions
- **Timeline (25%)**: Implementation urgency

### Qualification Triggers
- **Auto-qualify**: After 4+ meaningful messages
- **Manual**: Call `/api/chat/qualify` endpoint
- **Real-time**: Updates as conversation progresses

### CRM Integration
```php
// Example: Access qualification data
$qualification = DB::table('lead_qualifications')
    ->where('sales_ready', true)
    ->where('lead_score', '>=', 80)
    ->orderBy('qualified_at', 'desc')
    ->get();
```

## 🔧 Customization Options

### Chat Widget Configuration
```javascript
window.ragChatWidget = new BrainGenRAGChatWidget({
    // API endpoints
    apiEndpoint: '/api/chat',
    qualificationEndpoint: '/api/chat/qualify',
    
    // Appearance
    theme: 'dark', // 'dark' or 'light'
    position: 'bottom-right', // 'bottom-left', 'top-right', 'top-left'
    
    // Behavior
    autoOpen: false, // Auto-open on page load
    autoQualifyAfter: 4, // Messages before auto-qualification
    
    // Content
    welcomeMessage: "Your custom welcome message",
    brandName: 'Your Company Name',
    
    // Features
    enableSounds: true,
    enableTypingIndicator: true,
    maxMessageLength: 2000
});
```

### RAG System Configuration
Edit `rag_system/.env`:

```bash
# Model settings
LLM_MODEL=llama3-70b-8192
LLM_TEMPERATURE=0.3  # 0.0 = focused, 1.0 = creative
LLM_MAX_TOKENS=2048

# Knowledge base
CHUNK_SIZE=1000      # Document chunk size
CHUNK_OVERLAP=200    # Overlap between chunks
RETRIEVAL_K=3        # Number of relevant chunks

# Lead qualification
LEAD_SCORE_THRESHOLD=60
QUALIFICATION_TIMEOUT=30
```

## 📚 Adding Your Content

### Document Structure
```
rag_system/vectorstore/documents/
├── company/              # Company information
│   ├── overview.md
│   ├── values.md
│   └── team.md
├── services/             # Service descriptions
│   ├── ai_solutions.md
│   ├── automation.md
│   └── consulting.md
├── case_studies/         # Success stories
│   ├── fintech_case.md
│   └── healthcare_case.md
└── technical/            # Technical docs
    ├── api_docs.md
    └── integration.md
```

### Adding New Documents
1. **Manual**: Place `.md` files in appropriate folders
2. **API**: Use `POST /documents` endpoint
3. **Bulk**: Use the indexer utility

```bash
# Reindex after adding documents
cd rag_system
python utils/indexer.py --force-reindex
```

## 🚨 Troubleshooting

### Common Issues

**"RAG system not initialized"**
```bash
# Check if RAG server is running
curl http://localhost:8001/health

# Check API key is valid
grep GROQ_API_KEY rag_system/.env
```

**"Chat widget doesn't appear"**
- Check browser console for JavaScript errors
- Verify CSS and JS files are loading
- Ensure CSRF token is available

**"Slow responses"**
- Check internet connection to Groq API
- Monitor system resources (CPU/Memory)
- Consider upgrading to Groq Pro for faster limits

**"No relevant answers"**
- Add more company documents to knowledge base
- Reindex documents after changes
- Check document format (Markdown works best)

### Debug Mode
```bash
# Enable debug logging
export LOG_LEVEL=DEBUG
python start_rag_server.py --reload
```

### Performance Monitoring
```bash
# Check system status
python start_rag_server.py --status

# View index statistics
python utils/indexer.py --stats-only
```

## 🔐 Production Deployment

### Security Checklist
- [ ] Set strong `GROQ_API_KEY` in production environment
- [ ] Configure proper CORS origins in `ChatController`
- [ ] Enable rate limiting on chat endpoints
- [ ] Set up HTTPS for all API calls
- [ ] Configure proper database permissions

### Performance Optimization
- [ ] Use Redis for conversation caching
- [ ] Set up load balancer for multiple RAG instances
- [ ] Configure CDN for static assets
- [ ] Enable Gzip compression
- [ ] Monitor API usage and costs

### Monitoring & Analytics
```php
// Laravel: Track chat usage
Log::info('Chat interaction', [
    'session_id' => $sessionId,
    'user_agent' => $request->userAgent(),
    'response_time' => $processingTime
]);

// Google Analytics: Track qualified leads
gtag('event', 'lead_qualified', {
    'lead_score': qualification.lead_score,
    'company_size': qualification.company_size
});
```

## 📞 Support & Next Steps

### Getting Help
- **Documentation**: Check `rag_system/README.md` for technical details
- **API Docs**: Visit `http://localhost:8001/docs` for interactive API documentation
- **Logs**: Check `storage/logs/laravel.log` for Laravel issues

### Advanced Features
- **Multi-language Support**: Configure different models for different languages
- **Voice Integration**: Add speech-to-text and text-to-speech
- **Video Calls**: Integrate with Zoom/Teams for qualified leads
- **CRM Sync**: Bi-directional sync with Salesforce, HubSpot, etc.

### Custom Development
The system is built with extensibility in mind:
- **Custom Qualification Logic**: Modify `qualification_chain.py`
- **New Document Types**: Add processors in `indexer.py`
- **UI Customization**: Modify CSS and JavaScript
- **API Extensions**: Add endpoints in Laravel or FastAPI

---

**🎉 Congratulations!** Your intelligent RAG chat system is now ready to engage prospects and qualify leads automatically. The AI assistant will help visitors learn about your services while gathering valuable qualification data for your sales team.

**Questions?** The system includes comprehensive logging and error handling to help diagnose any issues. Check the health endpoints and logs if you encounter problems.