<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ville;
use App\Models\Depart;
use App\Models\Vehicule;
use App\Models\Chauffeur;
use Illuminate\Http\Request;

class DepartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicules = Vehicule::all();
        $villes = Ville::all();
        $chauffeurs = Chauffeur::all();
        $passagers = User::all();
        
        return response()->json($chauffeurs);
    }

    /**
     * Store a new Compagnie in storage.
     */
    public function store(Request $request )
    {
        $jsonData = ["code" => 1, "msg" => "Enregistrement effectué avec succès."];
        
        if ($request->isMethod('post') && $request->input('date_depart')) {

                $data = $request->all(); 
               
            try {

                $request->validate([
                    'date_depart' => 'required',
                    'date_arrivee' => 'required',
                    'vehicule_id' => 'required',
                    'chauffeur_id' => 'required',
                    'ville_depart_id' => 'required',
                    'ville_arrivee_id' => 'required',
                ]);
                
                $date_depart = Carbon::createFromFormat('d-m-Y H:i', $data['date_depart']);
                $date_arrivee = Carbon::createFromFormat('d-m-Y H:i', $data['date_arrivee']);

                $Depart = Depart::where([['vehicule_id', $data['vehicule_id']],['date_depart', $date_depart]])->exists();
                if($Depart){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }
               
                $depart = new Depart;
                $depart->date_depart = $date_depart;
                $depart->date_arrivee = $date_arrivee;
                $depart->vehicule_id = $data['vehicule_id'];
                $depart->chauffeur_id = $data['chauffeur_id'];
                $depart->ville_depart_id = $data['ville_depart_id'];
                $depart->ville_arrivee_id = $data['ville_arrivee_id'];
                
                $depart->created_by = $request->user();
                $depart->save();
                
                $jsonData["data"] = json_decode($depart);
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
    public function update(Request $request, Depart $depart)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        
        if($depart){
            $data = $request->all(); 

            try {

                $request->validate([
                    'date_depart' => 'required',
                    'date_arrivee' => 'required',
                    'vehicule_id' => 'required',
                    'chauffeur_id' => 'required',
                    'ville_depart_id' => 'required',
                    'ville_arrivee_id' => 'required',
                ]);

                $depart->date_depart = Carbon::createFromFormat('d-m-Y H:i', $data['date_depart']);
                $depart->date_arrivee = Carbon::createFromFormat('d-m-Y H:i', $data['date_arrivee']);
                $depart->vehicule_id = $data['vehicule_id'];
                $depart->chauffeur_id = $data['chauffeur_id'];
                $depart->ville_depart_id = $data['ville_depart_id'];
                $depart->ville_arrivee_id = $data['ville_arrivee_id'];
               
                $depart->updated_by = $request->user();
                $depart->save();

                $jsonData["data"] = json_decode($depart);
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
    public function destroy(Depart $depart)
    {
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($depart){
                try {
                
                    $depart->deleted_by = auth()->user();
                    
                    $depart->delete();
                    $jsonData["data"] = json_decode($depart);
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
