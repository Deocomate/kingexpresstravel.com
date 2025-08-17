@extends('admin.layouts.main')
@section('title', 'Danh sách Danh mục')

@push('styles')
    <style>

        .toggle-children i {
            transition: transform 0.2s ease-in-out;
        }
    </style>
@endpush

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

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th style="width: 50px;">ID</th>
                        <th>Tên</th>
                        <th style="width: 100px;">Ảnh</th>
                        <th style="width: 80px;">Loại</th>
                        <th style="width: 80px;">Ưu tiên</th>
                        <th style="width: 120px;">Trạng thái</th>
                        <th style="width: 150px;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        @include('admin.modules.categories.partials.category-row', ['category' => $category, 'level' => 0])
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có danh mục nào.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('tr.category-child').hide();

            $('.toggle-children').on('click', function (e) {
                e.preventDefault();

                const row = $(this).closest('tr');
                const id = row.data('id');
                const icon = $(this).find('i');
                const children = $(`tr[data-parent-id="${id}"]`);

                children.slideToggle('fast');

                icon.toggleClass('fa-plus-square fa-minus-square');
                icon.toggleClass('text-primary text-secondary');

                if (icon.hasClass('fa-plus-square')) {
                    function hideAllChildren(parentId) {
                        const directChildren = $(`tr[data-parent-id="${parentId}"]`);
                        directChildren.each(function() {
                            const currentId = $(this).data('id');
                            $(this).hide();

                            const childIcon = $(this).find('.toggle-children i');
                            if (childIcon.hasClass('fa-minus-square')) {
                                childIcon.removeClass('fa-minus-square').addClass('fa-plus-square');
                                childIcon.removeClass('text-secondary').addClass('text-primary');
                            }

                            hideAllChildren(currentId);
                        });
                    }
                    hideAllChildren(id);
                }
            });
        });
    </script>
@endpush
