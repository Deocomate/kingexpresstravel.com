@php
    $isEdit = !empty($news->id);
@endphp

@extends('admin.layouts.main')
@section('title', $isEdit ? 'Sửa Tin tức' : 'Tạo Tin tức')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $isEdit ? 'Sửa tin tức: ' . $news->title : 'Tạo mới tin tức' }}</h3>
        </div>
        <form
            action="{{ $isEdit ? route('admin.news.update', ['news' => $news->id]) : route('admin.news.store') }}"
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

                <x-inputs.text label="Tiêu đề" name="title" :value="old('title', $news->title ?? '')"
                               :required="true"/>

                <div class="row">
                    <div class="col-md-6">
                        <x-inputs.select label="Danh mục" name="category_id" :required="true">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}" @selected(old('category_id', $news->category_id ?? '') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-inputs.select>
                    </div>
                    <div class="col-md-6">
                        <x-inputs.number label="Độ ưu tiên" name="priority"
                                         :value="old('priority', $news->priority ?? 0)"/>
                    </div>
                </div>

                <x-inputs.image-link label="Ảnh đại diện" name="thumbnail"
                                     :value="old('thumbnail', $news->thumbnail ?? '')"/>

                <x-inputs.text-area label="Mô tả ngắn" name="short_description"
                                    :value="old('short_description', $news->short_description ?? '')"/>

                <x-inputs.editor label="Nội dung" name="contents" :value="old('contents', $news->contents ?? '')"/>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Cập nhật' : 'Tạo mới' }}</button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
@endsection
