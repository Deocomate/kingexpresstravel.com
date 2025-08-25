<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Thời gian hết hạn của link xác minh email đã được chuyển sang file config/auth.php
        // để đảm bảo tính nhất quán và tránh các vấn đề về cache.
        // Phần code tùy chỉnh URL đã được xóa khỏi đây.
    }
}
