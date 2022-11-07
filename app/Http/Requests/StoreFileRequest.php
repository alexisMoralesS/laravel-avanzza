<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StoreFileRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json([
            'code' => 422,
            'message' => trans('validation.validation_message'),
            'errors' => $errors,
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules['file'] = 'required|array|min:1';
        if ($this->file && is_array($this->file)) {
            
            foreach ($this->file as $key => $file) {
                $rules['file.' . $key] = 'required|file|max:500';
                $rules['name.' . $key] = 'required|string';
            }
        }


        return $rules;
    }
}
