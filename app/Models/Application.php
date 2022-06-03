<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeCurrentYear($query)
    {
        return $query->where('academic_year_id', (AcademicYear::current()->id??false));
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getRouteKeyName()
    {
        return 'application_id';
    }
}
