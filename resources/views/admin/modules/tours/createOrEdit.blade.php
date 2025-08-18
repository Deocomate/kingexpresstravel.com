@php
    $isEdit = isset($tour);
@endphp

@extends('admin.layouts.main')
@section('title', $isEdit ? 'Sửa Tour' : 'Tạo Tour')

@push('styles')
    <style>
        .itinerary-list .list-group-item {
            cursor: move;
            background-color: #f8f9fa;
        }
        .itinerary-list .list-group-item .handle {
            cursor: grab;
        }
    </style>
@endpush

@section('content')
    <form action="{{ $isEdit ? route('admin.tours.update', $tour) : route('admin.tours.store') }}" method="POST" novalidate>
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin chính</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Có lỗi xảy ra!</strong> Vui lòng kiểm tra lại các trường dữ liệu.
                            </div>
                        @endif

                        <x-inputs.text label="Tên tour" name="name" :value="old('name', $tour->name ?? '')" required/>
                        <x-inputs.text-area label="Mô tả ngắn" name="short_description" :value="old('short_description', $tour->short_description ?? '')"/>
                        <x-inputs.editor label="Mô tả chi tiết tour" name="tour_description" :value="old('tour_description', $tour->tour_description ?? '')"/>
                        <x-inputs.editor-array label="Lịch trình tour" name="tour_schedule" :value="old('tour_schedule', $tour->tour_schedule ?? [])"/>
                        <x-inputs.text-area label="Ghi chú dịch vụ" name="services_note" :value="old('services_note', $tour->services_note ?? '')"/>
                        <x-inputs.text-area label="Ghi chú thêm" name="note" :value="old('note', $tour->note ?? '')"/>
                        <x-inputs.text label="Đặc điểm nổi bật" name="characteristic" :value="old('characteristic', $tour->characteristic ?? '')"/>
                    </div>
                </div>

                <div class="card card-info">
                    <div class="card-header"><h3 class="card-title">Album ảnh</h3></div>
                    <div class="card-body">
                        <x-inputs.image-link-array label="Album ảnh" name="images" :value="old('images', $tour->images ?? [])"/>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin phụ & Hành trình</h3>
                    </div>
                    <div class="card-body">
                        <x-inputs.text label="Mã tour" name="tour_code" :value="old('tour_code', $tour->tour_code ?? '')" required/>
                        <x-inputs.image-link label="Ảnh đại diện" name="thumbnail" :value="old('thumbnail', $tour->thumbnail ?? '')"/>
                        <x-inputs.select-multiple label="Danh mục" name="category_ids">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(in_array($category->id, old('category_ids', $isEdit ? $tour->categories->pluck('id')->toArray() : [])))>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-inputs.select-multiple>

                        <div class="form-group">
                            <label>Hành trình (Điểm đến)</label>
                            <div class="input-group">
                                <select id="destination-selector" class="form-control">
                                    <option value="">-- Thêm điểm đến --</option>
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination->id }}" data-name="{{ $destination->name }}">
                                            {{ $destination->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info" id="add-destination-btn">Thêm</button>
                                </div>
                            </div>
                        </div>

                        <div class="itinerary-list mt-2">
                            <ol class="list-group" id="itinerary-sortable-list">
                                @php
                                    $selectedDestinations = collect(old('destination_ids', $isEdit ? $tour->destinations->pluck('id')->toArray() : []));
                                @endphp
                                @foreach($selectedDestinations as $destId)
                                    @php
                                        $dest = $destinations->find($destId);
                                    @endphp
                                    @if($dest)
                                        <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $dest->id }}">
                                        <span>
                                            <i class="fas fa-grip-vertical handle mr-2"></i>
                                            {{ $dest->name }}
                                        </span>
                                            <input type="hidden" name="destination_ids[]" value="{{ $dest->id }}">
                                            <button type="button" class="btn btn-xs btn-danger remove-destination-btn">&times;</button>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </div>
                        <hr>
                        <x-inputs.text label="Thời gian" name="duration" :value="old('duration', $tour->duration ?? '')"/>
                        <x-inputs.text label="Điểm khởi hành" name="departure_point" :value="old('departure_point', $tour->departure_point ?? '')"/>
                        <x-inputs.text label="Phương tiện" name="transport_mode" :value="old('transport_mode', $tour->transport_mode ?? '')"/>
                        <x-inputs.number label="Số chỗ còn lại" name="remaining_slots" :value="old('remaining_slots', $tour->remaining_slots ?? 0)"/>
                        <x-inputs.number label="Độ ưu tiên" name="priority" :value="old('priority', $tour->priority ?? 0)"/>
                    </div>
                </div>
                <div class="card card-warning">
                    <div class="card-header"><h3 class="card-title">Giá vé</h3></div>
                    <div class="card-body">
                        <x-inputs.number label="Giá người lớn (> 11 tuổi)" name="price_adult" :value="old('price_adult', $tour->price_adult ?? 0)"/>
                        <x-inputs.number label="Giá trẻ em (5 - 11 tuổi)" name="price_child" :value="old('price_child', $tour->price_child ?? 0)"/>
                        <x-inputs.number label="Giá trẻ nhỏ (2 - 5 tuổi)" name="price_toddler" :value="old('price_toddler', $tour->price_toddler ?? 0)"/>
                        <x-inputs.number label="Giá em bé (< 2 tuổi)" name="price_infant" :value="old('price_infant', $tour->price_infant ?? 0)"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Cập nhật' : 'Tạo mới' }}</button>
            <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selector = document.getElementById('destination-selector');
            const addButton = document.getElementById('add-destination-btn');
            const itineraryList = document.getElementById('itinerary-sortable-list');

            new Sortable(itineraryList, {
                animation: 150,
                handle: '.handle'
            });

            const getSelectedIds = () => {
                return Array.from(itineraryList.querySelectorAll('li')).map(li => li.dataset.id);
            };

            addButton.addEventListener('click', function () {
                const selectedOption = selector.options[selector.selectedIndex];
                if (!selectedOption.value || getSelectedIds().includes(selectedOption.value)) {
                    return;
                }

                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.dataset.id = selectedOption.value;
                li.innerHTML = `
            <span>
                <i class="fas fa-grip-vertical handle mr-2"></i>
                ${selectedOption.dataset.name}
            </span>
            <input type="hidden" name="destination_ids[]" value="${selectedOption.value}">
            <button type="button" class="btn btn-xs btn-danger remove-destination-btn">&times;</button>
        `;
                itineraryList.appendChild(li);
                selector.value = '';
            });

            itineraryList.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('remove-destination-btn')) {
                    e.target.closest('li').remove();
                }
            });
        });
    </script>
@endpush
