<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

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


    /*
     public function voirUtilisateur($id)
    {
        $utilisateur = Utilisateur::find($id);
        return response()->json(['voir utilisateur'=>$utilisateur, 'code' => 200]);
    }  
        
    */

    public function modifierInfo(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        
        $validationDesDonnees = $request->validate([
            'code' => 'required',
            'nomComplet' => 'required',
            'numero1' => 'required|string|unique:utilisateurs'.$utilisateur->id,
            'numero2' => 'nullable|string|unique:utilisateurs'.$utilisateur->id,
            'genre' => 'required|in:M,F',
            'email' => 'required|string|email|unique:utilisateurs'.$utilisateur->id,
            'roleID' => 'required|exists:roles,id'
        ]);
       
        
        $input = $request->all();
        dd($input);
        $utilisateur->update($input);
        return response()->json([' infos utilisateur modifiés'=>$utilisateur, 'code' => 200]);
    }

}
