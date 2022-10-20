<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get all of the student presences.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function presences(): HasMany
    {
        return $this->hasMany(StudentPresence::class);
    }

    /**
     * It gets all students from the database, and if there are no students with presence for today, it
     * gets all students from the database
     *
     * @return A collection of students with their presence for today.
     */
    public static function getStudentsWithPresenceForToday()
    {
        $students = self::orderBy('id', 'asc')
            ->leftJoin('student_presences', 'students.id', '=', 'student_id')
            ->where('date', date('Y-m-d'))
            ->get(['students.id', 'name', 'surname', 'is_present']);

        if (!count($students)) {
            $students = self::orderBy('id', 'asc')->get();
        }

        return $students;
    }
}
