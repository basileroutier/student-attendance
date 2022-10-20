<?php
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\StudentController;

use App\Models\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('homePage');
})->name('accueil');

// PRESENCE
Route::get('/presence', [PresenceController::class, 'index']) -> name('presence');

// STUDENTS
Route::get('/students', [StudentController::class, 'index']) -> name('students');

Route::middleware(['response.decode.json']) -> group(function(){
    Route::post('/presence/take', [PresenceController::class, 'takePresence']);
    Route::delete('/students/delete', [StudentController::class, 'delete']) -> name('students.delete');
    Route::post('/students/add', [StudentController::class, 'insert']) -> name('students.add');
});


// MISCELLANEOUS
Route::get('/token', function () {
    return csrf_token();
});

