<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Genre;
use App\Models\Marque;
use App\Models\Modele;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marques = Marque::all();
        $modeles = Modele::all();
        $genres = Genre::all();
        
        return response()->json($marques);
    }

     /**
     * Store a new Compagnie in storage.
     */
    public function store(Request $request )
    {
        $jsonData = ["code" => 1, "msg" => "Enregistrement effectué avec succès."];
        
        if ($request->isMethod('post') && $request->input('immatriculation')) {

                $data = $request->all(); 
               
            try {

                $request->validate([
                    'immatriculation' => 'required',
                    'numero_chassis' => 'required',
                    'compagnie_id' => 'required',
                    'marque_id' => 'required',
                    'genre_id' => 'required',
                    'modele_id' => 'required',
                ]);

                $Vehicule = Vehicule::where('immatriculation', $data['immatriculation'])->exists();
                if($Vehicule){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $vehicule = new Vehicule;
                $vehicule->immatriculation = $data['immatriculation'];
                $vehicule->numero_chassis = $data['numero_chassis'];
                $vehicule->compagnie_id = $data['compagnie_id'];
                $vehicule->marque_id = $data['marque_id'];
                $vehicule->modele_id = $data['modele_id'];
                $vehicule->genre_id = $data['genre_id'];

                $vehicule->annee_fabrication = isset($data['annee_fabrication']) ? $data['annee_fabrication'] : null ;
                $vehicule->nombre_place = isset($data['nombre_place']) ? $data['nombre_place'] : null ;
                
                $vehicule->created_by = $request->user();
                $vehicule->save();
                
                $jsonData["data"] = json_decode($vehicule);
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
    public function update(Request $request, Vehicule $vehicule)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        
        if($vehicule){
            $data = $request->all(); 

            try {

                $request->validate([
                    'immatriculation' => 'required',
                    'numero_chassis' => 'required',
                    'compagnie_id' => 'required',
                    'marque_id' => 'required',
                    'genre_id' => 'required',
                    'modele_id' => 'required',
                ]);

                $vehicule->immatriculation = $data['immatriculation'];
                $vehicule->numero_chassis = $data['numero_chassis'];
                $vehicule->compagnie_id = $data['compagnie_id'];
                $vehicule->marque_id = $data['marque_id'];
                $vehicule->modele_id = $data['modele_id'];
                $vehicule->genre_id = $data['genre_id'];

                $vehicule->annee_fabrication = isset($data['annee_fabrication']) ? $data['annee_fabrication'] : null ;
                $vehicule->nombre_place = isset($data['nombre_place']) ? $data['nombre_place'] : null ;
                
                $vehicule->updated_by = $request->user();
                $vehicule->save();

                $jsonData["data"] = json_decode($vehicule);
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
    public function destroy(Vehicule $vehicule)
    {
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($vehicule){
                try {
                
                    $vehicule->deleted_by = auth()->user();
                    
                    $vehicule->delete();
                    $jsonData["data"] = json_decode($vehicule);
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
