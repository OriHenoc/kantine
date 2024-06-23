<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;

Route::prefix("roles")->group(function(){
    Route::get("/", [RoleController::class, "listeRole"]);
    Route::post("/", [RoleController::class, "creerRole"]);
    Route::put("/{id}", [RoleController::class, "modifierRole"]);
    Route::put("/{id}", [RoleController::class, "changerActivation"]);
    Route::put("/{id}", [RoleController::class, "changerSuppression"]);


});


Route::prefix("clients")->group(function(){
    Route::get("/", [ClientController::class, "listeClient"]);
    Route::post("/", [ClientController::class, "creerClient"]);
    Route::put("/{id}", [ClientController::class, "modifierClient"]);
    Route::put("/{id}", [ClientController::class, "changerActivation"]);
    Route::put("/{id}", [ClientController::class, "changerSuppression"]);
});

Route::prefix("utilisateurs")->group(function(){
    Route::get("/", [UtilisateurController::class, "listeUtilisateur"]);
    Route::post("/", [UtilisateurController::class, "creerUtilisateur"]);
    Route::put("/{id}", [UtilisateurController::class, "modifierInfo"]);
    /*Route::put("/{id}", [UtilisateurController::class, "changerActivation"]);
    Route::put("/{id}", [UtilisateurController::class, "changerSuppression"]); */
});

