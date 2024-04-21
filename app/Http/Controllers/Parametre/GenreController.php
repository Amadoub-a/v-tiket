<?php

namespace App\Http\Controllers\Parametre;

use Exception;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
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
        
        if ($request->isMethod('post') && $request->input('libelle_genre')) {

                $data = $request->all(); 
               
            try {

                $request->validate([
                    'libelle_genre' => 'required',
                ]);

                $Genre = Genre::where('libelle_genre', $data['libelle_genre'])->exists();
                if($Genre){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $genre = new Genre;
                $genre->libelle_genre = $data['libelle_genre'];
                
                $genre->save();
                $jsonData["data"] = json_decode($genre);
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
    public function update(Request $request, Genre $genre)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        
        if($genre){
            $data = $request->all(); 

            try {

                $request->validate([
                    'libelle_genre' => 'required',
                ]);

                $genre->libelle_genre = $data['libelle_genre'];
                $genre->save();
                $jsonData["data"] = json_decode($genre);
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
    public function destroy(Genre $genre)
    {
        $jsonData = ["code" => 1, "msg" => " Opération effectuée avec succès."];
            if($genre){
                try {
               
                $genre->delete();
                $jsonData["data"] = json_decode($genre);
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
