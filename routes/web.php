<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Mail\ContactMessage;
use Illuminate\Http\Request;

// Route vers un contrôleur
Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/a-propos', [App\Http\Controllers\IndexController::class, 'about']);
Route::get('/service/communication-et-marketing-digital', [App\Http\Controllers\IndexController::class, 'service01']);
Route::get('/a-propos', [App\Http\Controllers\IndexController::class, 'about']);
Route::get('/service/promotion-immobiliere-conciergerie', [App\Http\Controllers\IndexController::class, 'service02']);
Route::get('/service/agroalimentaire-tracabilite', [App\Http\Controllers\IndexController::class, 'service03']);
Route::get('/notre-demarche', [App\Http\Controllers\IndexController::class, 'demarche']);
Route::get('/contact', [App\Http\Controllers\IndexController::class, 'contact']);
Route::get('/faqs', [App\Http\Controllers\IndexController::class, 'awa']);
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
    Mail::to("bakkouadnane.rs88@gmail.com")->send(new ContactMessage($data));

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'Votre message a été envoyé avec succès!');
});
