<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($tours as $tour)
        <x-client.tour-card :tour="$tour" />
    @empty
        <div class="col-span-full text-center py-12">
            <i class="fa-solid fa-map-location-dot text-6xl text-gray-300"></i>
            <p class="mt-4 text-gray-500">Không tìm thấy tour nào phù hợp.</p>
        </div>
    @endforelse
</div>
