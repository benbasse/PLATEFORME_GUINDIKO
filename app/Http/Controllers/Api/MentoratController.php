<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mentorat;
use Exception;
use Illuminate\Http\Request;

class MentoratController extends Controller
{
    public function store(Request $request, Mentorat $mentorat)
    {
        try {
            $mentorat->mentors_id = Auth()->guard('mentor')->user();
            $mentorat->users_id = $request->users_id;
            return response()->json([
                "status_code"=> 200,
                "status_message"=>"Vous avez enregistrer un nouveau mentorat",
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function index(Mentorat $mentorat)
    {
        try {
            return response()->json([
                "status_code"=> 200,
                "status_message"=>"Voici la liste de tous les mentorats",
                "mentorat_liste"=> Mentorat::all(),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show(Mentorat $mentorat)
    {
        try {
            return response()->json([
                "status_code"=> 200,
                "status_message"=>"Voici le mentorat spécifique vous voulez récupérer",
                "mentorat_id"=>Mentorat::find($mentorat),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
