<!-- Real-time Analytics Widget for embedding -->
<div id="real-time-analytics" x-data="realTimeAnalytics()" x-init="init()">
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-3 flex items-center">
            <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
            Live Analytics
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold" x-text="metrics.activeUsers"></div>
                <div class="text-xs opacity-75">Active Now</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold" x-text="metrics.todayConversations"></div>
                <div class="text-xs opacity-75">Today</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold" x-text="metrics.todayLeads"></div>
                <div class="text-xs opacity-75">Leads</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold" x-text="metrics.conversionRate + '%'"></div>
                <div class="text-xs opacity-75">CVR</div>
            </div>
        </div>
    </div>
</div>

<script>
    function realTimeAnalytics() {
        return {
            metrics: {
                activeUsers: 0,
                todayConversations: 0,
                todayLeads: 0,
                conversionRate: 0
            },
            
            async init() {
                await this.loadMetrics();
                // Update every 30 seconds
                setInterval(() => {
                    this.loadMetrics();
                }, 30000);
            },
            
            async loadMetrics() {
                try {
                    const response = await fetch('/api/analytics/realtime');
                    if (response.ok) {
                        this.metrics = await response.json();
                    }
                } catch (error) {
                    console.error('Failed to load real-time metrics:', error);
                }
            }
        }
    }
</script>