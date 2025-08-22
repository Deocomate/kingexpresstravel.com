@extends('admin.layouts.main')
@section('title','Quản lý Danh mục')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Danh mục</h3>
            <div class="card-tools">
                <button id="save-category-order" class="btn btn-success btn-sm" style="display: none;">
                    <i class="fas fa-save"></i> Lưu thứ tự
                </button>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tạo mới
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('admin.partials.alerts')

            <div class="filter-area mb-4 card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Bộ lọc</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.index') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <div class="form-group mb-md-0">
                                    <label for="type-filter">Lọc theo loại</label>
                                    <select name="type" id="type-filter" class="form-control" onchange="this.form.submit()">
                                        <option value="">Tất cả</option>
                                        <option value="TOUR" @selected($selectedType == 'TOUR')>Tour</option>
                                        <option value="NEWS" @selected($selectedType == 'NEWS')>Tin tức</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <p class="text-muted">
                <i class="fas fa-info-circle"></i> Kéo thả các mục để thay đổi thứ tự hoặc đặt làm danh mục con.
                Nhấn nút "Lưu thứ tự" sau khi hoàn tất.
            </p>

            <div class="dd" id="category-nestable">
                @if(!empty($categoryTree) && count($categoryTree) > 0)
                    <ol class="dd-list">
                        @foreach ($categoryTree as $item)
                            @include('admin.modules.categories.partials.category_item', ['item' => $item])
                        @endforeach
                    </ol>
                @else
                    <div class="dd-empty">Không có danh mục nào phù hợp với bộ lọc.</div>
                @endif
            </div>

        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.css">
    <style>
        .dd { max-width: 100%; }
        .dd-list .dd-list { padding-left: 40px; }
        .dd-handle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 46px;
            cursor: move;
            border-right: 1px solid #eee;
            font-size: 16px;
        }
        .handle-icon { color: #888; }
        .dd-handle:hover .handle-icon { color: #3c8dbc; }
        .dd-content {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        .dd-content:hover { border-color: #3c8dbc; }
        .dd-text {
            flex-grow: 1;
            padding: 12px 15px;
            font-weight: 600;
        }
        .category-actions {
            display: flex;
            padding-right: 15px;
        }
        .category-actions .btn { margin-left: 5px; }
        .dd-placeholder {
            background: #f9fbff;
            border: 2px dashed #bed2e8;
            border-radius: 4px;
            margin: 5px 0;
            padding: 0;
            min-height: 30px;
            box-sizing: border-box;
        }
        .dd-item > button {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#category-nestable').nestable({
                group: 1,
                maxDepth: 5,
                handleClass: 'dd-handle',
            }).on('change', function () {
                $('#save-category-order').fadeIn();
            });

            $('#save-category-order').on('click', function (e) {
                e.preventDefault();
                let nestableData = $('#category-nestable').nestable('serialize');
                let button = $(this);

                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');

                $.ajax({
                    url: '{{ route("admin.categories.updateOrder") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        categoryData: JSON.stringify(nestableData)
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            showErrorToast('Lỗi: ' + (response.message || 'Không thể cập nhật.'));
                            button.prop('disabled', false).html('<i class="fas fa-save"></i> Lưu thứ tự');
                        }
                    },
                    error: function (xhr) {
                        let errorMsg = 'Lỗi kết nối. Vui lòng thử lại.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showErrorToast(errorMsg);
                        button.prop('disabled', false).html('<i class="fas fa-save"></i> Lưu thứ tự');
                    }
                });
            });
        });
    </script>
@endpush
