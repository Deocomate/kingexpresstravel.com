<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('destinations')->truncate();
        Schema::enableForeignKeyConstraints();

        $destinations = [
            'Hà Nội', 'Vịnh Hạ Long', 'Sa Pa', 'Hà Giang', 'Ninh Bình', 'Huế', 'Đà Nẵng',
            'Hội An', 'Quy Nhơn', 'Nha Trang', 'Đà Lạt', 'Phan Thiết', 'Vũng Tàu',
            'TP. Hồ Chí Minh', 'Cần Thơ', 'Phú Quốc', 'Côn Đảo', 'Mộc Châu', 'Pù Luông', 'Cát Bà'
        ];

        $data = [];
        foreach ($destinations as $name) {
            $data[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Khám phá vẻ đẹp tuyệt vời của ' . $name . ' với những danh lam thắng cảnh độc đáo và nền văn hóa đặc sắc.',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('destinations')->insert($data);
    }
}
