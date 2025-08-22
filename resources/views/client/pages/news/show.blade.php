@extends('client.layouts.app')

@section('title', $news->title ?? 'Chi tiết tin tức')
@section('description', $news->short_description ?? 'Đọc bài viết chi tiết để cập nhật thông tin và kinh nghiệm du lịch hữu ích.')

@section('content')
    <div class="py-6 md:py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <article class="lg:col-span-8">
                    <div class="space-y-3">
                        @if($news->category)
                            <a href="{{ route('client.news', ['category' => $news->category->slug]) }}" class="text-sm font-bold text-[var(--color-primary)] uppercase hover:underline">{{ $news->category->name }}</a>
                        @endif
                        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">{{ $news->title ?? 'Tiêu đề bài viết' }}</h1>
                        <div class="flex items-center gap-x-4 text-sm text-gray-500">
                            <span><i class="fa-regular fa-user mr-1"></i> BY ADMIN</span>
                            <span><i class="fa-regular fa-calendar-days mr-1"></i> {{ optional($news->created_at)->format('d/m/Y') }}</span>
                            <span><i class="fa-regular fa-eye mr-1"></i> {{ $news->view ?? 0 }} Lượt xem</span>
                        </div>
                    </div>

                    <div class="mt-6 prose max-w-none text-gray-700">
                        {!! $news->contents ?? '<p>Nội dung đang được cập nhật.</p>' !!}
                    </div>

                    @if(isset($relatedNews) && $relatedNews->isNotEmpty())
                        <section class="mt-12">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Bài viết liên quan</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($relatedNews as $item)
                                    <x-client.news-card :news="$item"/>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </article>

                <aside class="lg:col-span-4">
                    <div class="sticky top-36 space-y-6">
                        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Bài viết mới nhất</h3>
                            <ul class="space-y-4">
                                @if(isset($latestNews) && !$latestNews->isEmpty())
                                    @foreach($latestNews as $item)
                                        <li>
                                            <a href="{{ route('client.news.show', $item) }}" class="flex items-start gap-x-3 group">
                                                <img src="{{ $item->thumbnail ?? 'https://placehold.co/100x80' }}" alt="{{ $item->title }}" class="w-24 h-16 object-cover rounded-md flex-shrink-0">
                                                <div>
                                                    <h4 class="text-sm font-semibold text-gray-800 group-hover:text-[var(--color-primary)] transition-colors leading-tight">{{ \Illuminate\Support\Str::limit($item->title, 55) }}</h4>
                                                    <p class="text-xs text-gray-500 mt-1">{{ optional($item->created_at)->format('d/m/Y') }}</p>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-500">Chưa có bài viết mới.</p>
                                @endif
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
@endsection
