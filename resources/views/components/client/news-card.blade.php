@props(['news'])

@if($news)
    <div class="bg-white rounded-lg shadow-md overflow-hidden group transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
        <a href="#" title="{{ $news->title ?? '' }}" class="block">
            <div class="relative">
                <img class="w-full h-48 object-cover"
                     src="{{ $news->thumbnail ?? '/userfiles/images/placeholder.jpg' }}"
                     alt="{{ $news->title ?? 'Hình ảnh tin tức' }}" loading="lazy">
            </div>
            <div class="p-4 flex flex-col h-[180px]">
                @if($news->category)
                    <p class="text-xs font-semibold text-[var(--color-primary)] uppercase">{{ $news->category->name }}</p>
                @endif
                <h3 class="font-bold text-gray-800 text-base leading-tight h-12 overflow-hidden group-hover:text-[var(--color-primary)] transition-colors mt-1">
                    {{ $news->title ?? 'Tiêu đề tin tức đang được cập nhật' }}
                </h3>
                <div class="mt-2 text-sm text-gray-600 flex-grow overflow-hidden">
                    {{ $news->short_description ?? '' }}
                </div>
                <div class="mt-3 text-xs text-gray-400">
                    <span>{{ optional($news->created_at)->format('d/m/Y') }}</span>
                </div>
            </div>
        </a>
    </div>
@endif
