#!/bin/bash

# =============================================================================
# BrainGenTechnology - Script de lancement du serveur de développement
# =============================================================================

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}==============================================================================${NC}"
echo -e "${BLUE}               BrainGenTechnology - Serveur de développement${NC}"
echo -e "${BLUE}==============================================================================${NC}"

# Vérifier PHP
if ! command -v php &> /dev/null; then
    echo -e "${RED}❌ PHP n'est pas installé. Veuillez installer PHP d'abord.${NC}"
    exit 1
fi

# Vérifier Composer
if ! command -v composer &> /dev/null; then
    echo -e "${RED}❌ Composer n'est pas installé. Veuillez installer Composer d'abord.${NC}"
    exit 1
fi

# Vérifier si le fichier .env existe
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}⚠️  Fichier .env manquant. Copie de .env.example...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✅ Fichier .env créé${NC}"
fi

# Vérifier si la clé d'application est définie
if ! grep -q "APP_KEY=base64:" .env; then
    echo -e "${YELLOW}⚠️  Génération de la clé d'application...${NC}"
    php artisan key:generate --quiet
    echo -e "${GREEN}✅ Clé d'application générée${NC}"
fi

# Vérifier si les dépendances sont installées
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW}⚠️  Installation des dépendances...${NC}"
    composer install --no-dev --quiet
    echo -e "${GREEN}✅ Dépendances installées${NC}"
fi

# Vérifier si la base de données existe
if [ ! -f "database/database.sqlite" ]; then
    echo -e "${YELLOW}⚠️  Création de la base de données...${NC}"
    touch database/database.sqlite
    echo -e "${GREEN}✅ Base de données créée${NC}"
fi

# Exécuter les migrations
echo -e "${YELLOW}⚠️  Exécution des migrations...${NC}"
php artisan migrate --force --quiet
echo -e "${GREEN}✅ Migrations exécutées${NC}"

# Définir le port
PORT=${1:-8080}

# Vérifier si le port est libre
if lsof -Pi :$PORT -sTCP:LISTEN -t >/dev/null ; then
    echo -e "${RED}❌ Le port $PORT est déjà utilisé. Essayez avec un autre port.${NC}"
    echo -e "${YELLOW}Usage: ./start-server.sh [port]${NC}"
    echo -e "${YELLOW}Exemple: ./start-server.sh 8081${NC}"
    exit 1
fi

# Lancer le serveur
echo -e "${BLUE}==============================================================================${NC}"
echo -e "${GREEN}🚀 Démarrage du serveur Laravel...${NC}"
echo -e "${GREEN}📱 URL: http://127.0.0.1:$PORT${NC}"
echo -e "${GREEN}📱 URL locale: http://localhost:$PORT${NC}"
echo -e "${BLUE}==============================================================================${NC}"
echo -e "${YELLOW}💡 Appuyez sur Ctrl+C pour arrêter le serveur${NC}"
echo -e "${BLUE}==============================================================================${NC}"

# Ouvrir le navigateur automatiquement (optionnel)
if command -v open &> /dev/null; then
    echo -e "${GREEN}🌐 Ouverture du navigateur...${NC}"
    sleep 2 && open "http://127.0.0.1:$PORT" &
fi

# Démarrer le serveur
php artisan serve --port=$PORT