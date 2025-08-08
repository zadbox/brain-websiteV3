#!/bin/bash

# BrainGenTechnology - Service Status Check

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

check_service() {
    local service_name=$1
    local url=$2
    local port=$3
    
    # Check if port is in use
    if lsof -ti:$port > /dev/null 2>&1; then
        # Check if service responds
        if curl -s "$url" > /dev/null 2>&1; then
            echo -e "   $service_name: ${GREEN}✅ Running${NC} (port $port)"
            return 0
        else
            echo -e "   $service_name: ${YELLOW}⚠️  Port active but not responding${NC} (port $port)"
            return 1
        fi
    else
        echo -e "   $service_name: ${RED}❌ Not running${NC} (port $port)"
        return 1
    fi
}

check_api_integration() {
    echo ""
    echo "🔗 API Integration Test:"
    
    # Test Laravel API
    if curl -s http://127.0.0.1:8000/api/chat/health > /dev/null 2>&1; then
        echo -e "   Laravel API: ${GREEN}✅ Responding${NC}"
        
        # Test end-to-end chat
        if curl -s -X POST http://127.0.0.1:8000/api/chat \
            -H "Content-Type: application/json" \
            -d '{"message": "test", "session_id": "status_test"}' > /dev/null 2>&1; then
            echo -e "   E2E Chat:    ${GREEN}✅ Working${NC}"
        else
            echo -e "   E2E Chat:    ${RED}❌ Failed${NC}"
        fi
    else
        echo -e "   Laravel API: ${RED}❌ Not responding${NC}"
        echo -e "   E2E Chat:    ${RED}❌ Cannot test${NC}"
    fi
}

get_system_info() {
    echo ""
    echo "📊 System Information:"
    
    # RAG System Info
    if RAG_HEALTH=$(curl -s http://localhost:8002/health 2>/dev/null); then
        DOC_COUNT=$(echo $RAG_HEALTH | python3 -c "import sys, json; data=json.load(sys.stdin); print(data['system_info']['document_count'])" 2>/dev/null || echo "unknown")
        LLM_MODEL=$(echo $RAG_HEALTH | python3 -c "import sys, json; data=json.load(sys.stdin); print(data['system_info']['llm_model'])" 2>/dev/null || echo "unknown")
        echo "   • Documents Loaded: $DOC_COUNT"
        echo "   • LLM Model: $LLM_MODEL"
    fi
    
    # Process Info
    if [[ -f "logs/rag-server.pid" ]]; then
        RAG_PID=$(cat logs/rag-server.pid)
        if kill -0 $RAG_PID 2>/dev/null; then
            echo "   • RAG Server PID: $RAG_PID"
        fi
    fi
    
    if [[ -f "logs/laravel-server.pid" ]]; then
        LARAVEL_PID=$(cat logs/laravel-server.pid)
        if kill -0 $LARAVEL_PID 2>/dev/null; then
            echo "   • Laravel Server PID: $LARAVEL_PID"
        fi
    fi
}

main() {
    cd "$PROJECT_DIR"
    
    echo "🔍 BrainGenTechnology - Service Status"
    echo "=" * 50
    
    echo "🖥️  Core Services:"
    
    # Check services
    rag_status=0
    laravel_status=0
    
    check_service "RAG Server   " "http://localhost:8002/health" "8002"
    rag_status=$?
    
    check_service "Laravel App  " "http://127.0.0.1:8000" "8000"
    laravel_status=$?
    
    # API Integration test
    if [[ $rag_status -eq 0 ]] && [[ $laravel_status -eq 0 ]]; then
        check_api_integration
    fi
    
    # System information
    get_system_info
    
    echo ""
    echo "📁 Log Files:"
    if [[ -f "logs/rag-server.log" ]]; then
        echo "   • RAG Server: logs/rag-server.log"
    fi
    if [[ -f "logs/laravel-server.log" ]]; then
        echo "   • Laravel: logs/laravel-server.log"  
    fi
    if [[ -f "logs/rag-dev.log" ]]; then
        echo "   • RAG Dev: logs/rag-dev.log"
    fi
    if [[ -f "logs/laravel-dev.log" ]]; then
        echo "   • Laravel Dev: logs/laravel-dev.log"
    fi
    
    echo ""
    echo "🔧 Management Commands:"
    echo "   • Start All:  ./start-all-services.sh"
    echo "   • Quick Dev:  ./start-dev.sh"
    echo "   • Stop All:   ./stop-all-services.sh"
    echo "   • Status:     ./status.sh"
    
    # Overall status
    if [[ $rag_status -eq 0 ]] && [[ $laravel_status -eq 0 ]]; then
        echo ""
        echo -e "${GREEN}🎉 All systems operational!${NC}"
        exit 0
    else
        echo ""
        echo -e "${RED}⚠️  Some services need attention${NC}"
        exit 1
    fi
}

main "$@"