#!/bin/bash

# 🚀 BrainGenTech - Complete Application Startup Script
# This script starts all services required for the BrainGenTech AI chatbot system

set -e  # Exit on any error

# Color codes for pretty output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Function to print colored output
print_color() {
    printf "${1}${2}${NC}\n"
}

# Function to print section headers
print_section() {
    echo
    print_color $CYAN "════════════════════════════════════════════════════════════════"
    print_color $CYAN "  $1"
    print_color $CYAN "════════════════════════════════════════════════════════════════"
}

# Function to check if a command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Function to check if a port is in use
port_in_use() {
    lsof -i:$1 >/dev/null 2>&1
}

# Function to wait for service to be ready
wait_for_service() {
    local url=$1
    local service_name=$2
    local max_attempts=30
    local attempt=1
    
    print_color $YELLOW "⏳ Waiting for $service_name to be ready..."
    
    while [ $attempt -le $max_attempts ]; do
        if curl -s -f "$url" > /dev/null 2>&1; then
            print_color $GREEN "✅ $service_name is ready!"
            return 0
        fi
        
        printf "."
        sleep 2
        attempt=$((attempt + 1))
    done
    
    print_color $RED "❌ $service_name failed to start within expected time"
    return 1
}

# Function to stop services gracefully
cleanup() {
    print_section "🛑 STOPPING SERVICES"
    
    # Kill background processes
    if [ ! -z "$PYTHON_PID" ]; then
        print_color $YELLOW "Stopping Python service (PID: $PYTHON_PID)..."
        kill $PYTHON_PID 2>/dev/null || true
    fi
    
    if [ ! -z "$LARAVEL_PID" ]; then
        print_color $YELLOW "Stopping Laravel service (PID: $LARAVEL_PID)..."
        kill $LARAVEL_PID 2>/dev/null || true
    fi
    
    if [ ! -z "$QDRANT_PID" ]; then
        print_color $YELLOW "Stopping Qdrant service (PID: $QDRANT_PID)..."
        kill $QDRANT_PID 2>/dev/null || true
    fi
    
    print_color $GREEN "🔄 All services stopped gracefully"
    exit 0
}

# Trap Ctrl+C to cleanup
trap cleanup INT TERM

print_section "🤖 BRAINGENTECH AI CHATBOT SYSTEM STARTUP"
print_color $PURPLE "Starting all services for the BrainGenTech AI chatbot system..."
print_color $PURPLE "Press Ctrl+C to stop all services"

# Check system requirements
print_section "🔍 CHECKING SYSTEM REQUIREMENTS"

# Check if we're in the right directory
if [ ! -f "composer.json" ] || [ ! -d "python-service" ]; then
    print_color $RED "❌ Error: Please run this script from the project root directory"
    print_color $YELLOW "Expected files: composer.json, python-service/"
    exit 1
fi

print_color $GREEN "✅ Project directory structure verified"

# Check required commands
REQUIRED_COMMANDS=("php" "composer" "npm" "python3" "curl")
for cmd in "${REQUIRED_COMMANDS[@]}"; do
    if command_exists $cmd; then
        print_color $GREEN "✅ $cmd is available"
    else
        print_color $RED "❌ $cmd is required but not installed"
        exit 1
    fi
done

# Check for Docker (optional)
if command_exists docker && command_exists docker-compose; then
    print_color $GREEN "✅ Docker is available (optional)"
    DOCKER_AVAILABLE=true
else
    print_color $YELLOW "⚠️  Docker not available (optional for development)"
    DOCKER_AVAILABLE=false
fi

# Check port availability
print_section "🔌 CHECKING PORT AVAILABILITY"

PORTS=(8000 8001 6333)
PORT_NAMES=("Laravel" "Python FastAPI" "Qdrant")

for i in "${!PORTS[@]}"; do
    port=${PORTS[$i]}
    name=${PORT_NAMES[$i]}
    
    if port_in_use $port; then
        print_color $YELLOW "⚠️  Port $port ($name) is already in use"
        print_color $YELLOW "    You may need to stop existing services or change ports"
    else
        print_color $GREEN "✅ Port $port ($name) is available"
    fi
done

# Install and setup Laravel
print_section "⚙️ SETTING UP LARAVEL APPLICATION"

print_color $BLUE "📦 Installing PHP dependencies..."
if ! composer install --no-interaction --prefer-dist --optimize-autoloader; then
    print_color $RED "❌ Failed to install PHP dependencies"
    exit 1
fi
print_color $GREEN "✅ PHP dependencies installed"

print_color $BLUE "📦 Installing Node.js dependencies..."
if ! npm install; then
    print_color $RED "❌ Failed to install Node.js dependencies"
    exit 1
fi
print_color $GREEN "✅ Node.js dependencies installed"

# Setup environment file
if [ ! -f ".env" ]; then
    print_color $BLUE "📝 Creating environment file..."
    cp .env.example .env
    php artisan key:generate --no-interaction
    print_color $GREEN "✅ Environment file created"
else
    print_color $GREEN "✅ Environment file exists"
fi

# Setup database
print_color $BLUE "🗄️  Setting up database..."
if ! php artisan migrate --no-interaction; then
    print_color $RED "❌ Database migration failed"
    exit 1
fi
print_color $GREEN "✅ Database migrated"

# Seed knowledge base
print_color $BLUE "🌱 Seeding knowledge base..."
if ! php artisan db:seed --class=KnowledgeBaseSeeder --no-interaction; then
    print_color $YELLOW "⚠️  Knowledge base seeding failed (may already exist)"
else
    print_color $GREEN "✅ Knowledge base seeded"
fi

# Build frontend assets
print_color $BLUE "🎨 Building frontend assets..."
if ! npm run build; then
    print_color $RED "❌ Failed to build frontend assets"
    exit 1
fi
print_color $GREEN "✅ Frontend assets built"

# Setup Python service
print_section "🐍 SETTING UP PYTHON AI SERVICE"

cd python-service

# Check for virtual environment
if [ ! -d "venv" ]; then
    print_color $BLUE "🔧 Creating Python virtual environment..."
    python3 -m venv venv
    print_color $GREEN "✅ Virtual environment created"
fi

# Activate virtual environment
print_color $BLUE "🔧 Activating virtual environment..."
source venv/bin/activate
print_color $GREEN "✅ Virtual environment activated"

# Install Python dependencies
print_color $BLUE "📦 Installing Python dependencies..."
if ! pip install -r requirements.txt; then
    print_color $RED "❌ Failed to install Python dependencies"
    exit 1
fi
print_color $GREEN "✅ Python dependencies installed"

# Setup environment file for Python service
if [ ! -f ".env" ]; then
    print_color $BLUE "📝 Creating Python service environment..."
    cat > .env << EOF
# Cohere API Configuration
COHERE_API_KEY=your_cohere_api_key_here

# Qdrant Configuration
QDRANT_URL=http://localhost:6333
QDRANT_COLLECTION=braingen_tech

# Logging Configuration
LOG_LEVEL=INFO

# Conversation Management
MAX_ACTIVE_CONVERSATIONS=1000
MAX_MEMORY_HOURS=24

# Web Search APIs (Optional)
SERPAPI_KEY=your_serpapi_key_here
BING_SEARCH_KEY=your_bing_search_key_here
EOF
    print_color $GREEN "✅ Python environment file created"
    print_color $YELLOW "🔑 Please update .env with your API keys for full functionality"
else
    print_color $GREEN "✅ Python environment file exists"
fi

cd ..

# Start services
print_section "🚀 STARTING ALL SERVICES"

# Start Qdrant (Vector Database)
print_color $BLUE "🗄️  Starting Qdrant vector database..."
if command_exists docker; then
    # Use Docker if available
    if ! docker run -d --name qdrant-braingen -p 6333:6333 -v $(pwd)/qdrant_storage:/qdrant/storage qdrant/qdrant:latest >/dev/null 2>&1; then
        print_color $YELLOW "⚠️  Docker Qdrant failed, you may need to install Qdrant manually"
        print_color $YELLOW "    Visit: https://qdrant.tech/documentation/install/"
    else
        print_color $GREEN "✅ Qdrant started with Docker"
        QDRANT_DOCKER=true
    fi
else
    print_color $YELLOW "⚠️  Please ensure Qdrant is running on port 6333"
    print_color $YELLOW "    Visit: https://qdrant.tech/documentation/install/"
fi

# Wait for Qdrant to be ready
sleep 5

# Initialize vector store
print_color $BLUE "🔧 Initializing vector store..."
cd python-service
source venv/bin/activate
if python init_vectorstore.py; then
    print_color $GREEN "✅ Vector store initialized"
else
    print_color $YELLOW "⚠️  Vector store initialization may have failed"
fi

# Add knowledge to vector store
print_color $BLUE "🧠 Adding knowledge to vector store..."
if python add_knowledge.py; then
    print_color $GREEN "✅ Knowledge added to vector store"
else
    print_color $YELLOW "⚠️  Knowledge addition may have failed"
fi

# Start Python FastAPI service
print_color $BLUE "🐍 Starting Python FastAPI service..."
python main.py &
PYTHON_PID=$!
print_color $GREEN "✅ Python service started (PID: $PYTHON_PID)"

cd ..

# Start Laravel development server
print_color $BLUE "🌐 Starting Laravel development server..."
php artisan serve --host=0.0.0.0 --port=8000 &
LARAVEL_PID=$!
print_color $GREEN "✅ Laravel server started (PID: $LARAVEL_PID)"

# Wait for services to be ready
print_section "⏳ WAITING FOR SERVICES TO BE READY"

wait_for_service "http://localhost:8001/health" "Python FastAPI service"
wait_for_service "http://localhost:8000" "Laravel application"

if command_exists curl; then
    wait_for_service "http://localhost:6333" "Qdrant vector database"
fi

# Display service status
print_section "✅ ALL SERVICES RUNNING"

print_color $GREEN "🎉 BrainGenTech AI Chatbot System is now running!"
echo
print_color $CYAN "📋 Service Information:"
print_color $WHITE "  🌐 Laravel Frontend:     http://localhost:8000"
print_color $WHITE "  🤖 Python AI API:        http://localhost:8001"
print_color $WHITE "  📊 API Documentation:    http://localhost:8001/docs"
print_color $WHITE "  🔍 Health Check:         http://localhost:8001/health"
print_color $WHITE "  📈 Metrics:              http://localhost:8001/metrics"
print_color $WHITE "  🗄️  Vector Database:      http://localhost:6333"
echo
print_color $CYAN "🧪 Test Pages:"
print_color $WHITE "  🏠 Main Website:          http://localhost:8000"
print_color $WHITE "  💬 Chatbot Test:          http://localhost:8000/test-chatbot"
echo
print_color $CYAN "📁 Important Directories:"
print_color $WHITE "  📝 Laravel Logs:          storage/logs/laravel.log"
print_color $WHITE "  🐍 Python Service:        python-service/"
print_color $WHITE "  🗄️  Database:              database/database.sqlite"
echo
print_color $PURPLE "💡 Tips:"
print_color $WHITE "  • Add your Cohere API key to python-service/.env for full AI functionality"
print_color $WHITE "  • Add SerpAPI/Bing keys for real-time web search capabilities"
print_color $WHITE "  • Check logs if you encounter any issues"
print_color $WHITE "  • Press Ctrl+C to stop all services"
echo

# Keep script running
print_color $YELLOW "⏳ Services are running... Press Ctrl+C to stop all services"

# Monitor services
while true; do
    sleep 5
    
    # Check if services are still running
    if ! kill -0 $PYTHON_PID 2>/dev/null; then
        print_color $RED "❌ Python service stopped unexpectedly"
        break
    fi
    
    if ! kill -0 $LARAVEL_PID 2>/dev/null; then
        print_color $RED "❌ Laravel service stopped unexpectedly"
        break
    fi
done

# Cleanup on exit
cleanup