<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\QueryException;

use Tests\TestCase;
use App\Models\Student;

class StudentsDatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this -> get('/');
        $response -> assertStatus(200);
    }


    /**
     * Test that student exists in database after insertion.
     *
     * @return void
     */
    public function test_exists_when_student_insertion(){
        $student_infos = ['matricule' => 12345, 'name' => 'Bob', 'surname' => 'Sponge'];
        $student = Student::create($student_infos);

        $this -> assertModelExists($student);
        $this -> assertDatabaseHas('students', $student_infos);
        $this -> assertDatabaseCount('students', 1);
    }

    /**
     * Test that QueryException is thrown when a student with a negative matricule is inserted
     * into the database.
     *
     * @return void
     */
    public function test_exception_when_student_insertion_with_negative_matricule(){
        $student_infos = ['matricule' => -10, 'name' => 'Bob', 'surname' => 'Sponge'];
        $closure = function() use ($student_infos){ Student::create($student_infos); };

        $this -> assertThrows($closure, QueryException::class);
        $this -> assertDatabaseMissing('students', $student_infos);
        $this -> assertDatabaseCount('students', 0);
    }

    /**
     * Test that QueryException is thrown when a student with an pre-existing matricule is inserted
     * into the database.
     *
     * @return void
     */
    public function test_exception_when_student_insertion_with_existing_matricule(){
        $student_infos = ['matricule' => 12345, 'name' => 'Bob', 'surname' => 'Sponge'];
        $student = Student::create($student_infos);
        $closure = function() use ($student_infos){ Student::create($student_infos); };

        $this -> assertThrows($closure, QueryException::class);
        $this -> assertModelExists($student);
        $this -> assertDatabaseHas('students', $student_infos);
        $this -> assertDatabaseCount('students', 1);
    }

    /**
     * Test that QueryException is thrown when a student with a matricule of more or less than
     * 5 digits is inserted into the database.
     *
     * @return void
     */
    public function test_exception_when_student_insertion_with_invalid_length_matricule(){
        $student_infos1 = ['matricule' => 1234, 'name' => 'Bob', 'surname' => 'Sponge'];
        $student_infos2 = ['matricule' => 123456, 'name' => 'Bob', 'surname' => 'Sponge'];
        $closure1 = function() use ($student_infos1){ Student::create($student_infos1); };
        $closure2 = function() use($student_infos2){ Student::create($student_infos2); };

        $this -> assertThrows($closure1, QueryException::class);
        $this -> assertThrows($closure2, QueryException::class);
        $this -> assertDatabaseMissing('students', $student_infos1);
        $this -> assertDatabaseMissing('students', $student_infos2);
        $this -> assertDatabaseCount('students', 0);
    }

    /**
     * Test that student doesn't longer exists in database after full deletion.
     *
     * @return void
     */
    public function test_missing_when_student_deletion(){
        $student_infos = ['matricule' => 12345, 'name' => 'Bob', 'surname' => 'Sponge'];
        $student = Student::create($student_infos);
        $student -> forceDelete();

        $this -> assertModelMissing($student);
        $this -> assertDatabaseMissing('students', $student_infos);
        $this -> assertDatabaseCount('students', 0);
    }

    /**
     * Test that student still exists in database after soft deletion.
     *
     * @return void
     */
    public function test_exists_when_student_soft_deletion(){
        $student_infos = ['matricule' => 12345, 'name' => 'Bob', 'surname' => 'Sponge'];
        $student = Student::create($student_infos);
        $student -> delete();

        $this -> assertSoftDeleted($student);
        $this -> assertModelExists($student);
        $this -> assertDatabaseHas('students', $student_infos);
        $this -> assertDatabaseCount('students', 1);
    }
}
