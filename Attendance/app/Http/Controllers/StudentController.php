<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\DeleteStudentRequest;
use App\Models\Student;
use App\Util\Http\Response\CustomResponse;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::all();
        return view('studentlist', compact('students'));
    }

    public function insert(CreateStudentRequest $request)
    {
        $validated = $request -> validated();
        [$name, $surname] = [$validated['name'], $validated['surname']];
        $student = Student::create(['name' => $name, 'surname' => $surname]);

        return CustomResponse::make('json')
            -> withMessage('Student successfully deleted !') 
            -> success(['student' => $student])
            -> get();        
    }

    public function delete(DeleteStudentRequest $request)
    {
        $validated = $request -> validated();
        Student::where('id', $validated['id']) -> delete(); // soft deleted
        
        return CustomResponse::make('json')
            -> withMessage('Student successfully deleted !') 
            -> success()
            -> get();        
    }
}
