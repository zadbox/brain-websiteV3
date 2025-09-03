<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsDataSeeder extends Seeder
{
    public function run()
    {
        $this->seedChatConversations();
        $this->seedLeadQualifications();
        $this->seedChatMessages();
    }

    private function seedChatConversations()
    {
        $conversations = [];
        $sessionIds = [];
        
        for ($i = 1; $i <= 50; $i++) {
            $sessionId = 'session_' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $sessionIds[] = $sessionId;
            
            $conversations[] = [
                'session_id' => $sessionId,
                'user_ip' => '192.168.1.' . rand(1, 254),
                'referrer' => ['google.com', 'linkedin.com', 'direct', 'facebook.com', 'twitter.com'][rand(0, 4)],
                'started_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                'last_activity_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                'is_active' => rand(1, 100) <= 20, // 20% active
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('chat_conversations')->insert($conversations);
        
        // Store session IDs for use in other seeders
        cache()->put('seeder_session_ids', $sessionIds, 3600);
    }

    private function seedLeadQualifications()
    {
        $sessionIds = cache()->get('seeder_session_ids', []);
        $industries = [
            'Technology', 'Healthcare', 'Finance', 'E-commerce', 'Manufacturing',
            'Real Estate', 'Education', 'Automotive', 'Retail', 'Consulting',
            'Marketing', 'Legal Services', 'Agriculture', 'Entertainment', 'Food & Beverage'
        ];
        
        $intents = ['information', 'pricing', 'demo', 'purchase', 'support'];
        $companySizes = ['startup', 'sme', 'enterprise', 'individual'];
        
        $qualifications = [];
        
        foreach (array_slice($sessionIds, 0, 35) as $sessionId) {
            $qualifications[] = [
                'session_id' => $sessionId,
                'lead_score' => rand(0, 100),
                'intent' => $intents[rand(0, count($intents)-1)],
                'urgency' => ['low', 'medium', 'high'][rand(0, 2)],
                'budget_range' => ['<10k', '10k-50k', '50k-100k', '100k+'][rand(0, 3)],
                'authority_level' => ['individual', 'influencer', 'decision_maker', 'budget_holder'][rand(0, 3)],
                'company_size' => $companySizes[rand(0, count($companySizes)-1)],
                'industry' => $industries[rand(0, count($industries)-1)],
                'needs_analysis' => json_encode([
                    'primary_need' => ['automation', 'ai_integration', 'process_optimization'][rand(0, 2)],
                    'timeline' => ['immediate', '1-3_months', '3-6_months', '6+_months'][rand(0, 3)]
                ]),
                'sales_ready' => rand(1, 100) <= 30, // 30% sales ready
                'conversation_quality' => round(rand(50, 100) / 10, 1), // 5.0 to 10.0
                'model_confidence' => round(rand(70, 95) / 100, 2), // 0.70 to 0.95
                'qualified_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('lead_qualifications')->insert($qualifications);
    }

    private function seedChatMessages()
    {
        $sessionIds = cache()->get('seeder_session_ids', []);
        $messages = [];
        
        $userMessages = [
            'Hello, I\'m interested in your AI solutions',
            'Can you tell me about automation services?',
            'What blockchain solutions do you offer?',
            'I need help with process optimization',
            'How much does your AI chatbot cost?',
            'Do you have experience in healthcare?',
            'Can you integrate with our existing systems?',
            'What\'s your implementation timeline?',
            'I\'d like to schedule a demo',
            'Tell me about your pricing plans'
        ];
        
        $assistantMessages = [
            'Hello! I\'d be happy to help you learn about our AI solutions. We specialize in automation, machine learning, and intelligent business processes.',
            'Our automation services include RPA, workflow optimization, and intelligent document processing. What specific processes are you looking to automate?',
            'We offer comprehensive blockchain solutions including smart contracts, supply chain traceability, and digital identity management.',
            'Process optimization is one of our core strengths. We can help streamline your operations using AI and automation technologies.',
            'Our pricing varies based on your specific needs and scale. I\'d recommend scheduling a consultation to discuss your requirements.',
            'Yes, we have extensive experience in healthcare, including compliance-ready solutions and patient data management systems.',
            'Absolutely! Our solutions are designed to integrate seamlessly with existing enterprise systems through APIs and custom connectors.',
            'Implementation timelines typically range from 2-8 weeks depending on complexity. We provide full project management support.',
            'I\'d be happy to arrange a demo. Let me connect you with our solutions specialist.',
            'We offer flexible pricing plans from starter packages to enterprise solutions. What\'s your expected scale?'
        ];
        
        foreach ($sessionIds as $index => $sessionId) {
            $messageCount = rand(2, 8);
            
            for ($i = 0; $i < $messageCount; $i++) {
                $isUser = $i % 2 === 0;
                
                $messages[] = [
                    'session_id' => $sessionId,
                    'role' => $isUser ? 'user' : 'assistant',
                    'content' => $isUser ? 
                        $userMessages[rand(0, count($userMessages)-1)] : 
                        $assistantMessages[rand(0, count($assistantMessages)-1)],
                    'metadata' => json_encode([
                        'processing_time' => $isUser ? null : round(rand(500, 3000) / 1000, 3),
                        'token_count' => rand(20, 150),
                        'model' => $isUser ? null : 'llama3-70b-8192'
                    ]),
                    'sent_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        DB::table('chat_messages')->insert($messages);
    }
}