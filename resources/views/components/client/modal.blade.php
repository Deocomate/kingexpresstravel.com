@props(['id', 'title', 'subtitle'])

<div id="{{ $id }}" class="fixed inset-0 bg-black/50 z-40 flex items-start justify-center pt-24 hidden" aria-labelledby="modal-title-{{ $id }}" role="dialog" aria-modal="true">
    <div class="modal-panel bg-white rounded-lg shadow-xl w-full max-w-md transition-all duration-300 ease-in-out opacity-0">
        <div class="p-6">
            <div class="flex justify-between items-center">
                <h2 id="modal-title-{{ $id }}" class="text-2xl font-bold text-gray-800">{{ $title }}</h2>
                <button type="button" class="modal-close-button text-gray-400 hover:text-gray-600 cursor-pointer" aria-label="Đóng">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            <p class="mt-2 text-gray-600">{{ $subtitle }}</p>

            <div class="mt-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
