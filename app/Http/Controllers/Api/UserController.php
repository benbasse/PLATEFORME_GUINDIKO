<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\RegisterUserRequest;


class UserController extends Controller
{

    

    public function register(RegisterUserRequest $request)
    {
        try{
            $user = new User(); 
            $user->nom = $request->nom;
            $user->telephone = $request->telephone;
            $user->parcours = $request->parcours;
            $user->statut = $request->statut;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            
            $user->save();
            return response()->json([
                'status_code'=>200,
                'status_message'=>'utilisateur ajouté avec succes',
                'status_body'=>$user
            ]);
    
            }
            catch(Exception $e){
                return response()->json([$e]);
            }
    
        }

        public function logoutUser(){
            if(auth()->check()){
                Auth::user()->tokens()->delete();
                Auth::logout();
                
                return response()->json([
                    "status_code"=>200,
                    "status_message"=>"deconnexion reussie"
                ]);
            }
        }

        public function filterUsersByName(Request $request)
        {
            try {
                $nameFilter = $request->input('search');
        
                 $users = User::where('nom', 'like', '%' . $nameFilter . '%')->get();
                

        
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Utilisateurs filtrés par nom avec succès',
                    'filtered_users' => $users,
                ]);
        
            } catch (Exception $e) {
                return response()->json([$e]);
            }
        }

        public function index()
        {
            try {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Voici la liste de tous les mentorés',
                    'Mentor' => User::all(),
                ]); 
            } catch (Exception $e) {
                return response()->json($e);
            }
        }

        public function mentoreNonArchive()
        {
            try {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Voici la liste de tous les mentorés non archivés',
                    'Mentor' => User::where('is_archived',0)->get(),
                ]); 
            } catch (Exception $e) {
                return response()->json($e);
            }
        }

        public function mentoreArchive()
        {
            try {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Voici la liste de tous les mentorés archivés',
                    'Mentor' => User::where('is_archived',1)->get(),
                ]); 
            } catch (Exception $e) {
                return response()->json($e);
            }
        }
        
        public function archive (User $user)
        {
            try {
                $user->update([
                    'is_archived'=> 1
                ]);
                return response()->json([
                    'status_code' => 200,
                    'status_message' => "Vous avez archivés ce mentor"
                ]); 
            } catch (Exception $e) {
                return response()->json($e);
            }
        }

        public function verifMailUser(Request $request){
            $user=User::where('email',$request->email)->first();
            if($user){
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Utilisateur trouvé',
                    'user' => $user,
                ]);
            }
            else{
                return response()->json([
                    'status_code' => 422,
                    'status_message' => 'Utilisateur non inscrit'
                ]);
            }
    
        }

        public function resetPasswordUser(Request $request,User $user){
            $request->validate([
                'password'=>'required|regex:/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@#$%^&+=!])(.{8,})$/'
            ]);
            $user->password=$request->password;
            $user->save();
           //dd($user);
            if($user){
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Votre mot de passe a été modifier',
                    'user' => $user,
                ]);
            }else{
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Votre mot de passe est invalide',
                    'user' => $user,
                ]);
            }
    
        }

    }