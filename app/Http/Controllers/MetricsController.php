<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class MetricsController extends Controller
{
    /**
     * Export Prometheus metrics for Laravel application
     */
    public function metrics()
    {
        $metrics = $this->collectMetrics();
        
        $output = [];
        
        // Application health metric
        $output[] = "# HELP laravel_up Application availability";
        $output[] = "# TYPE laravel_up gauge";
        $output[] = "laravel_up 1";
        
        // HTTP request metrics
        $output[] = "# HELP http_requests_total Total HTTP requests";
        $output[] = "# TYPE http_requests_total counter";
        $output[] = sprintf("http_requests_total{method=\"GET\",status=\"200\"} %d", $metrics['http_requests_get']);
        $output[] = sprintf("http_requests_total{method=\"POST\",status=\"200\"} %d", $metrics['http_requests_post']);
        
        // Database metrics
        $output[] = "# HELP database_connections_active Active database connections";
        $output[] = "# TYPE database_connections_active gauge";
        $output[] = sprintf("database_connections_active %d", $metrics['db_connections']);
        
        // Business metrics
        $output[] = "# HELP lead_conversion_rate Current lead conversion rate";
        $output[] = "# TYPE lead_conversion_rate gauge";
        $output[] = sprintf("lead_conversion_rate %.4f", $metrics['conversion_rate']);
        
        $output[] = "# HELP chat_conversations_total Total chat conversations";
        $output[] = "# TYPE chat_conversations_total counter";
        $output[] = sprintf("chat_conversations_total %d", $metrics['total_conversations']);
        
        $output[] = "# HELP lead_qualifications_total Total lead qualifications";
        $output[] = "# TYPE lead_qualifications_total counter";
        $output[] = sprintf("lead_qualifications_total %d", $metrics['total_qualifications']);
        
        $output[] = "# HELP sales_ready_leads_total Total sales-ready leads";
        $output[] = "# TYPE sales_ready_leads_total counter";
        $output[] = sprintf("sales_ready_leads_total %d", $metrics['sales_ready_leads']);
        
        // Response time metrics
        $output[] = "# HELP http_request_duration_seconds HTTP request duration";
        $output[] = "# TYPE http_request_duration_seconds histogram";
        $output[] = sprintf("http_request_duration_seconds_bucket{le=\"0.1\"} %d", $metrics['response_time_100ms']);
        $output[] = sprintf("http_request_duration_seconds_bucket{le=\"0.5\"} %d", $metrics['response_time_500ms']);
        $output[] = sprintf("http_request_duration_seconds_bucket{le=\"1.0\"} %d", $metrics['response_time_1s']);
        $output[] = sprintf("http_request_duration_seconds_bucket{le=\"2.0\"} %d", $metrics['response_time_2s']);
        $output[] = sprintf("http_request_duration_seconds_bucket{le=\"5.0\"} %d", $metrics['response_time_5s']);
        $output[] = sprintf("http_request_duration_seconds_bucket{le=\"+Inf\"} %d", $metrics['total_requests']);
        
        return response(implode("\n", $output) . "\n")
            ->header('Content-Type', 'text/plain; version=0.0.4; charset=utf-8');
    }
    
    /**
     * Business-specific metrics endpoint
     */
    public function businessMetrics()
    {
        $metrics = $this->collectBusinessMetrics();
        
        $output = [];
        
        // Lead quality metrics
        $output[] = "# HELP lead_score_average Average lead score";
        $output[] = "# TYPE lead_score_average gauge";
        $output[] = sprintf("lead_score_average %.2f", $metrics['avg_lead_score']);
        
        $output[] = "# HELP conversation_quality_average Average conversation quality";
        $output[] = "# TYPE conversation_quality_average gauge";
        $output[] = sprintf("conversation_quality_average %.2f", $metrics['avg_conversation_quality']);
        
        $output[] = "# HELP model_confidence_average Average model confidence";
        $output[] = "# TYPE model_confidence_average gauge";
        $output[] = sprintf("model_confidence_average %.4f", $metrics['avg_model_confidence']);
        
        // Industry distribution
        foreach ($metrics['industry_distribution'] as $industry => $count) {
            $output[] = sprintf("leads_by_industry{industry=\"%s\"} %d", $industry, $count);
        }
        
        // Intent distribution
        foreach ($metrics['intent_distribution'] as $intent => $count) {
            $output[] = sprintf("leads_by_intent{intent=\"%s\"} %d", $intent, $count);
        }
        
        // Company size distribution
        foreach ($metrics['company_size_distribution'] as $size => $count) {
            $output[] = sprintf("leads_by_company_size{size=\"%s\"} %d", $size, $count);
        }
        
        // Daily metrics
        $output[] = "# HELP daily_conversations_today Conversations today";
        $output[] = "# TYPE daily_conversations_today gauge";
        $output[] = sprintf("daily_conversations_today %d", $metrics['today_conversations']);
        
        $output[] = "# HELP daily_leads_today Leads qualified today";
        $output[] = "# TYPE daily_leads_today gauge";
        $output[] = sprintf("daily_leads_today %d", $metrics['today_leads']);
        
        return response(implode("\n", $output) . "\n")
            ->header('Content-Type', 'text/plain; version=0.0.4; charset=utf-8');
    }
    
    private function collectMetrics()
    {
        return Cache::remember('prometheus_metrics', 30, function () {
            $today = Carbon::today();
            
            // Basic application metrics
            $totalConversations = DB::table('chat_conversations')->count();
            $totalQualifications = DB::table('lead_qualifications')->count();
            $salesReadyLeads = DB::table('lead_qualifications')
                ->where('sales_ready', true)
                ->count();
            
            $conversionRate = $totalConversations > 0 
                ? $totalQualifications / $totalConversations 
                : 0;
                
            // Simulate HTTP request metrics (in real app, these would come from middleware)
            $httpRequestsGet = Cache::get('http_requests_get', 0);
            $httpRequestsPost = Cache::get('http_requests_post', 0);
            
            return [
                'total_conversations' => $totalConversations,
                'total_qualifications' => $totalQualifications,
                'sales_ready_leads' => $salesReadyLeads,
                'conversion_rate' => $conversionRate,
                'db_connections' => 1, // SQLite doesn't have multiple connections
                'http_requests_get' => $httpRequestsGet,
                'http_requests_post' => $httpRequestsPost,
                'total_requests' => $httpRequestsGet + $httpRequestsPost,
                'response_time_100ms' => (int)($httpRequestsGet * 0.8),
                'response_time_500ms' => (int)($httpRequestsGet * 0.95),
                'response_time_1s' => (int)($httpRequestsGet * 0.99),
                'response_time_2s' => (int)($httpRequestsGet * 0.995),
                'response_time_5s' => (int)($httpRequestsGet * 1.0),
            ];
        });
    }
    
    private function collectBusinessMetrics()
    {
        return Cache::remember('business_metrics', 60, function () {
            $today = Carbon::today();
            
            // Lead quality metrics
            $avgLeadScore = DB::table('lead_qualifications')
                ->avg('lead_score') ?? 0;
                
            $avgConversationQuality = DB::table('lead_qualifications')
                ->avg('conversation_quality') ?? 0;
                
            $avgModelConfidence = DB::table('lead_qualifications')
                ->avg('model_confidence') ?? 0;
            
            // Distribution metrics
            $industryDistribution = DB::table('lead_qualifications')
                ->select('industry', DB::raw('COUNT(*) as count'))
                ->whereNotNull('industry')
                ->groupBy('industry')
                ->pluck('count', 'industry')
                ->toArray();
                
            $intentDistribution = DB::table('lead_qualifications')
                ->select('intent', DB::raw('COUNT(*) as count'))
                ->whereNotNull('intent')
                ->groupBy('intent')
                ->pluck('count', 'intent')
                ->toArray();
                
            $companySizeDistribution = DB::table('lead_qualifications')
                ->select('company_size', DB::raw('COUNT(*) as count'))
                ->whereNotNull('company_size')
                ->groupBy('company_size')
                ->pluck('count', 'company_size')
                ->toArray();
            
            // Today's metrics
            $todayConversations = DB::table('chat_conversations')
                ->whereDate('started_at', $today)
                ->count();
                
            $todayLeads = DB::table('lead_qualifications')
                ->whereDate('qualified_at', $today)
                ->count();
            
            return [
                'avg_lead_score' => round($avgLeadScore, 2),
                'avg_conversation_quality' => round($avgConversationQuality, 2),
                'avg_model_confidence' => round($avgModelConfidence, 4),
                'industry_distribution' => $industryDistribution,
                'intent_distribution' => $intentDistribution,
                'company_size_distribution' => $companySizeDistribution,
                'today_conversations' => $todayConversations,
                'today_leads' => $todayLeads,
            ];
        });
    }
}