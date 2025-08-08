#!/bin/bash

# BrainGenTechnology - Stop All Services Script

set -e

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

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

# Function to kill process on port
kill_port() {
    local port=$1
    local service_name=$2
    
    if lsof -ti:$port > /dev/null 2>&1; then
        print_status "Stopping $service_name (port $port)..."
        lsof -ti:$port | xargs kill -9 2>/dev/null || true
        sleep 1
        
        if lsof -ti:$port > /dev/null 2>&1; then
            print_error "Failed to stop $service_name"
        else
            print_success "$service_name stopped"
        fi
    else
        print_warning "$service_name not running (port $port)"
    fi
}

main() {
    echo "🛑 BrainGenTechnology - Stopping All Services"
    echo "=" * 50
    
    cd "$PROJECT_DIR"
    
    # Stop by PID files if they exist
    if [[ -f "logs/rag-server.pid" ]]; then
        RAG_PID=$(cat logs/rag-server.pid)
        if kill -0 $RAG_PID 2>/dev/null; then
            print_status "Stopping RAG server (PID: $RAG_PID)..."
            kill $RAG_PID
            print_success "RAG server stopped"
        fi
        rm logs/rag-server.pid
    fi
    
    if [[ -f "logs/laravel-server.pid" ]]; then
        LARAVEL_PID=$(cat logs/laravel-server.pid)
        if kill -0 $LARAVEL_PID 2>/dev/null; then
            print_status "Stopping Laravel server (PID: $LARAVEL_PID)..."
            kill $LARAVEL_PID
            print_success "Laravel server stopped"
        fi
        rm logs/laravel-server.pid
    fi
    
    # Stop by ports as backup
    kill_port 8000 "Laravel Server"
    kill_port 8002 "RAG Server"
    
    # Kill any Python processes that might be our RAG server
    print_status "Cleaning up any remaining RAG processes..."
    pkill -f "working_server.py" 2>/dev/null || true
    pkill -f "simple_server.py" 2>/dev/null || true
    
    # Kill any PHP artisan serve processes
    print_status "Cleaning up any remaining Laravel processes..."
    pkill -f "artisan serve" 2>/dev/null || true
    
    print_success "All services stopped successfully"
    
    echo ""
    echo "✅ Cleanup Complete"
    echo "🚀 To restart all services: ./start-all-services.sh"
}

main "$@"