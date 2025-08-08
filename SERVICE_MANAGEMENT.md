# 🧠 BrainGenTechnology - Service Management Guide

Complete guide for managing the RAG-enabled Laravel application with all services.

## 🏗️ **System Architecture**

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Laravel App   │────│   RAG Server    │────│  Vectorstore    │
│   Port: 8000    │    │   Port: 8002    │    │  (ChromaDB)     │
│                 │    │                 │    │                 │
│ • Web Interface │    │ • Groq LLM      │    │ • 56 Documents  │
│ • API Endpoints │    │ • Embeddings    │    │ • Business KB   │
│ • Chat Widget   │    │ • Context Ret.  │    │ • Vector Search │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

## 🚀 **Quick Start Commands**

### 🔥 **Development Start (Recommended)**
```bash
./start-dev.sh
```
*Fastest way to start all services for development*

### 🏭 **Production Start**
```bash
./start-all-services.sh
```
*Complete startup with dependency checks and monitoring*

### 🛑 **Stop All Services**
```bash
./stop-all-services.sh
```
*Cleanly stop all running services*

### 📊 **Check Status**
```bash
./status.sh
```
*Real-time status of all services*

## 📋 **Service Details**

### **Laravel Application (Port 8000)**
- **Purpose**: Web interface and API gateway
- **URL**: http://127.0.0.1:8000
- **API**: http://127.0.0.1:8000/api/chat
- **Features**:
  - Main website interface
  - RAG chat API endpoints
  - Session management
  - Lead qualification

### **RAG Server (Port 8002)**
- **Purpose**: AI-powered conversation engine
- **URL**: http://localhost:8002
- **Health**: http://localhost:8002/health
- **Features**:
  - Groq Llama3-70B LLM
  - Vector document search
  - Context-aware responses
  - Business knowledge base (56 documents)

## 🔧 **Configuration Files**

### **RAG System Configuration**
```bash
rag_system/.env
```
Key settings:
- `GROQ_API_KEY`: Your Groq API key
- `API_PORT=8002`: RAG server port
- `LLM_MODEL=llama3-70b-8192`: AI model

### **Laravel Configuration**
```bash
.env
```
Standard Laravel environment configuration

## 📁 **Important File Locations**

### **Startup Scripts**
- `start-all-services.sh` - Complete production startup
- `start-dev.sh` - Quick development startup
- `stop-all-services.sh` - Stop all services
- `status.sh` - Service status checker

### **RAG System**
- `rag_system/working_server.py` - Main RAG server
- `rag_system/vectorstore/` - Document knowledge base
- `rag_system/.env` - RAG configuration

### **Laravel Integration**
- `app/Http/Controllers/ChatController.php` - Laravel chat API
- `routes/api.php` - Chat API routes
- `public/assets/js/rag-chat-widget.js` - Frontend chat widget

### **Logs**
- `logs/rag-server.log` - RAG server logs
- `logs/laravel-server.log` - Laravel logs
- `logs/rag-dev.log` - Development RAG logs
- `logs/laravel-dev.log` - Development Laravel logs

## 🎯 **Usage Examples**

### **Start Development Environment**
```bash
# Quick start for development
./start-dev.sh

# Check status
./status.sh

# View logs
tail -f logs/rag-dev.log
tail -f logs/laravel-dev.log
```

### **Test Chat API**
```bash
# Test health endpoint
curl http://127.0.0.1:8000/api/chat/health | jq

# Send chat message
curl -X POST http://127.0.0.1:8000/api/chat \
  -H "Content-Type: application/json" \
  -d '{"message": "What AI services do you offer?", "session_id": "test"}'
```

### **Check RAG Server Status**
```bash
# Direct RAG health check
curl http://localhost:8002/health | jq

# Check document count
curl -s http://localhost:8002/health | jq '.system_info.document_count'
```

## 🔍 **Troubleshooting**

### **Common Issues**

#### **Port Conflicts**
```bash
# Check what's using ports
lsof -i :8000
lsof -i :8002

# Kill processes on ports
./stop-all-services.sh
```

#### **RAG Server Won't Start**
1. Check Groq API key in `rag_system/.env`
2. Verify Python dependencies: `pip install -r rag_system/requirements.txt`
3. Check vectorstore: `ls -la rag_system/vectorstore/chroma_db/`

#### **Laravel Issues**
1. Check environment: `php artisan config:clear`
2. Verify database: `ls -la database/database.sqlite`
3. Check dependencies: `composer install`

#### **Chat Widget Not Working**
1. Verify both servers are running: `./status.sh`
2. Check browser console for JavaScript errors
3. Test API directly with curl

### **Log Analysis**
```bash
# Watch RAG server logs
tail -f logs/rag-server.log

# Watch Laravel logs
tail -f logs/laravel-server.log

# Search for errors
grep -i error logs/*.log
```

## 🧪 **Testing**

### **Automated Status Check**
```bash
./status.sh
```

### **Manual API Testing**
```bash
# Test chat functionality
curl -X POST http://127.0.0.1:8000/api/chat \
  -H "Content-Type: application/json" \
  -d '{"message": "Hello", "session_id": "test123"}'

# Test lead qualification  
curl -X POST http://127.0.0.1:8000/api/chat/qualify \
  -H "Content-Type: application/json" \
  -d '{"session_id": "test123"}'
```

### **Browser Testing**
- **Main Site**: http://127.0.0.1:8000
- **Chat Test Page**: http://127.0.0.1:8000/test_rag_chat.html
- **RAG Health**: http://localhost:8002/health

## 📊 **Monitoring**

### **Service Health**
The `status.sh` script provides real-time monitoring:
- Service availability
- Port status
- API response testing
- Document count
- Process IDs

### **Performance Metrics**
- RAG response time: ~2-4 seconds
- Laravel response time: ~100-300ms
- Concurrent chat sessions: Unlimited
- Document retrieval: 3 relevant docs per query

## 🔒 **Security Notes**

- RAG server runs on localhost only (not exposed externally)
- Laravel handles CSRF protection for web routes
- API routes are CSRF-exempt for chat functionality
- Groq API key stored in environment variables
- No sensitive data logged

## 🎨 **Customization**

### **Modify Chat Widget**
Edit: `public/assets/js/rag-chat-widget.js`

### **Update Business Knowledge**
Add documents to: `rag_system/vectorstore/documents/`
Then re-index the vectorstore

### **Adjust AI Responses**
Modify prompts in: `rag_system/working_server.py`

## 📈 **Scaling Considerations**

### **For Production**
1. Use a proper web server (nginx/Apache)
2. Configure environment-specific settings
3. Set up proper logging and monitoring
4. Consider load balancing for high traffic
5. Use a production database (MySQL/PostgreSQL)

### **Performance Tuning**
1. Adjust RAG server timeout settings
2. Optimize vectorstore chunk sizes
3. Implement response caching
4. Use connection pooling

---

## 🆘 **Need Help?**

1. **Check Status**: `./status.sh`
2. **View Logs**: `tail -f logs/*.log`
3. **Restart Services**: `./stop-all-services.sh && ./start-dev.sh`
4. **Test APIs**: Use the curl examples above

**Happy coding! 🧠✨**