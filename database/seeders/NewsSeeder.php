<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('news')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create('vi_VN');
        $newsCategories = Category::where('type', 'NEWS')->pluck('id')->toArray();

        if (empty($newsCategories)) {
            $this->command->info('Không tìm thấy danh mục tin tức nào. Vui lòng tạo danh mục trước.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $title = $faker->sentence(10);
            News::create([
                'title' => $title,
                'category_id' => $faker->randomElement($newsCategories),
                'slug' => Str::slug($title) . '-' . Str::random(5),
                'thumbnail' => '/userfiles/images/placeholder.jpg',
                'priority' => $faker->numberBetween(1, 100),
                'view' => $faker->numberBetween(100, 5000),
                'short_description' => $faker->paragraph(2),
                'contents' => '<p>' . implode('</p><p>', $faker->paragraphs(5)) . '</p>',
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
