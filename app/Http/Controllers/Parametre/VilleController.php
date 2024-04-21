<?php

namespace App\Http\Controllers\Parametre;

use Exception;
use App\Models\Ville;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coutries = Country::all();
        
        return response()->json($coutries);
    }


    /**
     * Store a new Ville in storage.
     */
    public function store(Request $request )
    {
        $jsonData = ["code" => 1, "msg" => "Enregistrement effectué avec succès."];
        
        if ($request->isMethod('post') && $request->input('libelle_ville')) {

                $data = $request->all(); 
               
            try {

                $request->validate([
                    'libelle_ville' => 'required',
                    'country_id' => 'required',
                ]);

                $Ville = Ville::where([['libelle_ville', $data['libelle_ville']],['country_id', $data['country_id']]])->exists();
                if($Ville){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $ville = new Ville;
                $ville->country_id = $data['country_id'];
                $ville->libelle_ville = $data['libelle_ville'];
                $ville->save();
                
                $jsonData["data"] = json_decode($ville);
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
    public function update(Request $request, Ville $ville)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        
        if($ville){
            $data = $request->all(); 

            try {

                $request->validate([
                'libelle_ville' => 'required',
                'country_id' => 'required',
            ]);

                $ville->country_id = $data['country_id'];
                $ville->libelle_ville = $data['libelle_ville'];
                $ville->save();

                $jsonData["data"] = json_decode($ville);
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
    public function destroy(Ville $ville)
    {
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($ville){
                try {
               
                $ville->delete();
                $jsonData["data"] = json_decode($ville);
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
