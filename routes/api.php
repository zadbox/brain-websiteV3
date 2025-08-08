<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// RAG Chat API Routes - No CSRF protection needed in API routes
Route::prefix('chat')->group(function () {
    Route::post('/', [App\Http\Controllers\ChatController::class, 'chat']);
    Route::post('/qualify', [App\Http\Controllers\ChatController::class, 'qualifyLead']);
    Route::get('/health', [App\Http\Controllers\ChatController::class, 'healthCheck']);
    Route::delete('/clear/{session_id}', [App\Http\Controllers\ChatController::class, 'clearConversation']);
});