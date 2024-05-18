<?php

namespace App\Http\Controllers\Parametre;

use Exception;
use App\Models\Country;
use App\Models\Compagnie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CompagnieController extends Controller
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
     * Store a new Compagnie in storage.
     */
    public function store(Request $request )
    {
        
        $jsonData = ["code" => 1, "msg" => "Enregistrement effectué avec succès."];
        
        if ($request->isMethod('post') && $request->input('raison_sociale')) {

                $data = $request->all(); 
               
            try {
                
                $request->validate([
                    'raison_sociale' => 'required',
                    'contact' => 'required',
                    'email' => 'required',
                    'adresse' => 'required',
                    'country_id' => 'required',
                ]);

            //Debut de transaction
            DB::beginTransaction();

                $Compagnie = Compagnie::where([['raison_sociale', $data['raison_sociale']],['country_id', $data['country_id']]])->exists();
                if($Compagnie){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $compagnie = new Compagnie;
                $compagnie->raison_sociale = $data['raison_sociale'];
                $compagnie->contact = $data['contact'];
                $compagnie->email = $data['email'];
                $compagnie->adresse = $data['adresse'];
                $compagnie->country_id = $data['country_id'];

                $compagnie->contact_fixe = isset($data['contact_fixe']) ? $data['contact_fixe'] : null ;
                $compagnie->annee_fondation = isset($data['annee_fondation']) ? $data['annee_fondation'] : null ;
                $compagnie->site_internet = isset($data['site_internet']) ? $data['site_internet'] : null ;
                
                $compagnie->created_by = $request->user();
                $compagnie->save();

                //Ajout des villes dans lesquelles se trouvent cette compagnie
               $villes = array_map('intval', explode(',', $data['villes']));
               $compagnie->villes()->attach($villes);
                
                $jsonData["data"] = json_decode($compagnie);
            
            //En cas de succes
            DB::commit();
                return response()->json($jsonData);

            } catch (Exception $exc) {
            //En cas d'echec
               DB::rollBack();
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
    public function update(Request $request,  $id)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        $compagnie = Compagnie::find($id);

        if($compagnie){
            $data = $request->all(); 

            try {

                $request->validate([
                    'raison_sociale' => 'required',
                    'contact' => 'required',
                    'email' => 'required',
                    'adresse' => 'required',
                    'country_id' => 'required',
                ]);

            //Debut de transaction
            DB::beginTransaction();
                $compagnie->update([
                    'raison_sociale' => $data['raison_sociale'],
                    'contact' => $data['contact'],
                    'email' => $data['email'],
                    'adresse' => $data['adresse'],
                    'country_id' => $data['country_id'],
                    'contact_fixe' => isset($data['contact_fixe']) ? $data['contact_fixe'] : null,
                    'annee_fondation' => isset($data['annee_fondation']) ? $data['annee_fondation'] : null,
                    'site_internet' => isset($data['site_internet']) ? $data['site_internet'] : null,
                    'updated_by' => $request->user(),
                ]);

                //Modification des villes dans lesquelles se trouvent cette compagnie
                $villes = array_map('intval', explode(',', $data['villes']));
                $compagnie->villes()->sync($villes);

                $jsonData["data"] = json_decode($compagnie);

            //En cas de succes
            DB::commit();
                return response()->json($jsonData);

            } catch (Exception $exc) {
               //En cas d'echec
               DB::rollBack();
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
    public function destroy($id)
    {
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            $compagnie = Compagnie::find($id);
            
            if($compagnie){
                try {
                    //Supression des villes dans lesquelles se trouvent cette compagnie
                    $compagnie->villes()->detach();

                    $compagnie->deleted_by = auth()->user();
                    
                    $compagnie->delete();
                    $jsonData["data"] = json_decode($compagnie);
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
