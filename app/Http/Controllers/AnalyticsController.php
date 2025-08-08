<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display the analytics dashboard
     */
    public function dashboard()
    {
        $analytics = $this->getAnalyticsData();
        
        return view('analytics.dashboard', compact('analytics'));
    }

    /**
     * Get analytics data via API
     */
    public function getData(Request $request)
    {
        $period = $request->get('period', '7days');
        $analytics = $this->getAnalyticsData($period);
        
        return response()->json($analytics);
    }

    /**
     * Get real-time analytics metrics
     */
    public function getRealTimeMetrics()
    {
        $today = Carbon::today();
        
        // Active users (sessions active in last 10 minutes)
        $activeUsers = DB::table('chat_conversations')
            ->where('last_activity_at', '>=', now()->subMinutes(10))
            ->where('is_active', true)
            ->count();
        
        // Today's conversations
        $todayConversations = DB::table('chat_conversations')
            ->whereDate('started_at', $today)
            ->count();
        
        // Today's leads
        $todayLeads = DB::table('lead_qualifications')
            ->whereDate('qualified_at', $today)
            ->count();
        
        // Conversion rate
        $conversionRate = $todayConversations > 0 
            ? round(($todayLeads / $todayConversations) * 100, 1) 
            : 0;
        
        return response()->json([
            'activeUsers' => $activeUsers,
            'todayConversations' => $todayConversations,
            'todayLeads' => $todayLeads,
            'conversionRate' => $conversionRate,
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Get comprehensive analytics data
     */
    private function getAnalyticsData($period = '7days')
    {
        $dateRange = $this->getDateRange($period);
        
        return [
            'overview' => $this->getOverviewMetrics($dateRange),
            'conversations' => $this->getConversationMetrics($dateRange),
            'leads' => $this->getLeadMetrics($dateRange),
            'performance' => $this->getPerformanceMetrics($dateRange),
            'trends' => $this->getTrendData($dateRange),
            'traffic' => $this->getTrafficMetrics($dateRange),
            'quality' => $this->getQualityMetrics($dateRange)
        ];
    }

    /**
     * Get overview metrics
     */
    private function getOverviewMetrics($dateRange)
    {
        $totalConversations = DB::table('chat_conversations')
            ->whereBetween('started_at', $dateRange)
            ->count();

        $totalMessages = DB::table('chat_messages')
            ->whereBetween('sent_at', $dateRange)
            ->count();

        $qualifiedLeads = DB::table('lead_qualifications')
            ->whereBetween('qualified_at', $dateRange)
            ->count();

        $salesReadyLeads = DB::table('lead_qualifications')
            ->whereBetween('qualified_at', $dateRange)
            ->where('sales_ready', true)
            ->count();

        // Calculate previous period for comparison
        $previousDateRange = $this->getPreviousDateRange($dateRange);
        
        $previousConversations = DB::table('chat_conversations')
            ->whereBetween('started_at', $previousDateRange)
            ->count();

        $previousLeads = DB::table('lead_qualifications')
            ->whereBetween('qualified_at', $previousDateRange)
            ->count();

        return [
            'total_conversations' => $totalConversations,
            'total_messages' => $totalMessages,
            'qualified_leads' => $qualifiedLeads,
            'sales_ready_leads' => $salesReadyLeads,
            'avg_messages_per_conversation' => $totalConversations > 0 ? round($totalMessages / $totalConversations, 1) : 0,
            'lead_conversion_rate' => $totalConversations > 0 ? round(($qualifiedLeads / $totalConversations) * 100, 1) : 0,
            'sales_ready_rate' => $qualifiedLeads > 0 ? round(($salesReadyLeads / $qualifiedLeads) * 100, 1) : 0,
            'conversation_growth' => $this->calculateGrowthRate($totalConversations, $previousConversations),
            'lead_growth' => $this->calculateGrowthRate($qualifiedLeads, $previousLeads)
        ];
    }

    /**
     * Get conversation metrics
     */
    private function getConversationMetrics($dateRange)
    {
        // Conversations by hour of day (SQLite compatible)
        $hourlyDistribution = DB::table('chat_conversations')
            ->selectRaw('CAST(strftime("%H", started_at) AS INTEGER) as hour, COUNT(*) as count')
            ->whereBetween('started_at', $dateRange)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->pluck('count', 'hour');

        // Fill missing hours with 0
        $hourlyData = [];
        for ($i = 0; $i < 24; $i++) {
            $hourlyData[$i] = $hourlyDistribution->get($i, 0);
        }

        // Conversations by day of week (SQLite compatible)
        $weeklyDistribution = DB::table('chat_conversations')
            ->selectRaw('CAST(strftime("%w", started_at) AS INTEGER) as day, COUNT(*) as count')
            ->whereBetween('started_at', $dateRange)
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->pluck('count', 'day');

        // Average conversation duration (SQLite compatible)
        $avgDuration = DB::table('chat_conversations')
            ->selectRaw('AVG((julianday(last_activity_at) - julianday(started_at)) * 24 * 60) as avg_duration')
            ->whereBetween('started_at', $dateRange)
            ->whereRaw('last_activity_at > started_at')
            ->value('avg_duration');

        return [
            'hourly_distribution' => $hourlyData,
            'weekly_distribution' => $weeklyDistribution,
            'avg_duration_minutes' => round($avgDuration ?? 0, 1),
            'active_conversations' => DB::table('chat_conversations')
                ->where('is_active', true)
                ->count()
        ];
    }

    /**
     * Get lead metrics
     */
    private function getLeadMetrics($dateRange)
    {
        // Lead distribution by score ranges
        $scoreDistribution = DB::table('lead_qualifications')
            ->selectRaw('
                CASE 
                    WHEN lead_score >= 80 THEN "High (80-100)"
                    WHEN lead_score >= 60 THEN "Medium (60-79)"
                    WHEN lead_score >= 40 THEN "Low (40-59)"
                    ELSE "Very Low (0-39)"
                END as score_range,
                COUNT(*) as count
            ')
            ->whereBetween('qualified_at', $dateRange)
            ->groupBy('score_range')
            ->get();

        // Top industries
        $topIndustries = DB::table('lead_qualifications')
            ->select('industry', DB::raw('COUNT(*) as count'))
            ->whereBetween('qualified_at', $dateRange)
            ->whereNotNull('industry')
            ->groupBy('industry')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Intent distribution
        $intentDistribution = DB::table('lead_qualifications')
            ->select('intent', DB::raw('COUNT(*) as count'))
            ->whereBetween('qualified_at', $dateRange)
            ->whereNotNull('intent')
            ->groupBy('intent')
            ->orderByDesc('count')
            ->get();

        // Company size distribution
        $companySizeDistribution = DB::table('lead_qualifications')
            ->select('company_size', DB::raw('COUNT(*) as count'))
            ->whereBetween('qualified_at', $dateRange)
            ->whereNotNull('company_size')
            ->groupBy('company_size')
            ->orderByDesc('count')
            ->get();

        return [
            'score_distribution' => $scoreDistribution,
            'top_industries' => $topIndustries,
            'intent_distribution' => $intentDistribution,
            'company_size_distribution' => $companySizeDistribution,
            'avg_lead_score' => DB::table('lead_qualifications')
                ->whereBetween('qualified_at', $dateRange)
                ->avg('lead_score')
        ];
    }

    /**
     * Get performance metrics
     */
    private function getPerformanceMetrics($dateRange)
    {
        // Response times (if stored in metadata) - SQLite compatible
        $avgResponseTime = DB::table('chat_messages')
            ->whereBetween('sent_at', $dateRange)
            ->where('role', 'assistant')
            ->whereRaw("json_extract(metadata, '$.processing_time') IS NOT NULL")
            ->selectRaw('AVG(CAST(json_extract(metadata, "$.processing_time") AS REAL)) as avg_time')
            ->value('avg_time');

        // Popular topics (basic keyword extraction from user messages)
        $popularKeywords = DB::table('chat_messages')
            ->whereBetween('sent_at', $dateRange)
            ->where('role', 'user')
            ->selectRaw('content')
            ->get()
            ->pluck('content')
            ->map(function ($content) {
                // Simple keyword extraction
                $keywords = [];
                $aiTerms = ['ai', 'artificial intelligence', 'automation', 'blockchain', 'brain', 'technology', 'solution'];
                foreach ($aiTerms as $term) {
                    if (stripos($content, $term) !== false) {
                        $keywords[] = $term;
                    }
                }
                return $keywords;
            })
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(10);

        return [
            'avg_response_time' => round($avgResponseTime ?? 0, 3),
            'popular_keywords' => $popularKeywords,
            'total_tokens_processed' => $this->estimateTokensProcessed($dateRange),
            'error_rate' => $this->calculateErrorRate($dateRange)
        ];
    }

    /**
     * Get trend data for charts
     */
    private function getTrendData($dateRange)
    {
        $dailyConversations = DB::table('chat_conversations')
            ->selectRaw('date(started_at) as date, COUNT(*) as conversations')
            ->whereBetween('started_at', $dateRange)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dailyLeads = DB::table('lead_qualifications')
            ->selectRaw('date(qualified_at) as date, COUNT(*) as leads')
            ->whereBetween('qualified_at', $dateRange)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'daily_conversations' => $dailyConversations,
            'daily_leads' => $dailyLeads,
            'conversion_trend' => $this->getConversionTrend($dateRange)
        ];
    }

    /**
     * Get traffic metrics
     */
    private function getTrafficMetrics($dateRange)
    {
        // Top referrers
        $topReferrers = DB::table('chat_conversations')
            ->select('referrer', DB::raw('COUNT(*) as count'))
            ->whereBetween('started_at', $dateRange)
            ->whereNotNull('referrer')
            ->groupBy('referrer')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Geographic distribution (basic IP-based)
        $ipDistribution = DB::table('chat_conversations')
            ->select('user_ip', DB::raw('COUNT(*) as count'))
            ->whereBetween('started_at', $dateRange)
            ->whereNotNull('user_ip')
            ->groupBy('user_ip')
            ->orderByDesc('count')
            ->limit(20)
            ->get();

        return [
            'top_referrers' => $topReferrers,
            'unique_visitors' => DB::table('chat_conversations')
                ->whereBetween('started_at', $dateRange)
                ->distinct('user_ip')
                ->count(),
            'return_visitors' => $this->getReturnVisitors($dateRange)
        ];
    }

    /**
     * Get quality metrics
     */
    private function getQualityMetrics($dateRange)
    {
        $avgConversationQuality = DB::table('lead_qualifications')
            ->whereBetween('qualified_at', $dateRange)
            ->avg('conversation_quality');

        $avgModelConfidence = DB::table('lead_qualifications')
            ->whereBetween('qualified_at', $dateRange)
            ->avg('model_confidence');

        return [
            'avg_conversation_quality' => round($avgConversationQuality ?? 0, 2),
            'avg_model_confidence' => round($avgModelConfidence ?? 0, 3),
            'high_quality_conversations' => DB::table('lead_qualifications')
                ->whereBetween('qualified_at', $dateRange)
                ->where('conversation_quality', '>=', 8)
                ->count()
        ];
    }

    /**
     * Helper methods
     */
    private function getDateRange($period)
    {
        switch ($period) {
            case '24hours':
                return [Carbon::now()->subDay(), Carbon::now()];
            case '7days':
                return [Carbon::now()->subWeek(), Carbon::now()];
            case '30days':
                return [Carbon::now()->subMonth(), Carbon::now()];
            case '90days':
                return [Carbon::now()->subMonths(3), Carbon::now()];
            default:
                return [Carbon::now()->subWeek(), Carbon::now()];
        }
    }

    private function getPreviousDateRange($currentRange)
    {
        $duration = $currentRange[1]->diffInDays($currentRange[0]);
        return [
            $currentRange[0]->copy()->subDays($duration),
            $currentRange[0]
        ];
    }

    private function calculateGrowthRate($current, $previous)
    {
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function estimateTokensProcessed($dateRange)
    {
        $totalChars = DB::table('chat_messages')
            ->whereBetween('sent_at', $dateRange)
            ->sum(DB::raw('length(content)'));
        
        // Rough estimate: 1 token ≈ 4 characters
        return round($totalChars / 4);
    }

    private function calculateErrorRate($dateRange)
    {
        $totalMessages = DB::table('chat_messages')
            ->whereBetween('sent_at', $dateRange)
            ->where('role', 'assistant')
            ->count();

        $errorMessages = DB::table('chat_messages')
            ->whereBetween('sent_at', $dateRange)
            ->where('role', 'assistant')
            ->where('content', 'like', '%error%')
            ->orWhere('content', 'like', '%sorry%')
            ->count();

        return $totalMessages > 0 ? round(($errorMessages / $totalMessages) * 100, 2) : 0;
    }

    private function getConversionTrend($dateRange)
    {
        return DB::table('chat_conversations as c')
            ->leftJoin('lead_qualifications as l', 'c.session_id', '=', 'l.session_id')
            ->selectRaw('
                date(c.started_at) as date, 
                COUNT(c.id) as conversations,
                COUNT(l.id) as leads,
                CASE WHEN COUNT(c.id) > 0 THEN ROUND((CAST(COUNT(l.id) AS REAL) / COUNT(c.id)) * 100, 2) ELSE 0 END as conversion_rate
            ')
            ->whereBetween('c.started_at', $dateRange)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getReturnVisitors($dateRange)
    {
        return DB::table('chat_conversations')
            ->select('user_ip')
            ->whereBetween('started_at', $dateRange)
            ->groupBy('user_ip')
            ->having(DB::raw('COUNT(*)'), '>', 1)
            ->count();
    }
}