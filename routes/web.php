<?php

use App\Http\Controllers\CalculateurController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/calculateur/prix-ttc', [CalculateurController::class, 'prixTtc']);
Route::post('/api/calculateur/appliquer-remise', [CalculateurController::class, 'appliquerRemise']);
