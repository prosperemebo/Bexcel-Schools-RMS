<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'label',
        'code',
        'session_year',
        'next_session_begins'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function score_records()
    {
        return $this->hasMany(ScoreRecords::class);
    }
}
