@extends('admin.layouts.main')
@section('title', 'Chi tiết Người dùng: ' . $user->name)

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{ $user->avatar ?? asset('admin/dist/img/avatar5.png') }}"
                     alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{ $user->name }}</h3>

            <p class="text-muted text-center">{{ ucfirst($user->role) }}</p>

            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                </li>
                <li class="list-group-item">
                    <b>Điện thoại</b> <a class="float-right">{{ $user->phone ?? 'Chưa cập nhật' }}</a>
                </li>
                <li class="list-group-item">
                    <b>Địa chỉ</b> <a class="float-right">{{ $user->address ?? 'Chưa cập nhật' }}</a>
                </li>
                <li class="list-group-item">
                    <b>Loại tài khoản</b> <a class="float-right">{{ $user->account_type }}</a>
                </li>
                <li class="list-group-item">
                    <b>Ngày tham gia</b> <a class="float-right">{{ $user->created_at->format('d/m/Y') }}</a>
                </li>
            </ul>

            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-block"><b>Sửa</b></a>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
        </div>
    </div>
@endsection
