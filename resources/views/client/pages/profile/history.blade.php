@extends('client.layouts.app')

@section('title', 'Lịch sử đặt tour')
@section('description', 'Xem lại lịch sử các tour du lịch bạn đã đặt tại King Express Travel.')

@section('content')
    <div class="bg-gray-100 py-6 md:py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <aside class="lg:col-span-3">
                    @include('client.pages.profile.partials._sidebar', ['user' => $user])
                </aside>

                <div class="lg:col-span-9">
                    <div class="bg-white p-6 md:p-8 rounded-lg shadow-sm border border-gray-200">
                        <h1 class="text-2xl font-bold text-gray-800 mb-6">Lịch sử đặt tour</h1>

                        <div id="booking-history-container" class="space-y-6">
                            @include('client.pages.profile.partials._booking_history_items', ['orders' => $orders])
                        </div>

                        <div id="pagination-container" class="mt-10 text-center">
                            @if ($orders->hasMorePages())
                                <button id="load-more-button" data-next-url="{{ $orders->nextPageUrl() }}"
                                        class="inline-block bg-[var(--color-primary)] text-white font-bold py-3 px-8 rounded-lg hover:bg-[var(--color-primary-dark)] cursor-pointer transition-colors text-base">
                                    Xem thêm
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
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
                const loadMoreButton = e.target.closest('#load-more-button');
                if (loadMoreButton && !loadMoreButton.disabled) {
                    e.preventDefault();
                    const url = loadMoreButton.dataset.nextUrl;
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
                                const historyContainer = document.getElementById('booking-history-container');
                                historyContainer.insertAdjacentHTML('beforeend', data.html);
                            }

                            const nextUrl = data.next_page_url;

                            if (nextUrl) {
                                loadMoreButton.dataset.nextUrl = nextUrl;
                                loadMoreButton.innerHTML = 'Xem thêm';
                                loadMoreButton.disabled = false;
                            } else {
                                paginationContainer.remove();
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi tải thêm lịch sử:', error);
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
