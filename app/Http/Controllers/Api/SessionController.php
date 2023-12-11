<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSessionRequest;
use App\Http\Requests\EditSessionRequest;
use App\Models\Session;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{


    public function index(Session $session)
    {
        try {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Voici la liste de tous les sessions',
                'session' => Session::all(),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function archive(Session $session)
    {
        try {
            $session->update([
                "est_archive" => 1,
            ]);
            $session->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Vous avez archivés cette sessions',
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function sessionArchive(Session $session)
    {
        try {
            if ($session->est_archive == 0) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Voici la liste des sessions archivés',
                    'session' => Session::where('est_archive', 1)->get(),
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function sessionNonArchive(Session $session)
    {
        try {
            if ($session->est_archive == 0) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Voici la liste des sessions non archivés',
                    'session' => Session::where('est_archive', 0)->get(),
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

  
    public function show(Session $session)
    {
        try {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Voici la session spécifique que vous voulez lister',
                'session' => Session::find($session),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function filtrerSession(Request $request)
    {
        try {
            $nameFilter = $request->input('search');
            $session = Session::where('libelle', 'like', '%' . $nameFilter . '%')->get();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateurs filtrés par libelle avec succès',
                'session_filtre' => $session,
            ]);
        } catch (Exception $e) {
            return response()->json([$e]);
        }
    }


    public function store(CreateSessionRequest $request, Session $session)
    {
        try {
            $session->mentorats_id = $request->mentorats_id;
            $session->libelle = $request->libelle;
            $session->en_ligne= $request->en_ligne;
            $session->theme = $request->theme;
            $session->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Vous avez ajouter une session',
                'session' => $session,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function update(EditSessionRequest $request, Session $session)
    {
        try {
            $session->mentorats_id = $request->mentorats_id;
            $session->libelle = $request->libelle;
            $session->en_ligne = $request->en_ligne;
            $session->theme = $request->theme;
            $session->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Vous avez modifier cette session',
                'session' => Session::all(),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function destroy(Session $session)
    {
        try {
            $session->delete();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Vous avez supprimer cette session',
                'session' => $session,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
