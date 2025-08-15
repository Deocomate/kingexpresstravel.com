<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        User::insert([
            'name' => "root",
            'email' => "root@gmail.com",
            'password' => bcrypt('password'),
            'role' => "admin",
        ]);
        return;
    }
}
