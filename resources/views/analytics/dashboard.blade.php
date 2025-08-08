<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard - BrainGenTechnology</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            backdrop-filter: blur(10px);
        }
        .metric-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .chart-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-800 min-h-screen" x-data="dashboardData()">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">
                        <i class="fas fa-chart-line mr-3"></i>Analytics Dashboard
                    </h1>
                    <p class="text-indigo-200">BrainGenTechnology RAG Chat Analytics</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Period Selector -->
                    <select x-model="selectedPeriod" @change="loadData()" 
                            class="bg-white/10 text-white border border-white/20 rounded-lg px-4 py-2 backdrop-blur">
                        <option value="24hours">Last 24 Hours</option>
                        <option value="7days" selected>Last 7 Days</option>
                        <option value="30days">Last 30 Days</option>
                        <option value="90days">Last 90 Days</option>
                    </select>
                    <!-- Refresh Button -->
                    <button @click="loadData()" :disabled="loading"
                            class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg backdrop-blur transition-all duration-300">
                        <i class="fas fa-sync-alt" :class="{'animate-spin': loading}"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div x-show="loading" class="text-center mb-8">
            <div class="inline-flex items-center px-6 py-3 bg-white/10 rounded-lg backdrop-blur">
                <i class="fas fa-spinner animate-spin mr-3 text-white"></i>
                <span class="text-white">Loading analytics data...</span>
            </div>
        </div>

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" x-show="!loading">
            <!-- Total Conversations -->
            <div class="metric-card rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Conversations</p>
                        <p class="text-3xl font-bold text-gray-800" x-text="data.overview?.total_conversations || 0"></p>
                        <p class="text-sm mt-1" :class="getGrowthColor(data.overview?.conversation_growth)">
                            <i :class="getGrowthIcon(data.overview?.conversation_growth)"></i>
                            <span x-text="data.overview?.conversation_growth || 0"></span>% vs previous period
                        </p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-comments text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Qualified Leads -->
            <div class="metric-card rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Qualified Leads</p>
                        <p class="text-3xl font-bold text-gray-800" x-text="data.overview?.qualified_leads || 0"></p>
                        <p class="text-sm mt-1" :class="getGrowthColor(data.overview?.lead_growth)">
                            <i :class="getGrowthIcon(data.overview?.lead_growth)"></i>
                            <span x-text="data.overview?.lead_growth || 0"></span>% vs previous period
                        </p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-user-check text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Conversion Rate -->
            <div class="metric-card rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Conversion Rate</p>
                        <p class="text-3xl font-bold text-gray-800">
                            <span x-text="data.overview?.lead_conversion_rate || 0"></span>%
                        </p>
                        <p class="text-sm mt-1 text-gray-500">
                            Conversations → Leads
                        </p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-percentage text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Sales Ready -->
            <div class="metric-card rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Sales Ready</p>
                        <p class="text-3xl font-bold text-gray-800" x-text="data.overview?.sales_ready_leads || 0"></p>
                        <p class="text-sm mt-1 text-gray-500">
                            <span x-text="data.overview?.sales_ready_rate || 0"></span>% of qualified leads
                        </p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <i class="fas fa-handshake text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8" x-show="!loading">
            <!-- Conversations Trend -->
            <div class="chart-container p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-line mr-2 text-blue-600"></i>Conversations Over Time
                </h3>
                <canvas id="conversationTrendChart" width="400" height="200"></canvas>
            </div>

            <!-- Lead Score Distribution -->
            <div class="chart-container p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chart-pie mr-2 text-green-600"></i>Lead Score Distribution
                </h3>
                <canvas id="leadScoreChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8" x-show="!loading">
            <!-- Traffic by Hour -->
            <div class="chart-container p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-clock mr-2 text-purple-600"></i>Traffic by Hour
                </h3>
                <canvas id="trafficByHourChart" width="400" height="200"></canvas>
            </div>

            <!-- Intent Distribution -->
            <div class="chart-container p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-bullseye mr-2 text-red-600"></i>User Intent
                </h3>
                <canvas id="intentChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" x-show="!loading">
            <!-- Top Industries -->
            <div class="chart-container p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-industry mr-2 text-indigo-600"></i>Top Industries
                </h3>
                <div class="space-y-3">
                    <template x-for="industry in data.leads?.top_industries || []">
                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                            <span x-text="industry.industry || 'Unknown'"></span>
                            <span class="font-semibold text-indigo-600" x-text="industry.count"></span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Top Referrers -->
            <div class="chart-container p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-external-link-alt mr-2 text-teal-600"></i>Top Referrers
                </h3>
                <div class="space-y-3">
                    <template x-for="referrer in data.traffic?.top_referrers || []">
                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                            <span x-text="referrer.referrer || 'Direct'"></span>
                            <span class="font-semibold text-teal-600" x-text="referrer.count"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center">
            <p class="text-indigo-200 text-sm">
                <i class="fas fa-brain mr-2"></i>
                BrainGenTechnology Analytics Dashboard - Last updated: <span x-text="new Date().toLocaleString()"></span>
            </p>
        </div>
    </div>

    <script>
        function dashboardData() {
            return {
                loading: true,
                selectedPeriod: '7days',
                data: {},
                charts: {},

                async init() {
                    await this.loadData();
                },

                async loadData() {
                    this.loading = true;
                    try {
                        const response = await fetch(`/api/analytics/data?period=${this.selectedPeriod}`);
                        this.data = await response.json();
                        this.$nextTick(() => {
                            this.renderCharts();
                        });
                    } catch (error) {
                        console.error('Error loading analytics data:', error);
                    }
                    this.loading = false;
                },

                renderCharts() {
                    this.renderConversationTrend();
                    this.renderLeadScoreChart();
                    this.renderTrafficByHour();
                    this.renderIntentChart();
                },

                renderConversationTrend() {
                    const ctx = document.getElementById('conversationTrendChart').getContext('2d');
                    if (this.charts.conversationTrend) this.charts.conversationTrend.destroy();
                    
                    const trendData = this.data.trends?.daily_conversations || [];
                    
                    this.charts.conversationTrend = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: trendData.map(d => new Date(d.date).toLocaleDateString()),
                            datasets: [{
                                label: 'Conversations',
                                data: trendData.map(d => d.conversations),
                                borderColor: 'rgb(99, 102, 241)',
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },

                renderLeadScoreChart() {
                    const ctx = document.getElementById('leadScoreChart').getContext('2d');
                    if (this.charts.leadScore) this.charts.leadScore.destroy();
                    
                    const scoreData = this.data.leads?.score_distribution || [];
                    
                    this.charts.leadScore = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: scoreData.map(d => d.score_range),
                            datasets: [{
                                data: scoreData.map(d => d.count),
                                backgroundColor: [
                                    'rgb(34, 197, 94)',
                                    'rgb(59, 130, 246)',
                                    'rgb(251, 191, 36)',
                                    'rgb(239, 68, 68)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                },

                renderTrafficByHour() {
                    const ctx = document.getElementById('trafficByHourChart').getContext('2d');
                    if (this.charts.trafficByHour) this.charts.trafficByHour.destroy();
                    
                    const hourlyData = this.data.conversations?.hourly_distribution || {};
                    const hours = Array.from({length: 24}, (_, i) => i);
                    
                    this.charts.trafficByHour = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: hours.map(h => `${h}:00`),
                            datasets: [{
                                label: 'Conversations',
                                data: hours.map(h => hourlyData[h] || 0),
                                backgroundColor: 'rgba(147, 51, 234, 0.8)',
                                borderColor: 'rgb(147, 51, 234)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },

                renderIntentChart() {
                    const ctx = document.getElementById('intentChart').getContext('2d');
                    if (this.charts.intent) this.charts.intent.destroy();
                    
                    const intentData = this.data.leads?.intent_distribution || [];
                    
                    this.charts.intent = new Chart(ctx, {
                        type: 'polarArea',
                        data: {
                            labels: intentData.map(d => d.intent || 'Unknown'),
                            datasets: [{
                                data: intentData.map(d => d.count),
                                backgroundColor: [
                                    'rgba(239, 68, 68, 0.8)',
                                    'rgba(34, 197, 94, 0.8)',
                                    'rgba(59, 130, 246, 0.8)',
                                    'rgba(251, 191, 36, 0.8)',
                                    'rgba(147, 51, 234, 0.8)',
                                    'rgba(6, 182, 212, 0.8)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                },

                getGrowthColor(growth) {
                    if (growth > 0) return 'text-green-600';
                    if (growth < 0) return 'text-red-600';
                    return 'text-gray-600';
                },

                getGrowthIcon(growth) {
                    if (growth > 0) return 'fas fa-arrow-up';
                    if (growth < 0) return 'fas fa-arrow-down';
                    return 'fas fa-minus';
                }
            }
        }
    </script>
</body>
</html>