<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SimpleAnalyticsSeeder extends Seeder
{
    public function run()
    {
        // Create sample conversations
        $sessionIds = [];
        for ($i = 1; $i <= 30; $i++) {
            $sessionId = 'demo_session_' . $i;
            $sessionIds[] = $sessionId;
            
            DB::table('chat_conversations')->insert([
                'session_id' => $sessionId,
                'user_ip' => '192.168.1.' . rand(1, 254),
                'referrer' => ['google.com', 'linkedin.com', 'direct', 'facebook.com'][rand(0, 3)],
                'started_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                'last_activity_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                'is_active' => rand(1, 100) <= 20,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Industries with realistic distribution
        $industries = [
            'Technology' => 8,
            'Healthcare' => 6, 
            'Finance' => 5,
            'E-commerce' => 4,
            'Manufacturing' => 3,
            'Real Estate' => 2,
            'Education' => 2,
            'Consulting' => 2,
            'Marketing' => 2,
            'Legal Services' => 1
        ];

        $leadCount = 0;
        foreach ($industries as $industry => $count) {
            for ($i = 0; $i < $count; $i++) {
                $leadCount++;
                if ($leadCount > 25) break; // Limit to 25 leads
                
                DB::table('lead_qualifications')->insert([
                    'session_id' => $sessionIds[($leadCount - 1) % count($sessionIds)],
                    'intent' => ['information', 'pricing', 'demo', 'purchase'][rand(0, 3)],
                    'urgency' => ['low', 'medium', 'high'][rand(0, 2)],
                    'company_size' => ['startup', 'sme', 'enterprise'][rand(0, 2)],
                    'industry' => $industry,
                    'company_name' => $industry . ' Company ' . ($i + 1),
                    'lead_score' => rand(0, 100),
                    'sales_ready' => rand(1, 100) <= 30,
                    'conversation_quality' => rand(5, 10),
                    'model_confidence' => rand(70, 95) / 100,
                    'qualified_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Add some chat messages
        foreach (array_slice($sessionIds, 0, 20) as $sessionId) {
            $messageCount = rand(2, 6);
            
            for ($j = 0; $j < $messageCount; $j++) {
                $isUser = $j % 2 === 0;
                
                DB::table('chat_messages')->insert([
                    'session_id' => $sessionId,
                    'role' => $isUser ? 'user' : 'assistant',
                    'content' => $isUser ? 
                        'Hello, I need help with AI solutions' : 
                        'I\'d be happy to help you with our AI and automation solutions!',
                    'sent_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        echo "\nSeeded:\n";
        echo "- " . count($sessionIds) . " conversations\n";
        echo "- 25 lead qualifications\n";
        echo "- Sample chat messages\n";
        echo "✅ Analytics data ready!\n";
    }
}