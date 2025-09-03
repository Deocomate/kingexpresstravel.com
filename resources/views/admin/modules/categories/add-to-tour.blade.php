@extends('admin.layouts.main')
@section('title', 'Thêm danh mục cho Tour')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Thêm hàng loạt danh mục vào Tour</h3>
        </div>
        <form action="{{ route('admin.categories.add-to-tour.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <p class="text-muted">
                    Chức năng này cho phép bạn chọn các danh mục và thêm chúng vào tất cả các tour có tên chứa một từ
                    khóa nhất định.
                </p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Có lỗi xảy ra!</strong> Vui lòng kiểm tra lại các trường dữ liệu.
                    </div>
                @endif

                <x-inputs.select-multiple label="Chọn các danh mục muốn thêm" name="category_ids" :required="true">
                    @foreach($tourCategories as $category)
                        <option value="{{ $category->id }}" @selected(in_array($category->id, old('category_ids', [])))>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-inputs.select-multiple>

                <x-inputs.text
                    label="Thêm các danh mục trên vào các tour có từ khóa này trong tên"
                    name="tour_name"
                    :value="old('tour_name', '')"
                    :required="true"
                    placeholder="Ví dụ: 'Hà Nội' hoặc 'Phan Thiết'"
                />
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Thêm vào Tour
                </button>
            </div>
        </form>
    </div>
@endsection
