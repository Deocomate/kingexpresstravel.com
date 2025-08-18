@extends('admin.layouts.main')
@section('title', 'Quản lý Thông tin Liên hệ')

@section('content')
    <form action="{{ route('admin.contacts.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thông tin chung</h3>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Có lỗi xảy ra!</strong> Vui lòng kiểm tra lại các trường dữ liệu.
                    </div>
                @endif

                <x-inputs.text label="Tên công ty" name="company_name" :value="old('company_name', $contact->company_name ?? '')"/>
                <div class="row">
                    <div class="col-md-6">
                        <x-inputs.email label="Email chính" name="email" :value="old('email', $contact->email ?? '')"/>
                    </div>
                    <div class="col-md-6">
                        <x-inputs.text label="Số điện thoại chính" name="phone" :value="old('phone', $contact->phone ?? '')"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-inputs.text label="Facebook" name="facebook" :value="old('facebook', $contact->facebook ?? '')"/>
                    </div>
                    <div class="col-md-6">
                        <x-inputs.text label="Zalo" name="zalo" :value="old('zalo', $contact->zalo ?? '')"/>
                    </div>
                </div>
                <x-inputs.text label="Giờ làm việc" name="working_hours" :value="old('working_hours', $contact->working_hours ?? '')"/>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Quản lý Chi nhánh</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="add-branch-btn">
                        <i class="fas fa-plus"></i> Thêm chi nhánh
                    </button>
                </div>
            </div>
            <div class="card-body" id="branches-container">
                @php
                    $branches = old('branches', $contact->branches->toArray());
                    $mainBranchIndex = old('is_main_branch');
                    if (is_null($mainBranchIndex)) {
                        $mainBranchIndex = $contact->branches->search(fn($branch) => $branch->is_main);
                        if ($mainBranchIndex === false) {
                            $mainBranchIndex = -1; // -1 nếu không có trụ sở chính
                        }
                    }
                @endphp
                @foreach($branches as $index => $branch)
                    @include('admin.modules.contact.partials.branch-item', ['index' => $index, 'branch' => (object)$branch, 'mainBranchIndex' => $mainBranchIndex])
                @endforeach
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </div>
    </form>

    <template id="branch-template">
        @include('admin.modules.contact.partials.branch-item', ['index' => '__INDEX__', 'branch' => null, 'mainBranchIndex' => -1])
    </template>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('branches-container');
            const template = document.getElementById('branch-template');
            const addBtn = document.getElementById('add-branch-btn');
            let branchIndex = {{ count($branches) }};

            addBtn.addEventListener('click', () => {
                const newBranchHTML = template.innerHTML.replace(/__INDEX__/g, branchIndex);
                const newBranchDiv = document.createElement('div');
                newBranchDiv.innerHTML = newBranchHTML;

                // If this is the very first branch, make it the main one by default
                if (container.childElementCount === 0) {
                    const radio = newBranchDiv.querySelector('input[type="radio"]');
                    if(radio) radio.checked = true;
                }

                container.appendChild(newBranchDiv.firstElementChild);
                branchIndex++;
            });

            container.addEventListener('click', (e) => {
                if (e.target && e.target.classList.contains('remove-branch-btn')) {
                    e.target.closest('.branch-item').remove();
                }
            });
        });
    </script>
@endpush
