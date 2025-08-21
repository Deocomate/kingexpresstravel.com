@extends('client.layouts.app')

@section('title', 'Về Chúng Tôi - King Express Travel')
@section('description', 'Tìm hiểu về lịch sử hình thành, tầm nhìn, sứ mệnh và giá trị cốt lõi của King Express Travel. Chúng tôi tự hào là người bạn đồng hành tin cậy trên mọi hành trình.')

@section('content')
    <div class="py-6 md:py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="prose max-w-4xl mx-auto">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 uppercase mb-6">Giới thiệu về chúng tôi</h1>
                @if($aboutPage && $aboutPage->content)
                    <div>
                        {!! $aboutPage->content !!}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fa-solid fa-circle-info text-6xl text-gray-300"></i>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 uppercase text-center mt-4">Về chúng tôi</h1>
                        <p class="mt-4 text-gray-500">Nội dung đang được cập nhật. Vui lòng quay lại sau.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

