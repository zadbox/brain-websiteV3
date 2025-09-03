Here are the commands to start your applications
  locally and with Docker:

  🏠 Local Development Setup

  1. Start All Services (Automated)

  cd /Users/abderrahim_boussyf/brain-website___V3
  ./start-all-services.sh

  2. Manual Local Setup

  Step 1: Laravel Application

  cd /Users/abderrahim_boussyf/brain-website___V3

  # Install dependencies
  composer install --no-dev

  # Setup environment
  cp .env.example .env
  php artisan key:generate

  # Setup database
  touch database/database.sqlite
  php artisan migrate

  # Start Laravel server
  php artisan serve --port=8000

  Step 2: RAG System

  cd /Users/abderrahim_boussyf/brain-website___V3/r
  ag_system

  # Activate conda environment
  conda activate Elect_24

  # Start RAG server
  python working_server.py

  Step 3: Monitoring Stack (Optional)

  cd /Users/abderrahim_boussyf/brain-website___V3/m
  onitoring
  docker-compose up -d

  3. Quick Start Commands

  # Terminal 1: Laravel
  cd /Users/abderrahim_boussyf/brain-website___V3
  && php artisan serve --port=8000

  # Terminal 2: RAG Server  
  cd /Users/abderrahim_boussyf/brain-website___V3/r
  ag_system && conda activate Elect_24 && python
  working_server.py

  # Terminal 3: Monitoring (optional)
  cd /Users/abderrahim_boussyf/brain-website___V3/m
  onitoring && docker compose up -d

  🐳 Docker Setup

  1. Full Docker Stack

  cd /Users/abderrahim_boussyf/brain-website___V3
  docker-compose up -d

  2. Individual Docker Services

  # Laravel app only
  docker-compose up -d laravel-app

  # RAG system only  
  docker-compose up -d rag-system

  # Monitoring stack only
  cd monitoring && docker-compose up -d

  3. Docker with Build

  # Rebuild and start
  docker-compose up -d --build

  # Force recreate containers
  docker-compose up -d --force-recreate

  📋 Service URLs

  Local Development

  - Website: http://localhost:8000
  - Analytics Dashboard:
  http://localhost:8000/analytics/dashboard
  - RAG API: http://localhost:8002/health
  - Grafana Monitoring: http://localhost:3000
  (admin/admin123)

  Docker

  - Website: http://localhost:80
  - Analytics Dashboard:
  http://localhost:80/analytics/dashboard
  - RAG API: http://localhost:8002/health
  - Grafana Monitoring: http://localhost:3000

  🔧 Useful Commands

  Check Service Status

  # Check if services are running
  lsof -i :8000  # Laravel
  lsof -i :8002  # RAG Server
  lsof -i :3000  # Grafana

  # Health checks
  curl http://localhost:8000/api/chat/health
  curl http://localhost:8002/health

  Stop Services

  # Stop Laravel
  pkill -f "php.*artisan.*serve"

  # Stop RAG server
  pkill -f "python.*working_server.py"

  # Stop Docker
  docker-compose down

  Logs

  # RAG server logs
  tail -f logs/rag-server.log

  # Laravel logs  
  tail -f storage/logs/laravel.log

  # Docker logs
  docker-compose logs -f

  🚀 Recommended Startup Sequence

  # 1. Quick local start (recommended)
  cd /Users/abderrahim_boussyf/brain-website___V3
  ./start-all-services.sh

  # 2. Or manual start in separate terminals:
  # Terminal 1:
  php artisan serve --port=8000

  # Terminal 2:  
  conda activate Elect_24 && cd rag_system &&
  python working_server.py

  # Terminal 3 (optional monitoring):
  cd monitoring && docker-compose up -d

  The automated script ./start-all-services.sh
  handles the conda environment activation and
  starts both Laravel and RAG services
  automatically!
