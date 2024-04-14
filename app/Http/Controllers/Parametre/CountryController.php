<?php

namespace App\Http\Controllers\Parametre;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
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
        
        if ($request->isMethod('post') && $request->input('libelle_country')) {

                $data = $request->all(); 
                
            try {

                $request->validate([
                    'libelle_country' => 'required',
                ]);

                $Country = Country::where('code', $data['code'])->exists();
                if($Country){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $country = new Country;
                $country->code = $data['code'];
                $country->libelle_country = $data['libelle_country'];
                //TODO enregistrement d'image du drapeau
                $country->flags = $data['flags'];

                $country->save();
                $jsonData["data"] = json_decode($country);
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
    public function update(Request $request, Country $country)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        
        if($country){
            $data = $request->all(); 
            try {

                $request->validate([
                    'libelle_country' => 'required',
                ]);

                $country->code = $data['code'];
                $country->libelle_country = $data['libelle_country'];
                //TODO enregistrement d'image du drapeau
                
                $jsonData["data"] = json_decode($country);
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
    public function destroy(Country $country)
    {
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($country){
                try {
               
                $country->delete();
                $jsonData["data"] = json_decode($country);
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
