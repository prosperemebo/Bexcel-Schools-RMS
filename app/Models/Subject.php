<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'label'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function subjectOffers()
    {
        return $this->hasMany(SubjectOffer::class);
    }
}
