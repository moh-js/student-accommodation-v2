<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
        ->generateSlugsFrom('name')
        ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function side()
    {
        return $this->belongsTo(Side::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->withTrashed()->first();
    }

    public function scopeFemaleRooms($query)
    {
        return $query->whereHas('side', function (Builder $q)
        {
            return $q->where('gender_id', 2);
        });
    }

    public function scopeMaleRooms($query)
    {
        return $query->whereHas('side', function (Builder $q)
        {
            return $q->where('gender_id', 1);
        });
    }

}
