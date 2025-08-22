<div class="mt-8 space-y-12">
    @if($tour->short_description)
        <section id="mo-ta-ngan">
            <div class="prose max-w-none text-gray-700 font-semibold italic text-base">
                {!! $tour->short_description !!}
            </div>
        </section>
    @endif

    @if($tour->tour_description)
        <section id="mo-ta-tour">
            <div class="flex items-center mb-4">
                <i class="fa-solid fa-file-lines text-xl md:text-2xl text-[var(--color-primary)] mr-3"></i>
                <h2 class="text-lg md:text-xl font-bold text-gray-800">Mô tả tour</h2>
            </div>
            <div class="prose max-w-none text-gray-700 prose-styles">
                {!! $tour->tour_description !!}
            </div>
        </section>
    @endif

    @if($tour->characteristic)
        <section id="diem-nhan">
            <div class="flex items-center mb-4">
                <i class="fa-solid fa-star text-xl md:text-2xl text-[var(--color-primary)] mr-3"></i>
                <h2 class="text-lg md:text-xl font-bold text-gray-800">Điểm nhấn hành trình</h2>
            </div>
            <div class="prose max-w-none text-gray-700 prose-styles">
                {!! $tour->characteristic !!}
            </div>
        </section>
    @endif

    <section id="lich-trinh">
        <div class="flex items-center mb-6">
            <i class="fa-solid fa-book-open text-xl md:text-2xl text-[var(--color-primary)] mr-3"></i>
            <div>
                <h2 class="text-lg md:text-xl font-bold text-gray-800">Lịch trình</h2>
                <p class="text-xs text-gray-500">Cập nhật {{ optional($tour->updated_at)->format('d/m/Y') }}</p>
            </div>
        </div>

        @if(!empty($tour->tour_schedule) && is_array($tour->tour_schedule))
            <div class="relative border-l-2 border-dashed border-gray-300 ml-3 py-2">
                <div class="space-y-4">
                    @foreach($tour->tour_schedule as $schedule)
                        <div class="schedule-item relative pl-8">
                            <div class="absolute -left-[13px] top-3 w-6 h-6 rounded-full bg-white border-4 border-[var(--color-primary)] flex items-center justify-center z-10">
                                <div class="w-2 h-2 rounded-full bg-[var(--color-primary)]"></div>
                            </div>
                            <div>
                                <button type="button" class="schedule-toggle group relative flex justify-between items-center w-full text-left p-3 hover:cursor-pointer rounded-lg bg-[var(--color-primary)] text-white focus:outline-none transition-colors duration-300 hover:bg-[var(--color-primary-dark)]">
                                    <h3 class="text-base font-bold">{{ $schedule['title'] ?? 'Chi tiết' }}</h3>
                                    <span class="schedule-icon transform transition-transform duration-300">
                                        <i class="fa-solid fa-chevron-down text-sm"></i>
                                    </span>
                                </button>
                                <div class="schedule-content overflow-hidden transition-all duration-300 ease-in-out">
                                    <div class="prose-styles pt-4 bg-gray-50 p-4 mt-2 rounded-lg border border-gray-200">
                                        {!! $schedule['content'] ?? '<p>Nội dung đang được cập nhật.</p>' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-gray-600">Lịch trình chi tiết đang được cập nhật. Vui lòng liên hệ để biết thêm thông tin.</p>
        @endif
    </section>

    <section id="bang-gia">
        <div class="flex items-center mb-4">
            <i class="fa-solid fa-tags text-xl md:text-2xl text-[var(--color-primary)] mr-3"></i>
            <h2 class="text-lg md:text-xl font-bold text-gray-800">Bảng giá tour chi tiết</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full tour-price-table text-sm md:text-base">
                <thead>
                <tr>
                    <th>Loại giá/Độ tuổi</th>
                    <th>Người lớn (Trên 11 tuổi)</th>
                    <th>Trẻ em (5 - 11 tuổi)</th>
                    <th>Trẻ nhỏ (2 - 5 tuổi)</th>
                    <th>Sơ sinh (< 2 tuổi)</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="font-semibold">Giá</td>
                    <td class="font-semibold text-red-600">{{ $tour->price_adult ? number_format($tour->price_adult) . ' đ' : 'Liên hệ' }}</td>
                    <td class="font-semibold text-red-600">{{ $tour->price_child ? number_format($tour->price_child) . ' đ' : 'Liên hệ' }}</td>
                    <td class="font-semibold text-red-600">{{ $tour->price_toddler ? number_format($tour->price_toddler) . ' đ' : 'Liên hệ' }}</td>
                    <td class="font-semibold text-red-600">{{ $tour->price_infant ? number_format($tour->price_infant) . ' đ' : 'Liên hệ' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>

    @if($tour->services_note)
        <section id="dich-vu">
            <div class="flex items-center mb-4">
                <i class="fa-solid fa-concierge-bell text-xl md:text-2xl text-[var(--color-primary)] mr-3"></i>
                <h2 class="text-lg md:text-xl font-bold text-gray-800">Dịch vụ</h2>
            </div>
            <div class="prose max-w-none text-gray-700 prose-styles">
                {!! $tour->services_note !!}
            </div>
        </section>
    @endif

    @if($tour->note)
        <section id="ghi-chu">
            <div class="flex items-center mb-4">
                <i class="fa-solid fa-clipboard-list text-xl md:text-2xl text-[var(--color-primary)] mr-3"></i>
                <h2 class="text-lg md:text-xl font-bold text-gray-800">Ghi chú</h2>
            </div>
            <div class="prose max-w-none text-gray-700 prose-styles">
                {!! $tour->note !!}
            </div>
        </section>
    @endif
</div>
