<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;


class MenuController extends Controller
{
    public function listeMenu()
    {
        $menus = Menu::all();
        return response()->json(['liste des menus' => $menus, 'code' => 200]);
    }

    public function creerMenu(Request $request)
    {
        // Validation des données pour Menu
        $validationDesDonnees = $request->validate([
            'date' => 'required|date',
            'code' => 'required|string|unique:menus',
            'platID' => 'required|exists:plats,id',
        ]);

        // Récupération des données validées
        $input = $request->all();
        $input['createdBy'] = 1; // Remplacer par l'ID de l'utilisateur actuel
        $input['updatedBy'] = 1; // Remplacer par l'ID de l'utilisateur actuel

        // Création du menu avec les données validées
        $menu = Menu::create($input);

        return response()->json(['menu créé' => $menu, 'code' => 201]);
    }


    public function voirMenu($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu non trouvé', 'code' => 404]);
        }
        return response()->json(['menu' => $menu, 'code' => 200]);
    }



    public function modifierInfoMenu(Request $request, $id)
{
    // Validation des données pour Menu
    $validationDesDonnees = $request->validate([
        'date' => 'sometimes|required|date',
        'code' => 'sometimes|required|string',
        'platID' => 'sometimes|required|exists:plats,id'
    ]);

    // Trouver le menu par ID
    $menu = Menu::find($id);
    if (!$menu) {
        return response()->json(['message' => 'Menu non trouvé'], 404);
    }

    // Mise à jour des données validées
    $input = $request->all();
    $input['updatedBy'] = 1; // Remplacer 1 par l'ID de l'utilisateur actuel

    $menu->update($input);

    return response()->json(['menu modifié' => $menu, 'code' => 200]);
}

public function changerActivation($id)
{
    $menu = Menu::find($id);

    if (!$menu) {
        return response()->json(['message' => 'Menu non trouvé', 'code' => 404]);
    }

    $message = "";
    if ($menu->active == 1) {
        $menu->active = 0;  
        $message = "Menu désactivé";
    } else {
        $menu->active = 1; 
        $message = "Menu activé";
    }

    $menu->save();

    return response()->json([$message => $menu, 'code' => 200]);
}

public function changerSuppression($id)
{
    $menu = Menu::find($id);

    if (!$menu) {
        return response()->json(['message' => 'Menu non trouvé', 'code' => 404]);
    }

    $message = "";
    if ($menu->deleted == 1) {
        $menu->deleted = 0;  
        $message = "Menu restauré";
    } else {
        $menu->deleted = 1; 
        $message = "Menu supprimé";
    }

    $menu->save();

    return response()->json([$message => $menu, 'code' => 200]);
}


}
