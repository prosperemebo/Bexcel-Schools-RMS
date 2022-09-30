<?php

namespace App\Models;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'grade_id',
        'gender',
        'admission_number',
        'date_of_birth',
        'first_name',
        'last_name',
        'other_name',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subjectOffers()
    {
        return $this->hasMany(SubjectOffer::class);
    }
}
