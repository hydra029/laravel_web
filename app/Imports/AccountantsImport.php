<?php

namespace App\Imports;

use App\Models\Accountant;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class AccountantsImport implements ToArray, WithHeadingRow
{

    public function array(array $array): void
    {
        $fname = $array['fname'];
        $lname  = $array['lname'];
        $gender = $array['gender'];
        $dob  = $array['dob'];
        $city = $array['city'];
        $district = $array['district'];
        $phone = $array['phone'];
        $dept_id = $array['dept_id'];
        $role_id = $array['role_id'];
        $status = $array['status'];
        Accountant::create([
            'fname' => $fname,
            'lname' => $lname,
            'gender' => $gender,
            'dob'=> $dob,
            'city' => $city,
            'district'=> $district,
            'phone' => $phone,
            'dept_id'=> $dept_id,
            'role_id' => $role_id,
            'status' => $status,
        ]);
    }
}
