@extends('client.layouts.app')

@section('title', $selectedCategory->name ?? 'Danh sách Tour du lịch')
@section('description', 'Khám phá các tour du lịch hấp dẫn trong và ngoài nước được tổ chức bởi King Express Travel. Đa dạng lựa chọn, giá cả cạnh tranh.')

@section('content')
    <div class="py-6 md:py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 md:mb-12">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 uppercase">Tour Du Lịch</h1>
                <p class="text-gray-600 mt-2">Khám phá thế giới qua những hành trình đầy cảm hứng từ King Express Travel.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <aside class="lg:col-span-3">
                    <div class="sticky top-28 space-y-6">
                        <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Bộ lọc tìm kiếm</h3>
                            <form action="{{ route('client.tours') }}" method="GET" id="filter-form">
                                <div class="space-y-4">
                                    <div>
                                        <label for="search" class="block text-sm font-semibold text-gray-800">Tên tour</label>
                                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nhập tên tour..." class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                    </div>
                                    <div>
                                        <label for="category" class="block text-sm font-semibold text-gray-800">Loại hình</label>
                                        <select name="category" id="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                            <option value="">Tất cả</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->slug }}" @selected($selectedCategorySlug == $category->slug)>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="destination" class="block text-sm font-semibold text-gray-800">Điểm đến</label>
                                        <select name="destination" id="destination" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                            <option value="">Tất cả</option>
                                            @foreach($destinations as $destination)
                                                <option value="{{ $destination->slug }}" @selected($selectedDestination == $destination->slug)>{{ $destination->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="price_range_slider" class="block text-sm font-semibold text-gray-800">Khoảng giá</label>
                                        <input type="text" id="price_range_slider" name="price_range" value="" />
                                        <input type="hidden" name="price_from" id="price_from" value="{{ request('price_from') }}">
                                        <input type="hidden" name="price_to" id="price_to" value="{{ request('price_to') }}">
                                    </div>
                                    <div>
                                        <label for="sort" class="block text-sm font-semibold text-gray-800">Sắp xếp</label>
                                        <select name="sort" id="sort" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                            <option value="default" @selected(request('sort') == 'default')>Mặc định</option>
                                            <option value="price_asc" @selected(request('sort') == 'price_asc')>Giá tăng dần</option>
                                            <option value="price_desc" @selected(request('sort') == 'price_desc')>Giá giảm dần</option>
                                            <option value="name_asc" @selected(request('sort') == 'name_asc')>Theo tên A-Z</option>
                                        </select>
                                    </div>
                                    <div class="pt-2 grid grid-cols-2 gap-2">
                                        <a href="{{ route('client.tours') }}" class="w-full text-center bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors flex items-center justify-center">
                                            <i class="fa-solid fa-eraser mr-2"></i> Xóa lọc
                                        </a>
                                        <button type="submit" class="w-full text-center bg-[var(--color-primary)] text-white font-bold py-2 px-4 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors flex items-center justify-center">
                                            <i class="fa-solid fa-filter mr-2"></i> Lọc
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>

                <div class="lg:col-span-9">
                    <div class="mb-4">
                        <h2 id="tour-list-title" class="text-2xl font-bold text-gray-800">{{ $selectedCategory->name ?? 'Tất cả tour' }}</h2>
                    </div>

                    <div id="tour-list-container">
                        @include('client.pages.tours.partials.tour_list', ['tours' => $tours])
                    </div>

                    <div id="pagination-container" class="mt-10">
                        {{ $tours->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

    <style>
        .irs--flat .irs-bar { background-color: var(--color-primary); }
        .irs--flat .irs-handle>i:first-child { background-color: var(--color-primary-dark); }
        .irs--flat .irs-from, .irs--flat .irs-to, .irs--flat .irs-single { background-color: var(--color-primary-dark); }
        .irs--flat .irs-from:before, .irs--flat .irs-to:before, .irs--flat .irs-single:before { border-top-color: var(--color-primary-dark); }
    </style>

    <script>
        $(document).ready(function () {
            $("#price_range_slider").ionRangeSlider({
                type: "double",
                grid: true,
                min: 1000000,
                max: 50000000,
                from: {{ request('price_from', 1000000) }},
                to: {{ request('price_to', 50000000) }},
                prefix: "đ ",
                step: 500000,
                prettify_separator: ".",
                onFinish: function (data) {
                    $('#price_from').val(data.from);
                    $('#price_to').val(data.to);
                },
            });
        });
    </script>
@endpush
