@props(['variant' => 'overlay'])

@php
    $isOverlay = $variant === 'overlay';

    // Wrapper classes
    $wrapperClasses = $isOverlay
        ? 'hidden md:block absolute left-1/2 bottom-0 translate-y-1/2 -translate-x-1/2 w-full max-w-5xl px-4 z-20'
        : 'block md:hidden w-full';

    // Panel classes
    $panelClasses = $isOverlay
        ? 'bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl p-4 md:p-6 ring-1 ring-gray-200'
        : 'bg-white rounded-xl shadow-lg p-4 mx-auto max-w-xl ring-1 ring-gray-200';

@endphp

<div class="{{ $wrapperClasses }}">
    <div class="{{ $panelClasses }}">
        <style>
            .input-shell {
                transition: border-color .25s, box-shadow .25s, background-color .25s;
                background: #fff;
            }

            .input-shell:hover {
                border-color: var(--color-primary);
            }

            .input-shell:focus-within {
                border-color: var(--color-primary);
                box-shadow: 0 0 0 3px rgba(255, 165, 0, .25);
            }

            .custom-select select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background: transparent;
                padding-right: 2.25rem;
            }

            .custom-select select::-ms-expand {
                display: none;
            }

            @-moz-document url-prefix() {
                .custom-select select {
                    background: transparent !important;
                }
            }

            .custom-select .select-arrow {
                position: absolute;
                right: .65rem;
                top: 50%;
                width: 1.15rem;
                height: 1.15rem;
                transform: translateY(-50%);
                display: flex;
                align-items: center;
                justify-content: center;
                pointer-events: none;
                color: #9ca3af;
                transition: color .25s;
            }

            .custom-select .select-arrow i {
                display: block;
                line-height: 1;
                font-size: .85rem;
                transition: transform .28s;
            }

            .custom-select:has(select:hover) .select-arrow,
            .custom-select:has(select:focus) .select-arrow {
                color: var(--color-primary);
            }

            .custom-select:has(select:focus) .select-arrow i {
                transform: scaleY(-1);
            }

            /* Mobile spacing refinement: reduce gap between groups */
            @media (max-width: 767.98px) {
                #tour-search-form .field-group + .field-group {
                    margin-top: .75rem;
                }
            }
        </style>

        <form id="tour-search-form"
              action="{{ route('client.tours') }}"
              method="GET"
              data-suggestions-url="{{ route('api.destination.suggestions') }}"
              class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4"
              role="search" aria-label="Tìm tour">

            <!-- Destination -->
            <div class="w-full md:flex-1 field-group">
                <label for="destination-input"
                       class="block text-xs font-semibold text-[var(--color-primary)] mb-1 uppercase tracking-wide">
                    Điểm đến
                </label>
                <div class="relative input-shell bg-white border-2 border-gray-200 rounded-lg shadow-sm">
                    <i class="fa-solid fa-map-marker-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="destination-input" name="destination"
                           placeholder="Bạn muốn đi đâu?"
                           class="w-full pl-10 pr-4 py-3 bg-transparent focus:outline-none"
                           autocomplete="off"
                           aria-autocomplete="list" aria-expanded="false" aria-owns="destination-suggestions-list">
                    <div id="destination-suggestions"
                         class="hidden absolute top-full left-0 w-full bg-white rounded-b-md shadow-lg mt-1 z-30 overflow-hidden border border-gray-200"
                         role="listbox" aria-label="Gợi ý điểm đến"></div>
                </div>
            </div>

            <!-- Budget -->
            <div class="w-full md:w-60 field-group">
                <label for="budget-select"
                       class="block text-xs font-semibold text-[var(--color-primary)] mb-1 uppercase tracking-wide">
                    Ngân sách
                </label>
                <div class="relative input-shell custom-select bg-white border-2 border-gray-200 rounded-lg shadow-sm">
                    <i class="fa-solid fa-wallet absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <select id="budget-select" name="budget"
                            class="w-full pl-10 py-3 bg-transparent focus:outline-none cursor-pointer text-gray-700">
                        <option value="">Tất cả mức giá</option>
                        <option value="0-5000000">Dưới 5 triệu</option>
                        <option value="5000000-10000000">Từ 5 - 10 triệu</option>
                        <option value="10000000-20000000">Từ 10 - 20 triệu</option>
                        <option value="20000000-999999999">Trên 20 triệu</option>
                    </select>
                    <span class="select-arrow">
                        <i class="fa-solid fa-chevron-down"></i>
                    </span>
                </div>
            </div>

            <!-- Submit -->
            <div class="w-full md:w-auto">
                <button type="submit"
                        class="w-full bg-[var(--color-primary)] text-white font-bold py-3 px-8 rounded-lg hover:bg-[var(--color-primary-dark)] transition-all duration-300 flex items-center justify-center text-lg transform hover:scale-[1.03] shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-[var(--color-primary-accent)] focus:ring-offset-1">
                    <i class="fa-solid fa-magnifying-glass mr-2"></i>
                    <span>Tìm Tour</span>
                </button>
            </div>
        </form>
    </div>
</div>
