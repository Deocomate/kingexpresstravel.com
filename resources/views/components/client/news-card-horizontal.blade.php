@props(['news'])

@if($news)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden group transition-all duration-300 hover:shadow-lg hover:border-[var(--color-primary)]">
        <a href="#" title="{{ $news->title ?? '' }}" class="flex flex-col sm:flex-row">
            <div class="sm:w-1/3 lg:w-1/4">
                <img class="w-full h-48 sm:h-full object-cover"
                     src="{{ $news->thumbnail ?? '/userfiles/images/placeholder.jpg' }}"
                     alt="{{ $news->title ?? 'Hình ảnh tin tức' }}" loading="lazy">
            </div>
            <div class="p-5 flex flex-col flex-grow sm:w-2/3 lg:w-3/4">
                @if($news->category)
                    <p class="text-xs font-semibold text-[var(--color-primary)] uppercase">{{ $news->category->name }}</p>
                @endif
                <h3 class="font-bold text-gray-800 text-lg leading-tight mt-1 group-hover:text-[var(--color-primary)] transition-colors overflow-hidden [display:-webkit-box] [-webkit-line-clamp:2] [-webkit-box-orient:vertical]">
                    {{ $news->title ?? 'Tiêu đề tin tức đang được cập nhật' }}
                </h3>
                <div class="mt-2 text-sm text-gray-600 flex-grow overflow-hidden [display:-webkit-box] [-webkit-line-clamp:3] [-webkit-box-orient:vertical]">
                    {{ $news->short_description ?? '' }}
                </div>
                <div class="mt-4 text-xs text-gray-500 flex justify-between items-center">
                    <span>{{ optional($news->created_at)->format('d/m/Y') }}</span>
                    <span class="font-semibold text-gray-700 group-hover:text-[var(--color-primary-dark)]">
                        Đọc thêm <i class="fa-solid fa-arrow-right ml-1"></i>
                    </span>
                </div>
            </div>
        </a>
    </div>
@endif
