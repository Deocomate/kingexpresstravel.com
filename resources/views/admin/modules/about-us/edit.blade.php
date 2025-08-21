@extends('admin.layouts.main')
@section('title', 'Cập nhật trang Giới thiệu')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Chỉnh sửa nội dung trang Giới thiệu</h3>
        </div>
        <form action="{{ route('admin.about-us.update') }}" method="post">
            @csrf
            @method('PUT')

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Có lỗi xảy ra!</strong> Vui lòng kiểm tra lại các trường dữ liệu.
                    </div>
                @endif

                <x-inputs.editor label="Nội dung trang" name="content" :value="old('content', $aboutUsPage->content ?? '')"/>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </form>
    </div>
@endsection
