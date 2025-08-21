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
        $tourImages = [
            '/userfiles/images/tours/ben-thuong-hai-du-lich-viet(6).jpg',
            '/userfiles/images/tours/du-lich-phu-quoc-mua-he-du-lich-viet-2025.jpg',
            '/userfiles/images/tours/shanghai-city-skyline-du-lich-viet-2025.jpg',
            '/userfiles/images/tours/tham-quan-dai-noi-kinh-thanh-hue-du-lich-viet.jpg',
            '/userfiles/images/tours/tour-du-lich-ha-long-he-du-lich-viet-2024(1).jpg',
            '/userfiles/images/tours/tour-du-lich-hue-mua-he-tham-quan-lang-huong-thuy-xuan-du-lich-viet-2025.jpg',
            '/userfiles/images/tours/tour-du-lich-ninh-binh-mua-he-du-lich-viet(1).jpg',
            '/userfiles/images/tours/tour-du-lich-thai-lan-tham-quan-suanthai-pattaya-du-lich-viet-2025.jpg',
            '/userfiles/images/tours/tour-han-quoc-trai-nghiem-tau-ven-bien-Haeundae-du-lich-viet-2025.jpg',
            '/userfiles/images/tours/tour-sapa-chinh-phuc-dinh-nui-fansipan-du-lich-viet(1).jpg',
        ];

        if (empty($tourCategoryIds) || empty($destinationIds)) {
            $this->command->info('Vui lòng tạo danh mục (TOUR) và điểm đến trước khi chạy seeder cho Tour.');
            return;
        }

        for ($i = 1; $i <= 20; $i++) {
            $name = 'Tour Khám Phá ' . $faker->city . ' ' . $faker->randomElement(['Hùng Vĩ', 'Thơ Mộng', 'Cổ Kính', 'Năng Động']) . ' ' . $faker->numberBetween(3, 5) . 'N' . $faker->numberBetween(2, 4) . 'Đ';

            $tour = Tour::create([
                'tour_code' => 'KET' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => $name,
                'slug' => Str::slug($name) . '-' . Str::random(5),
                'duration' => $faker->numberBetween(3, 7) . ' ngày ' . $faker->numberBetween(2, 6) . ' đêm',
                'departure_point' => $faker->randomElement(['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng']),
                'remaining_slots' => $faker->numberBetween(5, 20),
                'price_adult' => $faker->numberBetween(300, 2500) * 10000,
                'price_child' => $faker->numberBetween(200, 1800) * 10000,
                'price_toddler' => $faker->numberBetween(100, 900) * 10000,
                'price_infant' => 500000,
                'transport_mode' => $faker->randomElement(['Máy bay', 'Ô tô giường nằm', 'Tàu hỏa']),
                'thumbnail' => $faker->randomElement($tourImages),
                'images' => $faker->randomElements($tourImages, $faker->numberBetween(2, 4)),
                'priority' => $i,
                'short_description' => $faker->paragraph(3),
                'tour_description' => '<p>' . implode('</p><p>', $faker->paragraphs(8)) . '</p>',
                'tour_schedule' => json_encode([
                    ['title' => 'Ngày 1: ' . $faker->sentence, 'content' => $faker->paragraph(4)],
                    ['title' => 'Ngày 2: ' . $faker->sentence, 'content' => $faker->paragraph(4)],
                    ['title' => 'Ngày 3: ' . $faker->sentence, 'content' => $faker->paragraph(4)],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $numberOfCategories = $faker->numberBetween(1, 2);
            $randomCategoryIds = $faker->randomElements($tourCategoryIds, $numberOfCategories);
            $tour->categories()->sync($randomCategoryIds);

            $numberOfDestinations = $faker->numberBetween(2, 4);
            $randomDestinationIds = $faker->randomElements($destinationIds, $numberOfDestinations);
            $destinationsData = [];
            foreach ($randomDestinationIds as $index => $destinationId) {
                $destinationsData[$destinationId] = ['position' => $index + 1];
            }
            $tour->destinations()->sync($destinationsData);
        }
    }
}
