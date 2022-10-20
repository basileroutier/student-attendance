<?php

namespace Database\Seeders;

use App\Models\StudentPresence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentPresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentPresence::factory()->count(10)->create();
    }
}
