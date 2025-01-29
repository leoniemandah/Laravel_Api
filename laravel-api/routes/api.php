<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

// Route publique pour la connexion des administrateurs
Route::post('/admin/login', [AuthController::class, 'login']);

// Routes publiques pour les profils
// Récupérer tous les profils
Route::get("/profile", [ProfileController::class, 'index']);
// Récupérer un profil spécifique par son ID
Route::get("/profile/{id}", [ProfileController::class, 'show']);

// Groupe de routes protégées par l'authentification des administrateurs
Route::middleware(['auth:admin'])->group(function () {
    // Créer un nouveau profil (réservé aux administrateurs authentifiés)
    Route::post("/profile", [ProfileController::class, 'store']);
    
    // Supprimer un profil existant par son ID (réservé aux administrateurs authentifiés)
    Route::delete("/profile/{id}", [ProfileController::class, 'destroy']);
    
    // Mettre à jour un profil existant par son ID (réservé aux administrateurs authentifiés)
    Route::put("/profile/{id}", [ProfileController::class, 'update']);
});
