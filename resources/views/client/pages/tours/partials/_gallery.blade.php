@php
    $allImages = collect([$tour->thumbnail])->concat($tour->images ?? [])->filter()->unique()->values();
@endphp

@if($allImages->isNotEmpty())
    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
         class="swiper gallery-top rounded-lg shadow-md">
        <div class="swiper-wrapper">
            @foreach($allImages as $image)
                <div class="swiper-slide">
                    <img src="{{ $image }}" alt="Ảnh tour {{ $tour->name }}" class="w-full h-full object-cover"/>
                </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
    <div thumbsSlider="" class="swiper gallery-thumbs mt-2">
        <div class="swiper-wrapper">
            @foreach($allImages as $image)
                <div class="swiper-slide rounded-md overflow-hidden">
                    <img src="{{ $image }}" alt="Thumbnail tour {{ $tour->name }}" class="w-full h-full object-cover"/>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="rounded-lg overflow-hidden shadow-md">
        <img src="https://placehold.co/800x500/e2e8f0/e2e8f0?text=King+Express" alt="Ảnh bìa {{ $tour->name ?? '' }}"
             class="w-full h-auto object-cover">
    </div>
@endif
