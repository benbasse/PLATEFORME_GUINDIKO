<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateMentoratRequest extends FormRequest
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
            "users_id"
        ];
    }

    public function failedValidation(Validator $validator)
{
    throw new HttpResponseException (response()->json([
        'success'=> false,
        'error'=> true,
        'message'=> 'erreur de validation',
        'errorLists' => $validator->errors(),
    ]));
}

public function messages()
{
    return[
        "mentors_id.required"=>"mentor est requis",
        "users_id.required"=>"mentor est requis",
    ];
}
}
