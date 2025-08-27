<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// RAG Chat API Routes - No CSRF protection needed in API routes
Route::prefix('chat')->group(function () {
    Route::post('/', [App\Http\Controllers\ChatController::class, 'chat']);
    Route::post('/qualify', [App\Http\Controllers\ChatController::class, 'qualifyLead']);
    Route::get('/health', [App\Http\Controllers\ChatController::class, 'healthCheck']);
    Route::delete('/clear/{session_id}', [App\Http\Controllers\ChatController::class, 'clearConversation']);
});

// RAG System Integration API - Store conversations and messages
Route::post('/conversations', function (Request $request) {
    $validated = $request->validate([
        'session_id' => 'required|string',
        'user_ip' => 'nullable|string',
        'referrer' => 'nullable|string'
    ]);

    // Check if conversation already exists
    $exists = DB::table('chat_conversations')->where('session_id', $validated['session_id'])->exists();
    if ($exists) {
        return response()->json(['success' => true, 'message' => 'Conversation already exists']);
    }

    DB::table('chat_conversations')->insert([
        'session_id' => $validated['session_id'],
        'user_ip' => $validated['user_ip'] ?? '127.0.0.1',
        'referrer' => $validated['referrer'] ?? 'direct',
        'started_at' => now(),
        'last_activity_at' => now(),
        'is_active' => true,
        'message_count' => 0,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return response()->json(['success' => true, 'message' => 'Conversation stored']);
});

Route::post('/messages', function (Request $request) {
    $validated = $request->validate([
        'session_id' => 'required|string',
        'role' => 'required|string|in:user,assistant',
        'content' => 'required|string',
        'metadata' => 'nullable|array'
    ]);

    DB::table('chat_messages')->insert([
        'session_id' => $validated['session_id'],
        'role' => $validated['role'],
        'content' => $validated['content'],
        'metadata' => json_encode($validated['metadata'] ?? []),
        'sent_at' => now(),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // Update conversation message count
    DB::table('chat_conversations')
        ->where('session_id', $validated['session_id'])
        ->increment('message_count');

    return response()->json(['success' => true, 'message' => 'Message stored']);
});

// Consultation requests API
Route::post('/consultation/request', function (Request $request) {
    $validated = $request->validate([
        'session_id' => 'required|string',
        'email' => 'nullable|string',
        'phone' => 'nullable|string',
        'industry' => 'nullable|string',
        'request_type' => 'nullable|string|in:consultation,demo,quote,general',
        'notes' => 'nullable|string',
        'status' => 'nullable|string|in:pending,scheduled,completed',
        'preferred_contact' => 'nullable|string',
        'preferred_time' => 'nullable|string'
    ]);

    DB::table('consultation_requests')->insert([
        'session_id' => $validated['session_id'],
        'email' => $validated['email'] ?? '',
        'phone' => $validated['phone'] ?? '',
        'industry' => $validated['industry'] ?? 'unknown',
        'request_type' => $validated['request_type'] ?? 'consultation',
        'status' => $validated['status'] ?? 'pending',
        'notes' => $validated['notes'] ?? '',
        'preferred_contact' => $validated['preferred_contact'] ?? 'email',
        'preferred_time' => $validated['preferred_time'] ?? 'flexible',
        'requested_at' => now(),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return response()->json(['success' => true, 'message' => 'Consultation request saved']);
});