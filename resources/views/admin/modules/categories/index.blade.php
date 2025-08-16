@extends('admin.layouts.main')
@section('title', 'Danh sách Danh mục')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quản lý Danh mục</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tạo mới Danh mục
                    </a>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <form action="{{ route('admin.categories.index') }}" method="GET" class="form-inline">
                        <div class="form-group mr-2">
                            <select name="type" class="form-control">
                                <option value="">Tất cả loại</option>
                                <option value="TOUR" @selected(request('type') == 'TOUR')>TOUR</option>
                                <option value="NEWS" @selected(request('type') == 'NEWS')>NEWS</option>
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <select name="is_active" class="form-control">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1" @selected(request('is_active') == '1')>Hoạt động</option>
                                <option value="0" @selected(request('is_active') == '0')>Không hoạt động</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Tìm theo tên..."
                                   value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="form-group ml-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Xóa lọc</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Ảnh đại diện</th>
                        <th>Danh mục cha</th>
                        <th>Loại</th>
                        <th>Ưu tiên</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @if($item->thumbnail)
                                    <img src="{{ url($item->thumbnail) }}" alt="{{ $item->name }}"
                                         style="max-width: 100px; max-height: 100px;">
                                @endif
                            </td>
                            <td>{{ $item->parent->name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $item->type === 'TOUR' ? 'badge-info' : 'badge-warning' }}">
                                    {{ $item->type }}
                                </span>
                            </td>
                            <td>{{ $item->priority }}</td>
                            <td>
                                <span class="badge {{ $item->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $item->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-sm"
                                   href="{{ route('admin.categories.edit', ['category' => $item->id]) }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.categories.destroy', ['category' => $item->id]) }}"
                                      method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa Danh mục này?')">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Không tìm thấy dữ liệu phù hợp.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-end">
                {{ $categories->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
