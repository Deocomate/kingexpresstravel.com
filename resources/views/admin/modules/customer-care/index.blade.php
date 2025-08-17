@extends('admin.layouts.main')
@section('title', 'Quản lý Liên hệ')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Liên hệ từ Khách hàng</h3>
        </div>
        <div class="card-body">
            <div class="filter-area mb-3">
                <form action="{{ route('admin.customer-care.index') }}" method="GET">
                    <div class="row align-items-end">
                        <div class="col-md-7">
                            <div class="form-group mb-md-0">
                                <label for="search-input">Tìm kiếm</label>
                                <input type="text" id="search-input" name="search" class="form-control"
                                       placeholder="Tìm kiếm tên, email, sđt, chủ đề..."
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-md-0">
                                <label for="date-range-picker">Khoảng ngày gửi</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" id="date-range-picker" name="date_range" class="form-control"
                                           value="{{ request('date_range') }}" autocomplete="off" readonly
                                           style="cursor: pointer; background-color: #fff;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group mb-md-0 d-flex">
                                <button class="btn btn-primary flex-grow-1" type="submit">Lọc</button>
                            </div>
                        </div>
                    </div>
                </form>
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
                            <td>{{ $contact->created_at->format('d/m/Y H:i:s') }}</td>
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

@push('scripts')
    <script>
        $(function () {
            const dateRangePicker = $('#date-range-picker');

            dateRangePicker.daterangepicker({
                autoUpdateInput: false,
                opens: 'left',
                linkedCalendars: false,
                showDropdowns: true,
                minYear: 2024,
                maxDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Xóa',
                    applyLabel: 'Áp dụng',
                    fromLabel: 'Từ',
                    toLabel: 'Đến',
                    customRangeLabel: 'Tùy chỉnh',
                    daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                    monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                    firstDay: 1
                },
                ranges: {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 ngày qua': [moment().subtract(6, 'days'), moment()],
                    '30 ngày qua': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            dateRangePicker.on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            dateRangePicker.on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            const initialValue = dateRangePicker.val();
            if (initialValue) {
                const dates = initialValue.split(' - ');
                if (dates.length === 2) {
                    dateRangePicker.data('daterangepicker').setStartDate(dates[0]);
                    dateRangePicker.data('daterangepicker').setEndDate(dates[1]);
                }
            }
        });
    </script>
@endpush
