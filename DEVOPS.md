# 🚀 BrainGenTechnology DevOps Infrastructure

Complete monitoring and observability stack with Prometheus + Grafana for the RAG system.

## 📋 Overview

This implementation provides a comprehensive DevOps infrastructure including:
- **Containerization**: Docker + Docker Compose
- **Monitoring**: Prometheus + Grafana
- **Logging**: ELK Stack (Elasticsearch, Logstash, Kibana)
- **Reverse Proxy**: Traefik with automatic HTTPS
- **Metrics**: Custom application and business metrics
- **Alerting**: Comprehensive alert rules

## 🏗️ Architecture

```
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│   Laravel App   │───▶│   FastAPI RAG    │───▶│   Groq LLM API  │
│   (Port 8080)   │    │   (Port 8002)    │    │   (External)    │
└─────────────────┘    └──────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│  Nginx + PHP    │    │  Custom Metrics  │    │  Business KPIs  │
│  (Containerized)│    │  (Prometheus)    │    │  (Analytics)    │
└─────────────────┘    └──────────────────┘    └─────────────────┘
         │                       │                       │
         └───────────────────────┼───────────────────────┘
                                 ▼
                    ┌──────────────────────────┐
                    │     Monitoring Stack     │
                    │ Prometheus + Grafana     │
                    │ + ELK + Traefik         │
                    └──────────────────────────┘
```

## 🚀 Quick Start

### 1. Prerequisites
```bash
# Install Docker & Docker Compose
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo curl -L "https://github.com/docker/compose/releases/download/v2.20.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

### 2. Environment Setup
```bash
# Copy environment template
cp .env.monitoring .env

# Edit configuration (required!)
nano .env
# Update: APP_KEY, GROQ_API_KEY, HF_API_KEY, passwords
```

### 3. Deploy Infrastructure
```bash
# Make deployment script executable
chmod +x scripts/deploy.sh

# Full deployment (recommended)
./scripts/deploy.sh deploy

# Or step-by-step
./scripts/deploy.sh verify    # Check status
./scripts/deploy.sh restart   # Restart services
./scripts/deploy.sh cleanup   # Stop and cleanup
```

## 📊 Access URLs

### Application Services
- **Laravel App**: http://localhost:8080
- **RAG API**: http://localhost:8002
- **Analytics Dashboard**: http://localhost:8080/analytics/dashboard

### Monitoring Stack
- **Grafana**: http://localhost:3000 (admin/admin123)
- **Prometheus**: http://localhost:9090
- **Kibana**: http://localhost:5601
- **Traefik Dashboard**: http://localhost:8081

### Metrics Endpoints
- **Laravel Metrics**: http://localhost:8080/metrics
- **RAG Metrics**: http://localhost:8002/metrics
- **Business Metrics**: http://localhost:8080/api/metrics/business

## 🔧 Services Configuration

### Docker Compose Services

| Service | Description | Port | Health Check |
|---------|------------|------|--------------|
| `laravel-app` | Laravel web application | 8080 | `/health` |
| `rag-system` | FastAPI RAG system | 8002 | `/health` |
| `traefik` | Reverse proxy & load balancer | 80, 443, 8081 | Built-in |
| `prometheus` | Metrics collection | 9090 | `/health` |
| `grafana` | Visualization dashboards | 3000 | `/api/health` |
| `elasticsearch` | Log storage | 9200 | `/_cluster/health` |
| `logstash` | Log processing | 5044, 9600 | Built-in |
| `kibana` | Log visualization | 5601 | `/api/status` |
| `redis` | Caching & sessions | 6379 | `PING` |
| `node-exporter` | System metrics | 9100 | `/metrics` |
| `cadvisor` | Container metrics | 8083 | `/healthz` |

## 📈 Monitoring Features

### Prometheus Metrics

#### System Metrics
- CPU, memory, disk usage
- Network I/O and bandwidth
- Container resource consumption
- Service availability and health

#### Application Metrics
- HTTP request/response times
- Database query performance
- Error rates and success ratios
- Session and user metrics

#### RAG System Metrics
- Query processing latency
- Vector search performance
- LLM API response times
- Token usage and costs
- Model confidence scores

#### Business Metrics
- Lead conversion rates
- Conversation quality scores
- Revenue attribution
- Customer engagement metrics

### Grafana Dashboards

#### 1. System Overview Dashboard
- Service health status
- Resource utilization
- Performance metrics
- Alert summary

#### 2. RAG System Dashboard
- AI performance metrics
- Query processing times
- Model accuracy scores
- Business conversions

#### 3. Business Analytics Dashboard
- Lead qualification trends
- Revenue metrics
- Customer journey analysis
- ROI calculations

### Alert Rules

#### Critical Alerts (Immediate Response)
- Application down (>1 minute)
- High error rate (>5% in 5 minutes)
- Database connection failures
- LLM API unavailable

#### Warning Alerts (Monitoring Required)
- High response time (>2 seconds)
- Memory usage >80%
- Low lead conversion rate
- Model confidence drops

## 🔒 Security Considerations

### Network Security
```yaml
Traefik Configuration:
  - Automatic HTTPS with Let's Encrypt
  - Security headers enabled
  - Rate limiting configured

Container Security:
  - Non-root user execution
  - Read-only root filesystems
  - Minimal base images
  - Secret management via environment
```

### Access Control
```yaml
Grafana:
  - Admin password required
  - User signup disabled
  - HTTPS-only in production

Prometheus:
  - Metrics endpoints restricted
  - Docker network isolation
  - No external exposure by default

Elasticsearch:
  - Authentication disabled (development)
  - Network isolation enabled
  - Index lifecycle management
```

## 📚 Operational Procedures

### Daily Operations

#### Health Monitoring
```bash
# Check all services status
docker-compose ps

# View real-time logs
docker-compose logs -f [service-name]

# Check resource usage
docker stats

# Verify metrics collection
curl http://localhost:8080/metrics
curl http://localhost:8002/metrics
```

#### Performance Monitoring
```bash
# Monitor key business metrics
curl http://localhost:8080/api/analytics/realtime

# Check Prometheus targets
open http://localhost:9090/targets

# Review Grafana dashboards
open http://localhost:3000
```

### Troubleshooting Guide

#### Service Won't Start
```bash
# Check logs for errors
docker-compose logs [service-name]

# Verify environment variables
docker-compose config

# Restart individual service
docker-compose restart [service-name]

# Full reset
docker-compose down && docker-compose up -d
```

#### High Resource Usage
```bash
# Identify resource-heavy containers
docker stats --format "table {{.Container}}\t{{.CPUPerc}}\t{{.MemUsage}}\t{{.NetIO}}\t{{.BlockIO}}"

# Scale down services if needed
docker-compose up -d --scale rag-system=1

# Clear unused resources
docker system prune -f
```

#### Monitoring Issues
```bash
# Check Prometheus scraping
curl http://localhost:9090/api/v1/targets

# Verify metric endpoints
curl http://localhost:8080/metrics | head -20

# Test alerting
curl -X POST http://localhost:9093/api/v1/alerts
```

## 🚀 Production Deployment

### Pre-Production Checklist
- [ ] Update all passwords in `.env`
- [ ] Configure proper domain names
- [ ] Setup SSL certificates
- [ ] Configure backup storage
- [ ] Setup monitoring alerts
- [ ] Test disaster recovery

### Production Configuration
```yaml
Environment Variables:
  - APP_ENV=production
  - APP_DEBUG=false
  - GRAFANA_ADMIN_PASSWORD=strong-password
  - REDIS_PASSWORD=secure-redis-password

Resource Limits:
  - Set memory limits for containers
  - Configure CPU limits
  - Setup log rotation
  - Enable persistent volumes

Security:
  - Enable authentication for all services
  - Configure firewall rules
  - Setup VPN access
  - Enable audit logging
```

## 📊 Cost Analysis

### Resource Requirements
```yaml
Minimum Configuration:
  - CPU: 4 cores
  - RAM: 8GB
  - Disk: 50GB SSD
  - Network: 1Gbps

Recommended Production:
  - CPU: 8 cores
  - RAM: 16GB
  - Disk: 200GB SSD
  - Network: 10Gbps
```

### Monthly Costs (AWS/GCP/Azure)
```yaml
Development Environment: $150-250/month
Production Environment: $400-800/month
Enterprise Environment: $1000-2000/month

Cost Optimization:
  - Use spot instances for development
  - Implement auto-scaling
  - Setup log retention policies
  - Monitor resource utilization
```

## 🔄 Backup & Recovery

### Automated Backups
```bash
# Database backups (every 6 hours)
0 */6 * * * docker exec braintech-laravel php artisan backup:run

# Configuration backups (daily)
0 2 * * * tar -czf /backups/config-$(date +%Y%m%d).tar.gz .env docker-compose.yml monitoring/

# Vector store backups (daily)
0 3 * * * tar -czf /backups/vectorstore-$(date +%Y%m%d).tar.gz rag_system/vectorstore/
```

### Disaster Recovery
```bash
# Complete system restore
./scripts/deploy.sh cleanup
git pull origin main
cp backup/.env .env
./scripts/deploy.sh deploy

# Database restore
docker exec -i braintech-laravel php artisan migrate:fresh
# Import backup data

# Vector store restore
rm -rf rag_system/vectorstore/
tar -xzf backup/vectorstore-latest.tar.gz
```

## 📞 Support & Maintenance

### Log Locations
```yaml
Application Logs:
  - Laravel: storage/logs/laravel.log
  - RAG System: rag_system/*.log
  - Docker: docker-compose logs

System Logs:
  - Prometheus: /var/log/prometheus/
  - Grafana: /var/log/grafana/
  - Elasticsearch: /var/log/elasticsearch/
```

### Performance Tuning
```yaml
Laravel Optimization:
  - Enable OPcache
  - Configure Redis caching
  - Optimize database queries
  - Enable route caching

RAG System Optimization:
  - Adjust vector search parameters
  - Optimize embedding model
  - Implement query caching
  - Tune LLM parameters

Monitoring Optimization:
  - Adjust scrape intervals
  - Configure retention policies
  - Optimize dashboard queries
  - Setup alert thresholds
```

## 🎯 Next Steps

### Short Term (1-2 weeks)
- [ ] Test all monitoring alerts
- [ ] Setup automated backups
- [ ] Configure SSL certificates
- [ ] Performance baseline testing

### Medium Term (1-2 months)
- [ ] Implement CI/CD pipeline
- [ ] Setup staging environment
- [ ] Advanced security hardening
- [ ] Custom dashboard development

### Long Term (3-6 months)
- [ ] Multi-region deployment
- [ ] Advanced analytics integration
- [ ] Machine learning monitoring
- [ ] Cost optimization automation

---

**Need Help?** 
- 📧 Email: devops@braingentech.com
- 📖 Documentation: [Internal Wiki]
- 🐛 Issues: Create GitHub issue
- 💬 Slack: #devops-support

**Last Updated**: 2024-08-06
**Version**: 1.0.0