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
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            const verifyButton = document.getElementById('verify-email-button');
            if (verifyButton) {
                const cooldownTimer = document.getElementById('cooldown-timer');
                const cooldownKey = 'email_verification_cooldown_end_{{ auth()->id() }}';
                let intervalId;

                const updateCooldown = () => {
                    const cooldownEnd = localStorage.getItem(cooldownKey);
                    if (!cooldownEnd) {
                        verifyButton.disabled = false;
                        cooldownTimer.classList.add('hidden');
                        if(intervalId) clearInterval(intervalId);
                        return;
                    }

                    const now = new Date().getTime();
                    const remaining = cooldownEnd - now;

                    if (remaining <= 0) {
                        localStorage.removeItem(cooldownKey);
                        verifyButton.disabled = false;
                        cooldownTimer.classList.add('hidden');
                        if(intervalId) clearInterval(intervalId);
                        return;
                    }

                    verifyButton.disabled = true;
                    cooldownTimer.classList.remove('hidden');
                    const minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((remaining % (1000 * 60)) / 1000);
                    cooldownTimer.textContent = `Vui lòng đợi ${minutes}:${seconds.toString().padStart(2, '0')} để gửi lại.`;
                };

                verifyButton.addEventListener('click', function() {
                    this.disabled = true;
                    this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang gửi...';

                    const cooldownEnd = new Date().getTime() + 5 * 60 * 1000;
                    localStorage.setItem(cooldownKey, cooldownEnd);

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("verification.send") }}';

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    form.appendChild(csrfInput);
                    document.body.appendChild(form);
                    form.submit();
                });

                updateCooldown();
                if (localStorage.getItem(cooldownKey) && new Date().getTime() < localStorage.getItem(cooldownKey)) {
                    intervalId = setInterval(updateCooldown, 1000);
                }
            }
        });
    </script>
@endpush
