<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Mentor;
use App\Mail\MentorMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\LoginMentorRequest;
use App\Http\Requests\UpdateMentorRequest;
use App\Http\Requests\RegisterMentorRequest;
use App\Models\Mentorat;
use App\Models\Session as ModelsSession;
use OpenApi\Annotations as OA;



class MentorController extends Controller
{

    public function registerMentor(RegisterMentorRequest $request)
    {


        try {
            $user = new Mentor();

            $user->nom = $request->nom;
            $user->telephone = $request->telephone;
            $user->nombre_annee_experience = $request->nombre_annee_experience;
            $user->email = $request->email;
            $user->articles_id = $request->articles_id;
            $user->password = Hash::make($request->password);

            if ($request->hasFile('photo_profil')) {
                $file = $request->file('photo_profil');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('profil', $filename, 'public');
                $user->photo_profil = $path;
            }

            if($user->save()){
             Mail::to($user->email)->send(new MentorMail($user));   
            }
            return response()->json([
                'status_code' => 200,
                'status_message' => 'utilisateur ajouté avec succes',
                'status_body' => $user
            ]);
        } catch (Exception $e) {
            return response()->json([$e]);
        }
    }



    public function login(LoginMentorRequest $request)
    {
        if (Auth::guard('mentor')->attempt($request->only(['email', 'password']))) {
            $user = Auth::guard('mentor')->user();
            $token = $user->createToken('cle_secret_pour_le_mentor', ['mentor'])->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'utilisateur connecté',
                'status_body' => $user,
                'token' => $token
            ]);
        }
        if (Auth::guard('web')->attempt($request->only(['email', 'password']))) {
            $user = Auth::guard('web')->user();
            $token = $user->createToken('cle_secret_pour_le_back')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'status_message' => 'utilisateur connecté',
                'status_body' => $user,
                'token' => $token
            ]);
        } else {

            return response()->json([
                'status_code' => 403,
                'status_message' => 'Identifiants non valides',

            ]);
        }
    }


    public function logout()
    {
        $user = auth()->user();
        if ($user->tokens()->delete()) {
            Session::invalidate();
            return response()->json([
                'status_code' => 200,
                "status_body" => "deconnexion reussie"
            ]);
        } else {
            return response()->json([
                'status_code' => 400,
                "status_body" => "deconnexion echouée"
            ]);
        }
    }


    public function index()
    {
        try {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Voici la liste de tous les mentors',
                'Mentor' => Mentor::all(),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }



    public function non_archive(Mentor $mentor)
    {
        try {
            if ($mentor->est_archive == 0) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Voici la liste des mentors non archivés',
                    'mentor' => Mentor::where('est_archive', 0)->get(),
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }



    public function est_archive(Mentor $mentor)
    {
        try {
            if ($mentor->est_archive == 1) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Voici la liste des mentors qui sont archivés',
                    'mentor' => Mentor::where('est_archive', 1)->get(),
                ]);
            } else {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => "il n'y a pas de mentors archivés pour le moment",
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function nombre_mentor(Mentor $mentor)
    {
        try {
            if ($mentor->est_archive == 0) {
                if ($mentor->nombre_mentores < 16) {
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Voici la liste des mentors qui n\'ont pas atteint la limite et qui ne sont pas archivés',
                        'mentor' => Mentor::where('nombre_mentores', '<', 16)->get(),
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function nombre_mentor_atteint(Mentor $mentor)
    {
        try {
            if ($mentor->est_archive == 0) {
                if ($mentor->nombre_mentores > 16) {
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Voici la liste des mentors qui n\'ont pas atteint la limite et qui ne sont pas archivés',
                        'mentor' => Mentor::where('nombre_mentores', '>', 16)->get(),
                    ]);
                } else {
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => "il n'y pas de mentors qui ont atteint leurs limites",
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function archive(Mentor $mentor)
    {
        try {
            $mentor->est_archive = true;
            $mentor->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => "Vous avez archivés ce mentor",
                'mentor' => $mentor,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function filterMentorsByName(Request $request)
    {
        try {
            $nameFilter = $request->input('search');
            $users = Mentor::where('nom', 'like', '%' . $nameFilter . '%')->get();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Mentors filtrés par nom avec succès',
                'filtered_users' => $users,
            ]);
        } catch (Exception $e) {
            return response()->json([$e]);
        }
    }

    public function verifMailMentor(Request $request)
    {
        $mentor = Mentor::where('email', $request->email)->first();
        if ($mentor) {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur trouvé',
                'user' => $mentor,
            ]);
        } else {
            return response()->json([
                'status_code' => 422,
                'status_message' => 'Utilisateur non inscrit'
            ]);
        }
    }

    public function resetPasswordMentor(Request $request, Mentor $mentor)
    {
        $request->validate([
            'password' => 'required|regex:/^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[@#$%^&+=!])(.{8,})$/'
        ]);
        $mentor->password = $request->password;
        $mentor->save();
        if ($mentor) {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Votre mot de passe a été modifier',
                'user' => $mentor,
            ]);
        } else {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Votre mot de passe est invalide',
                'user' => $mentor,
            ]);
        }
    }



    /*je dois d'abord récupérer le mentorat depuis la table sessions apres essaie 
    de verifie quel mentor et quel user appartient cette mentorat si je l'ai,
    je pourrais savoir combien de fois on a pris id du mentor  
    */

    public function listesSessions(Mentor $mentor, Mentorat $mentorat, ModelsSession $session)
    {

        // Assurez-vous que $mentorat est bien lié à $mentor
        $mentorat->mentors_id = $mentor->id;
        // dd($mentor);

        
        // Vérifiez s'il y a des sessions liées au mentor
        $session =ModelsSession::where('mentorats_id', $mentorat->mentors_id)->first();
        if ($session) {
            return response()->json([
                "status_code" => 200,
                "status_message" => "Voici la liste des sessions pour ce mentor",
                "sessions" => $session
            ]);
        } else {
            return response()->json([
                "status_code" => 404,
                "status_message" => "Aucune session trouvée pour ce mentor"
            ]);
        }
    }
}
