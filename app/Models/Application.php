<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected static function booted()
    {
        static::addGlobalScope('flagged', function (Builder $builder) {
            $builder->where('red_flagged', 0);
        });
    }
}
