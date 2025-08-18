<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('destinations')->truncate();
        Schema::enableForeignKeyConstraints();

        $destinations = [
            'Hà Nội', 'Hạ Long', 'Sapa', 'Hà Giang', 'Ninh Bình', 'Huế', 'Đà Nẵng',
            'Hội An', 'Quy Nhơn', 'Nha Trang', 'Đà Lạt', 'Mũi Né', 'Vũng Tàu',
            'TP. Hồ Chí Minh', 'Cần Thơ', 'Phú Quốc', 'Côn Đảo', 'Mộc Châu', 'Pù Luông', 'Cát Bà'
        ];

        $data = [];
        foreach ($destinations as $name) {
            $data[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Mô tả chi tiết cho điểm đến ' . $name . '.',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('destinations')->insert($data);
    }
}
