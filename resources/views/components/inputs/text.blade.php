<div class="form-group">
    <label for="input-{{$name}}">{{$label}}</label>
    <input {{ $attributes->merge(['type' => 'text', 'class' => 'form-control', 'id' => 'input-'.$name, 'name' => $name, 'placeholder' => $placeholder ?: 'Enter '.$label]) }}
           value="{{ $value ?: old($name) }}"
           @if($required) required @endif>
    @error($name)
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
