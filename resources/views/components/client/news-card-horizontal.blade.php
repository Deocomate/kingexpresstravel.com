@props(['news'])

@if($news)
    <div class="rounded-lg shadow-sm border border-gray-200 overflow-hidden group transition-all duration-300 hover:shadow-lg hover:border-[var(--color-primary)]">
        <a href="{{ route('client.news.show', $news) }}" title="{{ $news->title ?? '' }}" class="flex flex-col md:flex-row">
            <div class="md:w-1/3 flex-shrink-0 relative">
                @if($news->category)
                    <span class="absolute top-3 left-3 z-10 inline-block bg-[var(--color-primary-light)] text-[var(--color-primary-dark)] text-xs font-bold px-3 py-1 rounded-full">{{ $news->category->name }}</span>
                @endif
                <img class="w-full h-40 md:h-44 object-cover"
                     src="{{ $news->thumbnail ?? 'https://placehold.co/400x300/e2e8f0/e2e8f0?text=King+Express' }}"
                     alt="{{ $news->title ?? 'Hình ảnh tin tức' }}" loading="lazy">
            </div>
            <div class="p-4 flex flex-col flex-grow bg-white">
                <h3 class="font-bold text-gray-800 text-lg leading-tight group-hover:text-[var(--color-primary)] transition-colors">
                    {{ $news->title ?? 'Tiêu đề tin tức đang được cập nhật' }}
                </h3>

                <div class="mt-3 flex items-center gap-x-4 text-xs text-gray-500">
                    <span><i class="fa-regular fa-user mr-1"></i> BY ADMIN</span>
                    <span><i class="fa-regular fa-calendar-days mr-1"></i> {{ optional($news->created_at)->format('d/m/Y') }}</span>
                    <span><i class="fa-regular fa-eye mr-1"></i> {{ $news->view ?? 0 }}</span>
                </div>

                <div class="mt-3 text-sm text-gray-600 flex-grow overflow-hidden [display:-webkit-box] [-webkit-line-clamp:2] [-webkit-box-orient:vertical]">
                    {{ $news->short_description ?? '' }}
                </div>
            </div>
        </a>
    </div>
@endif
