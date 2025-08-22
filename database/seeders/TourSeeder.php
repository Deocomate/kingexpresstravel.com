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
            $short_description = 'Hành trình khám phá đầy mê hoặc, đưa quý khách đến với những cảnh quan tuyệt đẹp, trải nghiệm văn hóa độc đáo và thưởng thức ẩm thực địa phương phong phú. Một chuyến đi hứa hẹn mang lại nhiều kỷ niệm khó quên.';
            $tour_description = '<p>Chuyến đi này được thiết kế đặc biệt để mang đến cho quý khách những trải nghiệm trọn vẹn và đáng nhớ nhất. Chúng tôi tự hào với đội ngũ hướng dẫn viên chuyên nghiệp, am hiểu địa phương, sẽ đồng hành cùng quý khách trên mọi nẻo đường.</p><p>Quý khách sẽ được nghỉ ngơi tại các khách sạn tiện nghi, di chuyển bằng phương tiện đời mới, an toàn và thưởng thức những bữa ăn đặc sắc mang đậm hương vị bản địa. Lịch trình tour được sắp xếp hợp lý, kết hợp giữa tham quan các địa danh nổi tiếng và thời gian tự do để quý khách có thể tự mình khám phá.</p><p>Hãy sẵn sàng cho một cuộc phiêu lưu kỳ thú, nơi mỗi khoảnh khắc đều trở thành một phần ký ức đẹp đẽ. King Express Travel cam kết mang đến chất lượng dịch vụ tốt nhất cho sự hài lòng của quý khách.</p>';
            $schedule_content_1 = 'Xe và hướng dẫn viên đón quý khách tại điểm hẹn. Bắt đầu hành trình, quý khách sẽ được giới thiệu về lịch trình và những điểm đến thú vị sắp tới. Sau khi đến nơi, đoàn làm thủ tục nhận phòng khách sạn và nghỉ ngơi. Buổi tối, tự do khám phá thành phố về đêm.';
            $schedule_content_2 = 'Sau bữa sáng, đoàn khởi hành tham quan những địa danh nổi tiếng và mang tính biểu tượng của vùng đất này. Quý khách sẽ có cơ hội chụp những bức ảnh kỷ niệm tuyệt đẹp và lắng nghe những câu chuyện lịch sử, văn hóa hấp dẫn. Buổi chiều, tham gia các hoạt động trải nghiệm địa phương độc đáo.';
            $schedule_content_3 = 'Buổi sáng, quý khách tự do mua sắm đặc sản địa phương làm quà cho người thân và bạn bè. Sau đó, đoàn làm thủ tục trả phòng và xe đưa quý khách ra sân bay/bến xe, kết thúc hành trình. Hướng dẫn viên chia tay và hẹn gặp lại quý khách trong những chuyến đi tiếp theo.';


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
                'short_description' => $short_description,
                'tour_description' => $tour_description,
                'tour_schedule' => [
                    ['title' => 'Ngày 1: Khởi hành và Chào mừng', 'content' => $schedule_content_1],
                    ['title' => 'Ngày 2: Khám phá các danh lam thắng cảnh', 'content' => $schedule_content_2],
                    ['title' => 'Ngày 3: Mua sắm và Tạm biệt', 'content' => $schedule_content_3],
                ],
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
