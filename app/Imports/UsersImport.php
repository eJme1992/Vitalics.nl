<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;


class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $faker = new Faker();
        // $password = $faker->bothify('???#?#??'); ## CREAR CONTRASE#A ALEATORIA

        return new User([
            'name' => $row[0],
            'model' => 'natural',
            'birthdate' => $row[1],
            'phone' => $row[2],
            'nationality' => $row[3],
            'address' => $row[4],
            'profile' => url('/')."/img/profile.png",
            'email' => $row[5],
            'password' => Hash::make('secret')

        ]);
    }
}
