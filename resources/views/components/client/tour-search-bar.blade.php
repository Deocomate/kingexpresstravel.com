<section class="bg-[var(--color-primary-light)] rounded-lg shadow-lg p-6 md:p-8 -mt-14 md:-mt-20 relative z-10 container mx-auto max-w-5xl transition-all duration-300 hover:shadow-xl">
    <form id="tour-search-form" action="{{ route('client.tours') }}" method="GET" data-suggestions-url="{{ route('api.destination.suggestions') }}">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <div class="md:col-span-5 relative">
                <label for="destination-input" class="block text-sm font-bold text-gray-700 mb-2">
                    Điểm đến
                </label>
                <div class="relative">
                    <i class="fa-solid fa-map-marker-alt absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="destination-input" name="destination"
                           placeholder="Bạn muốn đi đâu?"
                           class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-accent)] focus:border-transparent transition-all"
                           autocomplete="off">
                    <div id="destination-suggestions" class="hidden absolute top-full left-0 w-full bg-white rounded-b-md shadow-lg mt-1 z-10 overflow-hidden border border-gray-200"></div>
                </div>
            </div>

            <div class="md:col-span-4">
                <label for="budget-select" class="block text-sm font-bold text-gray-700 mb-2">Ngân sách</label>
                <div class="relative">
                    <i class="fa-solid fa-wallet absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <select id="budget-select"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-primary-accent)] focus:border-transparent appearance-none bg-white cursor-pointer">
                        <option value="">Tất cả mức giá</option>
                        <option value="0-5000000">Dưới 5 triệu</option>
                        <option value="5000000-10000000">Từ 5 - 10 triệu</option>
                        <option value="10000000-20000000">Từ 10 - 20 triệu</option>
                        <option value="20000000-999999999">Trên 20 triệu</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="md:col-span-3">
                <button type="submit"
                        class="w-full bg-[var(--color-primary)] text-white font-bold py-3 px-4 rounded-md hover:bg-[var(--color-primary-dark)] transition-all duration-300 flex items-center justify-center text-lg transform hover:scale-105 shadow hover:shadow-lg">
                    <i class="fa-solid fa-magnifying-glass mr-2"></i>
                    <span>Tìm Tour</span>
                </button>
            </div>
        </div>
    </form>
</section>
