<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    use Exportable;

    protected $status;
    protected $start;
    protected $end;

    public function __construct($data = null)
    {
        $this->status = $data['status']??null;
        $this->start = $data['start']??null;
        $this->end = $data['end']??null;
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Registration Number',
            'Email Address',
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
        return  Student::query()->when($this->status != null, function ($query) {
            $query->where('status', $this->status);
        })->when(($this->start && $this->end), function ($query) {
            $query->whereBetween('created_at', [$this->start, $this->end]);
        })->orderBy('id', 'asc');
    }

    public function map($student): array
    {
        return [
            $student->name,
            $student->username,
            $student->email,
            $student->phone,
            $student->programme,
            $student->level,
            $student->sponsor,
            $student->student_type,
            $student->status ? 'Active' : 'Inactive'
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
