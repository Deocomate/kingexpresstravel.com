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

<x-client.modal id="cancel-order-modal" title="Lý do hủy tour" subtitle="Vui lòng cho chúng tôi biết lý do bạn muốn hủy đơn hàng này.">
    <form id="cancel-order-form" method="POST" action="">
        @csrf
        @method('DELETE')
        <div class="space-y-4">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Vui lòng chọn lý do hủy (*)</label>
                <div class="flex items-center">
                    <input id="reason1" name="reason_option" type="radio" value="Thay đổi kế hoạch" class="h-4 w-4 border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary-accent)]" checked>
                    <label for="reason1" class="ml-3 block text-sm text-gray-900">Tôi có thay đổi kế hoạch</label>
                </div>
                <div class="flex items-center">
                    <input id="reason2" name="reason_option" type="radio" value="Lý do cá nhân / sức khỏe" class="h-4 w-4 border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary-accent)]">
                    <label for="reason2" class="ml-3 block text-sm text-gray-900">Lý do cá nhân / sức khỏe</label>
                </div>
                <div class="flex items-center">
                    <input id="reason3" name="reason_option" type="radio" value="Tìm được tour tốt hơn" class="h-4 w-4 border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary-accent)]">
                    <label for="reason3" class="ml-3 block text-sm text-gray-900">Tôi tìm được tour khác tốt hơn</label>
                </div>
                <div class="flex items-center">
                    <input id="reason_other_option" name="reason_option" type="radio" value="other" class="h-4 w-4 border-gray-300 text-[var(--color-primary)] focus:ring-[var(--color-primary-accent)]">
                    <label for="reason_other_option" class="ml-3 block text-sm text-gray-900">Lý do khác</label>
                </div>
            </div>
            <div id="other_reason_container" class="hidden">
                <label for="reason_other" class="sr-only">Lý do khác</label>
                <textarea name="reason_other" id="reason_other" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[var(--color-primary)] focus:border-[var(--color-primary)]" placeholder="Vui lòng nhập lý do cụ thể..."></textarea>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full hover:cursor-pointer text-center bg-red-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-red-700 transition-colors">
                Xác nhận hủy
            </button>
        </div>
    </form>
</x-client.modal>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paginationContainer = document.getElementById('pagination-container');
            if (paginationContainer) {
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
                                    document.getElementById('booking-history-container').insertAdjacentHTML('beforeend', data.html);
                                }
                                if (data.next_page_url) {
                                    loadMoreButton.dataset.nextUrl = data.next_page_url;
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
            }

            const reasonRadios = document.querySelectorAll('input[name="reason_option"]');
            const otherReasonContainer = document.getElementById('other_reason_container');
            const otherReasonTextarea = document.getElementById('reason_other');

            reasonRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'other') {
                        otherReasonContainer.classList.remove('hidden');
                        otherReasonTextarea.required = true;
                    } else {
                        otherReasonContainer.classList.add('hidden');
                        otherReasonTextarea.required = false;
                    }
                });
            });
        });
    </script>
@endpush
