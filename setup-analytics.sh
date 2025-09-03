#!/bin/bash

# Setup Analytics Dashboard for BrainGenTechnology
echo "🧠 Setting up BrainGenTechnology Analytics Dashboard..."
echo "=================================================="

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Please run this script from the Laravel project root directory"
    exit 1
fi

# Run database migrations
echo "📊 Running database migrations..."
php artisan migrate --force

# Clear application cache
echo "🔄 Clearing application cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Create some sample data if none exists
echo "📝 Checking for existing data..."
CONVERSATION_COUNT=$(php artisan tinker --execute="echo DB::table('chat_conversations')->count();")

if [ "$CONVERSATION_COUNT" -eq "0" ]; then
    echo "🎯 Creating sample analytics data for demonstration..."
    
    # Create sample conversations and leads
    php artisan tinker --execute="
    \$sessionIds = [];
    for (\$i = 0; \$i < 25; \$i++) {
        \$sessionId = 'demo_session_' . uniqid();
        \$sessionIds[] = \$sessionId;
        
        // Create conversation
        DB::table('chat_conversations')->insert([
            'session_id' => \$sessionId,
            'user_ip' => '127.0.0.1',
            'user_agent' => 'Sample User Agent',
            'referrer' => 'https://google.com',
            'message_count' => rand(2, 20),
            'started_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
            'last_activity_at' => now()->subDays(rand(0, 7))->subHours(rand(0, 23)),
            'is_active' => rand(0, 1),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Create some messages
        \$messageCount = rand(3, 15);
        for (\$j = 0; \$j < \$messageCount; \$j++) {
            \$isUser = \$j % 2 === 0;
            DB::table('chat_messages')->insert([
                'session_id' => \$sessionId,
                'message_id' => 'msg_' . uniqid(),
                'role' => \$isUser ? 'user' : 'assistant',
                'content' => \$isUser ? 'What AI services do you offer?' : 'We offer Brain Assistant, Brain RH+, and Brain Invest solutions.',
                'metadata' => json_encode(['timestamp' => now()->toISOString()]),
                'sent_at' => now()->subDays(rand(0, 30)),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Create lead qualification for some sessions
        if (rand(0, 100) < 40) { // 40% conversion rate
            \$industries = ['Technology', 'Healthcare', 'Finance', 'Manufacturing', 'Retail', 'Education'];
            \$companySizes = ['startup', 'sme', 'mid_market', 'enterprise'];
            \$intents = ['information', 'quote', 'demo', 'consultation'];
            
            DB::table('lead_qualifications')->insert([
                'session_id' => \$sessionId,
                'intent' => \$intents[array_rand(\$intents)],
                'urgency' => ['low', 'medium', 'high'][rand(0, 2)],
                'company_size' => \$companySizes[array_rand(\$companySizes)],
                'industry' => \$industries[array_rand(\$industries)],
                'lead_score' => rand(30, 95),
                'sales_ready' => rand(0, 100) < 25, // 25% sales ready
                'conversation_quality' => rand(6, 10),
                'follow_up_priority' => ['low', 'medium', 'high'][rand(0, 2)],
                'model_confidence' => rand(60, 95) / 100,
                'qualified_at' => now()->subDays(rand(0, 30)),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    echo 'Sample data created successfully!';
    "
    echo "✅ Sample data created successfully!"
else
    echo "✅ Existing data found - skipping sample data creation"
fi

# Set proper permissions
echo "🔐 Setting proper permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo ""
echo "🎉 Analytics Dashboard Setup Complete!"
echo "=================================================="
echo ""
echo "📊 Access your analytics dashboard at:"
echo "   Dashboard: http://localhost:8000/analytics/dashboard"
echo "   API Data: http://localhost:8000/api/analytics/data"
echo "   Real-time: http://localhost:8000/api/analytics/realtime"
echo ""
echo "🔒 Note: The dashboard is protected by authentication middleware."
echo "   Make sure you have user authentication set up."
echo ""
echo "🚀 Next steps:"
echo "   1. Start your Laravel server: php artisan serve"
echo "   2. Start your RAG server: cd rag_system && python working_server.py"
echo "   3. Visit the analytics dashboard"
echo ""
echo "Happy analyzing! 🧠✨"