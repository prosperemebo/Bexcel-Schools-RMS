<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreRecords extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'student_id',
        'subject_id',
        'session_id',
        'ca_score',
        'exam_score'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function session()
    {
        return $this->belongsTo(AcademicSession::class);
    }
}
