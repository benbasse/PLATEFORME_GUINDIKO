<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMentoratRequest;
use App\Models\Mentorat;
use Exception;
use Illuminate\Http\Request;


class MentoratController extends Controller
{

    public function store(Request $request)
    {
        $mentorat = new Mentorat();

        $mentorat->users_id = $request->users_id;
        $mentorat->mentors_id = auth()->user()->id;
        $mentorat->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'mentorat crée',
            'status_body' => $mentorat
        ]);

    }

    public function index(Mentorat $mentorat)
    {
        try {
            return response()->json([
                "status_code" => 200,
                "status_message" => "Voici la liste de tous les mentorats",
                "mentorat_liste" => Mentorat::all(),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function show(Mentorat $mentorat)
    {
        try {
            return response()->json([
                "status_code" => 200,
                "status_message" => "Voici le mentorat spécifique vous voulez récupérer",
                "mentorat_id" => Mentorat::find($mentorat),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
