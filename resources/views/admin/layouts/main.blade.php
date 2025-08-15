<!DOCTYPE html>
<html lang="vi">

<head>
    @include('admin.layouts.partials.head')

    {{-- Custom styles for specific pages --}}
    <style>
        .image-preview-grid .list-unstyled {
            gap: 15px;
        }
        .image-preview-grid .grid-item {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 150px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .image-preview-grid .grid-item img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        .image-preview-grid .grid-item .btn-remove-image {
            position: absolute; top: -10px; right: -10px;
            width: 25px; height: 25px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            padding: 0; line-height: 1;
        }
        /* You can move other common styles here or to a dedicated css file */
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @include('admin.layouts.partials.header')

    @include('admin.layouts.partials.sidebar')

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @include('admin.partials.alerts')
                @yield("content")
            </div>
        </section>
    </div>

    @include('admin.layouts.partials.footer')

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</div>

@include('admin.layouts.partials.scripts')

</body>
</html>