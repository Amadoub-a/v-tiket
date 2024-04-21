<?php

namespace App\Http\Controllers\Parametre;

use Exception;
use App\Models\Marque;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarqueController extends Controller
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
        
        if ($request->isMethod('post') && $request->input('libelle_marque')) {

                $data = $request->all(); 
               
            try {

                $request->validate([
                    'libelle_marque' => 'required',
                ]);

                $Marque = Marque::where('libelle_marque', $data['libelle_marque'])->exists();
                if($Marque){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $marque = new Marque;
                $marque->libelle_marque = $data['libelle_marque'];
                
                $marque->save();
                $jsonData["data"] = json_decode($marque);
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
    public function update(Request $request, Marque $marque)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        
        if($marque){
            $data = $request->all(); 

            try {

                $request->validate([
                    'libelle_marque' => 'required',
                ]);

                $marque->libelle_marque = $data['libelle_marque'];
                $marque->save();
                $jsonData["data"] = json_decode($marque);
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
    public function destroy(Marque $marque)
    {
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($marque){
                try {
               
                $marque->delete();
                $jsonData["data"] = json_decode($marque);
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
