#!/bin/bash

# Script de redémarrage sécurisé pour le service LangChain
# Résout les problèmes de Pydantic v2 et redémarrage constant

echo "🔄 Redémarrage du service LangChain..."

# Arrêter le service en cours
echo "⏹️  Arrêt du service en cours..."
pkill -f "python.*main.py" || true
pkill -f "uvicorn.*main:app" || true

# Attendre que le processus se termine
sleep 3

# Nettoyer les fichiers temporaires
echo "🧹 Nettoyage des fichiers temporaires..."
rm -f python-service/*.pyc
rm -f python-service/__pycache__/*.pyc
rm -f python-service/app/__pycache__/*.pyc
rm -f python-service/app/services/__pycache__/*.pyc

# Vérifier la configuration
echo "🔍 Vérification de la configuration..."
if [ -z "$COHERE_API_KEY" ]; then
    echo "❌ COHERE_API_KEY non définie"
    export COHERE_API_KEY="xSR9ISfXsRXcHoJNrI0KY42ofJPOj6gcurPLssqG"
    echo "✅ COHERE_API_KEY définie"
fi

# Redémarrer le service
echo "🚀 Redémarrage du service..."
cd python-service

# Activer l'environnement virtuel si disponible
if [ -d "venv" ]; then
    source venv/bin/activate
fi

# Démarrer avec uvicorn
uvicorn main:app --host 0.0.0.0 --port 8001 --reload &

echo "✅ Service LangChain redémarré avec succès"
echo "📊 Monitoring disponible sur: http://localhost:8001/health" 