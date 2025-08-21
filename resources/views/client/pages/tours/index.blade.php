@extends('client.layouts.app')

@section('title', 'Danh sách Tour du lịch')
@section('description', 'Khám phá các tour du lịch hấp dẫn trong và ngoài nước được tổ chức bởi King Express Travel. Đa dạng lựa chọn, giá cả cạnh tranh.')

@section('content')
    <div class="py-6 md:py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 uppercase">Tour Du Lịch</h1>
                <p class="text-gray-600 mt-2">Khám phá thế giới qua những hành trình đầy cảm hứng từ King Express Travel.</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm mb-8">
                <form action="{{ route('client.tours') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <div class="lg:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700">Tìm kiếm tour</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nhập tên tour bạn muốn tìm..." class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                        </div>
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Loại hình</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                <option value="">Tất cả</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="destination_id" class="block text-sm font-medium text-gray-700">Điểm đến</label>
                            <select name="destination_id" id="destination_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                <option value="">Tất cả</option>
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}" @selected(request('destination_id') == $destination->id)>{{ $destination->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700">Sắp xếp</label>
                            <select name="sort" id="sort" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                <option value="default" @selected(request('sort') == 'default')>Mặc định</option>
                                <option value="price_asc" @selected(request('sort') == 'price_asc')>Giá tăng dần</option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>Giá giảm dần</option>
                                <option value="name_asc" @selected(request('sort') == 'name_asc')>Theo tên A-Z</option>
                            </select>
                        </div>
                        <div class="col-span-full text-right">
                            <button type="submit" class="w-full md:w-auto mt-2 hover:cursor-pointer text-center bg-[var(--color-primary-accent)] text-white font-bold py-2 px-6 rounded-lg hover:bg-[var(--color-primary)] transition-colors">
                                <i class="fa-solid fa-magnifying-glass mr-1"></i> Tìm kiếm
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($tours as $tour)
                    <x-client.tour-card :tour="$tour" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fa-solid fa-map-location-dot text-6xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500">Không tìm thấy tour nào phù hợp.</p>
                    </div>
                @endforelse
            </div>

            @if($tours->hasPages())
                <div class="mt-10">
                    {{ $tours->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
