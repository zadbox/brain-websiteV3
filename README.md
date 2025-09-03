# BrainGenTechnology RAG System 🧠

## Vue d'ensemble

BrainGenTechnology est une plateforme web intelligente avec un système RAG (Retrieval-Augmented Generation) intégré pour la qualification automatisée des leads. Le système combine Laravel, FastAPI, et des technologies d'IA avancées pour créer une expérience conversationnelle intelligente avec persistence de mémoire et analytics en temps réel.

## 🎯 Fonctionnalités Principales

### 💬 Agent Conversationnel RAG
- **Groq LLM** pour des réponses ultra-rapides (< 1 seconde)
- **Mémoire persistante** avec Redis et SessionManager
- **Qualification automatisée** des leads selon critères BANT
- **Extraction d'entités** en temps réel (nom, entreprise, secteur)
- **Personnalisation adaptative** selon le profil utilisateur

### 📊 Analytics & Monitoring
- **Dashboard analytics** en temps réel
- **Métriques business** : taux de qualification, conversion, ROI
- **Stack monitoring** : Prometheus + Grafana
- **Logging centralisé** : ELK Stack
- **Health checks** automatisés

### 🏗️ Architecture
- **Backend** : Laravel 11 (PHP 8.2+)
- **IA Engine** : FastAPI + LangChain + Groq
- **Base vectorielle** : ChromaDB
- **Cache/Sessions** : Redis
- **Base de données** : SQLite (dev), PostgreSQL (prod)
- **Containerisation** : Docker + Docker Compose

### 🎨 Design & UX Moderne
- Interface responsive avec design mobile-first
- Animations neural network avec HTML5 Canvas
- Chat widget intelligent intégré
- Dashboard analytics avec métriques en temps réel
- Smooth scroll animations et hover effects

## 🚀 Installation et Démarrage

### Prérequis
- **PHP** 8.2+
- **Composer** 2.x
- **Python** 3.11+
- **Node.js** 18+
- **Docker** & Docker Compose (pour l'env Docker)

### 📦 Variables d'Environnement

Créez un fichier `.env` à la racine :

```bash
# Laravel Configuration
APP_NAME=BrainGenTechnology
APP_ENV=local
APP_KEY=base64:your-key-here
APP_DEBUG=true
APP_URL=http://localhost:8080

# Database
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# RAG System API
RAG_API_URL=http://localhost:8002

# Groq API (Requis pour l'IA)
GROQ_API_KEY=your-groq-api-key-here

# HuggingFace (pour les embeddings)
HF_API_KEY=your-huggingface-key-here

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=your-redis-password
REDIS_PORT=6379

# Email Configuration (optionnel)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contact@braingentech.com
```

## 🖥️ Développement Local

### 1. Installation Laravel

```bash
# Cloner le repository
git clone https://github.com/your-username/brain-websiteV3.git
cd brain-websiteV3

# Installer les dépendances PHP
composer install

# Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate

# Préparer la base de données
touch database/database.sqlite
php artisan migrate
php artisan db:seed --class=AnalyticsDataSeeder

# Installer les dépendances frontend
npm install
npm run dev
```

### 2. Configuration du Système RAG

⚠️ **Important**: Le système RAG utilise des dépendances Python conflictuelles. Utilisez un environnement virtuel isolé :

```bash
# Aller dans le dossier RAG
cd rag_system

# Créer un environnement virtuel Python isolé
python -m venv rag_env
source rag_env/bin/activate  # Linux/Mac
# ou
rag_env\Scripts\activate     # Windows

# Installer les dépendances Python
pip install -r requirements.txt

# Retourner à la racine
cd ..
```

**Résolution des conflits de dépendances** :
- Si vous avez des erreurs `pydantic._internal`, ceci est normal
- L'environnement virtuel `rag_env` isole les dépendances RAG du système global
- Pour réactiver l'environnement : `source rag_system/rag_env/bin/activate`

### 3. Démarrage des Services

#### Option A : Script Automatique (Recommandé)
```bash
# Démarrer tous les services
./start-all-services.sh

# Vérifier le statut
./status.sh

# Arrêter tous les services
./stop-all-services.sh
```

#### Option B : Démarrage Manuel
```bash
# Terminal 1: Laravel (port 8000)
php artisan serve

# Terminal 2: RAG System (port 8002)
cd rag_system
python working_server.py

# Terminal 3: Redis (si pas installé globalement)
redis-server

# Terminal 4: Frontend (dev)
npm run dev
```

### 4. Accès aux Services
- **Site principal** : http://localhost:8000
- **RAG API** : http://localhost:8002
- **Analytics Dashboard** : http://localhost:8000/analytics/dashboard

## 🐳 Déploiement Docker

### 1. Configuration Docker

```bash
# Copier le fichier d'environnement Docker
cp .env.example .env

# Modifier les variables pour Docker
# RAG_API_URL=http://rag-system:8002
# REDIS_HOST=redis
```

## 🚀 Déploiement Production

### 1. Prérequis Production

```bash
# Serveur avec au minimum :
# - 4 CPU cores
# - 8GB RAM
# - 50GB stockage SSD
# - Ubuntu 20.04+ ou CentOS 8+

# Docker & Docker Compose
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo curl -L "https://github.com/docker/compose/releases/download/v2.20.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

### 2. Configuration Production

```bash
# Cloner sur le serveur de production
git clone https://github.com/your-username/brain-websiteV3.git
cd brain-websiteV3

# Créer le fichier .env production
cp .env.example .env.production

# Variables critiques pour la production :
```

**Fichier `.env.production` :**

```bash
# Application
APP_NAME=BrainGenTechnology
APP_ENV=production
APP_KEY=base64:YOUR-SECURE-KEY-HERE  # php artisan key:generate
APP_DEBUG=false
APP_URL=https://your-domain.com

# Base de données (PostgreSQL recommandé)
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=braintech_prod
DB_USERNAME=braintech_user
DB_PASSWORD=your-secure-password

# RAG System
RAG_API_URL=http://rag-system:8002
GROQ_API_KEY=your-production-groq-key
HF_API_KEY=your-production-hf-key

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=your-secure-redis-password
REDIS_PORT=6379

# Mail (Production SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.your-provider.com
MAIL_PORT=587
MAIL_USERNAME=noreply@your-domain.com
MAIL_PASSWORD=your-mail-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com

# Monitoring
PROMETHEUS_ENABLED=true
GRAFANA_ADMIN_PASSWORD=your-secure-grafana-password

# SSL/Security
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
```

### 3. Docker Production avec SSL

**docker-compose.prod.yml :**

```yaml
version: '3.8'

services:
  # Nginx Reverse Proxy avec SSL
  nginx:
    image: nginx:alpine
    container_name: nginx-proxy
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./docker/nginx/prod.conf:/etc/nginx/nginx.conf
      - ./ssl:/etc/ssl/certs
      - ./logs/nginx:/var/log/nginx
    depends_on:
      - laravel-app
    restart: unless-stopped

  # Application Laravel
  laravel-app:
    build:
      context: .
      dockerfile: Dockerfile.prod
    container_name: laravel-prod
    environment:
      - APP_ENV=production
    volumes:
      - ./storage:/var/www/storage
      - ./bootstrap/cache:/var/www/bootstrap/cache
    depends_on:
      - postgres
      - redis
    restart: unless-stopped

  # PostgreSQL pour production
  postgres:
    image: postgres:15
    container_name: postgres-prod
    environment:
      POSTGRES_DB: braintech_prod
      POSTGRES_USER: braintech_user
      POSTGRES_PASSWORD: ${DB_PASSWORD}
    volumes:
      - postgres_data:/var/lib/postgresql/data
      - ./database/backups:/backups
    restart: unless-stopped

  # RAG System avec Python isolé
  rag-system:
    build:
      context: ./rag_system
      dockerfile: Dockerfile.prod
    container_name: rag-system-prod
    environment:
      - ENVIRONMENT=production
      - GROQ_API_KEY=${GROQ_API_KEY}
    volumes:
      - ./rag_system/vectorstore:/app/vectorstore
      - ./logs/rag:/app/logs
    depends_on:
      - redis
    restart: unless-stopped
    deploy:
      resources:
        limits:
          memory: 4G
          cpus: '2.0'

  # Redis avec persistence
  redis:
    image: redis:7-alpine
    container_name: redis-prod
    command: redis-server --appendonly yes --requirepass ${REDIS_PASSWORD}
    volumes:
      - redis_data:/data
    restart: unless-stopped

  # Monitoring Stack
  prometheus:
    image: prom/prometheus:latest
    container_name: prometheus-prod
    volumes:
      - ./monitoring/prometheus/prod.yml:/etc/prometheus/prometheus.yml
      - prometheus_data:/prometheus
    command:
      - '--config.file=/etc/prometheus/prometheus.yml'
      - '--storage.tsdb.path=/prometheus'
      - '--web.console.libraries=/etc/prometheus/console_libraries'
      - '--web.console.templates=/etc/prometheus/consoles'
      - '--storage.tsdb.retention.time=30d'
    restart: unless-stopped

  grafana:
    image: grafana/grafana:latest
    container_name: grafana-prod
    environment:
      - GF_SECURITY_ADMIN_PASSWORD=${GRAFANA_ADMIN_PASSWORD}
      - GF_SERVER_DOMAIN=your-domain.com
      - GF_SERVER_ROOT_URL=https://your-domain.com/grafana
    volumes:
      - grafana_data:/var/lib/grafana
      - ./monitoring/grafana/dashboards:/etc/grafana/provisioning/dashboards
    restart: unless-stopped

volumes:
  postgres_data:
  redis_data:
  prometheus_data:
  grafana_data:
```

### 4. Dockerfile Production

**Dockerfile.prod :**

```dockerfile
FROM php:8.2-fpm-alpine AS base

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    postgresql-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql gd xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Production optimizations
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

EXPOSE 9000
CMD ["php-fpm"]
```

**RAG System Dockerfile.prod :**

```dockerfile
FROM python:3.11-slim AS base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    gcc \
    g++ \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Create isolated virtual environment
RUN python -m venv /app/rag_env
ENV PATH="/app/rag_env/bin:$PATH"

# Install Python dependencies
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copy application code
COPY . .

# Create non-root user
RUN useradd -m -u 1000 raguser
RUN chown -R raguser:raguser /app
USER raguser

EXPOSE 8002

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
  CMD curl -f http://localhost:8002/health || exit 1

CMD ["python", "working_server.py"]
```

### 5. Scripts de Déploiement

**scripts/deploy-prod.sh :**

```bash
#!/bin/bash

set -e

echo "🚀 Déploiement Production BrainGenTechnology"

# Backup base de données
echo "📦 Backup base de données..."
docker-compose -f docker-compose.prod.yml exec postgres pg_dump -U braintech_user braintech_prod > "database/backups/backup-$(date +%Y%m%d-%H%M%S).sql"

# Pull dernières modifications
echo "📡 Pull du code..."
git pull origin main

# Build des nouveaux containers
echo "🔨 Build des containers..."
docker-compose -f docker-compose.prod.yml build --no-cache

# Arrêt des anciens services
echo "🛑 Arrêt des services..."
docker-compose -f docker-compose.prod.yml down

# Démarrage des nouveaux services
echo "▶️ Démarrage des services..."
docker-compose -f docker-compose.prod.yml up -d

# Migrations et optimisations
echo "🗄️ Migrations..."
docker-compose -f docker-compose.prod.yml exec laravel-prod php artisan migrate --force

# Cache et optimisations
echo "⚡ Optimisations..."
docker-compose -f docker-compose.prod.yml exec laravel-prod php artisan config:cache
docker-compose -f docker-compose.prod.yml exec laravel-prod php artisan route:cache
docker-compose -f docker-compose.prod.yml exec laravel-prod php artisan view:cache

# Health check
echo "🏥 Vérification santé des services..."
sleep 30
curl -f http://localhost/health || echo "❌ Laravel unhealthy"
curl -f http://localhost:8002/health || echo "❌ RAG System unhealthy"

echo "✅ Déploiement terminé !"
```

### 6. SSL avec Let's Encrypt

**scripts/setup-ssl.sh :**

```bash
#!/bin/bash

# Installer Certbot
sudo apt-get update
sudo apt-get install -y certbot

# Générer certificat SSL
sudo certbot certonly --standalone -d your-domain.com -d www.your-domain.com

# Copier les certificats
sudo cp /etc/letsencrypt/live/your-domain.com/fullchain.pem ./ssl/
sudo cp /etc/letsencrypt/live/your-domain.com/privkey.pem ./ssl/
sudo chown -R $USER:$USER ./ssl/

# Auto-renewal
echo "0 12 * * * /usr/bin/certbot renew --quiet" | sudo crontab -
```

### 7. Monitoring Production

**Alertes Prometheus (monitoring/prometheus/alerts.yml) :**

```yaml
groups:
  - name: braintech_alerts
    rules:
      - alert: ServiceDown
        expr: up == 0
        for: 1m
        labels:
          severity: critical
        annotations:
          summary: "Service {{ $labels.instance }} is down"

      - alert: HighRAGLatency
        expr: rag_response_time > 2
        for: 2m
        labels:
          severity: warning
        annotations:
          summary: "RAG system latency is high"

      - alert: LowMemory
        expr: (node_memory_MemAvailable_bytes / node_memory_MemTotal_bytes) < 0.1
        for: 2m
        labels:
          severity: critical
        annotations:
          summary: "Memory usage is above 90%"
```

### 8. Commandes Production

```bash
# Déploiement complet
./scripts/deploy-prod.sh

# Monitoring des logs
docker-compose -f docker-compose.prod.yml logs -f --tail=100

# Backup manuel
docker-compose -f docker-compose.prod.yml exec postgres pg_dump -U braintech_user braintech_prod > backup.sql

# Mise à l'échelle
docker-compose -f docker-compose.prod.yml up -d --scale rag-system=3

# Redémarrage sans downtime
docker-compose -f docker-compose.prod.yml up -d --force-recreate --no-deps rag-system
```

### 2. Démarrage Docker Compose

```bash
# Construire et démarrer tous les conteneurs
docker-compose up -d --build

# Vérifier le statut des conteneurs
docker-compose ps

# Voir les logs
docker-compose logs -f

# Accéder au conteneur Laravel pour les migrations
docker-compose exec laravel-app php artisan migrate
docker-compose exec laravel-app php artisan db:seed --class=AnalyticsDataSeeder
```

### 3. Services Docker Disponibles

| Service | Port | URL | Description |
|---------|------|-----|-------------|
| **Laravel App** | 8080 | <http://localhost:8080> | Application principale |
| **RAG System** | 8002 | <http://localhost:8002> | API IA/RAG |
| **Redis** | 6379 | - | Cache et sessions |
| **Prometheus** | 9090 | <http://localhost:9090> | Métriques |
| **Grafana** | 3000 | <http://localhost:3000> | Dashboards (admin:admin123) |
| **Elasticsearch** | 9200 | <http://localhost:9200> | Recherche/Logs |
| **Kibana** | 5601 | <http://localhost:5601> | Interface logs |
| **Traefik** | 8081 | <http://localhost:8081> | Load balancer |

### 4. Commandes Docker Utiles

```bash
# Redémarrer un service spécifique
docker-compose restart rag-system

# Voir les logs d'un service
docker-compose logs -f laravel-app

# Exécuter des commandes dans un conteneur
docker-compose exec laravel-app bash
docker-compose exec rag-system python --version

# Arrêter et nettoyer
docker-compose down
docker-compose down --volumes  # Supprime aussi les volumes
```

## 📁 Structure du Projet

```text
brain-websiteV3/
├── app/
│   ├── Http/Controllers/
│   │   ├── AnalyticsController.php    # Dashboard analytics
│   │   ├── ChatController.php         # API chat RAG
│   │   └── MetricsController.php      # Métriques système
│   ├── Mail/                         # Email classes
│   └── Models/                       # Eloquent models
├── rag_system/
│   ├── api/                          # FastAPI endpoints
│   ├── chains/                       # LangChain RAG chains
│   ├── config/                       # Configuration
│   ├── models/                       # Data models
│   ├── monitoring/                   # Prometheus metrics
│   ├── utils/                        # SessionManager, indexer
│   ├── vectorstore/                  # ChromaDB + documents
│   ├── requirements.txt              # Python dependencies
│   └── working_server.py            # Main RAG server
├── public/
│   └── assets/
│       ├── css/                      # Page-specific styles
│       └── js/                       # Custom scripts + chat widget
├── resources/views/
│   ├── analytics/dashboard.blade.php # Analytics dashboard
│   ├── partials/chat-widget.blade.php # Chat widget
│   └── ...                          # Other Blade templates
├── monitoring/
│   ├── grafana/dashboards/           # Grafana dashboards
│   └── prometheus/                   # Prometheus config
├── docker-compose.yml               # Docker orchestration
├── Dockerfile                       # Multi-stage Docker build
└── start-all-services.sh           # Launch script
```

## 🔧 Configuration Avancée

### Health Checks

Les conteneurs incluent des health checks automatiques :

```bash
# Vérifier la santé des conteneurs
docker-compose ps
# ou
curl http://localhost:8002/health  # RAG System
curl http://localhost:8080         # Laravel
```

### Scaling

```bash
# Scaler le service RAG pour haute charge
docker-compose up -d --scale rag-system=3
```

### Monitoring

- **Grafana** : Dashboards pré-configurés pour business et infrastructure
- **Prometheus** : Collecte des métriques en temps réel
- **Redis Exporter** : Métriques de cache et sessions
- **cAdvisor** : Métriques des conteneurs

## 🛠️ Scripts Utiles

```bash
# Développement
./start-dev.sh          # Démarre en mode développement
./debug-rag.sh          # Debug du système RAG
./setup-analytics.sh    # Configure les données analytics

# Production
./scripts/deploy.sh     # Déploiement production

# Maintenance
./brain-commands.sh     # Commandes spécifiques au projet
```

## 📚 API Documentation

### Endpoints RAG System

```bash
# Chat avec l'agent IA
POST http://localhost:8002/chat
{
    "message": "Bonjour, je cherche des solutions IA",
    "session_id": "user-123",
    "metadata": {"user_agent": "..."}
}

# Health check
GET http://localhost:8002/health

# Métriques Prometheus
GET http://localhost:8002/metrics
```

### Endpoints Laravel

```bash
# Dashboard analytics
GET /analytics/dashboard

# API metrics
GET /api/metrics

# Chat frontend
POST /api/chat
```

## 🔒 Sécurité

- **API Keys** protégées via `.gitignore`
- **CORS** configuré pour les domaines autorisés
- **Health checks** avec authentification
- **Variables d'environnement** sécurisées
- **Logs** filtrés pour éviter les données sensibles

## 🚨 Dépannage

### Problèmes Courants

**1. RAG System "unhealthy"**

```bash
# Vérifier les logs
docker-compose logs rag-system
# Souvent causé par une clé API manquante ou invalide
```

**2. Erreur 503 sur /chat**

```bash
# Vérifier que le RAG system est démarré
curl http://localhost:8002/health
# Vérifier la variable RAG_API_URL dans .env
```

**3. Redis connection refused**

```bash
# Vérifier Redis
docker-compose logs redis
# ou pour installation locale
redis-cli ping
```

**4. Conflits de dépendances Python (pydantic, langchain, etc.)**

```bash
# Solution recommandée : utiliser l'environnement virtuel isolé
cd rag_system
source rag_env/bin/activate
pip install -r requirements.txt

# Alternative : créer un nouvel environnement
rm -rf rag_env
python -m venv rag_env
source rag_env/bin/activate
pip install -r requirements.txt
```

**5. Base de données locked**

```bash
# Recreer la base SQLite
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate
```

### Logs Utiles

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# RAG system logs
tail -f rag_system/working_server.log

# Docker logs
docker-compose logs -f
```

## 📈 Performance

### Métriques Typiques

- **Latence RAG** : < 1 seconde
- **Temps de réponse Laravel** : < 200ms
- **Concurrent users** : 100+ (avec Redis)
- **Qualification accuracy** : 94%

### Optimisations

- **Redis caching** pour sessions et réponses fréquentes
- **ChromaDB** avec embeddings pré-calculés
- **Docker multi-stage** builds
- **Nginx** reverse proxy avec compression
- **Asset minification** avec Vite

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/amazing-feature`)
3. Commit les changements (`git commit -m 'Add amazing feature'`)
4. Push vers la branche (`git push origin feature/amazing-feature`)
5. Créer une Pull Request

## 📄 License

Ce projet est sous license MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 🆘 Support

- **Email** : contact@braingentech.com
- **Issues GitHub** : [Créer un ticket](https://github.com/your-username/brain-websiteV3/issues)
- **Documentation** : Ce README et les fichiers dans `/docs`

---

**Développé avec ❤️ par l'équipe BrainGenTechnology**

*Propulsé par Laravel, FastAPI, Groq, et une dose d'IA !* 🚀
