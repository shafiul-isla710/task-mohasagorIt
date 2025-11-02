<?php

namespace App\Http\Requests;

use App\Helper\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiFormRequest extends FormRequest
{
    use ApiResponseTrait;
    protected function failedValidation(Validator $validator)
    {
        Throw new HttpResponseException($this->errorResponse(false,$validator->errors()->all(),422));
    }
}
