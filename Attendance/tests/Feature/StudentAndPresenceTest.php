<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class StudentAndPresenceTest extends TestCase
{
    use WithoutMiddleware;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_student_with_presence()
    {
        $response = $this->get('/presence');

        $response->assertStatus(200);
    }

    public function test_home_page(){
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_set_presence_student(){
        $student = Student::factory()->create();
        $data = [['student_id' => $student->id, "date" => "2021-05-01", "is_present" => true]];
        $response = $this->postJson('/presence/take', $data);
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Student presences successfully taken !',
            ]);

        $this->assertDatabaseHas('student_presences', ['student_id' => $student->id, "date" => "2021-05-01", "is_present" => true]);

        $data = [['student_id' => $student->id, "date" => "2021-05-01", "is_present" => false]];
        $response = $this->postJson('/presence/take', $data);
        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Student presences successfully taken !',
            ]);

        $this->assertDatabaseHas('student_presences', ['student_id' => $student->id, "date" => "2021-05-01", "is_present" => false]);
    }


    // public function test_update_presence(){
    //     $student = Student::factory()->create();
    //     $response = $this->post('/presence/take', ['student_id' => $student->id, 'date' => date('Y-m-d'), 'is_present' => true]);

    //     $response->assertStatus(201);

    //     $response = $this->post('/presence/take', ['student_id' => $student->id, 'date' => date('Y-m-d'), 'is_present' => false]);

    //     $response->assertStatus(201);
    // }
}
