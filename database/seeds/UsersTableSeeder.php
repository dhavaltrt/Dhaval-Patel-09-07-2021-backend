<?php

use App\User;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seed.
     */
    public function run()
    {

        User::create([
            'name' => 'User 1',
            'email' => 'user_one@mailinator.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'User 2',
            'email' => 'user_two@mailinator.com',
            'password' => bcrypt('123456')
        ]);
        
        User::create([
            'name' => 'User 3',
            'email' => 'user_three@mailinator.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'User 4',
            'email' => 'user_four@mailinator.com',
            'password' => bcrypt('123456')
        ]);
    }
}
