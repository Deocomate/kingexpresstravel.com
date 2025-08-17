<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AboutUsSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('about_us')->truncate();
        Schema::enableForeignKeyConstraints();

        $pages = [
            [
                'title' => 'Về Chúng Tôi - King Express Travel',
                'slug' => 've-chung-toi-king-express-travel',
                'content' => '<p>Đây là nội dung chi tiết về trang giới thiệu công ty King Express Travel.</p>',
                'view' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Lịch Sử Hình Thành và Phát Triển',
                'slug' => 'lich-su-hinh-thanh-va-phat-trien',
                'content' => '<p>Nội dung về lịch sử hình thành và các cột mốc phát triển quan trọng của công ty.</p>',
                'view' => 85,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('about_us')->insert($pages);
    }
}
