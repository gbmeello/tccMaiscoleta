<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator) {

        $jsonResponse = [
            'success' => false,
            'message' => $validator->errors()->all()
        ];

        throw new HttpResponseException(response()->json($jsonResponse, 422));
    }
}
