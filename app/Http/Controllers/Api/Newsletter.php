<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewsletterRequest;
use App\Models\Newsletter as ModelsNewsletter;
use Exception;
use Illuminate\Http\Request;

class Newsletter extends Controller
{
    public function store(CreateNewsletterRequest $request)
    {
        try {
            $newsletter = new ModelsNewsletter();
            $newsletter->email = $request->email;
            $newsletter->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'le newslletter a été ajouté',
                'data' => $newsletter,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
