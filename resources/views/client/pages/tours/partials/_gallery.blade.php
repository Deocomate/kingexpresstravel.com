@props(['tour'])

@if(isset($tour))
    @php
        $allImages = collect([$tour->thumbnail])->concat($tour->images ?? [])->filter()->unique()->values();
    @endphp

    @if($allImages->isNotEmpty())
        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
             class="swiper gallery-top rounded-lg shadow-md">
            <div class="swiper-wrapper">
                @foreach($allImages as $image)
                    <div class="swiper-slide bg-gray-100">
                        <a href="{{ $image }}" data-fancybox="gallery" class="block h-full w-full">
                            <img src="{{ $image }}" alt="Ảnh tour {{ $tour->name ?? '' }}"
                                 class="w-full h-full object-cover"/>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <div thumbsSlider="" class="swiper gallery-thumbs mt-2">
            <div class="swiper-wrapper">
                @foreach($allImages as $image)
                    <div class="swiper-slide rounded-md overflow-hidden border-2 border-transparent">
                        <img src="{{ $image }}" alt="Thumbnail tour {{ $tour->name ?? '' }}"
                             class="w-full h-full object-cover"/>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="rounded-lg overflow-hidden shadow-md h-[500px] bg-gray-100">
            <img src="https://placehold.co/800x500/e2e8f0/e2e8f0?text=King+Express" alt="Chưa có ảnh cho tour này"
                 class="w-full h-full object-cover">
        </div>
    @endif
@endif
