<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix("roles")->group(function(){
    Route::get("/", [RoleController::class, "listeRole"]);
    Route::post("/", [RoleController::class, "creerRole"]);
});
