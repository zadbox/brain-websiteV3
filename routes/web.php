<?php

use Illuminate\Support\Facades\Route;

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
