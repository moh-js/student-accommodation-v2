<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoiceExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping, WithStyles
{
    use Exportable;

    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Registration Number',
            'Programme',
            'Level',
            'Control Number',
            'Sponsor',
            'Paid Amount',
            'Balance/Remaining Amount',
            'Date Created',
            'Status',
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return  Invoice::query()->when($this->status != null, function ($query) {
            $query->where('status', $this->status);
        })->orderBy('id', 'asc');
    }

    public function map($invoice): array
    {
        return [
            $invoice->student->name,
            $invoice->student->username,
            $invoice->student->programme,
            $invoice->student->level,
            $invoice->control_number,
            $invoice->student->sponsor,
            $invoice->amount_paid,
            $invoice->amount - $invoice->amount_paid,
            $invoice->created_at->format('d-m-Y'),
            $invoice->status ? 'Paid' : 'Pending'
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
