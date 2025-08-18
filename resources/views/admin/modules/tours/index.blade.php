@extends('admin.layouts.main')
@section('title', 'Quản lý Tour')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Tour du lịch</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tạo tour mới
                    </a>
                </div>
            </div>

            <div class="filter-area mb-4 card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tours.index') }}" method="GET" id="filter-form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tìm kiếm</label>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Tìm theo tên hoặc mã tour..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <x-inputs.select label="Lọc theo danh mục" name="category_id">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </x-inputs.select>
                            </div>
                            <div class="col-md-4">
                                <x-inputs.select label="Lọc theo điểm đến" name="destination_id">
                                    <option value="">Tất cả điểm đến</option>
                                    @foreach($destinations as $destination)
                                        <option value="{{ $destination->id }}" @selected(request('destination_id') == $destination->id)>
                                            {{ $destination->name }}
                                        </option>
                                    @endforeach
                                </x-inputs.select>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Khoảng giá</label>
                                    <input id="price_range_slider" type="text">
                                    <input type="hidden" name="price_from" id="price_from" value="{{ request('price_from') }}">
                                    <input type="hidden" name="price_to" id="price_to" value="{{ request('price_to') }}">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-group w-100">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-primary w-100" type="submit">Lọc</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th style="width: 100px;">Ảnh</th>
                        <th>Mã tour</th>
                        <th>Tên tour</th>
                        <th>Danh mục</th>
                        <th>Giá người lớn</th>
                        <th>Số chỗ</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tours as $tour)
                        <tr>
                            <td>{{ $tour->id }}</td>
                            <td>
                                @if($tour->thumbnail)
                                    <img src="{{ url($tour->thumbnail) }}" alt="{{ $tour->name }}"
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                @endif
                            </td>
                            <td>{{ $tour->tour_code }}</td>
                            <td>{{ $tour->name }}</td>
                            <td>
                                @foreach($tour->categories as $category)
                                    <span class="badge badge-info">{{ $category->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ number_format($tour->price_adult) }} đ</td>
                            <td>{{ $tour->remaining_slots }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-warning btn-sm"
                                   href="{{ route('admin.tours.edit', $tour) }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.tours.destroy', $tour) }}"
                                      method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa tour này?')">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Không tìm thấy tour nào.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $tours->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#price_range_slider').ionRangeSlider({
                type: 'double',
                grid: true,
                min: 0,
                max: 25000000,
                from: {{ request('price_from', 0) }},
                to: {{ request('price_to', 25000000) }},
                prefix: 'đ ',
                step: 500000,
                prettify_separator: '.',
                onFinish: function (data) {
                    $('#price_from').val(data.from);
                    $('#price_to').val(data.to);
                },
            });
        });
    </script>
@endpush
