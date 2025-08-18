@extends('admin.layouts.main')
@section('title', 'Quản lý Điểm đến')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Điểm đến</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tạo điểm đến
                    </a>
                </div>
                <div class="col-6">
                    <form action="{{ route('admin.destinations.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên..."
                                   value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
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
                        <th>Tên điểm đến</th>
                        <th>Slug</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($destinations as $destination)
                        <tr>
                            <td>{{ $destination->id }}</td>
                            <td>{{ $destination->name }}</td>
                            <td>{{ $destination->slug }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-warning btn-sm"
                                   href="{{ route('admin.destinations.edit', $destination) }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.destinations.destroy', $destination) }}"
                                      method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa điểm đến này?')">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Chưa có điểm đến nào.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $destinations->links() }}
            </div>
        </div>
    </div>
@endsection
