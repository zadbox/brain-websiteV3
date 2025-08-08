#!/bin/bash

# BrainGenTechnology - Command Aliases
# Source this file to add convenient aliases for managing the system
# Usage: source brain-commands.sh

BRAIN_PROJECT_DIR="/Users/abderrahim_boussyf/brain-website___V3"

# Check if we're in the right directory
if [[ ! -d "$BRAIN_PROJECT_DIR" ]]; then
    echo "❌ BrainGenTechnology project directory not found at: $BRAIN_PROJECT_DIR"
    return 1 2>/dev/null || exit 1
fi

# Define convenient aliases
alias brain-start="cd '$BRAIN_PROJECT_DIR' && ./start-dev.sh"
alias brain-start-all="cd '$BRAIN_PROJECT_DIR' && ./start-all-services.sh"
alias brain-stop="cd '$BRAIN_PROJECT_DIR' && ./stop-all-services.sh"
alias brain-status="cd '$BRAIN_PROJECT_DIR' && ./status.sh"
alias brain-logs-rag="cd '$BRAIN_PROJECT_DIR' && tail -f logs/rag-*.log"
alias brain-logs-laravel="cd '$BRAIN_PROJECT_DIR' && tail -f logs/laravel-*.log"
alias brain-logs-all="cd '$BRAIN_PROJECT_DIR' && tail -f logs/*.log"
alias brain-test-chat="cd '$BRAIN_PROJECT_DIR' && curl -X POST http://127.0.0.1:8000/api/chat -H 'Content-Type: application/json' -d '{\"message\": \"What AI services do you offer?\", \"session_id\": \"test\"}'"
alias brain-health="cd '$BRAIN_PROJECT_DIR' && curl -s http://localhost:8002/health | jq"
alias brain-cd="cd '$BRAIN_PROJECT_DIR'"

# Print available commands
echo "🧠 BrainGenTechnology Command Aliases Loaded!"
echo ""
echo "Available Commands:"
echo "  brain-start          - Quick development start"
echo "  brain-start-all      - Full production start"
echo "  brain-stop           - Stop all services"
echo "  brain-status         - Check service status"
echo "  brain-logs-rag       - Watch RAG server logs"
echo "  brain-logs-laravel   - Watch Laravel logs"
echo "  brain-logs-all       - Watch all logs"
echo "  brain-test-chat      - Test chat API"
echo "  brain-health         - Check RAG server health"
echo "  brain-cd             - Navigate to project directory"
echo ""
echo "Quick Start: brain-start"
echo "Check Status: brain-status"