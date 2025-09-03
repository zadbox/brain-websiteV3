<!DOCTYPE html>
<html lang="fr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Commercial - BrainGen Technology</title>
    <meta name="description" content="Dashboard commercial pour le suivi des leads et des performances du chatbot">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- CountUp.js -->
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.9.0/dist/countUp.min.js"></script>
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .metric-card {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            border: 1px solid #475569;
        }
        .loading {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <!-- Header -->
    <header class="gradient-bg shadow-lg">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="/assets/LogoBrainBlanc.png" alt="BrainGen Technology" class="h-8">
                    <h1 class="text-2xl font-bold">Dashboard Commercial</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm">En ligne</span>
                    </div>
                    <button id="refreshBtn" class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg transition-all">
                        🔄 Actualiser
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-8">
        <!-- Period Selector -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <label class="text-sm font-medium">Période :</label>
                <select id="periodSelector" class="bg-gray-800 border border-gray-600 rounded-lg px-4 py-2">
                    <option value="7d">7 derniers jours</option>
                    <option value="30d">30 derniers jours</option>
                    <option value="90d">90 derniers jours</option>
                </select>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Conversations -->
            <div class="metric-card rounded-xl p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Conversations</p>
                        <p class="text-3xl font-bold" id="totalConversations">-</p>
                    </div>
                    <div class="text-4xl">💬</div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-400">↗</span>
                        <span class="ml-1">+12%</span>
                        <span class="text-gray-400 ml-1">vs période précédente</span>
                    </div>
                </div>
            </div>

            <!-- Total Messages -->
            <div class="metric-card rounded-xl p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Messages</p>
                        <p class="text-3xl font-bold" id="totalMessages">-</p>
                    </div>
                    <div class="text-4xl">📨</div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-400">↗</span>
                        <span class="ml-1">+8%</span>
                        <span class="text-gray-400 ml-1">vs période précédente</span>
                    </div>
                </div>
            </div>

            <!-- Leads Qualifiés -->
            <div class="metric-card rounded-xl p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Leads Qualifiés</p>
                        <p class="text-3xl font-bold" id="totalLeads">-</p>
                    </div>
                    <div class="text-4xl">🎯</div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-400">↗</span>
                        <span class="ml-1">+15%</span>
                        <span class="text-gray-400 ml-1">vs période précédente</span>
                    </div>
                </div>
            </div>

            <!-- Leads Haute Valeur -->
            <div class="metric-card rounded-xl p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Leads Haute Valeur</p>
                        <p class="text-3xl font-bold" id="highValueLeads">-</p>
                    </div>
                    <div class="text-4xl">💎</div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-400">↗</span>
                        <span class="ml-1">+22%</span>
                        <span class="text-gray-400 ml-1">vs période précédente</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Response Time -->
            <div class="metric-card rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-4">Temps de Réponse</h3>
                <div class="text-center">
                    <p class="text-4xl font-bold text-blue-400" id="avgResponseTime">-</p>
                    <p class="text-gray-400 text-sm">millisecondes</p>
                </div>
            </div>

            <!-- Satisfaction Score -->
            <div class="metric-card rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-4">Score de Satisfaction</h3>
                <div class="text-center">
                    <p class="text-4xl font-bold text-yellow-400" id="satisfactionScore">-</p>
                    <p class="text-gray-400 text-sm">/ 5</p>
                </div>
            </div>

            <!-- Conversion Rate -->
            <div class="metric-card rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-4">Taux de Conversion</h3>
                <div class="text-center">
                    <p class="text-4xl font-bold text-green-400" id="conversionRate">-</p>
                    <p class="text-gray-400 text-sm">%</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Lead Qualification Chart -->
            <div class="metric-card rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-4">Qualification des Leads</h3>
                <canvas id="leadQualificationChart" width="400" height="200"></canvas>
            </div>

            <!-- Performance Trends -->
            <div class="metric-card rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-4">Tendances de Performance</h3>
                <canvas id="performanceTrendsChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Leads Table -->
        <div class="metric-card rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Leads Récents</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-600">
                            <th class="text-left py-3 px-4">Session ID</th>
                            <th class="text-left py-3 px-4">Score</th>
                            <th class="text-left py-3 px-4">Niveau</th>
                            <th class="text-left py-3 px-4">Valeur Estimée</th>
                            <th class="text-left py-3 px-4">Catégorie</th>
                            <th class="text-left py-3 px-4">Date</th>
                            <th class="text-left py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="recentLeadsTable">
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-400">
                                <div class="loading">Chargement des leads...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Lead Details Modal -->
    <div id="leadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-gray-800 rounded-xl p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold">Détails du Lead</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="leadDetails">
                    <!-- Lead details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let leadQualificationChart, performanceTrendsChart;
        let currentPeriod = '7d';

        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            loadDashboardData();
            setupEventListeners();
            
            // Auto-refresh every 30 seconds
            setInterval(loadDashboardData, 30000);
        });

        // Setup event listeners
        function setupEventListeners() {
            document.getElementById('periodSelector').addEventListener('change', function(e) {
                currentPeriod = e.target.value;
                loadDashboardData();
            });

            document.getElementById('refreshBtn').addEventListener('click', function() {
                loadDashboardData();
            });

            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('leadModal').classList.add('hidden');
            });
        }

        // Load dashboard data
        async function loadDashboardData() {
            try {
                const response = await fetch(`/api/commercial/dashboard?period=${currentPeriod}`);
                const data = await response.json();
                
                if (data.success) {
                    updateMetrics(data.metrics);
                    updateLeadQualification(data.lead_qualification);
                    updatePerformanceTrends(data.performance_trends);
                    updateRecentLeads(data.recent_leads);
                }
            } catch (error) {
                console.error('Error loading dashboard data:', error);
            }
        }

        // Update metrics
        function updateMetrics(metrics) {
            animateCounter('totalConversations', metrics.total_conversations);
            animateCounter('totalMessages', metrics.total_messages);
            animateCounter('avgResponseTime', metrics.avg_response_time, 'ms');
            animateCounter('satisfactionScore', metrics.satisfaction_score, '/5');
            animateCounter('conversionRate', metrics.conversion_rate, '%');
        }

        // Update lead qualification
        function updateLeadQualification(leadQualification) {
            animateCounter('totalLeads', leadQualification.total_leads);
            animateCounter('highValueLeads', leadQualification.high_value_leads);
            
            // Update chart
            if (leadQualificationChart) {
                leadQualificationChart.data.datasets[0].data = [
                    leadQualification.high_value_leads,
                    leadQualification.medium_value_leads,
                    leadQualification.low_value_leads
                ];
                leadQualificationChart.update();
            }
        }

        // Update performance trends
        function updatePerformanceTrends(trends) {
            if (performanceTrendsChart && trends.length > 0) {
                const labels = trends.map(t => t.date);
                const conversations = trends.map(t => t.conversations);
                const leads = trends.map(t => t.leads);
                
                performanceTrendsChart.data.labels = labels;
                performanceTrendsChart.data.datasets[0].data = conversations;
                performanceTrendsChart.data.datasets[1].data = leads;
                performanceTrendsChart.update();
            }
        }

        // Update recent leads table
        function updateRecentLeads(leads) {
            const tbody = document.getElementById('recentLeadsTable');
            
            if (leads.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-8 text-gray-400">Aucun lead récent</td></tr>';
                return;
            }
            
            tbody.innerHTML = leads.map(lead => `
                <tr class="border-b border-gray-700 hover:bg-gray-700">
                    <td class="py-3 px-4 font-mono text-xs">${lead.session_id}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold ${getScoreColor(lead.final_score)}">
                            ${lead.final_score}/100
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold ${getLevelColor(lead.level)}">
                            ${lead.level}
                        </span>
                    </td>
                    <td class="py-3 px-4">${formatCurrency(lead.estimated_value)}</td>
                    <td class="py-3 px-4">${lead.category}</td>
                    <td class="py-3 px-4 text-sm text-gray-400">${formatDate(lead.created_at)}</td>
                    <td class="py-3 px-4">
                        <button onclick="showLeadDetails('${lead.session_id}')" 
                                class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-xs">
                            Voir détails
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Initialize charts
        function initializeCharts() {
            // Lead Qualification Chart
            const leadCtx = document.getElementById('leadQualificationChart').getContext('2d');
            leadQualificationChart = new Chart(leadCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Haute Valeur', 'Valeur Moyenne', 'Faible Valeur'],
                    datasets: [{
                        data: [0, 0, 0],
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });

            // Performance Trends Chart
            const perfCtx = document.getElementById('performanceTrendsChart').getContext('2d');
            performanceTrendsChart = new Chart(perfCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Conversations',
                        data: [],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'Leads',
                        data: [],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#ffffff'
                            },
                            grid: {
                                color: '#374151'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#ffffff'
                            },
                            grid: {
                                color: '#374151'
                            }
                        }
                    }
                }
            });
        }

        // Animate counter
        function animateCounter(elementId, value, suffix = '') {
            const element = document.getElementById(elementId);
            if (!element) return;
            
            const counter = new CountUp(elementId, 0, value, 0, {
                duration: 2,
                separator: ',',
                decimal: '.'
            });
            
            counter.start();
            
            // Add suffix after animation
            setTimeout(() => {
                element.textContent = element.textContent + suffix;
            }, 2000);
        }

        // Show lead details
        async function showLeadDetails(sessionId) {
            try {
                const response = await fetch(`/api/commercial/lead-details/${sessionId}`);
                const data = await response.json();
                
                if (data.success) {
                    const details = data.data;
                    document.getElementById('leadDetails').innerHTML = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-semibold text-gray-300">Score Final</h4>
                                    <p class="text-2xl font-bold text-blue-400">${details.lead_score?.final_score || 0}/100</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-300">Niveau</h4>
                                    <p class="text-lg">${details.lead_score?.level || 'N/A'}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-300">Valeur Estimée</h4>
                                    <p class="text-lg">${formatCurrency(details.lead_score?.estimated_value || 0)}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-300">Probabilité de Conversion</h4>
                                    <p class="text-lg">${details.lead_score?.conversion_probability || 0}%</p>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="font-semibold text-gray-300 mb-2">Scores BANT</h4>
                                <div class="grid grid-cols-4 gap-2">
                                    <div class="bg-gray-700 p-3 rounded">
                                        <p class="text-sm text-gray-400">Budget</p>
                                        <p class="text-lg font-bold">${details.lead_score?.bant_scores?.budget || 0}</p>
                                    </div>
                                    <div class="bg-gray-700 p-3 rounded">
                                        <p class="text-sm text-gray-400">Autorité</p>
                                        <p class="text-lg font-bold">${details.lead_score?.bant_scores?.authority || 0}</p>
                                    </div>
                                    <div class="bg-gray-700 p-3 rounded">
                                        <p class="text-sm text-gray-400">Besoin</p>
                                        <p class="text-lg font-bold">${details.lead_score?.bant_scores?.need || 0}</p>
                                    </div>
                                    <div class="bg-gray-700 p-3 rounded">
                                        <p class="text-sm text-gray-400">Timeline</p>
                                        <p class="text-lg font-bold">${details.lead_score?.bant_scores?.timeline || 0}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('leadModal').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error loading lead details:', error);
            }
        }

        // Utility functions
        function getScoreColor(score) {
            if (score >= 80) return 'bg-green-600 text-white';
            if (score >= 60) return 'bg-yellow-600 text-white';
            return 'bg-red-600 text-white';
        }

        function getLevelColor(level) {
            switch (level) {
                case 'Hot Lead': return 'bg-red-600 text-white';
                case 'Warm Lead': return 'bg-yellow-600 text-white';
                case 'Qualified Lead': return 'bg-blue-600 text-white';
                default: return 'bg-gray-600 text-white';
            }
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('fr-FR', {
                style: 'currency',
                currency: 'EUR'
            }).format(amount);
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    </script>
</body>
</html> 