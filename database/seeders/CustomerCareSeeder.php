<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CustomerCareSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('customer_cares')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create('vi_VN');

        for ($i = 0; $i < 30; $i++) {
            DB::table('customer_cares')->insert([
                'full_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'subject' => $faker->sentence(6),
                'message' => $faker->paragraph(5),
                'note' => $faker->optional(0.3)->paragraph(2),
                'created_at' => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
