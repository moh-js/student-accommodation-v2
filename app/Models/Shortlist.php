<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shortlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function scopeFemaleShortlist($query)
    {
        return $query->whereHas('student', function (Builder $q)
        {
            return $q->where('gender_id', 2);
        });
    }

    public function scopeMaleShortlist($query)
    {
        return $query->whereHas('student', function (Builder $q)
        {
            return $q->where('gender_id', 1);
        });
    }
}
