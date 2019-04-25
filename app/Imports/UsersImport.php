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
        // dd($row[0]);
        $name = $row[0];
        $birthdate = $row[1];
        $phone = $row[2];
        $nationality = $row[3];
        $address = $row[4];
        $email = $row[5];
        dd($name);
        return new User([
            'name' => $name,
            'model' => 'natural',
            'birthdate' => $birthdate,
            'phone' => $phone,
            'nationality' => $nationality,
            'address' => $address,
            'profile' => url('/')."/img/profile.png",
            'email' => $email,
            'password' => Hash::make('secret')

        ]);
    }
}
