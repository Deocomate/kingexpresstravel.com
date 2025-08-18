@php
    $isEdit = isset($destination);
@endphp

@extends('admin.layouts.main')
@section('title', $isEdit ? 'Sửa Điểm đến' : 'Tạo Điểm đến')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $isEdit ? 'Sửa điểm đến: ' . $destination->name : 'Tạo mới điểm đến' }}</h3>
        </div>
        <form
            action="{{ $isEdit ? route('admin.destinations.update', $destination) : route('admin.destinations.store') }}"
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

                <x-inputs.text label="Tên điểm đến" name="name" :value="old('name', $destination->name ?? '')" required/>

                <x-inputs.editor label="Mô tả" name="description" :value="old('description', $destination->description ?? '')"/>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Cập nhật' : 'Tạo mới' }}</button>
                <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
@endsection
