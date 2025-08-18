<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('contact_branches')->truncate();
        DB::table('contacts')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create('vi_VN');

        $contactId = DB::table('contacts')->insertGetId([
            'company_name' => 'Công ty Du lịch King Express',
            'email' => 'contact@kingexpresstravel.com',
            'phone' => '1900 6868',
            'facebook' => 'https://facebook.com/kingexpresstravel',
            'zalo' => '0987654321',
            'working_hours' => 'Thứ 2 - Thứ 7: 8:00 - 17:30',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('contact_branches')->insert([
            [
                'contact_id' => $contactId,
                'branch_name' => 'Trụ sở chính Hà Nội',
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->companyEmail,
                'is_main' => true,
                'working_hours' => '8:00 - 17:30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'contact_id' => $contactId,
                'branch_name' => 'Chi nhánh Đà Nẵng',
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->companyEmail,
                'is_main' => false,
                'working_hours' => '8:00 - 17:30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
