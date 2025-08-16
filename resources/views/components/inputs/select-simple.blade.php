<div class="form-group">
    <label for="input-{{$name}}">{{$label}}</label>
    <select name="{{$name}}" id="input-{{$name}}" class="form-control" @if($required) required @endif>
        {{$slot}}
    </select>
    @error($name)
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
