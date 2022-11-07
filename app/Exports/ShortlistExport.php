<?php

namespace App\Exports;

use App\Models\Room;
use App\Models\Shortlist;
use App\Models\Application;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ShortlistExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    use Exportable;

    protected $gender_id;

    public function __construct($gender_id = null, $type)
    {
        $this->gender_id = $gender ?? 3;
        $this->type = $type;
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
        if ($this->type == 2) {
            $shortlist = Shortlist::withoutGlobalScope('banned')->where('is_banned', 1)->whereDoesntHave('student.invoices', function (Builder $q)
            {
                $q->where('academic_year_id', AcademicYear::current()->id);
            });
        } else {
            $shortlist = Shortlist::query();
        }

        if ($this->gender_id === 1) {
            $shortlist->maleShortlist()->orderBy('id', 'asc')->with('student');
        } elseif ($this->gender_id === 2) {
            $shortlist->femaleShortlist()->orderBy('id', 'asc')->with('student');
        } else if ($this->gender_id === 3) {
            $shortlist->orderBy('id', 'asc')->with('student');
        }

        return $shortlist;
    }

    public function map($shortlist): array
    {

        $maleRooms = roomsAvailable(1);
        $femaleRooms = roomsAvailable(2);
        $maleShortlist = Shortlist::maleShortlist()->orderBy('id', 'asc')->with('student')->get();
        $femaleShortlist = Shortlist::femaleShortlist()->orderBy('id', 'asc')->with('student')->get();

        return [
            $shortlist->student->name,
            $shortlist->student->username,
            $shortlist->student->programme,
            $shortlist->student->level,
            $shortlist->student->award,
            $shortlist->student->student_type,
            $shortlist->student->sponsor,
            selected($shortlist->student, $shortlist->student->gender_id, $maleRooms, $femaleRooms, $maleShortlist, $femaleShortlist) ? 'selected' : 'maximum capacity reached',
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
