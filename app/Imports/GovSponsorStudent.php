<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GovSponsorStudent implements OnEachRow, WithHeadingRow
{
    use Importable;


    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        
        $student = Student::where(
            'username', $row['f4_index_no'],
        )->first();

        if ($student) {
            $student->sponsor = 'government';
            $student->save();
        }
    }
}
