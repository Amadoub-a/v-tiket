<?php

namespace App\Http\Controllers\Parametre;

use Exception;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Laravel\Facades\Image;

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
                
                //File upload if existe
                if($request->hasFile('flags')){
                  
                    $flags = $request->file('flags');
                    $filename = $data['libelle_country'].rand(100000, 999999).'.jpg';
                    $image = Image::read($flags);

                    // Resize image
                    $image->resize(250, 250, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/uploads-flags/' . $filename));

                    //Enregistrement du lien dans la BD
                    $country->flags = "storage/uploads-flags/$filename";
                }

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

                //File upload if existe
                if($request->hasFile('flags')){
                  
                    $flags = $request->file('flags');
                    $filename = $data['libelle_country'].rand(100000, 999999).'.jpg';
                    $image = Image::read($flags);

                    // Resize image
                    $image->resize(250, 250, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(storage_path('app/public/uploads-flags/' . $filename));

                    //Enregistrement du lien dans la BD
                    $country->flags = "storage/uploads-flags/$filename";
                }

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
               
                unlink($country->flags);

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
