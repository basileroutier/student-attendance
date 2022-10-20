<?php

namespace App\Http\Requests;

class UpdatePresenceRequest extends JsonRequest
{
    protected $error_msg = 'Wrong presence update';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*' => 'required|array:student_id,date,is_present',
            '*.student_id' => 'distinct|int',
            '*.date' => 'date|date_equals:' . date('Y-m-d'),
            '*.is_present' => 'boolean'
        ];
    }
}
