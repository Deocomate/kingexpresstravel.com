@php
    $isEdit = !empty($aboutUsPage->id);
@endphp

@extends('admin.layouts.main')
@section('title', $isEdit ? 'Sửa trang Giới thiệu' : 'Tạo trang Giới thiệu')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $isEdit ? 'Sửa trang: ' . $aboutUsPage->title : 'Tạo mới trang Giới thiệu' }}</h3>
        </div>
        <form
            action="{{ $isEdit ? route('admin.about-us.update', ['about_u' => $aboutUsPage->id]) : route('admin.about-us.store') }}"
            method="post">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Có lỗi xảy ra!</strong> Vui lòng kiểm tra lại các trường dữ liệu.
                    </div>
                @endif

                <x-inputs.text label="Tiêu đề" name="title" :value="old('title', $aboutUsPage->title ?? '')"
                               :required="true"/>

                <x-inputs.editor label="Nội dung" name="content" :value="old('content', $aboutUsPage->content ?? '')"/>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Cập nhật' : 'Tạo mới' }}</button>
                <a href="{{ route('admin.about-us.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
@endsection
