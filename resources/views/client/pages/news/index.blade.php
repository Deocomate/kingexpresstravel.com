@extends('client.layouts.app')

@section('title', 'Tin tức & Sự kiện')
@section('description', 'Cập nhật những tin tức du lịch mới nhất, kinh nghiệm du lịch hữu ích và các chương trình khuyến mãi hấp dẫn từ King Express Travel.')

@section('content')
    <div class="py-6 md:py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 uppercase">Tin Tức & Sự kiện</h1>
                <p class="text-gray-600 mt-2">Cập nhật những thông tin mới nhất và kinh nghiệm du lịch hữu ích.</p>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm mb-8">
                <form action="{{ route('client.news') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700">Tìm kiếm bài viết</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nhập tiêu đề bạn muốn tìm..." class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                        </div>
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Chuyên mục</label>
                            <select name="category_id" id="category_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                <option value="">Tất cả</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
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
                @forelse($newsItems as $newsItem)
                    <x-client.news-card :news="$newsItem" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fa-regular fa-newspaper text-6xl text-gray-300"></i>
                        <p class="mt-4 text-gray-500">Không tìm thấy bài viết nào.</p>
                    </div>
                @endforelse
            </div>

            @if($newsItems->hasPages())
                <div class="mt-10">
                    {{ $newsItems->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
