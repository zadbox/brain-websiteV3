#!/bin/bash

# BrainGenTechnology - Quick Development Start
# Simplified startup script for development

set -e

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m'

print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[DEV]${NC} $1"
}

main() {
    echo "🚀 BrainGenTechnology - Quick Development Start"
    echo "=" * 50
    
    cd "$PROJECT_DIR"
    
    # Create logs directory
    mkdir -p logs
    
    print_warning "This is a development startup script"
    print_warning "For production, use: ./start-all-services.sh"
    echo ""
    
    # Kill existing processes
    print_status "Cleaning existing processes..."
    lsof -ti:8000 | xargs kill -9 2>/dev/null || true
    lsof -ti:8002 | xargs kill -9 2>/dev/null || true
    sleep 2
    
    # Start RAG server
    print_status "Starting RAG server..."
    cd rag_system
    python working_server.py > ../logs/rag-dev.log 2>&1 &
    RAG_PID=$!
    cd ..
    
    sleep 3
    
    # Start Laravel
    print_status "Starting Laravel server..."
    php artisan serve --host=127.0.0.1 --port=8000 > logs/laravel-dev.log 2>&1 &
    LARAVEL_PID=$!
    
    sleep 2
    
    # Quick health check
    if curl -s http://localhost:8002/health > /dev/null; then
        print_success "RAG Server: ✅ http://localhost:8002"
    else
        echo "RAG Server: ❌ Check logs/rag-dev.log"
    fi
    
    if curl -s http://127.0.0.1:8000 > /dev/null; then
        print_success "Laravel App: ✅ http://127.0.0.1:8000"
    else
        echo "Laravel App: ❌ Check logs/laravel-dev.log"
    fi
    
    echo ""
    echo "📝 Quick Links:"
    echo "   • Website:      http://127.0.0.1:8000"
    echo "   • Test Chat:    http://127.0.0.1:8000/test_rag_chat.html"
    echo "   • RAG Health:   http://localhost:8002/health"
    echo ""
    echo "📁 Development Logs:"
    echo "   • tail -f logs/rag-dev.log"
    echo "   • tail -f logs/laravel-dev.log"
    echo ""
    echo "⏹️  To stop: ./stop-all-services.sh"
    
    # Save PIDs for cleanup
    echo "$RAG_PID" > logs/rag-server.pid
    echo "$LARAVEL_PID" > logs/laravel-server.pid
}

main "$@"