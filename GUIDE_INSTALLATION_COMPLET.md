# 🚀 Guide d'Installation Complet - BrainGenTechnology

## 📋 Table des Matières

1. [Prérequis Système](#prérequis-système)
2. [Installation des Outils Requis](#installation-des-outils-requis)
3. [Obtention des Clés API](#obtention-des-clés-api)
4. [Installation du Projet](#installation-du-projet)
5. [Configuration Environnement](#configuration-environnement)
6. [Démarrage et Test](#démarrage-et-test)
7. [Vérification Installation](#vérification-installation)
8. [Résolution des Problèmes](#résolution-des-problèmes)
9. [Prochaines Étapes](#prochaines-étapes)

---

## 🖥️ Prérequis Système

### Configuration Minimale

| Composant | Minimum | Recommandé |
|-----------|---------|------------|
| **CPU** | 2 cores | 4 cores |
| **RAM** | 4GB | 8GB |
| **Stockage** | 10GB | 20GB |
| **OS** | Ubuntu 18.04+ / macOS 10.15+ / Windows 10+ | Ubuntu 20.04+ / macOS 12+ |

### Ports Requis

Les ports suivants doivent être libres :
- **8000/8080** : Laravel application
- **8002** : RAG System (FastAPI)
- **6379** : Redis
- **3000** : Grafana (optionnel)
- **9090** : Prometheus (optionnel)

---

## 🛠️ Installation des Outils Requis

### 1. PHP 8.2+ et Composer

#### Ubuntu/Debian
```bash
# Installer PHP 8.2 et extensions
sudo apt update
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install -y php8.2 php8.2-cli php8.2-common php8.2-curl \
    php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip php8.2-sqlite3 \
    php8.2-pdo php8.2-pgsql unzip curl

# Installer Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

#### macOS (avec Homebrew)
```bash
# Installer Homebrew si pas déjà fait
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Installer PHP 8.2
brew install php@8.2
brew link --force php@8.2

# Installer Composer
brew install composer
```

#### Windows
1. Télécharger PHP 8.2 depuis [php.net](https://windows.php.net/download)
2. Télécharger Composer depuis [getcomposer.org](https://getcomposer.org/download/)
3. Ajouter PHP au PATH système

### 2. Python 3.11+ et pip

#### Ubuntu/Debian
```bash
sudo apt install -y python3.11 python3.11-venv python3.11-dev python-is-python3 pip
```

#### macOS
```bash
brew install python@3.11
python3.11 -m ensurepip --upgrade
```

#### Windows
1. Télécharger Python 3.11 depuis [python.org](https://www.python.org/downloads/)
2. Cocher "Add Python to PATH" pendant l'installation

### 3. Node.js 18+ et npm

#### Ubuntu/Debian
```bash
# Via NodeSource
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

#### macOS
```bash
brew install node@18
brew link --force node@18
```

#### Windows
Télécharger depuis [nodejs.org](https://nodejs.org/)

### 4. Git

#### Ubuntu/Debian
```bash
sudo apt install -y git
```

#### macOS
```bash
brew install git
```

#### Windows
Télécharger depuis [git-scm.com](https://git-scm.com/download/win)

### 5. Redis (optionnel pour développement local)

#### Ubuntu/Debian
```bash
sudo apt install -y redis-server
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

#### macOS
```bash
brew install redis
brew services start redis
```

#### Windows
Télécharger depuis [releases GitHub](https://github.com/microsoftarchive/redis/releases)

### 6. Docker et Docker Compose (optionnel mais recommandé)

#### Ubuntu/Debian
```bash
# Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo usermod -aG docker $USER

# Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/download/v2.21.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Redémarrer session pour appliquer les groupes
newgrp docker
```

#### macOS
```bash
# Installer Docker Desktop depuis docker.com
# Ou via Homebrew
brew install --cask docker
```

---

## 🔑 Obtention des Clés API

### 1. Clé API Groq (OBLIGATOIRE)

1. Aller sur [console.groq.com](https://console.groq.com/)
2. Créer un compte ou se connecter
3. Aller dans "API Keys"
4. Cliquer "Create API Key"
5. Nommer la clé (ex: "BrainTech-Dev")
6. Copier la clé (format: `gsk_...`)

**⚠️ Important** : La clé ne sera visible qu'une fois, sauvegardez-la !

### 2. Clé API HuggingFace (OPTIONNELLE)

1. Aller sur [huggingface.co](https://huggingface.co/)
2. Créer un compte ou se connecter
3. Aller dans Settings > Access Tokens
4. Cliquer "New token"
5. Type: "Read"
6. Copier la clé (format: `hf_...`)

---

## 📦 Installation du Projet

### 1. Cloner le Repository

```bash
# Choisir un dossier pour le projet
cd ~/Documents  # ou le dossier de votre choix

# Cloner le projet
git clone https://github.com/your-username/brain-website-v3.git
cd brain-website-v3

# Vérifier la structure
ls -la
```

Vous devriez voir :
```
app/
rag_system/
public/
database/
docker-compose.yml
composer.json
package.json
README.md
```

### 2. Installation des Dépendances PHP (Laravel)

```bash
# Installer les dépendances Composer
composer install

# Si erreurs de permissions sur Windows
composer install --ignore-platform-reqs
```

### 3. Installation des Dépendances Frontend

```bash
# Installer les dépendances npm
npm install

# En cas d'erreurs, forcer la résolution
npm install --force
```

### 4. Installation des Dépendances Python (RAG System)

```bash
# Aller dans le dossier RAG
cd rag_system

# Créer environnement virtuel isolé
python -m venv rag_env

# Activer l'environnement (Linux/Mac)
source rag_env/bin/activate

# Activer l'environnement (Windows)
# rag_env\Scripts\activate

# Mettre à jour pip
pip install --upgrade pip

# Installer les dépendances
pip install -r requirements.txt

# Retourner à la racine
cd ..
```

**Note** : Si vous avez des erreurs `pydantic._internal`, c'est normal - l'environnement virtuel isole les conflits.

---

## ⚙️ Configuration Environnement

### 1. Configuration Laravel

```bash
# Copier le fichier d'exemple
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 2. Éditer le Fichier .env

Ouvrir `.env` avec votre éditeur préféré et configurer :

```bash
# Configuration de base
APP_NAME=BrainGenTechnology
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de données (SQLite par défaut)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# RAG System
RAG_API_URL=http://localhost:8002

# OBLIGATOIRE: Remplacer par votre clé Groq
GROQ_API_KEY=gsk_YOUR_GROQ_API_KEY_HERE

# OPTIONNEL: Clé HuggingFace
HF_API_KEY=hf_YOUR_HUGGINGFACE_KEY_HERE

# Redis (local)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail (optionnel en développement)
MAIL_MAILER=log
MAIL_HOST=localhost
MAIL_FROM_ADDRESS=contact@braingentech.com
```

### 3. Préparer la Base de Données

```bash
# Créer le fichier de base de données SQLite
touch database/database.sqlite

# Exécuter les migrations
php artisan migrate

# Optionnel: Ajouter des données de test
php artisan db:seed --class=AnalyticsDataSeeder
```

### 4. Configuration RAG System

Créer `rag_system/.env` :

```bash
# Créer le fichier de configuration RAG
cat > rag_system/.env << EOF
GROQ_API_KEY=gsk_YOUR_GROQ_API_KEY_HERE
HF_API_KEY=hf_YOUR_HUGGINGFACE_KEY_HERE
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=
REDIS_PORT=6379
CHROMA_PERSIST_DIR=./vectorstore/chroma_db
EOF
```

**⚠️ Remplacer `gsk_YOUR_GROQ_API_KEY_HERE` par votre vraie clé !**

---

## 🚀 Démarrage et Test

### Option 1: Démarrage Automatique (Recommandé)

Si le script existe et est exécutable :

```bash
# Rendre le script exécutable
chmod +x start-all-services.sh

# Démarrer tous les services
./start-all-services.sh
```

### Option 2: Démarrage Manuel

Ouvrir **4 terminaux** et exécuter dans chacun :

#### Terminal 1: Laravel
```bash
php artisan serve --port=8000
```

#### Terminal 2: RAG System
```bash
cd rag_system

# Activer l'environnement virtuel
source rag_env/bin/activate  # Linux/Mac
# ou rag_env\Scripts\activate  # Windows

# Démarrer le serveur RAG
python working_server.py
```

#### Terminal 3: Redis (si pas installé globalement)
```bash
redis-server
```

#### Terminal 4: Frontend Dev Server
```bash
npm run dev
```

### Option 3: Avec Docker

```bash
# Construire et démarrer tous les conteneurs
docker-compose up -d --build

# Vérifier le statut
docker-compose ps

# Voir les logs
docker-compose logs -f
```

---

## ✅ Vérification Installation

### 1. Tester les Services

Ouvrir votre navigateur et vérifier :

#### Sites Web
- **Application principale** : http://localhost:8000
- **Dashboard Analytics** : http://localhost:8000/analytics/dashboard

#### APIs
- **RAG Health Check** : http://localhost:8002/health
- **RAG Test** : http://localhost:8002 (devrait afficher du JSON)

### 2. Test du Chat RAG

1. Aller sur http://localhost:8000
2. Chercher le widget de chat (généralement en bas à droite)
3. Envoyer un message : "Bonjour, quels sont vos services ?"
4. Vous devriez recevoir une réponse en < 2 secondes

### 3. Commandes de Test

```bash
# Test de l'API RAG via curl
curl -X POST http://localhost:8002/chat \
  -H "Content-Type: application/json" \
  -d '{
    "message": "Test de connexion",
    "session_id": "test_installation"
  }'

# Test de l'API Laravel
curl http://localhost:8000/api/chat/health
```

### 4. Vérifications Techniques

```bash
# Vérifier PHP et extensions
php -v
php -m | grep -E "(sqlite|pdo|curl|gd)"

# Vérifier Python et packages
cd rag_system
source rag_env/bin/activate
python --version
pip list | grep -E "(langchain|groq|fastapi)"

# Vérifier Node.js
node --version
npm --version
```

---

## 🔧 Résolution des Problèmes

### Problème 1: "GROQ_API_KEY not found"

**Symptômes** : Erreur au démarrage du RAG system
**Solution** :
```bash
# Vérifier que la clé est bien dans .env
grep GROQ_API_KEY .env
grep GROQ_API_KEY rag_system/.env

# La clé doit commencer par "gsk_"
echo "GROQ_API_KEY=gsk_votre_vraie_cle_ici" >> .env
echo "GROQ_API_KEY=gsk_votre_vraie_cle_ici" >> rag_system/.env
```

### Problème 2: "Port 8000 already in use"

**Solution** :
```bash
# Trouver le processus qui utilise le port
lsof -i :8000  # Linux/Mac
netstat -ano | findstr :8000  # Windows

# Utiliser un autre port
php artisan serve --port=8001
```

### Problème 3: Erreurs de Dépendances Python

**Symptômes** : `ModuleNotFoundError` ou conflits de versions
**Solution** :
```bash
cd rag_system

# Supprimer l'environnement et recréer
rm -rf rag_env
python -m venv rag_env
source rag_env/bin/activate

# Réinstaller les dépendances
pip install --upgrade pip
pip install -r requirements.txt
```

### Problème 4: "Database locked" (SQLite)

**Solution** :
```bash
# Supprimer et recréer la base
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate
```

### Problème 5: Redis Connection Refused

**Solution** :
```bash
# Installer Redis si pas fait
sudo apt install redis-server  # Ubuntu
brew install redis  # macOS

# Démarrer Redis
redis-server
# ou
sudo systemctl start redis-server
```

### Problème 6: Permissions (Linux/Mac)

**Solution** :
```bash
# Donner les bonnes permissions
sudo chown -R $USER:$USER .
chmod -R 755 storage bootstrap/cache
```

### Problème 7: Chat Widget Ne Répond Pas

**Vérifications** :
```bash
# 1. Vérifier que RAG system fonctionne
curl http://localhost:8002/health

# 2. Vérifier les logs Laravel
tail -f storage/logs/laravel.log

# 3. Vérifier les logs RAG
tail -f rag_system/*.log

# 4. Vérifier la configuration
grep RAG_API_URL .env
```

---

## 🎯 Prochaines Étapes

### 1. Personnalisation

```bash
# Modifier les informations de l'entreprise
vim resources/views/partials/header.blade.php

# Ajouter vos propres documents RAG
# Placer les fichiers dans rag_system/vectorstore/documents/
# Puis réindexer
cd rag_system
python utils/indexer.py
```

### 2. Configuration Production

Consulter les sections production du README.md pour :
- Configuration SSL avec Let's Encrypt
- Base de données PostgreSQL
- Monitoring avancé
- Backup automatique

### 3. Développement

```bash
# Mode développement avec rechargement auto
npm run dev  # Frontend
# Le serveur Laravel se recharge automatiquement

# Pour le RAG system, utiliser uvicorn avec reload
cd rag_system
uvicorn working_server:app --host 0.0.0.0 --port 8002 --reload
```

### 4. Tests

```bash
# Tests Laravel
php artisan test

# Tests Python (si disponibles)
cd rag_system
python -m pytest tests/
```

---

## 📞 Support et Ressources

### Documentation
- **Documentation technique complète** : `DOCUMENTATION_TECHNIQUE_COMPLETE.md`
- **README principal** : `README.md`
- **API Documentation** : Section APIs dans la doc technique

### Logs Utiles
```bash
# Laravel
tail -f storage/logs/laravel.log

# RAG System  
tail -f rag_system/*.log

# Docker (si utilisé)
docker-compose logs -f
```

### Commandes de Debug
```bash
# Vérifier la configuration
php artisan config:show
php artisan route:list

# Nettoyer les caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Aide Supplémentaire

Si vous rencontrez des problèmes non couverts ici :

1. **Vérifier les logs** dans `storage/logs/` et `rag_system/`
2. **Tester chaque service individuellement** 
3. **Vérifier les variables d'environnement**
4. **Consulter la documentation technique complète**

---

## 🎉 Félicitations !

Si vous êtes arrivé jusqu'ici et que tous les tests passent, vous avez maintenant :

✅ **BrainGenTechnology RAG System** fonctionnel  
✅ **Interface web** responsive  
✅ **Chat IA intelligent** avec qualification des leads  
✅ **Dashboard analytics** temps réel  
✅ **Monitoring** et métriques  

**Votre plateforme d'IA conversationnelle est prête à être utilisée !** 🚀

---

*Développé avec ❤️ par l'équipe BrainGenTechnology - Propulsé par Laravel, FastAPI, Groq, et une dose d'IA !*