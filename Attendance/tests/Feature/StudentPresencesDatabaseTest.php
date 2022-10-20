<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\QueryException;

use Tests\TestCase;
use App\Models\Student;
use App\Models\StudentPresence;

class StudentPresencesDatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     *  Test that student presence exists in database after insertion.
     * 
     * @return void
     */
    public function test_exists_when_presence_insertion(){
        $student = Student::factory() -> create();
        $presence_infos = ['student_id' => $student -> id, 'date' => date('Y-m-d'), 'is_present' => true];
        $presence = StudentPresence::create($presence_infos);

        $this -> assertModelExists($presence);
        $this -> assertDatabaseHas('student_presences', $presence_infos);
        $this -> assertDatabaseCount('student_presences', 1);
    }

    /**
     * Test that student presence with default presence state exists in database after insertion.
     * 
     * @return void
     */
    public function test_exists_when_student_presence_insertion_with_default_presence_state(){
        $student = Student::factory() -> create();
        $presence_infos = ['student_id' => $student -> id, 'date' => date('Y-m-d')];
        $presence = StudentPresence::create($presence_infos);

        $this -> assertModelExists($presence);
        $this -> assertDatabaseHas('student_presences', $presence_infos);
        $this -> assertDatabaseCount('student_presences', 1);
        $this -> assertTrue($presence -> is_present == false);
    }

    /**
     * Test that many student presences linked to the same student exist in database after insertion.
     * 
     * @return void
     */
    public function test_exists_when_many_student_presences_insertion(){
        $student = Student::factory() -> create();
        for($i = 1; $i < 10; $i++){
            $presence_infos = ['student_id' => $student -> id, 'date' => "2022-0$i-25", 'is_present' => true];
            $presence = StudentPresence::create($presence_infos);

            $this -> assertModelExists($presence);
            $this -> assertDatabaseHas('student_presences', $presence_infos);
            $this -> assertDatabaseCount('student_presences', $i);
        }
    }

    /**
     * Test that QueryException is thrown when a student presence with a non-existing student foreign key 
     * is inserted into the database.
     * 
     * @return void
     */
    public function test_exception_when_student_presence_insertion_with_non_existing_foreign_key(){
        $presence_infos = ['student_id' => 1, 'date' => date('Y-m-d'), 'is_present' => true];
        $closure = function() use ($presence_infos){ StudentPresence::create($presence_infos); };

        $this -> assertThrows($closure, QueryException::class);
        $this -> assertDatabaseMissing('student_presences', $presence_infos);
        $this -> assertDatabaseCount('student_presences', 0);
    }

    /**
     * Test that QueryException is thrown when a student presence with an invalid date format
     * is inserted into the database.
     * 
     * @return void
     */
    public function test_exception_when_student_presence_insertion_with_invalid_date_format(){
        $date_formats = ['Y', 'm', 'd'];
        $student = Student::factory() -> create();
        foreach($date_formats as $format){
            $date = $format;
            for($i = 0; $i < count($date_formats); $i++){
                if($date_formats[$i] != $format){
                    $date .= "-$date_formats[$i]";
                }
            }
            $this -> assertValidDate($student, $date);
            $date = $format;
            for($i = count($date_formats) - 1; $i > -1; $i--){
                if($date_formats[$i] != $format){
                    $date .= "-$date_formats[$i]";
                }
            }
            $this -> assertValidDate($student, $date);
        }
    }

    /**
     * Test that QueryException is thrown when a student presence with an already existing presence date
     * is inserted into the database.
     * 
     * @return void
     */
    public function test_exception_when_student_presence_insertion_with_existing_date(){
        $student = Student::factory() -> create();
        $presence_infos = ['student_id' => $student -> id, 'date' => date('Y-m-d'), 'is_present' => true];
        $presence = StudentPresence::create($presence_infos);
        $closure = function() use ($presence_infos){ StudentPresence::create($presence_infos); };

        $this -> assertThrows($closure, QueryException::class);
        $this -> assertModelExists($presence);
        $this -> assertDatabaseHas('student_presences', $presence_infos);
        $this -> assertDatabaseCount('student_presences', 1);
    }

    /**
     * Test that the right student is returned when querying relationship method on student presence.
     * 
     * @return void 
     */
    public function test_valid_student_when_student_presence_relationship_query(){
        $student = Student::factory() -> create();
        $presence_infos = ['student_id' => $student -> id, 'date' => date('Y-m-d'), 'is_present' => true];
        $presence = StudentPresence::create($presence_infos);

        $this -> assertSameStudent($student, $presence -> student);
    }

    /**
     * Test that the right student presences are returned when querying relationship method on student.
     * 
     * @return void
     */
    public function test_valid_student_presences_when_student_relationship_query(){
        $student = Student::factory() -> create();
        $presence_infos1 = ['student_id' => $student -> id, 'date' => date('Y-m-d'), 'is_present' => true];
        $presence_infos2 = ['student_id' => $student -> id, 'date' => '2022-02-25', 'is_present' => true];
        $presence1 = StudentPresence::create($presence_infos1);
        $presence2 = StudentPresence::create($presence_infos2);

        $this -> assertTrue($student -> presences -> contains($presence1) && $student -> presences -> contains($presence2));
    }

    /**
     * Test that student presence does no longer exists in database after full deletion.
     * 
     * @return void
     */
    public function test_missing_when_student_presence_deletion(){
        $student = Student::factory() -> create();
        $presence_infos = ['student_id' => $student -> id, 'date' => date('Y-m-d'), 'is_present' => true];
        $presence = StudentPresence::create($presence_infos);
        $presence -> delete();

        $this -> assertModelMissing($presence);
        $this -> assertDatabaseMissing('student_presences', $presence_infos);
        $this -> assertDatabaseCount('student_presences', 0);
    }

    /**
     * Test that student presences exist in database after soft deletion of corresponding student.
     * 
     * @return void 
     */
    public function test_student_presences_exist_when_student_soft_deletion(){
        $student = Student::factory() -> create();
        $infos = ['INFOS' => [], 'PRESENCES' => []];
        for($i = 1; $i < 10; $i++){
            $infos['INFOS'][] = ['student_id' => $student -> id, 'date' => "2022-0$i-25", 'is_present' => true];
            $presences['PRESENCES'][] = StudentPresence::create($infos['INFOS'][$i - 1]);
        }

        $student -> delete();
        $this -> assertDatabaseCount('student_presences', 9);
        foreach($infos['INFOS'] as $info){
            $this -> assertDatabaseHas('student_presences', $info);
        }
        foreach($infos['PRESENCES'] as $info){
            $this -> assertModelExists($info);
        }
    }

    /**
     * Test that student presences do no longer exist in database after full deletion of corresponding student.
     * 
     * @return void
     */
    public function test_student_presences_missing_when_student_full_deletion(){
        $student = Student::factory() -> create();
        $infos = ['INFOS' => [], 'PRESENCES' => []];
        for($i = 1; $i < 10; $i++){
            $infos['INFOS'][] = ['student_id' => $student -> id, 'date' => "2022-0$i-25", 'is_present' => true];
            $presences['PRESENCES'][] = StudentPresence::create($infos['INFOS'][$i - 1]);
        }

        $student -> forceDelete();
        $this -> assertDatabaseCount('student_presences', 0);
        foreach($infos['INFOS'] as $info){
            $this -> assertDatabaseMissing('student_presences', $info);
        }
        foreach($infos['PRESENCES'] as $info){
            $this -> assertModelMissing($info);
        }
    }

    private function assertValidDate($student, $date){
        if($date == 'Y-m-d')
            return;

        $presence_infos = ['student_id' => $student -> id, 'date' => date($date), 'is_present' => true];
        $closure = function() use ($presence_infos){ StudentPresence::create($presence_infos); };
        $this -> assertThrows($closure, QueryException::class);
    }

    private function assertSameStudent($student1, $student2){
        $this -> assertTrue($student1 -> id == $student2 -> id &&
            $student1 -> matricule == $student2 -> matricule &&
            $student1 -> name == $student2 -> name &&
            $student1 -> surname == $student2 -> surname);
    }
}
