<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class EmployeesImport implements ToArray
{

    public function array(array $array): void
    {
        dd($array);
    }
}
