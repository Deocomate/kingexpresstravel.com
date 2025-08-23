@extends('client.layouts.app')

@section('title', 'Lịch sử đặt tour')

@section('content')
    <div class="bg-gray-100 py-6 md:py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <aside class="lg:col-span-3">
                    @include('client.pages.profile.partials._sidebar', ['user' => $user])
                </aside>

                <div class="lg:col-span-9">
                    @include('client.pages.profile.partials._booking_history', ['orders' => $orders])
                </div>
            </div>
        </div>
    </div>
@endsection
