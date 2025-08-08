#!/bin/bash

echo "🔍 Diagnostic du système RAG Docker"
echo "=================================="

# Vérifier les conteneurs
echo "📦 Status des conteneurs:"
docker ps -a --filter "name=braintech-rag" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"

echo ""
echo "🏥 Healthcheck status:"
docker inspect braintech-rag --format='{{json .State.Health}}' | jq '.' 2>/dev/null || echo "Container not running"

echo ""
echo "📋 Derniers logs (20 lignes):"
docker logs braintech-rag --tail=20 2>&1 || echo "No logs available"

echo ""
echo "🌐 Test de connectivité réseau:"
docker exec braintech-rag curl -f http://localhost:8002/health 2>/dev/null && echo "✅ Health endpoint accessible" || echo "❌ Health endpoint inaccessible"

echo ""
echo "🔧 Variables d'environnement RAG:"
docker exec braintech-rag env | grep -E "(GROQ|PYTHONPATH|PORT)" 2>/dev/null || echo "Cannot access container environment"

echo ""
echo "📁 Structure des fichiers dans le conteneur:"
docker exec braintech-rag ls -la /app/ 2>/dev/null | head -10 || echo "Cannot access container files"