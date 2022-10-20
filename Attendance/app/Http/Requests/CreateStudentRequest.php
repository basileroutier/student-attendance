<?php

namespace App\Http\Requests;

class CreateStudentRequest extends JsonRequest
{
    protected $error_msg = 'Wrong creation';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'surname' =>  'required|max:255',
        ];
    }
}
