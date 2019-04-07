<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

         App\StorePoint::create([
          'price'   => '1',
          'currency'     => 'EUR'
          
        ]);
    }
}
