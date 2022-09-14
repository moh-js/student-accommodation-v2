<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSimsDB extends Model
{
    use HasFactory;
    
    protected $connection = 'sims';
    protected $table = 'student';

    public function sponsor()
    {
        return $this->belongsTo(SponsorSimsDB::class, 'NewSponsor');
    }

    public function programme()
    {
        return $this->belongsTo(ProgrammeSimsDB::class, 'ProgrammeCode', 'Code');
    }
}
