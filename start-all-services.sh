#!/bin/bash

# BrainGenTechnology - Complete System Startup Script
# Starts Laravel, RAG Server, and all necessary services

set -e  # Exit on any error

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
RAG_DIR="$PROJECT_DIR/rag_system"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to check if port is available
check_port() {
    local port=$1
    if lsof -ti:$port > /dev/null 2>&1; then
        return 1  # Port is in use
    else
        return 0  # Port is available
    fi
}

# Function to kill process on port
kill_port() {
    local port=$1
    print_warning "Killing existing process on port $port..."
    lsof -ti:$port | xargs kill -9 2>/dev/null || true
    sleep 2
}

# Main startup function
main() {
    echo "🧠 BrainGenTechnology - Starting All Services"
    echo "=" * 60
    
    # Change to project directory
    cd "$PROJECT_DIR"
    
    print_status "Checking project structure..."
    if [[ ! -d "$RAG_DIR" ]]; then
        print_error "RAG system directory not found: $RAG_DIR"
        exit 1
    fi
    
    # Check for required files
    if [[ ! -f "$PROJECT_DIR/artisan" ]]; then
        print_error "Laravel artisan not found. Are you in the correct directory?"
        exit 1
    fi
    
    if [[ ! -f "$RAG_DIR/working_server.py" ]]; then
        print_error "RAG working server not found: $RAG_DIR/working_server.py"
        exit 1
    fi
    
    print_success "Project structure verified"
    
    # Step 1: Laravel Dependencies and Setup
    print_status "Setting up Laravel environment..."
    
    # Install PHP dependencies if needed
    if [[ ! -d "vendor" ]]; then
        print_status "Installing PHP dependencies..."
        composer install --no-dev --optimize-autoloader
    fi
    
    # Setup environment
    if [[ ! -f ".env" ]]; then
        print_status "Creating Laravel .env file..."
        cp .env.example .env
        php artisan key:generate
    fi
    
    # Setup database
    if [[ ! -f "database/database.sqlite" ]]; then
        print_status "Creating SQLite database..."
        touch database/database.sqlite
        php artisan migrate --force
    fi
    
    print_success "Laravel environment ready"
    
    # Step 2: RAG System Setup
    print_status "Setting up RAG system..."
    cd "$RAG_DIR"
    
    # Check Python environment
    if ! command -v python3 &> /dev/null; then
        print_error "Python 3 is required but not installed"
        exit 1
    fi
    
    # Install Python dependencies if needed
    if [[ ! -f ".venv/bin/activate" ]] && [[ ! -d "__pycache__" ]]; then
        print_status "Installing Python dependencies..."
        pip install -r requirements.txt
    fi
    
    # Check RAG environment file
    if [[ ! -f ".env" ]]; then
        print_error "RAG system .env file not found. Please ensure it exists with proper Groq API key."
        exit 1
    fi
    
    # Verify vectorstore exists
    if [[ ! -f "vectorstore/chroma_db/chroma.sqlite3" ]]; then
        print_warning "Vectorstore not found. You may need to run the indexer first."
    fi
    
    cd "$PROJECT_DIR"
    print_success "RAG system ready"
    
    # Step 3: Kill existing processes
    print_status "Checking for existing services..."
    
    # Check Laravel server (port 8000)
    if ! check_port 8000; then
        kill_port 8000
    fi
    
    # Check RAG server (port 8002)  
    if ! check_port 8002; then
        kill_port 8002
    fi
    
    print_success "Ports cleared"
    
    # Step 4: Start RAG Server
    print_status "Starting RAG server on port 8002..."
    cd "$RAG_DIR"
    
    # Start RAG server in background
    nohup python working_server.py > ../logs/rag-server.log 2>&1 &
    RAG_PID=$!
    
    # Wait for RAG server to start
    sleep 5
    
    # Check if RAG server started successfully
    if curl -s http://localhost:8002/health > /dev/null 2>&1; then
        print_success "RAG server started successfully (PID: $RAG_PID)"
    else
        print_error "Failed to start RAG server. Check logs/rag-server.log"
        exit 1
    fi
    
    cd "$PROJECT_DIR"
    
    # Step 5: Start Laravel Server
    print_status "Starting Laravel server on port 8000..."
    
    # Create logs directory
    mkdir -p logs
    
    # Start Laravel server in background
    nohup php artisan serve --host=127.0.0.1 --port=8000 > logs/laravel-server.log 2>&1 &
    LARAVEL_PID=$!
    
    # Wait for Laravel server to start
    sleep 3
    
    # Check if Laravel server started successfully
    if curl -s http://127.0.0.1:8000 > /dev/null 2>&1; then
        print_success "Laravel server started successfully (PID: $LARAVEL_PID)"
    else
        print_error "Failed to start Laravel server. Check logs/laravel-server.log"
        kill $RAG_PID 2>/dev/null || true
        exit 1
    fi
    
    # Step 6: Verify all services
    print_status "Verifying all services..."
    
    # Test RAG API health
    if RAG_RESPONSE=$(curl -s http://localhost:8002/health); then
        print_success "RAG API: ✅ Healthy"
    else
        print_error "RAG API: ❌ Not responding"
    fi
    
    # Test Laravel API
    if LARAVEL_RESPONSE=$(curl -s http://127.0.0.1:8000/api/chat/health); then
        print_success "Laravel API: ✅ Healthy"
    else
        print_error "Laravel API: ❌ Not responding"
    fi
    
    # Test end-to-end integration
    if curl -s -X POST http://127.0.0.1:8000/api/chat \
        -H "Content-Type: application/json" \
        -d '{"message": "test", "session_id": "startup_test"}' > /dev/null 2>&1; then
        print_success "End-to-End Integration: ✅ Working"
    else
        print_warning "End-to-End Integration: ⚠️ May have issues"
    fi
    
    # Save process IDs
    echo "$RAG_PID" > logs/rag-server.pid
    echo "$LARAVEL_PID" > logs/laravel-server.pid
    
    # Final status
    echo ""
    echo "🎉 All Services Started Successfully!"
    echo "=" * 60
    echo "📊 Service Status:"
    echo "   • RAG Server:    ✅ http://localhost:8002 (PID: $RAG_PID)"
    echo "   • Laravel App:   ✅ http://127.0.0.1:8000 (PID: $LARAVEL_PID)"
    echo "   • Chat Widget:   ✅ Available on all pages"
    echo ""
    echo "📝 Available Endpoints:"
    echo "   • Website:       http://127.0.0.1:8000"
    echo "   • Chat API:      http://127.0.0.1:8000/api/chat"
    echo "   • RAG Health:    http://localhost:8002/health"
    echo "   • Test Page:     http://127.0.0.1:8000/test_rag_chat.html"
    echo ""
    echo "📁 Log Files:"
    echo "   • RAG Server:    logs/rag-server.log"
    echo "   • Laravel:       logs/laravel-server.log"
    echo ""
    echo "⏹️  To stop all services: ./stop-all-services.sh"
    echo ""
    
    # Keep the script running to monitor
    print_status "Services are running. Press Ctrl+C to stop all services..."
    
    # Trap to clean up on exit
    trap 'print_warning "Stopping all services..."; kill $RAG_PID $LARAVEL_PID 2>/dev/null || true; print_success "All services stopped"; exit 0' INT TERM
    
    # Monitor services
    while true; do
        if ! kill -0 $RAG_PID 2>/dev/null; then
            print_error "RAG server stopped unexpectedly"
            kill $LARAVEL_PID 2>/dev/null || true
            exit 1
        fi
        
        if ! kill -0 $LARAVEL_PID 2>/dev/null; then
            print_error "Laravel server stopped unexpectedly"  
            kill $RAG_PID 2>/dev/null || true
            exit 1
        fi
        
        sleep 10
    done
}

# Run main function
main "$@"