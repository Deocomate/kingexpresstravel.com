@extends('client.layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
    <div class="bg-gray-100 py-6 md:py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <aside class="lg:col-span-3">
                    @include('client.pages.profile.partials._sidebar', ['user' => $user])
                </aside>

                <div class="lg:col-span-9">
                    @include('client.pages.profile.partials._info_form', ['user' => $user])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const changePasswordCheckbox = document.getElementById('change_password');
            const passwordFields = document.getElementById('password_fields');

            if (changePasswordCheckbox) {
                changePasswordCheckbox.addEventListener('change', function () {
                    passwordFields.classList.toggle('hidden', !this.checked);
                });
            }

            const avatarFileInput = document.getElementById('avatar_file');
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarPlaceholder = document.getElementById('avatar-placeholder');

            if (avatarFileInput) {
                avatarFileInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (avatarPreview) {
                                avatarPreview.src = e.target.result;
                                avatarPreview.classList.remove('hidden');
                            }
                            if (avatarPlaceholder) {
                                avatarPlaceholder.classList.add('hidden');
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endpush
