<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApplicationExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    use Exportable;

    protected $red_flagged;

    public function __construct($red_flagged = null)
    {
        $this->red_flagged = $red_flagged;
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Registration Number',
            'Application ID',
            'Phone Number',
            'Programme',
            'Level',
            'Sponsor',
            'Student Type',
            'Status',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return  Application::query()->when($this->red_flagged != null, function ($query)
        {
            $query->where('red_flagged', $this->red_flagged);
        });
    }

    public function map($application) : array
    {
        return [
            $application->student->name,
            $application->student->username,
            $application->application_id,
            $application->student->phone,
            $application->student->programme,
            $application->student->level,
            $application->student->sponsor,
            $application->student->student_type,
            $application->red_flagged?'Banned':'Received'
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
