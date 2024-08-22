<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarneController;

Route::get('/carne/{id}', [CarneController::class, 'show']);
Route::post('/gerar-parcelas', [CarneController::class, 'store']);
