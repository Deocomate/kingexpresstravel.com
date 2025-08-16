<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable()->after('role');
            $table->string('phone')->nullable()->after('address');
            $table->string('avatar')->nullable()->after('phone');
            $table->enum('account_type', ['LOCAL', 'GOOGLE'])->default('LOCAL')->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone', 'avatar', 'account_type']);
        });
    }
};
