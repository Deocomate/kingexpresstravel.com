<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 2000)->nullable();
            $table->string('thumbnail', 2000)->nullable();
            $table->string('slug')->unique();
            $table->integer('priority')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('type', ['TOUR', 'NEWS'])->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('thumbnail', 2000)->nullable();
            $table->integer('priority')->nullable();
            $table->integer('view')->default(0);
            $table->longText('short_description')->nullable();
            $table->longText('contents')->nullable();
            $table->timestamps();
        });

        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('tour_code')->unique()->nullable();
            $table->longText('name')->nullable();
            $table->string('duration', 2000)->nullable();
            $table->longText('departure_point')->nullable();
            $table->integer('remaining_slots')->nullable();
            $table->integer('price_adult')->nullable();
            $table->integer('price_child')->nullable();
            $table->integer('price_toddler')->nullable();
            $table->integer('price_infant')->nullable();
            $table->longText('transport_mode')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('tour_description')->nullable();
            $table->integer('priority')->nullable();
            $table->longText('tour_schedule')->nullable();
            $table->string('thumbnail', 2000)->nullable();
            $table->longText('images')->nullable();
            $table->string('slug')->unique();
            $table->longText('services_note')->nullable();
            $table->longText('note')->nullable();
            $table->longText('characteristic')->nullable();
            $table->timestamps();
        });

        Schema::create('tour_categories', function (Blueprint $table) {
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->primary(['tour_id', 'category_id']);
        });

        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->longText('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('tour_destinations', function (Blueprint $table) {
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->integer('position')->nullable();
            $table->primary(['tour_id', 'destination_id']);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address', 1000)->nullable();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->integer('adult_quantity')->default(1);
            $table->integer('child_quantity')->default(0);
            $table->integer('toddler_quantity')->default(0);
            $table->integer('infant_quantity')->default(0);
            $table->integer('total_price')->nullable();
            $table->enum('status', ['PENDING', 'CONFIRMED', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            $table->longText('note')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('method', 2000)->nullable();
            $table->string('transaction_id', 2000)->unique()->nullable();
            $table->integer('amount')->nullable();
            $table->enum('status', ['PENDING', 'SUCCESS', 'FAILED', 'CANCELLED', 'REFUNDED'])->default('PENDING');
            $table->dateTime('paid_at')->nullable();
            $table->string('note', 2000)->nullable();
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->longText('company_name')->nullable();
            $table->string('email', 2000)->nullable();
            $table->string('phone', 2000)->nullable();
            $table->string('facebook', 2000)->nullable();
            $table->string('zalo', 2000)->nullable();
            $table->string('working_hours', 2000)->nullable();
            $table->timestamps();
        });

        Schema::create('contact_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            $table->longText('branch_name')->nullable();
            $table->string('address', 2000)->nullable();
            $table->string('phone', 2000)->nullable();
            $table->string('email', 2000)->nullable();
            $table->boolean('is_main')->default(false);
            $table->string('working_hours', 2000)->nullable();
            $table->timestamps();
        });

        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->longText('content')->nullable();
            $table->timestamps();
        });

        Schema::create('customer_cares', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 2000)->nullable();
            $table->string('email', 2000)->nullable();
            $table->string('phone', 2000)->nullable();
            $table->longText('subject')->nullable();
            $table->longText('message')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_cares');
        Schema::dropIfExists('about_us');
        Schema::dropIfExists('contact_branches');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('tour_destinations');
        Schema::dropIfExists('destinations');
        Schema::dropIfExists('tour_categories');
        Schema::dropIfExists('tours');
        Schema::dropIfExists('news');
        Schema::dropIfExists('categories');
    }
};
