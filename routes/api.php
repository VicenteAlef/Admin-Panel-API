<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rotas públicas de autenticação
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('verify-2fa', [AuthController::class, 'verify2FA']);
});

// Rotas protegidas (exigem envio do token Bearer)
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/me', [AuthController::class, 'me']);

    // As rotas do CRUD de veículos e gestão de usuários entrarão aqui depois...
});
