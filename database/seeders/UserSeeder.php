<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

use App\Models\Customer;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *  run php artisan db:seed --class=UserSeeder
     */


    public function run(): void
    {
        User::create(
            [
                'user_id' => '001',
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('abc'),
                'phone' => '0103011927',
                'D_Role' => '2',
            ],
        );
        User::create(
            [
                'user_id' => '002',
                'name' => 'employee',
                'email' => 'employee@gmail.com',
                'email_verified_at' => Carbon::now(),
                'phone' => '016799233',
                'password' => bcrypt('abc'),
                'D_Role' => '1',
            ]
        );
        User::create(
            [
                'user_id' => '003',
                'name' => 'customer',
                'email' => 'customer@gmail.com',
                'email_verified_at' => Carbon::now(),
                'phone' => '0167992598',
                'password' => bcrypt('abc'),
                'D_Role' => '0',
            ]
        );
        Customer::create([
            'D_CusID' => '003',
            'D_CusPhone' => '0167992598',
        ]);
        
    }
}
