@extends('client.layouts.app')

@section('title', 'Tin tức & Sự kiện')
@section('description', 'Cập nhật những tin tức du lịch mới nhất, kinh nghiệm du lịch hữu ích và các chương trình khuyến mãi hấp dẫn từ King Express Travel.')

@section('content')
    <div class="py-6 md:py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 md:mb-12">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 uppercase">Tin Tức & Sự kiện</h1>
                <p class="text-gray-600 mt-2">Cập nhật những thông tin mới nhất và kinh nghiệm du lịch hữu ích.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-8 order-2 lg:order-1">
                    <div id="news-list-container" class="space-y-6">
                        @include('client.pages.news.partials.news_list', ['newsItems' => $newsItems])
                    </div>

                    <div id="pagination-container" class="mt-10 text-center">
                        @if ($newsItems->hasMorePages())
                            <a href="{{ $newsItems->nextPageUrl() }}" id="load-more-button"
                               class="inline-block bg-[var(--color-primary)] text-white font-bold py-3 px-8 rounded-lg hover:bg-[var(--color-primary-dark)] transition-colors text-base">
                                Xem thêm
                            </a>
                        @endif
                    </div>
                </div>

                <aside class="lg:col-span-4 order-1 lg:order-2">
                    <div class="sticky top-24 space-y-6">
                        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Tìm kiếm</h3>
                            <form action="{{ route('client.news') }}" method="GET">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ $searchQuery ?? '' }}"
                                           placeholder="Tìm kiếm bài viết..."
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]">
                                    <button type="submit"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-[var(--color-primary)]"
                                            aria-label="Tìm kiếm">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                                @if(isset($selectedCategorySlug))
                                    <input type="hidden" name="category" value="{{ $selectedCategorySlug }}">
                                @endif
                            </form>
                        </div>

                        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Danh mục</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('client.news', ['search' => $searchQuery ?? '']) }}"
                                       class="block px-4 py-2 rounded-md transition-colors text-gray-700 hover:bg-[var(--color-primary-light)] hover:text-[var(--color-primary-dark)] {{ !isset($selectedCategorySlug) ? 'bg-[var(--color-primary-light)] text-[var(--color-primary-dark)] font-bold' : '' }}">
                                        Tất cả
                                    </a>
                                </li>
                                @if(isset($categories) && !$categories->isEmpty())
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('client.news', ['category' => $category->slug, 'search' => $searchQuery ?? '']) }}"
                                               class="block px-4 py-2 rounded-md transition-colors text-gray-700 hover:bg-[var(--color-primary-light)] hover:text-[var(--color-primary-dark)] {{ (isset($selectedCategorySlug) && $selectedCategorySlug == $category->slug) ? 'bg-[var(--color-primary-light)] text-[var(--color-primary-dark)] font-bold' : '' }}">
                                                {{ $category->name ?? '' }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paginationContainer = document.getElementById('pagination-container');
            if (!paginationContainer) return;

            paginationContainer.addEventListener('click', function (e) {
                if (e.target && e.target.id === 'load-more-button') {
                    e.preventDefault();
                    const loadMoreButton = e.target;
                    const url = loadMoreButton.getAttribute('href');
                    loadMoreButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang tải...';
                    loadMoreButton.disabled = true;

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newItems = doc.querySelector('#news-list-container').innerHTML;
                            const newPagination = doc.querySelector('#pagination-container').innerHTML;

                            document.getElementById('news-list-container').insertAdjacentHTML('beforeend', newItems);

                            if (newPagination.trim()) {
                                paginationContainer.innerHTML = newPagination;
                            } else {
                                paginationContainer.remove();
                            }
                        })
                        .catch(error => {
                            console.error('Error loading more news:', error);
                            loadMoreButton.innerText = 'Xem thêm';
                            loadMoreButton.disabled = false;
                        });
                }
            });
        });
    </script>
@endpush
