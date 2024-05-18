<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Chauffeur;
use App\Models\Compagnie;
use Illuminate\Http\Request;

class ChauffeurController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compagnies = Compagnie::all();
        
        return response()->json($compagnies);
    }

     /**
     * Store a new Compagnie in storage.
     */
    public function store(Request $request )
    {
        $jsonData = ["code" => 1, "msg" => "Enregistrement effectué avec succès."];
        
        if ($request->isMethod('post') && $request->input('name')) {

                $data = $request->all(); 
               
            try {

                $request->validate([
                    'name' => 'required',
                    'contact' => 'required',
                    'compagnie_id' => 'required',
                    'email' => 'required',
                    'adresse' => 'required',
                ]);

                $Chauffeur = Chauffeur::where('email', $data['email'])->exists();
                if($Chauffeur){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $chauffeur = new Chauffeur;
                $chauffeur->name = $data['name'];
                $chauffeur->contact = $data['contact'];
                $chauffeur->compagnie_id = $data['compagnie_id'];
                $chauffeur->email = $data['email'];
                $chauffeur->adresse = $data['adresse'];
                
                $chauffeur->created_by = $request->user();
                $chauffeur->save();
                
                $jsonData["data"] = json_decode($chauffeur);
                return response()->json($jsonData);

            } catch (Exception $exc) {
               $jsonData["code"] = -1;
               $jsonData["data"] = NULL;
               $jsonData["msg"] = $exc->getMessage();
               return response()->json($jsonData); 
            }
        }
        return response()->json(["code" => 0, "msg" => "Saisie invalide", "data" => NULL]);
    }


    /**
     * Update the specified Ville in storage.
     */
    public function update(Request $request, Chauffeur $chauffeur)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        
        if($chauffeur){
            $data = $request->all(); 

            try {

                $request->validate([
                    'name' => 'required',
                    'contact' => 'required',
                    'compagnie_id' => 'required',
                    'email' => 'required',
                    'adresse' => 'required',
                ]);

                $chauffeur->name = $data['name'];
                $chauffeur->contact = $data['contact'];
                $chauffeur->compagnie_id = $data['compagnie_id'];
                $chauffeur->email = $data['email'];
                $chauffeur->adresse = $data['adresse'];

                $chauffeur->updated_by = $request->user();
                $chauffeur->save();

                $jsonData["data"] = json_decode($chauffeur);
                return response()->json($jsonData);

            } catch (Exception $exc) {
               $jsonData["code"] = -1;
               $jsonData["data"] = NULL;
               $jsonData["msg"] = $exc->getMessage();
               return response()->json($jsonData); 
            }

        }
        return response()->json(["code" => 0, "msg" => "Echec de modification", "data" => NULL]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chauffeur $chauffeur)
    {
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($chauffeur){
                try {
                
                    $chauffeur->deleted_by = auth()->user();
                    
                    $chauffeur->delete();
                    $jsonData["data"] = json_decode($chauffeur);
                    return response()->json($jsonData);

                } catch (Exception $exc) {
                   $jsonData["code"] = -1;
                   $jsonData["data"] = NULL;
                   $jsonData["msg"] = $exc->getMessage();
                   return response()->json($jsonData); 
                }
            }
        return response()->json(["code" => 0, "msg" => "Echec de suppression", "data" => NULL]);
    }
}
