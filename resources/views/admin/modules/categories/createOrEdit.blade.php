@php
    $isEdit = !empty($category->id);
@endphp

@extends('admin.layouts.main')
@section('title', $isEdit ? 'Sửa Danh mục' : 'Tạo Danh mục')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $isEdit ? 'Sửa Danh mục: ' . $category->name : 'Tạo mới Danh mục' }}</h3>
        </div>
        <form
            action="{{ $isEdit ? route('admin.categories.update', ['category' => $category->id]) : route('admin.categories.store') }}"
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

                <x-inputs.text label="Tên Danh mục" name="name" :value="old('name', $category->name ?? '')" :required="true"/>

                <x-inputs.image-link label="Ảnh đại diện" name="thumbnail" :value="old('thumbnail', $category->thumbnail ?? '')"/>

                <div class="row">
                    <div class="col-md-6">
                        <x-inputs.select label="Danh mục cha" name="parent_id">
                            <option value="">-- Không có --</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id ?? '') == $parent->id)>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </x-inputs.select>
                    </div>
                    <div class="col-md-6">
                        <x-inputs.select-simple label="Loại" name="type" :required="true">
                            <option value="">-- Chọn loại --</option>
                            <option value="TOUR" @selected(old('type', $category->type ?? '') == 'TOUR')>TOUR</option>
                            <option value="NEWS" @selected(old('type', $category->type ?? '') == 'NEWS')>NEWS</option>
                        </x-inputs.select-simple>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <x-inputs.number label="Độ ưu tiên" name="priority" :value="old('priority', $category->priority ?? 0)"/>
                    </div>
                    <div class="col-md-6">
                        <x-inputs.select-simple label="Trạng thái" name="is_active" :required="true">
                            <option value="1" @selected(old('is_active', $category->is_active ?? 1) == 1)>Hoạt động</option>
                            <option value="0" @selected(old('is_active', $category->is_active ?? 1) == 0)>Không hoạt động</option>
                        </x-inputs.select-simple>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Cập nhật' : 'Tạo mới' }}</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
@endsection
