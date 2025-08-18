<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('orders')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create('vi_VN');
        $userIds = User::pluck('id')->toArray();
        $tourIds = Tour::pluck('id')->toArray();

        if (empty($tourIds)) {
            $this->command->info('Không có tour nào để tạo đơn hàng.');
            return;
        }

        for ($i = 0; $i < 40; $i++) {
            $tour = Tour::find($faker->randomElement($tourIds));
            $adults = $faker->numberBetween(1, 4);
            $children = $faker->numberBetween(0, 2);

            Order::create([
                'user_id' => $faker->optional(0.7)->randomElement($userIds),
                'full_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'tour_id' => $tour->id,
                'departure_date' => $faker->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
                'adult_quantity' => $adults,
                'child_quantity' => $children,
                'toddler_quantity' => $faker->numberBetween(0, 1),
                'infant_quantity' => $faker->numberBetween(0, 1),
                'total_price' => ($adults * $tour->price_adult) + ($children * $tour->price_child),
                'status' => $faker->randomElement(['PENDING', 'CONFIRMED', 'COMPLETED', 'CANCELLED']),
                'note' => $faker->optional(0.4)->sentence,
                'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
