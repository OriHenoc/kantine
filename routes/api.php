<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\GroupeDeClientController;
use App\Http\Controllers\TypeDePlatController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\PosteEmployeController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CommandeController;
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
    Route::post("/imagePlat/{id}", [PlatController::class, "modifierPhoto"]);
    Route::put("/changerStatut/{id}", [PlatController::class, "changerActivation"]);
    Route::put("/changerSuppression/{id}", [PlatController::class, "changerSuppression"]);
});

Route::prefix("PostesEmployes")->group(function(){
    Route::get("/", [PosteEmployeController::class, "listerPostes"]);
    Route::get("/voirDeatilUnPoste/{id}", [PosteEmployeController::class, "voirPostes"]);
    Route::post("/", [PosteEmployeController::class, "creerPoste"]);
    Route::put("/modifierPostes/{id}", [PosteEmployeController::class, "modifierInfoPoste"]);
    Route::put("/changerStatut/{id}", [PosteEmployeController::class, "changerActivation"]);
    Route::put("/changerSuppression/{id}", [PosteEmployeController::class, "changerSuppression"]);
});


Route::prefix("Employes")->group(function(){
    Route::get("/", [EmployeController::class, "listeEmploye"]);
    Route::get("/voirDeatilUnEmploye/{id}", [EmployeController::class, "voirEmploye"]);
    Route::post("/", [EmployeController::class, "creerEmploye"]);
    Route::post("/photoEmploye/{id}", [EmployeController::class, "modifierPhoto"]);
    Route::put("/modifierEmploye/{id}", [EmployeController::class, "modifierInfoEmploye"]);
    Route::put("/changerStatut/{id}", [EmployeController::class, "changerActivation"]);
    Route::put("/changerSuppression/{id}", [EmployeController::class, "changerSuppression"]);
});


Route::prefix("Menus")->group(function(){
    Route::get("/", [MenuController::class, "listeMenu"]);
    Route::get("/voirDeatilUnMenu/{id}", [MenuController::class, "voirMenu"]);
    Route::post("/", [MenuController::class, "creerMenu"]);
    Route::put("/modifierMenu/{id}", [MenuController::class, "modifierInfoMenu"]);
    Route::put("/changerStatut/{id}", [MenuController::class, "changerActivation"]);
    Route::put("/changerSuppression/{id}", [MenuController::class, "changerSuppression"]);
});

Route::prefix("Commandes")->group(function(){
    Route::get("/", [CommandeController::class, "listeCommandes"]);
    Route::get("/voirDeatilUneCommande/{id}", [CommandeController::class, "voirCommande"]);
    Route::post("/", [CommandeController::class, "creerCommande"]);
    Route::put("/modifierCommande/{id}", [CommandeController::class, "modifierInfoCommande"]);
    Route::put("/changerStatut/{id}", [CommandeController::class, "changerActivation"]);
    Route::put("/changerSuppression/{id}", [CommandeController::class, "changerSuppression"]);
});