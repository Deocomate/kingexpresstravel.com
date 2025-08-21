<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AboutUsSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('about_us')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('about_us')->insert([
            'content' => '<h1>Về Chúng Tôi - King Express Travel</h1><p>Đây là nội dung giới thiệu mặc định về công ty. Bạn có thể chỉnh sửa nội dung này trong trang quản trị.</p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
