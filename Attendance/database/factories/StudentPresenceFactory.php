<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentsPresences>
 */
class StudentPresenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id,
            'is_present' => $this -> faker -> boolean(),
            'date' => $this -> faker -> dateTime(),
        ];
    }
}
