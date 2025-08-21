<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            // Tour Categories
            ['name' => 'Du lịch Trong nước', 'type' => 'TOUR', 'priority' => 1],
            ['name' => 'Du lịch Nước ngoài', 'type' => 'TOUR', 'priority' => 2],
            ['name' => 'Tour trọn gói', 'type' => 'TOUR', 'priority' => 3],
            // News Categories
            ['name' => 'Kinh nghiệm du lịch', 'type' => 'NEWS', 'priority' => 1],
            ['name' => 'Tin tức khuyến mãi', 'type' => 'NEWS', 'priority' => 2],
        ];

        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'type' => $category['type'],
                'is_active' => true,
                'priority' => $category['priority'],
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($data);
    }
}
