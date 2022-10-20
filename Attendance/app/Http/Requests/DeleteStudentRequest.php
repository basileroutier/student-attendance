<?php

namespace App\Http\Requests;

class DeleteStudentRequest extends JsonRequest
{
    protected $error_msg = 'Wrong deletion';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'exists:students'
        ];
    }
}
