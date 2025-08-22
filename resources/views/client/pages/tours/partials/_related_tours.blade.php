@if(isset($relatedTours) && $relatedTours->isNotEmpty())
    <section class="mt-12 md:mt-16">
        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 uppercase mb-6">Tour tương tự</h2>
        <div class="relative slider-container related-tours-slider-container">
            <div class="swiper tour-slider">
                <div class="swiper-wrapper">
                    @foreach($relatedTours as $relatedTour)
                        <div class="swiper-slide h-auto">
                            <x-client.tour-card :tour="$relatedTour"/>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>
@endif
