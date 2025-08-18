<div class="card card-outline card-secondary branch-item">
    <div class="card-header">
        <h3 class="card-title">{{ $branch->branch_name ?? 'Chi nhánh mới' }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool text-danger remove-branch-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <input type="hidden" name="branches[{{ $index }}][id]" value="{{ $branch->id ?? '' }}">

        <x-inputs.text label="Tên chi nhánh" name="branches[{{ $index }}][branch_name]"
                       :value="$branch->branch_name ?? ''" required/>
        <x-inputs.text label="Địa chỉ" name="branches[{{ $index }}][address]" :value="$branch->address ?? ''"/>
        <div class="row">
            <div class="col-md-6">
                <x-inputs.text label="Số điện thoại" name="branches[{{ $index }}][phone]"
                               :value="$branch->phone ?? ''"/>
            </div>
            <div class="col-md-6">
                <x-inputs.email label="Email" name="branches[{{ $index }}][email]" :value="$branch->email ?? ''"/>
            </div>
        </div>
        <x-inputs.text label="Giờ làm việc" name="branches[{{ $index }}][working_hours]"
                       :value="$branch->working_hours ?? ''"/>
        <div class="form-group">
            <div class="icheck-primary d-inline">
                <input type="radio"
                       name="is_main_branch"
                       id="is_main_{{ $index }}"
                       value="{{ $index }}"
                @if($isEdit ?? false)
                    @checked($mainBranchIndex == $index)
                    @else
                    @checked(old('is_main_branch', $mainBranchIndex ?? -1) == $index)
                    @endif
                >
                <label for="is_main_{{ $index }}">
                    Là trụ sở chính
                </label>
            </div>
        </div>
    </div>
</div>
