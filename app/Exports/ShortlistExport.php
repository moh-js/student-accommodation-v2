<?php

namespace App\Exports;

use App\Models\Shortlist;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ShortlistExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    use Exportable;

    protected $gender;

    public function __construct($gender = null)
    {
        $this->gender = $gender ?? 3;
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Registration / Form 4 Index Number',
            'Programme',
            'Level',
            'Award',
            'Student Type',
            'Sponsor',
            'Status'
        ];
    }

    public function query()
    {
        if ($this->gender === 1) {
            $shortlist = Shortlist::maleShortlist()->orderBy('id', 'asc')->with('student');
        } elseif ($this->gender === 2) {
            $shortlist = Shortlist::femaleShortlist()->orderBy('id', 'asc')->with('student');
        } else if ($this->gender === 3) {
            $shortlist = Shortlist::query()->orderBy('id', 'asc')->with('student');
        }

        return $shortlist;
    }

    public function map($shortlist): array
    {
        return [
            $shortlist->student->name,
            $shortlist->student->username,
            $shortlist->student->programme,
            $shortlist->student->level,
            $shortlist->student->award,
            $shortlist->student->student_type,
            $shortlist->student->sponsor,
            checkEligibility($shortlist->student) ? 'selected' : 'maximum capacity reached',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
