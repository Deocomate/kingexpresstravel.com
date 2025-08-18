@extends('admin.layouts.main')
@section('title', 'Quản lý Người dùng')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Người dùng</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tạo người dùng mới
                    </a>
                </div>
            </div>

            <div class="filter-area mb-4 card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tìm kiếm</label>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Tên hoặc email người dùng..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Vai trò</label>
                                    <select name="role" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="admin" @selected(request('role') == 'admin')>Admin</option>
                                        <option value="user" @selected(request('role') == 'user')>User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
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
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th style="width: 170px;">Ngày tạo</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-info btn-sm" href="{{ route('admin.users.show', $user) }}">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                                <a class="btn btn-warning btn-sm" href="{{ route('admin.users.edit', $user) }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Không tìm thấy người dùng nào.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
