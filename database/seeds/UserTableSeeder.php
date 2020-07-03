<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        'role_id'    => '1',
        'name'       => 'Bibek Raut',
        'username'       => 'bibek-raut',
        'email'      => 'rautbibek47@gmail.com',
        'password'   => bcrypt('bibek12345'),
      ]);
      DB::table('users')->insert([
        'role_id'    => '2',
        'name'       => 'slowrocker',
        'username'   => 'slowrocker',
        'email'      => 'slowrocker_bibek@yahoo.com',
        'password'   => bcrypt('slowrocker12345'),
      ]);

      DB::table('users')->insert([
        'role_id'    => '3',
        'name'       => 'tanuj adhikari',
        'username'   => 'tanuj-adhikari',
        'email'      => 'tnzeroxo@gmail.com',
        'password'   => bcrypt('apple12345'),
      ]);
    }
}
