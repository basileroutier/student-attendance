<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Util\Http\Response\CustomResponse;

class JsonRequest extends FormRequest
{

    protected $error_msg;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Return validation errors as json response
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $response = CustomResponse::make('json')
            -> withMessage($this -> error_msg) 
            -> failure($validator -> errors())
            -> get();

        throw new HttpResponseException($response);
    }
}
