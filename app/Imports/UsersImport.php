<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name' => $row[0],
            'birthdate' => $row[1],
            'phone' => $row[2],
            'nationality' => $row[3],
            'address' => $row[4],
            'email' => $row[5],
        ]);
    }
}
