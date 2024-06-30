<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\GroupeDeClientController;
use App\Http\Controllers\TypeDePlatController;
use App\Http\Controllers\PlatController;
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
    Route::put("/modifierClient/{id}", [ClientController::class, "modifierInfo"]);
    Route::post("/photoClient/{id}", [ClientController::class, "modifierPhoto"]);
    Route::put("/changerStatut/{id}", [ClientController::class, "changerActivation"]);
    Route::put("/statutSuppression/{id}", [ClientController::class, "changerSuppression"]);
});

Route::prefix("utilisateurs")->group(function(){
    Route::get("/", [UtilisateurController::class, "listeUtilisateur"]);
    Route::post("/", [UtilisateurController::class, "creerUtilisateur"]);
    Route::put("/{id}", [UtilisateurController::class, "modifierInfo"]);
    Route::post("/photo/{id}", [UtilisateurController::class, "modifierPhoto"]);
    Route::put("/motdepasse/{id}", [UtilisateurController::class, "modifierMotDePasse"]);
    Route::put("/changerstatut{id}", [UtilisateurController::class, "changerActivation"]); 
    Route::put("/{id}", [UtilisateurController::class, "changerSuppression"]); 

 
});

Route::prefix("groupesClients")->group(function(){
    Route::get("/", [GroupeDeClientController::class, "listerGroupesDeClients"]);
    Route::post("/", [GroupeDeClientController::class, "creerGroupesDeClients"]);
    Route::put("/{id}", [GroupeDeClientController::class, "modifierGroupeDeClient"]);
    Route::put("/changerstatut/{id}", [GroupeDeClientController::class, "changerActivation"]);
    Route::put("/{id}", [GroupeDeClientController::class, "changerSuppression"]);
    /*Route::put("/{id}", [UtilisateurController::class, "changerSuppression"]); */
});

Route::prefix("TypesDePlats")->group(function(){
    Route::get("/", [TypeDePlatController::class, "listerTypeDePlats"]);
    Route::post("/", [TypeDePlatController::class, "creerTypeDePlat"]);
    Route::put("/modifietTypesDePlats/{id}", [TypeDePlatController::class, "modifierTypeDePlat"]);
    Route::put("/changerStatut/{id}", [TypeDePlatController::class, "changerActivation"]);
    Route::put("/changerSuppression/{id}", [TypeDePlatController::class, "changerSuppression"]);
    /*Route::put("/{id}", [UtilisateurController::class, "changerSuppression"]); */
});


Route::prefix("Plats")->group(function(){
    Route::get("/", [PlatController::class, "listerPlats"]);
    Route::post("/", [PlatController::class, "creerPlat"]);
    Route::put("/modifierPlats/{id}", [PlatController::class, "modifierInfoPlat"]);
    Route::put("/changerStatut/{id}", [PlatController::class, "changerActivation"]);
    Route::post("/imagePlat/{id}", [UtilisateurController::class, "modifierPhoto"]);
    Route::put("/changerSuppression/{id}", [PlatController::class, "changerSuppression"]);
    /*Route::put("/{id}", [UtilisateurController::class, "changerSuppression"]); */
});
