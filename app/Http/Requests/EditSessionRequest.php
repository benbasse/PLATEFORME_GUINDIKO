<?php

namespace App\Http\Requests;

use Dotenv\Validator;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "en_ligne" =>"required",
            "theme" => "required",
            "libelle" => "required",
            "mentorats_id" => "required",
            "date" => "required|date",
            "heure" => "required"
        ];
    }

    public function failedValidation(ValidationValidator $validator ){
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'status_code'=>422,
            'error'=>true,
            'message'=>'erreur de validation',
            'errorList'=>$validator->errors()
        ]));
    }

    public function messages()
    {
        return[
            "mentorats_id.required" => "Le menroats_id ne peut pas être null",
            "theme.required" => "Le theme ne peut pas être null",
            "en_ligne.required" => "le champ en ligne ne peut pas être null",
            "libelle.required" => "Le libelle ne peut pas être null",
            "date.required" => "La date est requise",
            "date.date"=> "le format de date est incorrect",
            "heure.required"=>"l'heure est requis",
            "heure.time"=>" le format de l'heure est incorrect"
        ];
    }
}
