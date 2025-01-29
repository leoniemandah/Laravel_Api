<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware(['auth:admin'])->group(function () {
    Route::post("/profile", [ProfileController::class, 'store']);
    Route::delete("/profile/{id}", [ProfileController::class, 'destroy']);
    Route::put("/profile/{id}", [ProfileController::class, 'update']);
});

Route::get("/profil", [ProfileController::class, 'index']);
Route::get("/profil/{id}", [ProfileController::class, 'show']);
