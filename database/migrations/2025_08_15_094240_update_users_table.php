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
            $table->string('address', 2000)->nullable()->after('role');
            $table->string('phone', 2000)->nullable()->after('address');
            $table->string('avatar', 2000)->nullable()->after('phone');
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
