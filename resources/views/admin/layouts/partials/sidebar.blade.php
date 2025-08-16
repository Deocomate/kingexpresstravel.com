<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard.index') }}" class="brand-link">
        <img src="{{asset("/admin/dist/img/AdminLTELogo.png")}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{config("app.name")}}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- ADMIN BASE -->
                <li class="nav-header">Admin</li>
                <x-menus.menu-bar :route="route('admin.dashboard.index')" name="Dashboard" icon="fas fa-tachometer-alt"/>

                <!-- THÊM MỚI CÁC MENU TẠI ĐÂY -->
                <li class="nav-header">Quản lý Nội dung</li>
                <x-menus.menu-bar :route="route('admin.categories.index')" name="Quản lý Danh mục" icon="fas fa-sitemap" />

                <li class="nav-header">Cài đặt & Khác</li>

            </ul>
        </nav>
    </div>
</aside>
