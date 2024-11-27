<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\HistoriqueEquipementController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
//     // Route::get('/equipements', [EquipementController::class, 'index']);
//     // Route::post('/equipements', [EquipementController::class, 'store']);
//     // Route::post('/equipements/{id}/recuperer', [EquipementController::class, 'recuperer']);
// })->middleware('auth:sanctum');
Route::apiResource('clients', ClientController::class);

// API Resource pour les équipements
Route::apiResource('equipements', EquipementController::class);

// Routes spécifiques pour l'historique d'équipements
Route::get('historique', [HistoriqueEquipementController::class, 'index'])->name('historique.index');
Route::post('clients/{client}/equipements', [HistoriqueEquipementController::class, 'assign'])->name('historique.assign');
Route::post('clients/{client}/equipements/recuperer', [HistoriqueEquipementController::class, 'recover'])->name('historique.recover');
Route::get('/test', function () {
    return response()->json(['message' => 'API fonctionne']);
});
