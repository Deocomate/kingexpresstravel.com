@extends('client.layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
    <div class="bg-gray-100 py-6 md:py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <aside class="lg:col-span-3">
                    @include('client.pages.profile.partials._sidebar', ['user' => $user])
                </aside>

                <div class="lg:col-span-9" id="profile-content-area">
                    @include('client.pages.profile.partials._info_form', ['user' => $user])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Di chuyển script từ file này sang file _info_form.blade.php để được tải lại đúng cách --}}
@endpush
