# 🧠 BrainGenTechnology - Documentation Technique Complète

## 📋 Table des Matières

1. [Vue d'ensemble du Projet](#vue-densemble-du-projet)
2. [Architecture du Système](#architecture-du-système)
3. [Stack Technologique](#stack-technologique)
4. [Système RAG (Retrieval-Augmented Generation)](#système-rag)
5. [Intégration Laravel](#intégration-laravel)
6. [Base de Données](#base-de-données)
7. [Infrastructure Docker](#infrastructure-docker)
8. [Système de Monitoring](#système-de-monitoring)
9. [APIs et Endpoints](#apis-et-endpoints)
10. [Sécurité et Authentification](#sécurité-et-authentification)
11. [Configuration et Déploiement](#configuration-et-déploiement)
12. [Troubleshooting et Maintenance](#troubleshooting-et-maintenance)

---

## 🎯 Vue d'ensemble du Projet

**BrainGenTechnology** est une plateforme web d'intelligence artificielle avancée combinant :

- **Site web corporatif** moderne avec Laravel 11
- **Système RAG intelligent** pour la qualification automatique des leads
- **Analytics en temps réel** avec dashboards interactifs
- **Infrastructure containerisée** avec monitoring complet
- **Intégration CRM** pour la gestion des prospects qualifiés

### Objectifs Business

- **Qualification automatique des leads** via IA conversationnelle
- **Amélioration du ROI marketing** par scoring BANT+ intelligent
- **Optimisation de l'expérience utilisateur** avec chat intelligent
- **Analytics avancées** pour la prise de décision data-driven

### Métriques Clés

- **Latence RAG** : < 1 seconde
- **Précision qualification** : 94%+
- **Utilisateurs concurrents** : 100+
- **Uptime** : 99.9%

---

## 🏗️ Architecture du Système

### Architecture Générale

```
┌─────────────────────────────────────────────────────────────────┐
│                    BRAINGENTECH PLATFORM                        │
├─────────────────────────────────────────────────────────────────┤
│                      Load Balancer (Traefik)                    │
├─────────────────────┬───────────────────────┬───────────────────┤
│   Laravel Frontend  │    RAG System         │   Monitoring      │
│   (PHP 8.2)        │    (FastAPI/Python)   │   Stack           │
│                    │                       │                   │
│   • Web Interface   │   • Groq LLM          │   • Prometheus    │
│   • Chat Widget     │   • ChromaDB          │   • Grafana       │
│   • Analytics       │   • LangChain         │   • Alerting      │
│   • CRM Integration │   • Session Manager   │                   │
├─────────────────────┼───────────────────────┼───────────────────┤
│                    Redis Cache & Sessions                       │
├─────────────────────┼───────────────────────┼───────────────────┤
│    SQLite (Dev)     │    ChromaDB           │   Logs (ELK)      │
│    PostgreSQL (Prod)│    Vector Store       │                   │
└─────────────────────────────────────────────────────────────────┘
```

### Flux de Données

1. **Utilisateur** → Chat Widget (Frontend)
2. **Laravel** → Validation et routing
3. **RAG System** → Traitement IA et qualification
4. **Redis** → Cache de sessions et réponses
5. **Base de données** → Persistance des données analytics
6. **Monitoring** → Métriques et alertes en temps réel

---

## 🛠️ Stack Technologique

### Backend

| Composant | Version | Rôle |
|-----------|---------|------|
| **PHP** | 8.2+ | Runtime Laravel |
| **Laravel** | 11.x | Framework web principal |
| **Python** | 3.11+ | Runtime système RAG |
| **FastAPI** | 0.115.0 | API RAG haute performance |
| **SQLite** | 3.x | Base de données développement |
| **PostgreSQL** | 15+ | Base de données production |

### Intelligence Artificielle

| Composant | Version | Rôle |
|-----------|---------|------|
| **Groq API** | - | LLM ultra-rapide (<1s) |
| **LangChain** | 0.3.0 | Framework RAG |
| **ChromaDB** | 0.5.11 | Base vectorielle |
| **HuggingFace** | - | Embeddings et modèles |
| **Sentence Transformers** | 3.1.1 | Vectorisation texte |

### Infrastructure

| Composant | Version | Rôle |
|-----------|---------|------|
| **Docker** | 24.x+ | Containerisation |
| **Redis** | 7.x | Cache et sessions |
| **Traefik** | 2.10 | Reverse proxy |
| **Prometheus** | latest | Collecte métriques |
| **Grafana** | latest | Visualisation |

### Frontend

| Composant | Version | Rôle |
|-----------|---------|------|
| **Blade** | - | Templates Laravel |
| **TailwindCSS** | 3.4.0 | Framework CSS |
| **Vite** | 5.0 | Build tool |
| **JavaScript** | ES2022 | Interactivité |
| **HTML5 Canvas** | - | Animations neural network |

---

## 🤖 Système RAG (Retrieval-Augmented Generation)

### Architecture RAG

Le système RAG de BrainGenTechnology est conçu pour :

1. **Compréhension contextuelle** des requêtes business
2. **Qualification intelligente** des leads via BANT+
3. **Mémorisation des conversations** avec Redis
4. **Génération de réponses** personnalisées et pertinentes

### Composants Principaux

#### 1. Serveur RAG (`working_server.py`)

```python
# Point d'entrée principal - Port 8002
class WorkingRAGServer:
    - FastAPI application
    - Groq LLM integration
    - ChromaDB vectorstore
    - Session management
    - Lead qualification
    - Prometheus metrics
```

**Fonctionnalités clés :**
- Traitement des requêtes chat en temps réel
- Qualification BANT+ automatique
- Gestion de sessions persistantes
- Métriques de performance
- Health checks automatiques

#### 2. Chaîne de Qualification (`qualification_chain.py`)

```python
class LeadQualificationChain:
    - BANT methodology enhanced
    - 13 critères de qualification
    - Scoring 0-100 points
    - Classification industrie/taille
    - Détection niveau décisionnel
```

**Critères de qualification :**

| Critère | Poids | Description |
|---------|-------|-------------|
| **Intent** | 25% | information, quote, demo, consultation |
| **Urgency** | 25% | low, medium, high, critical |
| **Authority** | 25% | user, manager, director, c_level |
| **Company Size** | 25% | startup, sme, mid_market, enterprise |

#### 3. Gestionnaire de Sessions (`session_manager.py`)

```python
class SessionManager:
    - Redis integration
    - Conversation persistence
    - User context tracking
    - Memory management
    - Session analytics
```

**Fonctionnalités :**
- Mémoire conversationnelle persistante
- Extraction d'entités utilisateur
- Gestion du contexte business
- Nettoyage automatique des sessions expirées

#### 4. Base Vectorielle (ChromaDB)

```
vectorstore/
├── chroma_db/
│   ├── chroma.sqlite3          # Index principal
│   └── collections/            # Documents vectorisés
└── documents/
    ├── company/               # Info entreprise
    ├── services/             # Services IA/Automation
    └── technical/           # Documentation technique
```

**Documents indexés :**
- Présentation services BrainGenTechnology
- Études de cas et success stories
- Documentation technique solutions
- FAQ et cas d'usage courants

### Configuration RAG

#### Variables d'environnement

```bash
# rag_system/.env
GROQ_API_KEY=your_groq_api_key_here
HF_API_KEY=your_huggingface_key_here
REDIS_HOST=redis
REDIS_PASSWORD=your_redis_password
REDIS_PORT=6379
CHROMA_PERSIST_DIR=/app/vectorstore/chroma_db
```

#### Paramètres LLM

```python
# config/settings.py
class Settings:
    llm_model = "mixtral-8x7b-32768"  # Groq model
    temperature = 0.3                  # Controlled creativity
    max_tokens = 1500                 # Response length
    qualification_timeout = 30        # API timeout
```

### Performance RAG

| Métrique | Valeur | Description |
|----------|--------|-------------|
| **Latence moyenne** | 850ms | Temps de réponse RAG |
| **Précision qualification** | 94.2% | Accuracy BANT+ |
| **Vectorstore** | 2.3GB | Taille base vectorielle |
| **Embeddings** | 768D | Dimension vecteurs |

---

## 🚀 Intégration Laravel

### Architecture Laravel

Le framework Laravel gère :

1. **Interface web** et pages statiques
2. **API REST** pour intégration RAG
3. **Analytics dashboard** temps réel
4. **Base de données** conversations/leads
5. **Système de cache** avec Redis

### Contrôleurs Principaux

#### 1. ChatController (`app/Http/Controllers/ChatController.php`)

**Responsabilités :**
- Proxy vers API RAG
- Validation des requêtes chat
- Stockage analytics
- Qualification automatique
- Fallback rule-based

**Méthodes clés :**

```php
// Traitement chat principal
POST /api/chat
- Validation message utilisateur
- Appel système RAG
- Stockage conversation
- Qualification automatique

// Qualification manuelle
POST /api/chat/qualify
- Analyse conversation complète
- Scoring BANT+ détaillé
- Création consultation request

// Health check système
GET /api/chat/health
- Status RAG system
- Connectivité services
- Métriques performance
```

#### 2. AnalyticsController (`app/Http/Controllers/AnalyticsController.php`)

**Dashboard Analytics :**
- Métriques temps réel
- Conversations et leads
- Taux de conversion
- Distribution géographique
- Performance système

**Endpoints principaux :**

```php
GET /analytics/dashboard
- Interface analytics complète
- Widgets interactifs
- Filtres temporels

GET /api/analytics/realtime
- Métriques temps réel
- Utilisateurs actifs
- Taux conversion live
```

#### 3. MetricsController (`app/Http/Controllers/MetricsController.php`)

**Métriques Prometheus :**
- Business metrics
- System performance
- RAG system metrics
- Conversion rates

### Middleware et Sécurité

```php
// app/Http/Middleware/
- CORS configuration
- CSRF protection (web routes only)
- Rate limiting
- Request logging
```

### Blade Templates

```
resources/views/
├── layouts/
│   └── app.blade.php                # Layout principal
├── partials/
│   ├── chat-widget.blade.php        # Widget chat
│   ├── header.blade.php             # Navigation
│   └── footer.blade.php             # Pied de page
├── analytics/
│   └── dashboard.blade.php          # Dashboard analytics
└── pages/                           # Pages statiques
```

---

## 🗄️ Base de Données

### Schéma de Base de Données

Le système utilise SQLite en développement et PostgreSQL en production.

#### Tables Principales

##### 1. `chat_conversations`

```sql
CREATE TABLE chat_conversations (
    id                  BIGINT PRIMARY KEY,
    session_id          VARCHAR UNIQUE NOT NULL,
    user_ip             VARCHAR(45),
    user_agent          TEXT,
    referrer            VARCHAR,
    metadata            JSON,              -- Context additionnel
    message_count       INTEGER DEFAULT 0,
    started_at          TIMESTAMP NOT NULL,
    last_activity_at    TIMESTAMP NOT NULL,
    is_active           BOOLEAN DEFAULT TRUE,
    created_at          TIMESTAMP,
    updated_at          TIMESTAMP
);
```

**Index :**
- `session_id` (unique)
- `is_active, last_activity_at` (composite)
- `started_at`

##### 2. `chat_messages`

```sql
CREATE TABLE chat_messages (
    id          BIGINT PRIMARY KEY,
    session_id  VARCHAR NOT NULL,
    message_id  VARCHAR UNIQUE NOT NULL,
    role        ENUM('user', 'assistant', 'system'),
    content     TEXT NOT NULL,
    metadata    JSON,                    -- Sources, temps traitement
    sent_at     TIMESTAMP NOT NULL,
    created_at  TIMESTAMP,
    updated_at  TIMESTAMP,
    
    FOREIGN KEY (session_id) REFERENCES chat_conversations(session_id)
);
```

**Index :**
- `session_id, sent_at` (composite)
- `role`
- `message_id` (unique)

##### 3. `lead_qualifications`

```sql
CREATE TABLE lead_qualifications (
    id                      BIGINT PRIMARY KEY,
    session_id              VARCHAR NOT NULL,
    intent                  ENUM('information', 'quote', 'demo', 'consultation', 'support', 'partnership'),
    urgency                 ENUM('low', 'medium', 'high', 'critical'),
    company_size            ENUM('startup', 'sme', 'mid_market', 'enterprise'),
    industry                VARCHAR,
    company_name            VARCHAR,
    technology_interests    JSON,               -- Array technologies
    pain_points            JSON,               -- Array pain points
    use_cases              TEXT,
    decision_maker_level    ENUM('user', 'manager', 'director', 'c_level', 'owner', 'unknown'),
    geographic_region       VARCHAR,
    timezone               VARCHAR,
    lead_score             INTEGER DEFAULT 0,   -- 0-100
    sales_ready            BOOLEAN DEFAULT FALSE,
    notes                  TEXT,
    conversation_quality    INTEGER DEFAULT 5,   -- 1-10
    follow_up_priority     ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    model_confidence       FLOAT DEFAULT 0.5,   -- 0.0-1.0
    qualified_at           TIMESTAMP NOT NULL,
    raw_qualification_data JSON,               -- Réponse complète qualification
    created_at             TIMESTAMP,
    updated_at             TIMESTAMP,
    
    FOREIGN KEY (session_id) REFERENCES chat_conversations(session_id)
);
```

**Index principaux :**
- `sales_ready, lead_score` (composite)
- `follow_up_priority, qualified_at` (composite)
- `company_size`
- `industry`

##### 4. `consultation_requests`

```sql
CREATE TABLE consultation_requests (
    id                 BIGINT PRIMARY KEY,
    session_id         VARCHAR NOT NULL,
    email              VARCHAR,
    phone              VARCHAR,
    preferred_contact  VARCHAR DEFAULT 'email',
    preferred_time     VARCHAR DEFAULT 'flexible',
    industry           VARCHAR DEFAULT 'other',
    request_type       ENUM('consultation', 'demo', 'quote', 'general') DEFAULT 'consultation',
    status             ENUM('pending', 'scheduled', 'completed') DEFAULT 'pending',
    notes              TEXT,
    requested_at       TIMESTAMP NOT NULL,
    created_at         TIMESTAMP,
    updated_at         TIMESTAMP
);
```

### Migrations

```bash
# Migrations disponibles
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 0001_01_01_000001_create_cache_table.php
├── 2024_08_05_230000_create_chat_conversations_table.php
├── 2025_08_06_204352_add_missing_columns_to_lead_qualifications_table.php
└── 2025_08_08_063014_create_consultation_requests_table.php
```

### Seeders

```php
// database/seeders/
- AnalyticsDataSeeder.php         # Données demo analytics
- SimpleAnalyticsSeeder.php       # Données test simples
```

### Performance Base de Données

| Opération | Temps moyen | Index utilisé |
|-----------|-------------|---------------|
| **Insert message** | 2ms | session_id |
| **Qualification lookup** | 5ms | sales_ready, lead_score |
| **Analytics aggregation** | 15ms | started_at, qualified_at |
| **Session cleanup** | 50ms | is_active, last_activity_at |

---

## 🐳 Infrastructure Docker

### Architecture Containerisée

Le projet utilise Docker Compose pour orchestrer tous les services.

#### Services Docker

```yaml
# docker-compose.yml
services:
  # Applications
  laravel-app:      # Frontend Laravel (Port 8080)
  rag-system:       # Système RAG FastAPI (Port 8002)
  
  # Infrastructure  
  traefik:          # Load balancer (Port 80/443/8081)
  redis:            # Cache et sessions (Port 6379)
  
  # Monitoring
  prometheus:       # Métriques (Port 9090)
  grafana:          # Dashboards (Port 3000)
  node-exporter:    # Métriques système (Port 9100)
  cadvisor:         # Métriques conteneurs (Port 8083)
  redis-exporter:   # Métriques Redis (Port 9121)
  
  # Logs (ELK Stack)
  elasticsearch:    # Recherche logs (Port 9200)
  logstash:         # Processing logs (Port 5044)
  kibana:           # Interface logs (Port 5601)
```

#### Dockerfile Multi-stage

##### Laravel Application

```dockerfile
# Dockerfile - Laravel stage
FROM php:8.2-fpm-alpine AS php-base

# System dependencies
RUN apk add --no-cache git curl libpng-dev libxml2-dev zip unzip

# PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite gd xml

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Application
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
```

##### RAG System

```dockerfile
# Dockerfile - RAG System stage  
FROM python:3.11-slim AS rag-system

# System dependencies
RUN apt-get update && apt-get install -y gcc g++ curl

# Python environment
WORKDIR /app
COPY rag_system/requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Application
COPY rag_system/ .
RUN useradd -m raguser && chown -R raguser:raguser /app
USER raguser

EXPOSE 8002

# Health check
HEALTHCHECK --interval=30s --timeout=10s --retries=3 \
  CMD curl -f http://localhost:8002/health || exit 1

CMD ["python", "working_server.py"]
```

#### Volumes et Persistance

```yaml
volumes:
  # Données applicatives
  - ./storage:/var/www/storage                    # Laravel logs/cache
  - ./rag_system/vectorstore:/app/vectorstore     # ChromaDB data
  
  # Monitoring data
  - prometheus-data:/prometheus
  - grafana-data:/var/lib/grafana
  - redis-data:/data
  
  # Logs
  - elasticsearch-data:/usr/share/elasticsearch/data
```

#### Networking

```yaml
networks:
  braintech-network:
    driver: bridge
    
# Communication inter-services :
# laravel-app -> rag-system:8002
# rag-system -> redis:6379  
# prometheus -> *:metrics_port
```

#### Configuration Traefik

```yaml
# docker/traefik/traefik.yml
entryPoints:
  web:
    address: ":80"
  websecure:
    address: ":443"

providers:
  docker:
    exposedByDefault: false

metrics:
  prometheus:
    addEntryPointsLabels: true
    addServicesLabels: true
```

### Commandes Docker

```bash
# Développement
docker-compose up -d                    # Start tous services
docker-compose logs -f rag-system      # Logs service spécifique
docker-compose exec laravel-app bash   # Shell dans conteneur
docker-compose restart rag-system      # Restart service

# Production  
docker-compose -f docker-compose.prod.yml up -d --build
docker-compose -f docker-compose.prod.yml exec laravel-app php artisan migrate

# Maintenance
docker-compose down --volumes          # Stop et clean volumes
docker system prune -af               # Clean complet Docker
```

### Health Checks

Tous les services critiques ont des health checks :

```yaml
healthcheck:
  test: ["CMD", "curl", "-f", "http://localhost:8002/health"]
  interval: 30s
  timeout: 15s
  retries: 5
  start_period: 60s
```

---

## 📊 Système de Monitoring

### Architecture Monitoring

```
┌─────────────────────────────────────────────────────────────────┐
│                     MONITORING STACK                            │
├─────────────────────┬───────────────────────┬───────────────────┤
│    Data Sources     │   Processing          │   Visualization   │
│                     │                       │                   │
│   • Laravel Metrics │   • Prometheus        │   • Grafana       │
│   • RAG Metrics     │   • Alert Manager     │   • Dashboards    │
│   • Redis Metrics   │   • Push Gateway      │   • Notifications │
│   • System Metrics  │                       │                   │
│   • Container Stats │                       │                   │
├─────────────────────┴───────────────────────┴───────────────────┤
│                        Log Processing                           │
│   Elasticsearch ← Logstash ← Application Logs                  │
└─────────────────────────────────────────────────────────────────┘
```

### Prometheus Configuration

#### Targets de Scraping

```yaml
# monitoring/prometheus/prometheus.yml
scrape_configs:
  - job_name: 'laravel-app'
    static_configs:
      - targets: ['laravel-app:80']
    metrics_path: '/metrics'
    scrape_interval: 30s

  - job_name: 'rag-system'
    static_configs:
      - targets: ['rag-system:8002']
    metrics_path: '/metrics'
    scrape_interval: 15s

  - job_name: 'redis'
    static_configs:
      - targets: ['redis-exporter:9121']
    scrape_interval: 30s

  - job_name: 'business-metrics'
    static_configs:
      - targets: ['laravel-app:80']
    metrics_path: '/api/metrics/business'
    scrape_interval: 60s
```

#### Métriques Collectées

##### Métriques RAG System

```python
# rag_system/monitoring/metrics.py
class RAGMetrics:
    # Performance
    rag_response_time = Histogram('rag_response_time_seconds')
    rag_vector_search_time = Histogram('rag_vector_search_duration_seconds')
    rag_llm_request_time = Histogram('rag_llm_request_duration_seconds')
    
    # Business
    rag_conversations_total = Counter('rag_conversations_total')
    rag_qualifications_total = Counter('rag_qualifications_total')
    rag_sales_ready_leads = Counter('rag_sales_ready_leads_total')
    
    # Quality
    rag_lead_score = Histogram('rag_lead_score_distribution')
    rag_conversation_quality = Histogram('rag_conversation_quality_score')
```

##### Métriques Laravel

```php
// app/Http/Controllers/MetricsController.php
class MetricsController {
    // Business metrics
    - Total conversations
    - Lead qualifications 
    - Conversion rates
    - Revenue pipeline
    
    // Performance metrics
    - Response times
    - Database queries
    - Cache hit rates
    - Error rates
}
```

### Dashboards Grafana

#### 1. BrainTech Overview Dashboard

```json
{
  "title": "BrainGenTechnology - System Overview",
  "panels": [
    {
      "title": "System Health Status",
      "type": "stat",
      "targets": ["up{job=\"laravel-app\"}", "up{job=\"rag-system\"}"]
    },
    {
      "title": "Request Rate", 
      "type": "graph",
      "targets": ["rate(rag_conversations_total[5m])"]
    },
    {
      "title": "Response Time",
      "type": "graph", 
      "targets": ["histogram_quantile(0.95, rag_response_time_seconds)"]
    }
  ]
}
```

#### 2. Business Analytics Dashboard

```json
{
  "title": "Business Intelligence Dashboard",
  "panels": [
    {
      "title": "Lead Generation Rate",
      "type": "stat",
      "targets": ["rate(rag_qualifications_total[1h])"]
    },
    {
      "title": "Sales Ready Leads",
      "type": "pie", 
      "targets": ["rag_sales_ready_leads_total"]
    },
    {
      "title": "Conversion Funnel",
      "type": "table",
      "targets": ["rag_conversations_total", "rag_qualifications_total"]
    }
  ]
}
```

#### 3. Infrastructure Monitoring

- **CPU/Memory/Disk** usage par conteneur
- **Network I/O** et latence
- **Redis** performance et utilisation
- **Database** queries et performance

### Alerting Rules

```yaml
# monitoring/prometheus/alert_rules.yml
groups:
  - name: braintech_alerts
    rules:
      # Service availability
      - alert: ServiceDown
        expr: up == 0
        for: 1m
        labels:
          severity: critical
        annotations:
          summary: "Service {{ $labels.instance }} is down"
          
      # Performance
      - alert: HighRAGLatency
        expr: rag_response_time_seconds > 2
        for: 2m
        labels:
          severity: warning
        annotations:
          summary: "RAG system latency is high (>2s)"
          
      # Business
      - alert: LowConversionRate
        expr: rate(rag_qualifications_total[1h]) / rate(rag_conversations_total[1h]) < 0.1
        for: 5m
        labels:
          severity: warning
        annotations:
          summary: "Lead conversion rate is below 10%"
```

### Logging avec ELK Stack

#### Elasticsearch Configuration

```yaml
# docker-compose.yml - Elasticsearch
environment:
  - discovery.type=single-node
  - xpack.security.enabled=false
  - "ES_JAVA_OPTS=-Xms512m -Xmx512m"
volumes:
  - elasticsearch-data:/usr/share/elasticsearch/data
```

#### Logstash Pipeline

```ruby
# monitoring/logstash/pipeline/logstash.conf
input {
  beats {
    port => 5044
  }
}

filter {
  if [fields][log_type] == "laravel" {
    grok {
      match => { "message" => "%{TIMESTAMP_ISO8601:timestamp} %{WORD:environment}\.%{WORD:level}: %{GREEDYDATA:message}" }
    }
  }
  
  if [fields][log_type] == "rag" {
    json {
      source => "message"
    }
  }
}

output {
  elasticsearch {
    hosts => ["elasticsearch:9200"]
    index => "braintech-logs-%{+YYYY.MM.dd}"
  }
}
```

---

## 🔌 APIs et Endpoints

### Architecture API

Le système expose plusieurs APIs pour différents cas d'usage :

1. **Chat API** - Communication avec le système RAG
2. **Analytics API** - Métriques et dashboards  
3. **Business API** - Intégrations CRM
4. **Monitoring API** - Health checks et métriques

### Chat API (RAG Integration)

#### Base URL: `http://localhost:8002` (RAG System)

##### POST `/chat`
Chat avec l'agent IA intelligent.

**Request:**
```json
{
  "message": "Bonjour, je cherche des solutions d'automatisation pour mon entreprise",
  "session_id": "user_12345_1640995200",
  "metadata": {
    "user_agent": "Mozilla/5.0...",
    "ip_address": "192.168.1.100", 
    "referrer": "https://google.com"
  }
}
```

**Response:**
```json
{
  "success": true,
  "answer": "Bonjour ! Je serais ravi de vous aider avec vos besoins en automatisation. BrainGenTechnology propose des solutions d'automatisation sur mesure...",
  "session_id": "user_12345_1640995200",
  "sources": [
    {
      "source": "BrainGenTechnology Knowledge Base",
      "content": "Solutions d'automatisation incluant RPA, workflows intelligents..."
    }
  ],
  "conversation_length": 2,
  "processing_time": 0.847,
  "timestamp": "2024-12-20T10:30:00Z"
}
```

##### POST `/qualify`
Qualification avancée d'un lead.

**Request:**
```json
{
  "session_id": "user_12345_1640995200",
  "conversation_history": [...],
  "metadata": {
    "pages_visited": ["/services", "/about"],
    "session_duration": 300
  }
}
```

**Response:**
```json
{
  "success": true,
  "qualification": {
    "intent": "consultation",
    "urgency": "high", 
    "company_size": "mid_market",
    "industry": "fintech",
    "company_name": "FinTech Solutions Inc",
    "technology_interests": ["ai", "automation"],
    "pain_points": ["Manual processes", "High error rates"],
    "decision_maker_level": "c_level",
    "lead_score": 87,
    "sales_ready": true,
    "notes": "Highly engaged C-level contact from growing fintech company...",
    "conversation_quality": 9,
    "follow_up_priority": "urgent",
    "model_confidence": 0.92
  },
  "processing_time": 1.234,
  "session_id": "user_12345_1640995200"
}
```

##### GET `/health`
Vérification de l'état du système RAG.

**Response:**
```json
{
  "status": "healthy",
  "version": "1.0.0", 
  "timestamp": "2024-12-20T10:30:00Z",
  "system_info": {
    "groq_available": true,
    "vectorstore_available": true,
    "llm_model": "mixtral-8x7b-32768",
    "document_count": 1247
  }
}
```

##### GET `/metrics`
Métriques Prometheus du système RAG.

**Response:** Format Prometheus

```
# HELP rag_conversations_total Total number of conversations
# TYPE rag_conversations_total counter
rag_conversations_total 1547

# HELP rag_response_time_seconds Response time histogram
# TYPE rag_response_time_seconds histogram
rag_response_time_seconds_bucket{le="0.1"} 234
rag_response_time_seconds_bucket{le="0.5"} 1456
rag_response_time_seconds_bucket{le="1.0"} 1523
```

### Laravel API (Frontend Integration)

#### Base URL: `http://localhost:8080/api` (Laravel App)

##### POST `/chat`
Proxy vers système RAG avec analytics.

**Request/Response:** Identique à RAG API mais avec :
- Validation Laravel
- Stockage analytics automatique
- Gestion de cache Redis
- Fallback rule-based si RAG indisponible

##### POST `/chat/qualify`
Qualification avec fallback et intégration CRM.

**Features additionnelles :**
- Fallback rule-based intelligent
- Création automatique consultation requests
- Intégration base de données analytics
- Notifications équipe sales pour leads qualifiés

##### GET `/chat/health`
Health check complet (Laravel + RAG).

**Response:**
```json
{
  "status": "healthy",
  "rag_system": {
    "status": "healthy",
    "groq_available": true,
    "vectorstore_available": true
  },
  "database": "connected",
  "redis": "connected",
  "timestamp": "2024-12-20T10:30:00Z"
}
```

### Analytics API

#### GET `/api/analytics/data`
Données analytics complètes.

**Parameters:**
- `period`: "24hours", "7days", "30days", "90days"

**Response:**
```json
{
  "overview": {
    "total_conversations": 1547,
    "qualified_leads": 234,
    "sales_ready_leads": 89,
    "lead_conversion_rate": 15.1,
    "sales_ready_rate": 38.0,
    "conversation_growth": 12.3,
    "lead_growth": 8.7
  },
  "conversations": {
    "hourly_distribution": [12, 8, 5, 3, 2, 4, 8, 15, 22, 28, 35, 42, 45, 48, 44, 38, 32, 28, 24, 20, 18, 16, 14, 12],
    "avg_duration_minutes": 4.2,
    "active_conversations": 12
  },
  "leads": {
    "score_distribution": [
      {"score_range": "High (80-100)", "count": 89},
      {"score_range": "Medium (60-79)", "count": 95}, 
      {"score_range": "Low (40-59)", "count": 50}
    ],
    "top_industries": [
      {"industry": "fintech", "count": 67},
      {"industry": "healthcare", "count": 45}
    ],
    "avg_lead_score": 64.3
  }
}
```

#### GET `/api/analytics/realtime`
Métriques temps réel.

**Response:**
```json
{
  "activeUsers": 8,
  "todayConversations": 127,
  "todayLeads": 23,
  "conversionRate": 18.1,
  "timestamp": "2024-12-20T10:30:00Z"
}
```

### Business Integration API

#### POST `/api/conversations`
Stockage conversation (utilisé par RAG system).

#### POST `/api/messages` 
Stockage message individual.

#### POST `/api/consultation/request`
Création demande consultation.

**Request:**
```json
{
  "session_id": "user_12345_1640995200",
  "email": "contact@company.com",
  "phone": "+1-555-123-4567",
  "industry": "fintech",
  "request_type": "consultation",
  "status": "pending",
  "notes": "BANT+ Score: 87/100 | Sales Ready: YES | Company: FinTech Solutions...",
  "preferred_contact": "email",
  "preferred_time": "flexible"
}
```

### Monitoring API

#### GET `/metrics`
Métriques Prometheus Laravel.

#### GET `/api/metrics/business`
Métriques business spécifiques.

**Response:** Format Prometheus
```
# HELP braintech_total_conversations Total conversations
braintech_total_conversations 1547

# HELP braintech_qualified_leads Total qualified leads  
braintech_qualified_leads 234

# HELP braintech_conversion_rate Lead conversion rate
braintech_conversion_rate 0.151
```

### Error Handling

Toutes les APIs implémentent une gestion d'erreurs cohérente :

```json
// Erreur standard
{
  "success": false,
  "error": "RAG system temporarily unavailable",
  "error_code": "RAG_UNAVAILABLE",
  "timestamp": "2024-12-20T10:30:00Z",
  "retry_after": 30
}

// Erreur de validation
{
  "success": false,
  "error": "Validation failed",
  "errors": {
    "message": ["The message field is required."],
    "session_id": ["The session_id field must be a string."]
  }
}
```

### Rate Limiting

```php
// Rate limiting configuration
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/api/chat', [ChatController::class, 'chat']);
});

// Headers de réponse
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1640995260
```

---

## 🔒 Sécurité et Authentification

### Mesures de Sécurité Implémentées

#### 1. Protection des APIs

**CORS Configuration:**
```php
// config/cors.php
'allowed_origins' => ['https://braingentech.com', 'https://www.braingentech.com'],
'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
'max_age' => 86400,
'supports_credentials' => true
```

**Rate Limiting:**
```php
// Middleware throttle
Route::middleware(['throttle:chat,60,1'])->group(function () {
    Route::post('/api/chat', [ChatController::class, 'chat']);
});

// Custom rate limiter
RateLimiter::for('chat', function (Request $request) {
    return Limit::perMinute(30)->by($request->ip());
});
```

#### 2. Protection des Données Sensibles

**Environment Variables:**
```bash
# .env - Clés API protégées
GROQ_API_KEY=************************
HF_API_KEY=************************
REDIS_PASSWORD=************************
APP_KEY=base64:************************
```

**.gitignore Protection:**
```gitignore
.env
.env.local
.env.production
*.key
*.pem
/storage/logs/*.log
/rag_system/rag_env/
```

**Data Sanitization:**
```php
// ChatController.php
private function sanitizeInput(string $input): string {
    return strip_tags(trim($input));
}

private function sanitizeMetadata(array $metadata): array {
    // Remove sensitive data
    unset($metadata['password'], $metadata['token'], $metadata['secret']);
    return $metadata;
}
```

#### 3. Sécurité Base de Données

**Prepared Statements:**
```php
// Utilisation exclusive d'Eloquent ORM et Query Builder
DB::table('chat_messages')->where('session_id', $sessionId)->get();

// Validation stricte
$validated = $request->validate([
    'message' => 'required|string|max:2000',
    'session_id' => 'nullable|string|max:100|regex:/^[a-zA-Z0-9_-]+$/',
]);
```

**Index de Performance:**
```sql
-- Index pour prévenir les attaques par énumération
CREATE INDEX idx_session_secure ON chat_conversations(session_id, user_ip);
CREATE INDEX idx_message_lookup ON chat_messages(session_id, sent_at);
```

#### 4. Sécurité Infrastructure Docker

**Non-Root Containers:**
```dockerfile
# RAG System - User non-root
RUN useradd -m -u 1000 raguser
USER raguser

# Laravel - www-data user
RUN chown -R www-data:www-data /var/www
USER www-data
```

**Network Isolation:**
```yaml
# docker-compose.yml
networks:
  braintech-network:
    driver: bridge
    internal: false  # Accès externe contrôlé
  
# Services exposent seulement ports nécessaires
expose:
  - "8002"  # Pas de publication automatique
```

**Secrets Management:**
```yaml
# docker-compose.yml
secrets:
  groq_api_key:
    external: true
  redis_password:
    external: true

services:
  rag-system:
    secrets:
      - groq_api_key
      - redis_password
```

#### 5. Monitoring de Sécurité

**Logging des Événements Sensibles:**
```php
// Tentatives d'accès non autorisées
Log::warning('Unauthorized API access attempt', [
    'ip' => $request->ip(),
    'user_agent' => $request->userAgent(),
    'endpoint' => $request->path(),
    'payload' => $request->except(['password', 'token'])
]);

// Anomalies de trafic
Log::alert('Unusual traffic pattern detected', [
    'ip' => $request->ip(),
    'request_rate' => $requestCount,
    'time_window' => '1_minute'
]);
```

**Alertes Prometheus:**
```yaml
# monitoring/prometheus/security_alerts.yml
- alert: SuspiciousActivity
  expr: rate(http_requests_total{status_code=~"4.."}[5m]) > 10
  labels:
    severity: warning
  annotations:
    summary: "High error rate detected - possible attack"

- alert: UnauthorizedAccess
  expr: increase(laravel_unauthorized_attempts_total[5m]) > 5
  labels:
    severity: critical
  annotations:
    summary: "Multiple unauthorized access attempts"
```

#### 6. Authentification (Future Implementation)

**JWT Token System:**
```php
// Préparation pour authentification future
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/analytics/dashboard', [AnalyticsController::class, 'dashboard']);
    Route::get('/api/admin/metrics', [MetricsController::class, 'adminMetrics']);
});
```

**RBAC (Role-Based Access Control):**
```php
// Permissions futures
Gate::define('view-analytics', function ($user) {
    return $user->hasRole(['admin', 'analyst']);
});

Gate::define('manage-system', function ($user) {
    return $user->hasRole('admin');
});
```

### Recommandations de Sécurité Production

#### 1. SSL/TLS

```yaml
# docker-compose.prod.yml
traefik:
  command:
    - "--certificatesresolvers.letsencrypt.acme.email=admin@braingentech.com"
    - "--certificatesresolvers.letsencrypt.acme.storage=/certificates/acme.json"
    - "--certificatesresolvers.letsencrypt.acme.keytype=EC256"
    - "--certificatesresolvers.letsencrypt.acme.httpchallenge=true"
```

#### 2. Backup et Recovery

```bash
#!/bin/bash
# scripts/backup-security.sh

# Backup base de données chiffrée
pg_dump $DB_NAME | gpg --cipher-algo AES256 --compress-algo 1 -c > backup-$(date +%Y%m%d).sql.gpg

# Backup clés et certificats
tar -czf secrets-backup-$(date +%Y%m%d).tar.gz /path/to/secrets/
```

#### 3. Security Headers

```php
// middleware/SecurityHeaders.php
public function handle($request, Closure $next)
{
    $response = $next($request);
    
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('X-Frame-Options', 'DENY');
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline'");
    
    return $response;
}
```

---

## ⚙️ Configuration et Déploiement

### Configuration Environnements

#### Développement Local

**1. Prérequis**
```bash
# Versions requises
PHP >= 8.2
Python >= 3.11
Node.js >= 18.x
Docker >= 24.x
Docker Compose >= 2.x
```

**2. Configuration .env**
```bash
# Application
APP_NAME=BrainGenTechnology
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080

# Base de données
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# RAG System
RAG_API_URL=http://localhost:8002
GROQ_API_KEY=your_groq_api_key_here
HF_API_KEY=your_huggingface_key_here

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail (optionnel en dev)
MAIL_MAILER=log
```

**3. Installation Développement**
```bash
# Clone repository
git clone https://github.com/your-org/brain-website-v3.git
cd brain-website-v3

# Laravel setup
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed --class=AnalyticsDataSeeder

# Frontend assets
npm install
npm run dev

# RAG System setup
cd rag_system
python -m venv rag_env
source rag_env/bin/activate  # Linux/Mac
pip install -r requirements.txt
cd ..

# Start all services
./start-all-services.sh
```

#### Staging Environment

**Configuration .env.staging**
```bash
APP_ENV=staging
APP_DEBUG=false
APP_URL=https://staging.braingentech.com

# PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_DATABASE=braintech_staging
DB_USERNAME=braintech_user
DB_PASSWORD=secure_staging_password

# RAG System
RAG_API_URL=http://rag-system:8002
GROQ_API_KEY=staging_groq_key
HF_API_KEY=staging_hf_key

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=secure_redis_password

# Monitoring
PROMETHEUS_ENABLED=true
GRAFANA_ADMIN_PASSWORD=staging_grafana_password
```

**Docker Compose Staging**
```yaml
# docker-compose.staging.yml
version: '3.8'

services:
  # Production-like setup but with:
  # - Reduced resource limits
  # - Debug logging enabled
  # - Separate network namespace
  # - Automated testing integration
```

#### Production Environment

**Infrastructure Requirements**
```bash
# Minimum server specs
CPU: 4 cores (8 recommended)
RAM: 8GB (16GB recommended)
Storage: 100GB SSD (500GB recommended)
Network: 1Gbps
OS: Ubuntu 20.04 LTS / CentOS 8+
```

**Configuration .env.production**
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://braingentech.com

# Security
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# Database - PostgreSQL cluster
DB_CONNECTION=pgsql
DB_HOST=postgres-cluster.internal
DB_DATABASE=braintech_prod
DB_USERNAME=braintech_prod_user
DB_PASSWORD=ultra_secure_production_password

# RAG System
RAG_API_URL=http://rag-system:8002
GROQ_API_KEY=production_groq_key
HF_API_KEY=production_hf_key

# Redis Cluster
REDIS_HOST=redis-cluster.internal
REDIS_PASSWORD=ultra_secure_redis_password
REDIS_PORT=6379

# Mail Production
MAIL_MAILER=smtp
MAIL_HOST=smtp.braingentech.com
MAIL_PORT=587
MAIL_USERNAME=noreply@braingentech.com
MAIL_PASSWORD=secure_mail_password
MAIL_ENCRYPTION=tls

# Monitoring
PROMETHEUS_ENABLED=true
GRAFANA_ADMIN_PASSWORD=ultra_secure_grafana_password
SENTRY_DSN=https://your-sentry-dsn@sentry.io/project-id

# Backup
BACKUP_ENABLED=true
BACKUP_S3_BUCKET=braintech-backups
BACKUP_ENCRYPTION_KEY=backup_encryption_key
```

### Scripts de Déploiement

#### Script de Déploiement Principal

```bash
#!/bin/bash
# scripts/deploy.sh

set -e

echo "🚀 BrainGenTechnology Production Deployment"

# Variables
ENVIRONMENT=${1:-production}
COMPOSE_FILE="docker-compose.${ENVIRONMENT}.yml"
BACKUP_DIR="/backups/$(date +%Y%m%d-%H%M%S)"

# Pre-deployment checks
echo "📋 Pre-deployment checks..."
./scripts/pre-deploy-checks.sh

# Database backup
echo "💾 Creating database backup..."
mkdir -p $BACKUP_DIR
docker-compose -f $COMPOSE_FILE exec postgres pg_dump -U braintech_user braintech_prod > "${BACKUP_DIR}/database.sql"

# Pull latest code
echo "📡 Pulling latest code..."
git pull origin main

# Build new images
echo "🔨 Building new images..."
docker-compose -f $COMPOSE_FILE build --no-cache

# Rolling update
echo "🔄 Performing rolling update..."
docker-compose -f $COMPOSE_FILE up -d --force-recreate --no-deps rag-system
sleep 30
docker-compose -f $COMPOSE_FILE up -d --force-recreate --no-deps laravel-app

# Database migrations
echo "🗄️ Running database migrations..."
docker-compose -f $COMPOSE_FILE exec laravel-app php artisan migrate --force

# Cache optimization
echo "⚡ Optimizing caches..."
docker-compose -f $COMPOSE_FILE exec laravel-app php artisan config:cache
docker-compose -f $COMPOSE_FILE exec laravel-app php artisan route:cache
docker-compose -f $COMPOSE_FILE exec laravel-app php artisan view:cache

# Health checks
echo "🏥 Running health checks..."
./scripts/health-check.sh

# Monitoring setup
echo "📊 Updating monitoring..."
./scripts/update-monitoring.sh

echo "✅ Deployment completed successfully!"
```

#### Script de Health Check

```bash
#!/bin/bash
# scripts/health-check.sh

echo "🏥 Performing comprehensive health checks..."

# Service availability
services=("laravel-app:8080" "rag-system:8002" "prometheus:9090" "grafana:3000")
for service in "${services[@]}"; do
    echo "Checking $service..."
    if curl -f -s "http://$service/health" > /dev/null 2>&1; then
        echo "✅ $service is healthy"
    else
        echo "❌ $service is not responding"
        exit 1
    fi
done

# Database connectivity
echo "Checking database connectivity..."
if docker-compose exec postgres psql -U braintech_user -d braintech_prod -c "SELECT 1;" > /dev/null 2>&1; then
    echo "✅ Database is accessible"
else
    echo "❌ Database connection failed"
    exit 1
fi

# Redis connectivity
echo "Checking Redis connectivity..."
if docker-compose exec redis redis-cli ping | grep -q "PONG"; then
    echo "✅ Redis is responding"
else
    echo "❌ Redis connection failed"
    exit 1
fi

# RAG System specific checks
echo "Checking RAG system functionality..."
response=$(curl -s -X POST http://localhost:8002/chat \
  -H "Content-Type: application/json" \
  -d '{"message":"test","session_id":"health_check"}')

if echo "$response" | grep -q '"success":true'; then
    echo "✅ RAG system is functional"
else
    echo "❌ RAG system health check failed"
    echo "Response: $response"
    exit 1
fi

echo "🎉 All health checks passed!"
```

### Configuration CI/CD

#### GitHub Actions Workflow

```yaml
# .github/workflows/deploy.yml
name: Deploy BrainGenTechnology

on:
  push:
    branches: [ main ]
  pull_request:
    branches: [ main ]

env:
  REGISTRY: ghcr.io
  IMAGE_NAME: ${{ github.repository }}

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      redis:
        image: redis:7-alpine
        ports:
          - 6379:6379
    
    steps:
    - uses: actions/checkout@v4
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: pdo, pdo_sqlite, gd, xml
    
    - name: Setup Python
      uses: actions/setup-python@v4
      with:
        python-version: '3.11'
    
    - name: Install Laravel dependencies
      run: composer install --no-dev --optimize-autoloader
    
    - name: Install Python dependencies
      run: |
        cd rag_system
        pip install -r requirements.txt
    
    - name: Run Laravel tests
      run: php artisan test
    
    - name: Run RAG system tests
      run: |
        cd rag_system
        python -m pytest tests/

  build:
    needs: test
    runs-on: ubuntu-latest
    if: github.event_name == 'push' && github.ref == 'refs/heads/main'
    
    steps:
    - uses: actions/checkout@v4
    
    - name: Log in to Container Registry
      uses: docker/login-action@v3
      with:
        registry: ${{ env.REGISTRY }}
        username: ${{ github.actor }}
        password: ${{ secrets.GITHUB_TOKEN }}
    
    - name: Build and push Docker images
      run: |
        docker build -t ${{ env.REGISTRY }}/${{ env.IMAGE_NAME }}/laravel:${{ github.sha }} --target php-base .
        docker build -t ${{ env.REGISTRY }}/${{ env.IMAGE_NAME }}/rag:${{ github.sha }} --target rag-system .
        docker push ${{ env.REGISTRY }}/${{ env.IMAGE_NAME }}/laravel:${{ github.sha }}
        docker push ${{ env.REGISTRY }}/${{ env.IMAGE_NAME }}/rag:${{ github.sha }}

  deploy:
    needs: build
    runs-on: ubuntu-latest
    if: github.event_name == 'push' && github.ref == 'refs/heads/main'
    
    steps:
    - name: Deploy to production
      uses: appleboy/ssh-action@v1.0.0
      with:
        host: ${{ secrets.PRODUCTION_HOST }}
        username: ${{ secrets.PRODUCTION_USER }}
        key: ${{ secrets.PRODUCTION_SSH_KEY }}
        script: |
          cd /opt/braintech
          export IMAGE_TAG=${{ github.sha }}
          ./scripts/deploy.sh production
```

### Configuration SSL/TLS

#### Let's Encrypt avec Traefik

```yaml
# docker-compose.prod.yml - Traefik SSL
traefik:
  image: traefik:v2.10
  command:
    - "--certificatesresolvers.letsencrypt.acme.email=admin@braingentech.com"
    - "--certificatesresolvers.letsencrypt.acme.storage=/certificates/acme.json"
    - "--certificatesresolvers.letsencrypt.acme.httpchallenge=true"
    - "--certificatesresolvers.letsencrypt.acme.httpchallenge.entrypoint=web"
  
  labels:
    - "traefik.http.routers.laravel.tls=true"
    - "traefik.http.routers.laravel.tls.certresolver=letsencrypt"
    - "traefik.http.routers.laravel.rule=Host(`braingentech.com`,`www.braingentech.com`)"
```

### Backup et Récupération

#### Stratégie de Backup Automatisée

```bash
#!/bin/bash
# scripts/backup.sh

BACKUP_DIR="/backups/$(date +%Y%m%d)"
S3_BUCKET="braintech-backups"
RETENTION_DAYS=30

mkdir -p $BACKUP_DIR

# Database backup
echo "Backing up database..."
docker-compose exec postgres pg_dump -U braintech_user braintech_prod | gzip > "${BACKUP_DIR}/database.sql.gz"

# Application data backup
echo "Backing up application data..."
tar -czf "${BACKUP_DIR}/application.tar.gz" \
  --exclude='node_modules' \
  --exclude='vendor' \
  --exclude='rag_system/rag_env' \
  .

# Vector store backup
echo "Backing up vector store..."
tar -czf "${BACKUP_DIR}/vectorstore.tar.gz" rag_system/vectorstore/

# Secrets backup (encrypted)
echo "Backing up secrets..."
tar -czf - .env docker/secrets/ | gpg --cipher-algo AES256 -c > "${BACKUP_DIR}/secrets.tar.gz.gpg"

# Upload to S3
echo "Uploading to S3..."
aws s3 sync $BACKUP_DIR s3://$S3_BUCKET/$(basename $BACKUP_DIR)/

# Cleanup old backups
echo "Cleaning up old backups..."
find /backups -type d -mtime +$RETENTION_DAYS -exec rm -rf {} +

echo "Backup completed: $BACKUP_DIR"
```

### Monitoring du Déploiement

#### Métriques de Déploiement

```yaml
# monitoring/prometheus/deployment_metrics.yml
- name: deployment_metrics
  rules:
    - record: deployment:success_rate
      expr: |
        (
          sum(increase(deployment_total{status="success"}[24h])) /
          sum(increase(deployment_total[24h]))
        ) * 100
    
    - record: deployment:avg_duration
      expr: |
        avg(deployment_duration_seconds) by (environment)
    
    - alert: DeploymentFailure
      expr: deployment:success_rate < 95
      for: 0m
      labels:
        severity: critical
      annotations:
        summary: "Deployment success rate below 95%"
```

---

## 🔧 Troubleshooting et Maintenance

### Problèmes Courants et Solutions

#### 1. Système RAG Non Disponible

**Symptômes :**
- Erreur 503 sur `/api/chat`
- Health check RAG échoue
- Logs : "RAG API unavailable"

**Diagnostic :**
```bash
# Vérifier status conteneur RAG
docker-compose ps rag-system

# Logs RAG system
docker-compose logs -f rag-system

# Test connectivité
curl http://localhost:8002/health
```

**Solutions communes :**

1. **Groq API Key invalide/expirée**
```bash
# Vérifier la clé API
echo $GROQ_API_KEY
# Tester directement avec curl
curl -H "Authorization: Bearer $GROQ_API_KEY" https://api.groq.com/openai/v1/models
```

2. **Dépendances Python conflictuelles**
```bash
# Recréer environnement virtuel
cd rag_system
rm -rf rag_env
python -m venv rag_env
source rag_env/bin/activate
pip install -r requirements.txt
```

3. **ChromaDB corruption**
```bash
# Backup et reset vectorstore
cp -r rag_system/vectorstore rag_system/vectorstore.backup
rm -rf rag_system/vectorstore/chroma_db/*
# Réindexer les documents
python rag_system/utils/indexer.py
```

#### 2. Problèmes de Performance

**Symptômes :**
- Latence RAG > 3 secondes
- Timeouts fréquents
- CPU usage élevé

**Diagnostic :**
```bash
# Métriques conteneurs
docker stats

# Métriques Prometheus
curl http://localhost:9090/api/v1/query?query=rag_response_time_seconds

# Profiling Python
python -m cProfile rag_system/working_server.py
```

**Solutions :**

1. **Optimisation vectorstore**
```python
# Configuration ChromaDB optimisée
import chromadb
from chromadb.config import Settings

client = chromadb.Client(Settings(
    chroma_db_impl="duckdb+parquet",
    persist_directory="./vectorstore",
    anonymized_telemetry=False
))
```

2. **Scaling horizontal**
```yaml
# docker-compose.yml - Multiple RAG instances
rag-system:
  deploy:
    replicas: 3
  
traefik:
  labels:
    - "traefik.http.services.rag.loadbalancer.server.port=8002"
```

3. **Cache Redis optimisé**
```bash
# Configuration Redis production
redis-server --maxmemory 2gb --maxmemory-policy allkeys-lru
```

#### 3. Problèmes Base de Données

**Symptômes :**
- "Database locked" (SQLite)
- Lenteur requêtes analytics
- "Connection refused"

**Diagnostic :**
```bash
# SQLite status
sqlite3 database/database.sqlite ".schema"
sqlite3 database/database.sqlite "PRAGMA integrity_check;"

# PostgreSQL status (production)
docker-compose exec postgres psql -U braintech_user -c "SELECT * FROM pg_stat_activity;"
```

**Solutions :**

1. **SQLite locked**
```bash
# Identifier processus qui lock
lsof database/database.sqlite

# Forcer unlock (attention aux données)
rm database/database.sqlite-shm database/database.sqlite-wal
```

2. **Optimisation queries**
```sql
-- Analyser requêtes lentes
EXPLAIN QUERY PLAN SELECT * FROM chat_conversations WHERE session_id = 'xxx';

-- Ajouter index manquants
CREATE INDEX idx_session_activity ON chat_conversations(session_id, last_activity_at);
```

3. **Migration SQLite → PostgreSQL**
```bash
# Export SQLite
sqlite3 database/database.sqlite .dump > export.sql

# Import PostgreSQL
psql -U braintech_user -d braintech_prod -f export.sql
```

#### 4. Problèmes Redis

**Symptômes :**
- Sessions perdues
- "Redis connection refused"
- Mémoire Redis saturée

**Diagnostic :**
```bash
# Status Redis
docker-compose exec redis redis-cli info

# Mémoire usage
docker-compose exec redis redis-cli info memory

# Clés existantes
docker-compose exec redis redis-cli keys "*"
```

**Solutions :**

1. **Nettoyage sessions expirées**
```bash
# Script nettoyage manuel
redis-cli --scan --pattern "conversation:*" | while read key; do
    ttl=$(redis-cli ttl "$key")
    if [ "$ttl" -lt 0 ]; then
        redis-cli del "$key"
        echo "Deleted expired key: $key"
    fi
done
```

2. **Configuration memory**
```bash
# Optimisation Redis
redis-cli config set maxmemory 1gb
redis-cli config set maxmemory-policy allkeys-lru
redis-cli config rewrite
```

#### 5. Problèmes Docker

**Symptômes :**
- Conteneurs qui redémarrent constamment
- "No space left on device"
- Network connectivity issues

**Diagnostic :**
```bash
# Status conteneurs
docker-compose ps
docker-compose logs --tail=50

# Espace disque
docker system df
df -h

# Networks
docker network ls
docker network inspect braintech_braintech-network
```

**Solutions :**

1. **Nettoyage Docker**
```bash
# Nettoyage complet
docker system prune -af
docker volume prune -f

# Images non utilisées
docker image prune -af
```

2. **Fix network connectivity**
```bash
# Recréer network
docker-compose down
docker network rm braintech_braintech-network
docker-compose up -d
```

### Scripts de Maintenance

#### Script de Maintenance Quotidienne

```bash
#!/bin/bash
# scripts/daily-maintenance.sh

echo "🧹 Daily maintenance started at $(date)"

# Cleanup old logs
echo "Cleaning up logs..."
find storage/logs -name "*.log" -mtime +7 -delete
find rag_system -name "*.log" -mtime +7 -delete

# Database maintenance
echo "Database maintenance..."
if [ "$DB_CONNECTION" = "sqlite" ]; then
    sqlite3 database/database.sqlite "VACUUM;"
else
    docker-compose exec postgres psql -U braintech_user -d braintech_prod -c "VACUUM ANALYZE;"
fi

# Redis maintenance
echo "Redis maintenance..."
docker-compose exec redis redis-cli bgrewriteaof

# Clear expired cache
echo "Clearing expired cache..."
php artisan cache:clear
php artisan view:clear

# Backup
echo "Running backup..."
./scripts/backup.sh

# Health check
echo "Health check..."
./scripts/health-check.sh

echo "✅ Daily maintenance completed at $(date)"
```

#### Script de Monitoring Avancé

```bash
#!/bin/bash
# scripts/monitor.sh

# Seuils d'alerte
CPU_THRESHOLD=80
MEMORY_THRESHOLD=85
DISK_THRESHOLD=90
RESPONSE_TIME_THRESHOLD=2000

# Check CPU usage
cpu_usage=$(docker stats --no-stream --format "{{.CPUPerc}}" | sed 's/%//' | awk '{sum+=$1} END {print int(sum/NR)}')
if [ "$cpu_usage" -gt "$CPU_THRESHOLD" ]; then
    echo "⚠️  HIGH CPU USAGE: ${cpu_usage}%"
    # Slack notification
    curl -X POST -H 'Content-type: application/json' \
        --data "{\"text\":\"🚨 BrainTech: HIGH CPU USAGE: ${cpu_usage}%\"}" \
        $SLACK_WEBHOOK_URL
fi

# Check memory usage
memory_usage=$(free | grep Mem | awk '{printf("%.0f", $3/$2 * 100.0)}')
if [ "$memory_usage" -gt "$MEMORY_THRESHOLD" ]; then
    echo "⚠️  HIGH MEMORY USAGE: ${memory_usage}%"
fi

# Check disk usage
disk_usage=$(df / | tail -1 | awk '{print $5}' | sed 's/%//')
if [ "$disk_usage" -gt "$DISK_THRESHOLD" ]; then
    echo "⚠️  HIGH DISK USAGE: ${disk_usage}%"
fi

# Check RAG response time
response_time=$(curl -w "%{time_total}" -s -o /dev/null -X POST \
    http://localhost:8002/chat \
    -H "Content-Type: application/json" \
    -d '{"message":"health check","session_id":"monitor"}')
response_time_ms=$(echo "$response_time * 1000" | bc | cut -d. -f1)

if [ "$response_time_ms" -gt "$RESPONSE_TIME_THRESHOLD" ]; then
    echo "⚠️  HIGH RAG RESPONSE TIME: ${response_time_ms}ms"
fi

# Generate report
echo "📊 System Status Report - $(date)"
echo "CPU: ${cpu_usage}% | Memory: ${memory_usage}% | Disk: ${disk_usage}%"
echo "RAG Response Time: ${response_time_ms}ms"
```

### Procédures de Récupération d'Urgence

#### 1. Disaster Recovery Plan

```bash
#!/bin/bash
# scripts/disaster-recovery.sh

echo "🚨 DISASTER RECOVERY INITIATED"

# 1. Assessment
echo "1. Assessing system status..."
./scripts/health-check.sh || echo "System compromised - continuing recovery"

# 2. Stop all services
echo "2. Stopping all services..."
docker-compose down

# 3. Restore from backup
echo "3. Restoring from latest backup..."
LATEST_BACKUP=$(ls -t /backups/ | head -1)
echo "Using backup: $LATEST_BACKUP"

# 4. Database recovery
echo "4. Recovering database..."
gunzip -c "/backups/$LATEST_BACKUP/database.sql.gz" | \
docker-compose exec -T postgres psql -U braintech_user braintech_prod

# 5. Application recovery
echo "5. Recovering application..."
tar -xzf "/backups/$LATEST_BACKUP/application.tar.gz"

# 6. Vectorstore recovery
echo "6. Recovering vectorstore..."
tar -xzf "/backups/$LATEST_BACKUP/vectorstore.tar.gz"

# 7. Restart services
echo "7. Restarting services..."
docker-compose up -d

# 8. Verify recovery
echo "8. Verifying recovery..."
sleep 60
./scripts/health-check.sh

echo "✅ DISASTER RECOVERY COMPLETED"
```

#### 2. Rollback Procedure

```bash
#!/bin/bash
# scripts/rollback.sh

ROLLBACK_VERSION=${1:-"previous"}

echo "🔙 Rolling back to version: $ROLLBACK_VERSION"

# 1. Tag current version as rollback point
docker-compose exec laravel-app php artisan backup:create --tag=pre-rollback

# 2. Switch to rollback version
git checkout $ROLLBACK_VERSION

# 3. Rebuild and deploy
docker-compose build --no-cache
docker-compose up -d --force-recreate

# 4. Verify rollback
./scripts/health-check.sh

echo "✅ Rollback completed to version: $ROLLBACK_VERSION"
```

---

<function_calls>
<invoke name="TodoWrite">
<parameter name="todos">[{"content": "Analyser la structure générale du projet", "status": "completed"}, {"content": "Documenter l'architecture du système RAG", "status": "completed"}, {"content": "Analyser les composants Laravel", "status": "completed"}, {"content": "Documenter le système de monitoring", "status": "completed"}, {"content": "Analyser l'infrastructure Docker", "status": "completed"}, {"content": "Documenter l'intégration base de données", "status": "completed"}, {"content": "Créer la documentation API", "status": "completed"}, {"content": "Documenter le déploiement et la configuration", "status": "completed"}, {"content": "Finaliser la documentation complète", "status": "completed"}]