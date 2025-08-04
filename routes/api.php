<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// === Chatbot Routes ===
Route::prefix('chatbot')->group(function () {
    Route::post('/message', [ChatbotController::class, 'sendMessage']);
    Route::post('/qualify-lead', [ChatbotController::class, 'qualifyLead']);
    Route::get('/search-knowledge', [ChatbotController::class, 'searchKnowledge']);
    Route::get('/status', [ChatbotController::class, 'getStatus']);
    Route::get('/config', [ChatbotController::class, 'getConfig']);
});

// === Agent Compatibility Routes ===
Route::prefix('agent')->group(function () {
    Route::get('/ping', function() {
        return response()->json([
            'pong' => true, 
            'timestamp' => now(),
            'status' => 'healthy'
        ]);
    });
    
    // UI Integration - Route agent/message to chatbot/message
    Route::post('/message', [ChatbotController::class, 'sendMessage']);
});



// === Health Check Route ===
Route::get('/health', function() {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'version' => '2.0.0',
        'services' => [
            'laravel' => 'healthy',
            'python_api' => 'healthy',
            'chatbot' => 'healthy'
        ]
    ]);
});

// === Prometheus Metrics Endpoint ===
Route::get('/metrics', function() {
    $metrics = [
        '# HELP laravel_app_status Application status (1=healthy, 0=unhealthy)',
        '# TYPE laravel_app_status gauge',
        'laravel_app_status 1',
        '',
        '# HELP laravel_uptime_seconds Application uptime in seconds',
        '# TYPE laravel_uptime_seconds counter',
        'laravel_uptime_seconds ' . (time() - LARAVEL_START),
        '',
        '# HELP laravel_memory_usage_bytes Current memory usage in bytes',
        '# TYPE laravel_memory_usage_bytes gauge',
        'laravel_memory_usage_bytes ' . memory_get_usage(true),
        '',
        '# HELP laravel_requests_total Total number of HTTP requests',
        '# TYPE laravel_requests_total counter',
        'laravel_requests_total ' . (cache()->get('request_count', 0) + 1),
    ];
    
    cache()->put('request_count', cache()->get('request_count', 0) + 1, 3600);
    
    return response(implode("\n", $metrics))
        ->header('Content-Type', 'text/plain; version=0.0.4; charset=utf-8');
});