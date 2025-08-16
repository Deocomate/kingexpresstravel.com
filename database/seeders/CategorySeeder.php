<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();

        $parentCategories = [];
        // Tạo 5 danh mục cha
        for ($i = 1; $i <= 5; $i++) {
            $name = 'Danh mục Cha ' . $i;
            $parentCategories[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'type' => ($i % 2 == 0) ? 'TOUR' : 'NEWS',
                'is_active' => true,
                'priority' => $i,
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('categories')->insert($parentCategories);

        // Lấy ID của các danh mục cha vừa tạo
        $parentIds = DB::table('categories')->whereNull('parent_id')->pluck('id')->toArray();

        $childCategories = [];
        // Tạo 15 danh mục con
        for ($i = 1; $i <= 15; $i++) {
            $name = 'Danh mục Con ' . $i;
            $parentId = $parentIds[array_rand($parentIds)];
            $parentType = DB::table('categories')->find($parentId)->type;

            $childCategories[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'type' => $parentType, // Danh mục con thường cùng loại với cha
                'is_active' => true,
                'priority' => $i,
                'parent_id' => $parentId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('categories')->insert($childCategories);
    }
}
