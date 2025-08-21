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
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('news')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create('vi_VN');
        $newsCategories = Category::where('type', 'NEWS')->pluck('id')->toArray();
        $newsImages = [
            '/userfiles/images/news/can-tho-du-lich-viet.jpg',
            '/userfiles/images/news/hoi-an-du-lich-viet.jpg',
            '/userfiles/images/news/kinh-nghiem-du-lich-an-do-du-lich-viet.jpg',
            '/userfiles/images/news/kinh-nghiem-du-lich-brazil-du-lich-viet.jpg',
            '/userfiles/images/news/kinh-nghiem-du-lich-chau-my-du-lich-viet.jpg',
            '/userfiles/images/news/kinh-nghiem-du-lich-hong-kong-du-lich-viet.jpg',
            '/userfiles/images/news/kinh-nghiem-du-lich-ninh-binh-du-lich-viet.jpg',
            '/userfiles/images/news/kinh-nghiem-du-lich-tho-nhi-ki-du-lich-viet.jpg',
        ];

        $vietnameseTitles = [
            '10 kinh nghiệm du lịch Phú Quốc tự túc không thể bỏ lỡ',
            'Cẩm nang khám phá phố cổ Hội An trong 2 ngày 1 đêm',
            'Top 5 homestay "sống ảo" cực chất tại Đà Lạt',
            'Du lịch Ninh Bình mùa lúa chín: nên đi đâu và ăn gì?',
            'Bí kíp săn vé máy bay giá rẻ cho chuyến du lịch tiết kiệm',
            'Những lưu ý quan trọng khi du lịch Thái Lan lần đầu',
            'Khám phá vẻ đẹp hùng vĩ của cung đường Hà Giang',
            'Lễ hội hoa tam giác mạch 2025 có gì đặc sắc?',
            'Du lịch Hàn Quốc mùa thu: Những địa điểm ngắm lá vàng đẹp nhất',
            'Top 10 món ăn đường phố phải thử khi đến Sài Gòn',
            'Review chi tiết chuyến đi Côn Đảo 3 ngày 2 đêm',
            'Cẩm nang du lịch Vịnh Hạ Long trên du thuyền 5 sao',
            'Những ngôi chùa linh thiêng nên ghé thăm khi đến Hà Nội',
            'Mùa nước nổi miền Tây và những trải nghiệm khó quên',
            'Kinh nghiệm xin visa du lịch Châu Âu cho người mới bắt đầu',
            'Đà Nẵng - Thành phố đáng sống và những cây cầu biểu tượng',
            'Khám phá "tiểu Bali" tại Quy Nhơn, Bình Định',
            'Du lịch Mộc Châu mùa hoa mận trắng tinh khôi',
            'Check-in những cánh đồng điện gió "hot" nhất Việt Nam',
            'Trải nghiệm văn hóa độc đáo của người dân tộc thiểu số ở Sapa',
        ];

        if (empty($newsCategories)) {
            $this->command->info('Không tìm thấy danh mục tin tức nào. Vui lòng tạo danh mục trước.');
            return;
        }

        foreach($vietnameseTitles as $title) {
            $shortDescription = 'Bài viết này sẽ chia sẻ những kinh nghiệm quý báu và thông tin hữu ích giúp bạn có một chuyến đi trọn vẹn và đáng nhớ. Hãy cùng khám phá những điểm đến hấp dẫn, thưởng thức ẩm thực địa phương và lên kế hoạch cho hành trình của riêng mình.';
            $content = '<p>Đây là nội dung chi tiết cho bài viết "' . $title . '". Trong bài viết này, chúng tôi sẽ đi sâu vào các khía cạnh khác nhau của chủ đề, cung cấp cho bạn đọc những thông tin chính xác và cập nhật nhất.</p><p>' . $faker->paragraph(15) . '</p><p>' . $faker->paragraph(12) . '</p>';

            News::create([
                'title' => $title,
                'category_id' => $faker->randomElement($newsCategories),
                'slug' => Str::slug($title) . '-' . Str::random(5),
                'thumbnail' => $faker->randomElement($newsImages),
                'priority' => $faker->numberBetween(1, 100),
                'view' => $faker->numberBetween(100, 5000),
                'short_description' => $shortDescription,
                'contents' => $content,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
