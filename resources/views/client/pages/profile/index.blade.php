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
    @include('ckfinder::setup')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const changePasswordCheckbox = document.getElementById('change_password');
            const passwordFields = document.getElementById('password_fields');

            if (changePasswordCheckbox) {
                changePasswordCheckbox.addEventListener('change', function () {
                    passwordFields.classList.toggle('hidden', !this.checked);
                });
            }

            const avatarBrowseButton = document.getElementById('avatar-browse-button');
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarPlaceholder = document.getElementById('avatar-placeholder');

            if (avatarBrowseButton) {
                avatarBrowseButton.addEventListener('click', function () {
                    CKFinder.popup({
                        chooseFiles: true,
                        resourceType: 'Images',
                        width: 800,
                        height: 600,
                        onInit: function (finder) {
                            finder.on('files:choose', function (evt) {
                                const file = evt.data.files.first();
                                const path = new URL(file.getUrl()).pathname;
                                if (avatarInput) {
                                    avatarInput.value = path;
                                }
                                if (avatarPreview) {
                                    avatarPreview.src = path;
                                    avatarPreview.classList.remove('hidden');
                                }
                                if(avatarPlaceholder) {
                                    avatarPlaceholder.classList.add('hidden');
                                }
                            });
                        }
                    });
                });
            }
        });
    </script>
@endpush
