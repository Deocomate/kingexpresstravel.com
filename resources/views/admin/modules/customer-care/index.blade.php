@extends('admin.layouts.main')
@section('title', 'Quản lý Liên hệ')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Liên hệ từ Khách hàng</h3>
        </div>
        <div class="card-body">
            <div class="filter-area mb-4 card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customer-care.index') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-7">
                                <div class="form-group mb-md-0">
                                    <label>Tìm kiếm</label>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Tìm kiếm tên, email, sđt, chủ đề..."
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-md-0">
                                    <label>Khoảng ngày gửi</label>
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
                                <div class="form-group w-100 mb-md-0">
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
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Chủ đề</th>
                        <th style="width: 170px;">Ngày gửi</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->full_name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($contact->subject, 50) }}</td>
                            <td>{{ optional($contact->created_at)->addHours(7)->format('d/m/Y H:i:s') }}</td>
                            <td class="text-nowrap">
                                <a class="btn btn-info btn-sm"
                                   href="{{ route('admin.customer-care.show', $contact) }}">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                                <form action="{{ route('admin.customer-care.destroy', $contact) }}"
                                      method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa liên hệ này?')">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Không tìm thấy liên hệ nào.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
@endsection
