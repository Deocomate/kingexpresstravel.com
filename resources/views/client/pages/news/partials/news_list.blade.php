@forelse($newsItems as $newsItem)
    <x-client.news-card-horizontal :news="$newsItem"/>
@empty
    @if(!request()->ajax())
        <div class="col-span-full text-center py-12">
            <i class="fa-regular fa-newspaper text-6xl text-gray-300"></i>
            <p class="mt-4 text-gray-500">Không tìm thấy bài viết nào phù hợp.</p>
        </div>
    @endif
@endforelse
