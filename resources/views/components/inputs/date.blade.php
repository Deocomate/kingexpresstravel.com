<div class="form-group">
    <label for="input-{{$name}}">{{$label}}</label>
    <input type="date" id="input-{{$name}}" name="{{$name}}" class="form-control"
           value="{{ $value ?: old($name) }}"
           onfocus="this.showPicker()"
           @if($required) required @endif>
    @error($name)
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

@if($required && !$value && !old($name))
    @push('scripts')
        <script>
            document.getElementById('input-{{$name}}').valueAsDate = new Date();
        </script>
    @endpush
@endif
