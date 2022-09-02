<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use SoftDeletes;

    public function getProperNameAttribute()
    {
        return title_case(str_replace('-', ' ', $this->name));
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return Role::withTrashed()->where('name', $value)->first();
    }
}
