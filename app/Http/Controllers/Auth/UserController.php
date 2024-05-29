<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Mail\SimpleMessage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = ['super-admin','admin','admin-compagnie','gerand','caissier'];
        
        return response()->json($roles);
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
                    'email' => 'required',
                    'role' => 'required',
                ]);

                //Debut de transaction
                DB::beginTransaction();

                $User = User::where(['email',$data['email']])->exists();
                if($User){
                    return response()->json(["code" => 0, "msg" => "Cet enregistrement existe déjà dans la base", "data" => NULL]);
                }

                $user = new User;
                $user->name =  $data['name'];
                $user->contact = $data['contact'];
                $user->email = $data['email'];
                $user->role = $data['role'];
                $user->confirmation_token = str_replace('/', '', bcrypt(Str::random(16)));

                $password = Str::random(10);
                $user->password = bcrypt($password);

                $user->created_by = $request->user();
                $user->save();
                
                //Envoie de mail pour notifier la création du compte
                $subject = 'CREATION DE VOTRE COMPTE UTILISATEUR';
                $body = "Bonjour, '.$user->name.' <br/>Votre compte utilisateur du site v-ticket vient d'être crée.<br/> Votre nom d'utilisateur : <strong>".$user->email."</strong><br/> Votre mot de passe : '.$password.'<br/> Veuillez vous connecter pour réinitialiser votre mot de passe. <br/> Merci !";
                Mail::to($user->email)->send((new SimpleMessage($subject, $body))->onQueue('notifications'));

                $jsonData["data"] = json_decode($user);
            
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
     * Update the specified Compagnie in storage.
     */
    public function update(Request $request,  $id)
    {
        $jsonData = ["code" => 1, "msg" => "Modification effectuée avec succès."];
        $user = User::find($id);

        if($user){
            $data = $request->all(); 

            try {

                $request->validate([
                    'name' => 'required',
                    'contact' => 'required',
                    'email' => 'required',
                    'role' => 'required',
                ]);

                //Debut de transaction
                DB::beginTransaction();

                $user->update([
                    'name' =>  $data['name'],
                    'contact' => $data['contact'],
                    'email' => $data['email'],
                    'role' => $data['role'],
                    'updated_by' => $request->user(),
                ]);

                $oldEmail = $user->email;
                
                //Envoie de mail pour notifier la modification du compte si l'email change
                if($user->email != $oldEmail){
                    $subject = 'CREATION DE VOTRE COMPTE UTILISATEUR';
                    $body = "Bonjour, '.$user->name.' <br/>Votre compte utilisateur du site v-ticket vient d'être crée.<br/> Votre nom d'utilisateur : <strong>".$user->email."</strong><br/> Votre mot de passe : '.$user->password.'<br/> Veuillez vous connecter pour réinitialiser votre mot de passe. <br/> Merci !";
                    Mail::to($user->email)->send((new SimpleMessage($subject, $body))->onQueue('notifications'));
                }
               
                $jsonData["data"] = json_decode($user);

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
            $user = User::find($id);
            
            if($user){
                try {
                    
                    $user->deleted_by = auth()->user();
                    
                    $user->delete();
                    $jsonData["data"] = json_decode($user);
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
