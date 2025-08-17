@extends('admin.layouts.main')
@section('title', 'Quản lý Giới thiệu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách trang Giới thiệu</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <a href="{{ route('admin.about-us.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tạo trang mới
                    </a>
                </div>
                <div class="col-6">
                    <form action="{{ route('admin.about-us.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tiêu đề..."
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
                        <th>Tiêu đề</th>
                        <th>Slug</th>
                        <th style="width: 100px;">Lượt xem</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($aboutUsPages as $page)
                        <tr>
                            <td>{{ $page->id }}</td>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td>{{ $page->view }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-warning btn-sm"
                                   href="{{ route('admin.about-us.edit', $page) }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.about-us.destroy', $page) }}"
                                      method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa trang này?')">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Chưa có trang giới thiệu nào.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $aboutUsPages->links() }}
            </div>
        </div>
    </div>
@endsection
