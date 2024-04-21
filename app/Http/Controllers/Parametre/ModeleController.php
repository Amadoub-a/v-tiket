<?php

namespace App\Http\Controllers\Parametre;

use Exception;
use App\Models\Modele;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModeleController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }


    /**
     * Store a new country in storage.
     */
    public function store(Request $request )
    {
        $jsonData = ["code" => 1, "msg" => "Enregistrement effectué avec succès."];
        
        if ($request->isMethod('post') && $request->input('libelle_modele')) {

                $data = $request->all(); 
               
            try {

                $request->validate([
                    'libelle_modele' => 'required',
                ]);

                $Modele = Modele::where('libelle_modele', $data['libelle_modele'])->exists();
                if($Modele){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $modele = new Modele;
                $modele->libelle_modele = $data['libelle_modele'];
                
                $modele->save();
                $jsonData["data"] = json_decode($modele);
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
     * Update the specified country in storage.
     */
    public function update(Request $request, Modele $modele)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        
        if($modele){
            $data = $request->all(); 

            try {

                $request->validate([
                    'libelle_modele' => 'required',
                ]);

                $modele->libelle_modele = $data['libelle_modele'];
                $modele->save();
                $jsonData["data"] = json_decode($modele);
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
    public function destroy(Modele $modele)
    {
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($modele){
                try {
               
                $modele->delete();
                $jsonData["data"] = json_decode($modele);
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
