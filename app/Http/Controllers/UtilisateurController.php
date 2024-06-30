<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UtilisateurController extends Controller
{
    public function listeUtilisateur()
    {
        $utilisateurs = Utilisateur::all();
        return response()->json(['liste des utilisateurs'=>$utilisateurs, 'code' => 200]);
    }

    public function creerUtilisateur(Request $request)
    {

        $validationDesDonnees = $request->validate([
            'code' => 'required',
            'nomComplet' => 'required',
            'photo' => 'required|image|max:10240',
            'numero1' => 'required|string|unique:utilisateurs',
            'numero2' => 'nullable|string|unique:utilisateurs',
            'genre' => 'required|in:M,F',
            'email' => 'required|string|email|unique:utilisateurs',
            'motDePasse' => 'required|string|min:6',
            'roleID' => 'required|exists:roles,id'
        ]);

        if($request->hasFile('photo')){
            $cheminPhoto = $request->file('photo')->store('', 'photo_utilisateurs');
        }
        else{
            $cheminPhoto = null;
        }

        $motDePasseCrypte = Hash::make($validationDesDonnees['motDePasse']);

        $input = $request->all();
        $input['photo'] = $cheminPhoto;
        $input['motDePasse'] = $motDePasseCrypte;

        //dd($input);

        $utilisateur = Utilisateur::create($input);

        return response()->json(['utilisateur crée'=>$utilisateur, 'code' => 201]);
    }


    public function voirUtilisateur($id)
    {
        $utilisateur = Utilisateur::find($id);
        return response()->json(['Utilisateur'=>$utilisateur, 'code' => 200]);
    }

    public function modifierInfo(Request $request, $id)
    {
        $utilisateur = Utilisateur::find($id);

        if (!$utilisateur) {
            return response()->json(['Erreur' => 'Utilisateur non trouvé !', 'code' => 404]);
        }

        // Validation des données
        $validator = Validator::make($request->all(), [
            'code' => 'sometimes|required',
            'nomComplet' => 'sometimes|required',
            'numero1' => 'sometimes|required|string|unique:utilisateurs,numero1,' . $id,
            'numero2' => 'sometimes|nullable|string|unique:utilisateurs,numero2,' . $id,
            'genre' => 'sometimes|required|in:M,F',
            'email' => 'sometimes|required|string|email|unique:utilisateurs,email,' . $id,
            'roleID' => 'sometimes|required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors()], 422);
        }

        // Mise à jour des informations de l'utilisateur avec les données validées
        $donneesValidees = $validator->validated();
        $utilisateur->fill($donneesValidees);

        // Mise à jour des autres champs non validés explicitement
        $donneesNonValidees = $request->except(array_keys($donneesValidees));
        $utilisateur->fill($donneesNonValidees);

        // Sauvegarde des informations de l'utilisateur
        $utilisateur->save();

        return response()->json(['message' => 'Infos utilisateur modifiées', 'utilisateur' => $utilisateur, 'code' => 200]);
    }

    public function modifierPhoto(Request $request, $id)
    {
        $utilisateur = Utilisateur::find($id);

        if(!$utilisateur){
            return response()->json(['Erreur' => 'Utilisateur non trouvé !', 'code' => 404]);
        }
        else{
            // $request->validate([
            //     'photo' => 'required|image|max:10240',
            // ]);

            $validator = Validator::make($request->all(), [
                'photo' => 'required|image|max:10240',
            ]);

            if ($validator->fails()) {
                return response()->json(['Erreurs' => $validator->errors()], 422);
            }

            if ($request->hasFile('photo')) {
                $nouveauCheminPhoto = $request->file('photo')->store('', 'photo_utilisateurs');

                // Supprimer l'ancienne photo si nécessaire (pour éviter une accumulation de photos non utilisées)
                if ($utilisateur->photo) {
                    $ancienCheminDePhoto = public_path('assets/photosUtilisateurs/') . $utilisateur->photo;

                    if (File::exists($ancienCheminDePhoto)) {
                        File::delete($ancienCheminDePhoto);
                    }
                }
                $utilisateur->photo = $nouveauCheminPhoto;
                $utilisateur->save();
                return response()->json(['message' => 'Photo de l\'utilisateur modifiée', 'utilisateur' => $utilisateur, 'code' => 200]);
            } else {
                return response()->json(['Erreur' => 'Fichier photo non trouvé dans la requête !', 'code' => 200]);
            }
        }
    }

    public function modifierMotDePasse(Request $request, $id)
    {
        // Valider la requête
        $validator = Validator::make($request->all(), [
            'ancienMotDePasse' => 'required|string|min:6',
            'nouveauMotDePasse' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['Erreurs' => $validator->errors(), 'code' => 422]);
        }

        // Récupérer l'utilisateur concerné
        $utilisateur = Utilisateur::find($id);

        if (!$utilisateur) {
            return response()->json(['Erreur' => 'Utilisateur non trouvé !', 'code' => 404]);
        }

        // Vérifier l'ancien mot de passe
        if (!Hash::check($request->ancienMotDePasse, $utilisateur->motDePasse)) {
            return response()->json(['Erreur' => 'Ancien mot de passe incorrect !', 'code' => 403]);
        }

        // Crypter le nouveau mot de passe
        $utilisateur->motDePasse = Hash::make($request->nouveauMotDePasse);

        // Sauvegarder les modifications
        $utilisateur->save();

        return response()->json(['message' => 'Mot de passe mis à jour !', 'code' => 200]);
    }



    public function changerActivation($id)
    {
        // Trouver l'utilisateur par ID
        $utilisateur = Utilisateur::find($id);

        // Changer l'état d'activation
        $message = "";
        if ($utilisateur->active == 1) {
            $utilisateur->active = 0;  
            $message = "Utilisateur désactivé";
        } else {
            $utilisateur->active = 1; 
            $message = "Utilisateur activé";
        }

        // Enregistrer les modifications
        $utilisateur->save();

        return response()->json([$message => $utilisateur, 'code' => 200]);
    }

    public function changerSuppression($id)
    {
        // Trouver l'utilisateur par ID
        $utilisateur = Utilisateur::find($id);

        // Changer l'état de suppression
        $message = "";
        if ($utilisateur->deleted == 1) {
            $utilisateur->deleted = 0;  
            $message = "Utilisateur restauré";
        } else {
            $utilisateur->deleted = 1; 
            $message = "Utilisateur supprimé";
        }

        // Enregistrer les modifications
        $utilisateur->save();

        return response()->json([$message => $utilisateur, 'code' => 200]);
    }

}
