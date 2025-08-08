#!/bin/bash

# BrainGenTechnology DevOps Deployment Script
# Deploys the complete monitoring stack with Prometheus + Grafana

set -e  # Exit on any error

echo "🚀 Starting BrainGenTechnology DevOps Deployment..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
PROJECT_NAME="braintech"
NETWORK_NAME="${PROJECT_NAME}-network"

# Functions
log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check prerequisites
check_prerequisites() {
    log_info "Checking prerequisites..."
    
    # Check Docker
    if ! command -v docker &> /dev/null; then
        log_error "Docker is not installed. Please install Docker first."
        exit 1
    fi
    
    # Check Docker Compose (both v1 and v2)
    if ! command -v docker-compose &> /dev/null && ! docker compose version &> /dev/null; then
        log_error "Docker Compose is not installed. Please install Docker Compose first."
        exit 1
    fi
    
    # Check if .env file exists
    if [ ! -f .env ]; then
        log_warn ".env file not found. Creating from .env.monitoring template..."
        cp .env.monitoring .env
        log_warn "Please edit .env file with your configuration before continuing."
        read -p "Press Enter to continue after editing .env file..."
    fi
    
    log_info "Prerequisites check completed ✅"
}

# Setup directories and permissions
setup_directories() {
    log_info "Setting up directories and permissions..."
    
    # Create required directories
    mkdir -p database
    mkdir -p storage/logs
    mkdir -p monitoring/grafana/data
    mkdir -p monitoring/prometheus/data
    mkdir -p rag_system/vectorstore
    
    # Create SQLite database if it doesn't exist
    if [ ! -f database/database.sqlite ]; then
        touch database/database.sqlite
        log_info "Created SQLite database file"
    fi
    
    # Set permissions
    chmod -R 755 storage/
    chmod -R 755 bootstrap/cache/
    chmod 664 database/database.sqlite
    
    log_info "Directories and permissions setup completed ✅"
}

# Build and start services
deploy_services() {
    log_info "Building and starting services..."
    
    # Use docker compose (v2) if available, fallback to docker-compose (v1)
    if docker compose version &> /dev/null; then
        DOCKER_COMPOSE="docker compose"
    else
        DOCKER_COMPOSE="docker-compose"
    fi
    
    # Pull latest images
    $DOCKER_COMPOSE pull
    
    # Build custom images
    $DOCKER_COMPOSE build --no-cache
    
    # Start core services first
    log_info "Starting core services..."
    $DOCKER_COMPOSE up -d redis elasticsearch
    
    # Wait for elasticsearch to be ready
    log_info "Waiting for Elasticsearch to be ready..."
    sleep 30
    
    # Start monitoring services
    log_info "Starting monitoring services..."
    $DOCKER_COMPOSE up -d prometheus grafana node-exporter cadvisor
    
    # Wait for monitoring services
    sleep 15
    
    # Start application services
    log_info "Starting application services..."
    $DOCKER_COMPOSE up -d rag-system laravel-app
    
    # Start remaining services
    log_info "Starting remaining services..."
    $DOCKER_COMPOSE up -d traefik logstash kibana
    
    log_info "Services deployment completed ✅"
}

# Run Laravel setup
setup_laravel() {
    log_info "Setting up Laravel application..."
    
    # Wait for Laravel container to be ready
    sleep 10
    
    # Use same docker compose command as in deploy_services
    if docker compose version &> /dev/null; then
        DOCKER_COMPOSE="docker compose"
    else
        DOCKER_COMPOSE="docker-compose"
    fi
    
    # Run Laravel setup commands inside container
    $DOCKER_COMPOSE exec -T laravel-app composer install --no-dev --optimize-autoloader
    $DOCKER_COMPOSE exec -T laravel-app php artisan key:generate
    $DOCKER_COMPOSE exec -T laravel-app php artisan migrate --force
    $DOCKER_COMPOSE exec -T laravel-app php artisan cache:clear
    $DOCKER_COMPOSE exec -T laravel-app php artisan config:cache
    $DOCKER_COMPOSE exec -T laravel-app php artisan route:cache
    
    log_info "Laravel setup completed ✅"
}

# Verify deployment
verify_deployment() {
    log_info "Verifying deployment..."
    
    # Check service health
    services=("laravel-app" "rag-system" "prometheus" "grafana" "elasticsearch")
    
    # Use same docker compose command
    if docker compose version &> /dev/null; then
        DOCKER_COMPOSE="docker compose"
    else
        DOCKER_COMPOSE="docker-compose"
    fi
    
    for service in "${services[@]}"; do
        if $DOCKER_COMPOSE ps | grep -q "$service.*Up"; then
            log_info "✅ $service is running"
        else
            log_error "❌ $service is not running"
        fi
    done
    
    # Check endpoints
    log_info "Checking endpoint availability..."
    
    sleep 10
    
    # Test endpoints (with retries)
    endpoints=(
        "http://localhost:8080/health:Laravel App"
        "http://localhost:8002/health:RAG System"
        "http://localhost:9090:Prometheus"
        "http://localhost:3000:Grafana"
        "http://localhost:9200:Elasticsearch"
    )
    
    for endpoint in "${endpoints[@]}"; do
        url=$(echo $endpoint | cut -d: -f1)
        name=$(echo $endpoint | cut -d: -f2)
        
        if curl -f -s "$url" > /dev/null; then
            log_info "✅ $name is accessible at $url"
        else
            log_warn "⚠️  $name may not be ready yet at $url"
        fi
    done
}

# Display access information
show_access_info() {
    log_info "🎉 Deployment completed successfully!"
    echo ""
    echo "📊 Access URLs:"
    echo "  • Laravel Application:  http://localhost:8080"
    echo "  • RAG System API:       http://localhost:8002"
    echo "  • Prometheus:           http://localhost:9090"
    echo "  • Grafana:              http://localhost:3000 (admin/admin123)"
    echo "  • Kibana:               http://localhost:5601"
    echo "  • Traefik Dashboard:    http://localhost:8081"
    echo ""
    echo "🔧 Management Commands:"
    echo "  • View logs:            docker-compose logs -f [service-name]"
    echo "  • Stop services:        docker-compose down"
    echo "  • Restart service:      docker-compose restart [service-name]"
    echo "  • Scale service:        docker-compose up -d --scale [service-name]=3"
    echo ""
    echo "📈 Monitoring:"
    echo "  • Metrics endpoint:     http://localhost:8080/metrics"
    echo "  • Business metrics:     http://localhost:8080/api/metrics/business"
    echo "  • Analytics dashboard:  http://localhost:8080/analytics/dashboard"
    echo ""
}

# Cleanup function
cleanup() {
    log_info "Cleaning up..."
    
    # Use same docker compose command
    if docker compose version &> /dev/null; then
        DOCKER_COMPOSE="docker compose"
    else
        DOCKER_COMPOSE="docker-compose"
    fi
    
    $DOCKER_COMPOSE down
    docker system prune -f
    log_info "Cleanup completed"
}

# Main execution
main() {
    case "${1:-deploy}" in
        "deploy")
            check_prerequisites
            setup_directories
            deploy_services
            setup_laravel
            verify_deployment
            show_access_info
            ;;
        "cleanup")
            cleanup
            ;;
        "verify")
            verify_deployment
            ;;
        "restart")
            log_info "Restarting services..."
            
            # Use same docker compose command
            if docker compose version &> /dev/null; then
                DOCKER_COMPOSE="docker compose"
            else
                DOCKER_COMPOSE="docker-compose"
            fi
            
            $DOCKER_COMPOSE restart
            verify_deployment
            ;;
        *)
            echo "Usage: $0 {deploy|cleanup|verify|restart}"
            echo ""
            echo "Commands:"
            echo "  deploy   - Full deployment (default)"
            echo "  cleanup  - Stop and cleanup all services"
            echo "  verify   - Verify deployment status"
            echo "  restart  - Restart all services"
            exit 1
            ;;
    esac
}

# Execute main function with all arguments
main "$@"