@extends('admin.layouts.main')
@section('title', 'Quản lý Tin tức')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Tin tức</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Viết bài mới
                    </a>
                </div>
            </div>

            <div class="filter-area mb-4 card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.news.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search-input">Tìm kiếm tiêu đề</label>
                                    <input type="text" id="search-input" name="search" class="form-control"
                                           placeholder="Nhập tiêu đề..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <x-inputs.select label="Lọc theo danh mục" name="category_id" id="category_id">
                                    <option value="">Tất cả danh mục</option>
                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </x-inputs.select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Khoảng ngày đăng</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" name="date_range" class="form-control date-range-picker"
                                               value="{{ request('date_range') }}" autocomplete="off" readonly
                                               style="cursor: pointer; background-color: #fff;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <div class="form-group w-100">
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
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th style="width: 100px;">Lượt xem</th>
                        <th style="width: 170px;">Ngày đăng</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($newsItems as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                @if($item->thumbnail)
                                    <img src="{{ url($item->thumbnail) }}" alt="{{ $item->title }}"
                                         style="width: 80px; height: 60px; object-fit: cover;">
                                @endif
                            </td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->category->name ?? 'N/A' }}</td>
                            <td>{{ $item->view }}</td>
                            <td>{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-warning btn-sm"
                                   href="{{ route('admin.news.edit', $item) }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.news.destroy', $item) }}"
                                      method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa tin tức này?')">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Không tìm thấy tin tức nào.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $newsItems->links() }}
            </div>
        </div>
    </div>
@endsection
