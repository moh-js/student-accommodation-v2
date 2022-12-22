<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammeSimsDB extends Model
{
    use HasFactory;

    protected $connection = 'sims';
    protected $table = 'programme';

}
