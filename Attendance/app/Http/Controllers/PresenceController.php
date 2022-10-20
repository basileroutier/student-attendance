<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\StudentPresence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Util\Http\Response\CustomResponse;
use App\Http\Requests\UpdatePresenceRequest;

class PresenceController extends Controller
{
    /**
     * It gets all the students with their presence for today
     *
     * @return A view called presence.blade.php
     */
    public function index()
    {
        $students = Student::getStudentsWithPresenceForToday();
        return view('presence', compact('students'));
    }

    /**
     * It takes a JSON array of objects, each object containing a student's id and a boolean value
     * indicating whether the student is present or not, and updates the database accordingly
     *
     * @param Request request The request object.
     *
     * @return A JSON object with a message.
     */
    public function takePresence(UpdatePresenceRequest $request)
    {
        $presences = $request -> validated();
        StudentPresence::updateOrCreateMultiple($presences);
        
        return CustomResponse::make('json')
            -> withMessage('Student presences successfully taken !') 
            -> success()
            -> get();
    }
}
