<?php

namespace App\Exports;

use App\Models\Shortlist;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShortlistExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $gender;

    public function __construct( $gender)
    {
        $this->gender = $gender;
    }

    public function headings() : array
    {
        return [
            'Full Name',
            'Registration / Form 4 Index Number',
            'Programme',
            'Level'
        ];
    }

    public function query()
    {
        return Shortlist::query();
    }
}
