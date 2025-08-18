<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('tour_destinations')->truncate();
        DB::table('tour_categories')->truncate();
        DB::table('tours')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create('vi_VN');
        $tourCategoryIds = Category::where('type', 'TOUR')->pluck('id')->toArray();
        $destinationIds = Destination::pluck('id')->toArray();

        if (empty($tourCategoryIds) || empty($destinationIds)) {
            $this->command->info('Vui lòng tạo danh mục (TOUR) và điểm đến trước khi chạy seeder cho Tour.');
            return;
        }

        for ($i = 1; $i <= 15; $i++) {
            $name = 'Tour Khám Phá ' . $faker->city . ' ' . $faker->randomElement(['Hùng Vĩ', 'Thơ Mộng', 'Cổ Kính', 'Năng Động']) . ' ' . $faker->numberBetween(2, 5) . 'N' . $faker->numberBetween(1, 4) . 'Đ';

            $tour = Tour::create([
                'tour_code' => 'KET' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => $name,
                'slug' => Str::slug($name) . '-' . Str::random(5),
                'duration' => $faker->numberBetween(2, 7) . ' ngày ' . $faker->numberBetween(1, 6) . ' đêm',
                'departure_point' => $faker->randomElement(['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng']),
                'remaining_slots' => $faker->numberBetween(5, 20),
                'price_adult' => $faker->numberBetween(200, 1500) * 10000,
                'price_child' => $faker->numberBetween(150, 1000) * 10000,
                'price_toddler' => $faker->numberBetween(50, 500) * 10000,
                'price_infant' => 0,
                'transport_mode' => $faker->randomElement(['Máy bay', 'Ô tô', 'Tàu hỏa']),
                'thumbnail' => '/userfiles/images/placeholder.jpg',
                'priority' => $i,
                'short_description' => $faker->paragraph(2),
                'tour_description' => '<p>' . implode('</p><p>', $faker->paragraphs(5)) . '</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Sync categories
            $numberOfCategories = $faker->numberBetween(1, 2);
            $randomCategoryIds = $faker->randomElements($tourCategoryIds, $numberOfCategories);
            $tour->categories()->sync($randomCategoryIds);

            // Sync destinations with position
            $numberOfDestinations = $faker->numberBetween(2, 5);
            $randomDestinationIds = $faker->randomElements($destinationIds, $numberOfDestinations);
            $destinationsData = [];
            foreach ($randomDestinationIds as $index => $destinationId) {
                $destinationsData[$destinationId] = ['position' => $index + 1];
            }
            $tour->destinations()->sync($destinationsData);
        }
    }
}
