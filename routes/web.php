<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\MetricsController;
use App\Mail\ContactMessage;
use Illuminate\Http\Request;

// Route vers un contrôleur
Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/about', [App\Http\Controllers\IndexController::class, 'about']);
Route::get('/service/communication-et-marketing-digital', [App\Http\Controllers\IndexController::class, 'service01']);
Route::get('/a-propos', [App\Http\Controllers\IndexController::class, 'about']);
Route::get('/service/promotion-immobiliere-conciergerie', [App\Http\Controllers\IndexController::class, 'service02']);
Route::get('/service/agroalimentaire-tracabilite', [App\Http\Controllers\IndexController::class, 'service03']);
Route::get('/notre-demarche', [App\Http\Controllers\IndexController::class, 'demarche']);
Route::get('/contact', [App\Http\Controllers\IndexController::class, 'contact']);
Route::get('/faqs', [App\Http\Controllers\IndexController::class, 'awa']);
Route::get('/demo', [App\Http\Controllers\IndexController::class, 'demo']);
Route::get('/industries', [App\Http\Controllers\IndexController::class, 'industries']);
Route::get('/technology', [App\Http\Controllers\IndexController::class, 'technology']);
Route::get('/resources', [App\Http\Controllers\IndexController::class, 'resources']);
Route::get('/commercial-dashboard', [App\Http\Controllers\IndexController::class, 'commercialDashboard']);
Route::get('/solutions/brain-assistant', [App\Http\Controllers\IndexController::class, 'brainAssistant']);
Route::get('/solutions/brain-rh', [App\Http\Controllers\IndexController::class, 'brainRh']);
Route::get('/solutions/brain-invest', [App\Http\Controllers\IndexController::class, 'brainInvest']);


// Route pour la soumission du formulaire de réservation
Route::post('/message', function (Request $request) {
    // Valider les données du formulaire
    $validated = $request->validate([
        'user-name' => 'required|string',
        'user-email' => 'required|email',
        'user-subject' => 'required|string',
        'user-message' => 'required|string',
    ]);

    // Préparer les données pour l'email
    $data = [
        'user-name' => $validated['user-name'],
        'user-email' => $validated['user-email'],
        'user-subject' => $validated['user-subject'],
        'user-message' => $validated['user-message'],
    ];

    // Envoyer l'email
    Mail::to("contact@braingentech.com")->send(new ContactMessage($data));

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'Votre message a été envoyé avec succès!');
});

// Analytics Dashboard Routes (temporarily without auth for demo)
Route::prefix('analytics')->group(function () {
    Route::get('/dashboard', [AnalyticsController::class, 'dashboard'])->name('analytics.dashboard');
});

// Analytics API Routes
Route::prefix('api/analytics')->group(function () {
    Route::get('/data', [AnalyticsController::class, 'getData'])->name('analytics.data');
    Route::get('/realtime', [AnalyticsController::class, 'getRealTimeMetrics'])->name('analytics.realtime');
});

// Metrics endpoints for Prometheus
Route::get('/metrics', [MetricsController::class, 'metrics'])->name('metrics.prometheus');
Route::get('/api/metrics/business', [MetricsController::class, 'businessMetrics'])->name('metrics.business');
