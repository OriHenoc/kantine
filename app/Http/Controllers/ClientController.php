<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function listeClient()
    {
        $clients = Client::all();
        return response()->json(['liste des clients'=>$clients, 'code' => 200]);
    }

    public function creerClient(Request $request)
    {

     $input = $request->all();
            // dd($input);
            $client = Client::create($input);
     
     return response()->json(['client crée'=>$client, 'code' => 201]);          
    }

    public function voirClient($id)
    {
        $client = Client::find($id);
        return response()->json(['voir client'=>$client, 'code' => 200]);
    }


    public function modifierClient(Request $request, $id)
    {
       
        $client = Client::find($id);
        $input = $request->all();
        $client->update($input);
        return response()->json([' client modifié'=>$client, 'code' => 200]);
    }

    public function changerSuppression($id)
    {
       
        $client = Client::find($id);
        $message = "";
        if($client->deleted == 1){
            $client->deleted = 0;  
            $message = "Client restauré ";
        }else {
            $client->deleted = 1; 
            $message = "Client supprimé";
        }
        $client->update();
        return response()->json([$message=>$client, 'code' => 200]);

    }
}
