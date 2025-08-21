@extends('client.layouts.app')

@section('title', 'Danh sách Tour du lịch')
@section('description', 'Khám phá các tour du lịch hấp dẫn trong và ngoài nước được tổ chức bởi King Express Travel. Đa dạng lựa chọn, giá cả cạnh tranh.')

@section('content')
    <div class="py-6 md:py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 md:mb-12">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 uppercase">Tour Du Lịch</h1>
                <p class="text-gray-600 mt-2">Khám phá thế giới qua những hành trình đầy cảm hứng từ King Express Travel.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Cột Filter bên trái --}}
                <aside class="lg:col-span-3">
                    <div class="sticky top-36 space-y-6">
                        <div class="bg-white p-5 rounded-lg shadow-md border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Bộ lọc tìm kiếm</h3>
                            <form action="{{ route('client.tours') }}" method="GET">
                                <div class="space-y-4">
                                    <div>
                                        <label for="search" class="block text-sm font-semibold text-gray-800">Tên tour</label>
                                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nhập tên tour..." class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                    </div>
                                    <div>
                                        <label for="category_id" class="block text-sm font-semibold text-gray-800">Loại hình</label>
                                        <select name="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                            <option value="">Tất cả</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="destination_id" class="block text-sm font-semibold text-gray-800">Điểm đến</label>
                                        <select name="destination_id" id="destination_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                            <option value="">Tất cả</option>
                                            @foreach($destinations as $destination)
                                                <option value="{{ $destination->id }}" @selected(request('destination_id') == $destination->id)>{{ $destination->name }}</option>
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
                                        <button type="submit" class="w-full hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-white font-bold py-2 px-4 rounded-lg hover:bg-[var(--color-primary)] transition-colors flex items-center justify-center">
                                            <i class="fa-solid fa-magnifying-glass mr-1"></i> Lọc
                                        </button>
                                        <a href="{{ route('client.tours') }}" class="w-full text-center bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors flex items-center justify-center">
                                            <i class="fa-solid fa-eraser mr-1"></i> Xóa lọc
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>

                {{-- Cột danh sách Tour bên phải --}}
                <div class="lg:col-span-9">
                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">Các tour du lịch</h2>
                    </div>
                    <div id="tour-list-container">
                        @include('client.pages.tours.partials.tour_list', ['tours' => $tours])
                    </div>

                    <div id="pagination-container" class="mt-10 text-center">
                        @if ($tours->hasMorePages())
                            <a href="{{ $tours->nextPageUrl() }}" id="load-more-button"
                               class="inline-block bg-[var(--color-primary)] text-white font-bold py-3 px-8 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors text-base">
                                Xem thêm
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- jQuery is required for ion.rangeSlider --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- ion.rangeSlider CSS & JS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

    <style>
        .irs--flat .irs-bar {
            background-color: var(--color-primary);
        }
        .irs--flat .irs-handle>i:first-child {
            background-color: var(--color-primary-dark);
        }
        .irs--flat .irs-from, .irs--flat .irs-to, .irs--flat .irs-single {
            background-color: var(--color-primary-dark);
        }
        .irs--flat .irs-from:before, .irs--flat .irs-to:before, .irs--flat .irs-single:before {
            border-top-color: var(--color-primary-dark);
        }
    </style>

    <script>
        // Price Range Slider
        $(function () {
            $("#price_range_slider").ionRangeSlider({
                type: "double",
                grid: true,
                min: 1000000,
                max: 15000000,
                from: {{ request('price_from', 1000000) }},
                to: {{ request('price_to', 15000000) }},
                prefix: "đ ",
                step: 500000,
                prettify_separator: ".",
                onFinish: function (data) {
                    $('#price_from').val(data.from);
                    $('#price_to').val(data.to);
                },
            });
        });

        // Load More Button
        document.addEventListener('DOMContentLoaded', function () {
            const paginationContainer = document.getElementById('pagination-container');
            if (!paginationContainer) return;

            paginationContainer.addEventListener('click', function (e) {
                const loadMoreButton = e.target.closest('#load-more-button');
                if (loadMoreButton && !loadMoreButton.disabled) {
                    e.preventDefault();
                    const url = loadMoreButton.getAttribute('href');
                    if (!url) return;

                    loadMoreButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang tải...';
                    loadMoreButton.disabled = true;

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.html) {
                                const tourListContainer = document.getElementById('tour-list-container');
                                const grid = tourListContainer.querySelector('.grid');
                                if (grid) {
                                    const tempDiv = document.createElement('div');
                                    tempDiv.innerHTML = data.html;
                                    const newItems = tempDiv.querySelector('.grid').innerHTML;
                                    grid.insertAdjacentHTML('beforeend', newItems);
                                }
                            }

                            const nextUrl = data.next_page_url;

                            if (nextUrl) {
                                loadMoreButton.setAttribute('href', nextUrl);
                                loadMoreButton.innerHTML = 'Xem thêm';
                                loadMoreButton.disabled = false;
                            } else {
                                paginationContainer.remove();
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi tải thêm tour:', error);
                            if(loadMoreButton) {
                                loadMoreButton.innerText = 'Xem thêm';
                                loadMoreButton.disabled = false;
                            }
                        });
                }
            });
        });
    </script>
@endpush
