<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectOffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'student_id',
        'subject_id',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }

    public function students()
    {
        return $this->belongsTo(Student::class);
    }
}
