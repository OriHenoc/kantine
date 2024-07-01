<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PosteEmploye;
use Illuminate\Support\Facades\Validator;


class PosteEmployeController extends Controller
{
    public function listerPostes()
    {
        $postes = PosteEmploye::all();
        return response()->json(['liste des postes' => $postes, 'code' => 200]);
    }

    public function creerPoste(Request $request)
    {
        $validationDesDonnees = $request->validate([
            'libelle' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $input = $request->all();
        $input['createdBy'] = 1; // Remplacez par l'ID de l'utilisateur authentifié
        $input['updatedBy'] = 1; // Remplacez par l'ID de l'utilisateur authentifié

        $poste = PosteEmploye::create($input);

        return response()->json(['poste créé' => $poste, 'code' => 201]);
    }

    public function voirPostes($id)
    {
        $poste = PosteEmploye::find($id);

        if (!$poste) {
            return response()->json(['message' => 'Poste non trouvé'], 404);
        }

        return response()->json(['poste' => $poste, 'code' => 200]);
    }

    public function modifierInfoPoste(Request $request, $id)
    {
        $poste = PosteEmploye::find($id);

        if (!$poste) {
            return response()->json(['message' => 'Poste non trouvé'], 404);
        }

        $validator = Validator::make($request->all(), [
            'libelle' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        $input = $validator->validated();
        $input['updatedBy'] = 1; // Remplacez par l'ID de l'utilisateur authentifié

        $poste->update($input);

        return response()->json(['poste modifié' => $poste, 'code' => 200]);
    }


    public function changerActivation($id)
    {
        $poste = PosteEmploye::find($id);

        if (!$poste) {
            return response()->json(['message' => 'Poste non trouvé'], 404);
        }

        $message = "";
        if ($poste->active == 1) {
            $poste->active = 0;
            $message = "Poste désactivé";
        } else {
            $poste->active = 1;
            $message = "Poste activé";
        }

        $poste->save();

        return response()->json([$message => $poste, 'code' => 200]);
    }


    public function changerSuppression($id)
    {
        $poste = PosteEmploye::find($id);

        if (!$poste) {
            return response()->json(['message' => 'Poste non trouvé'], 404);
        }

        $message = "";
        if ($poste->deleted == 1) {
            $poste->deleted = 0;
            $message = "Poste restauré";
        } else {
            $poste->deleted = 1;
            $message = "Poste supprimé";
        }

        $poste->save();

        return response()->json([$message => $poste, 'code' => 200]);
    }


}
