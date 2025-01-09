<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="form-control" name="{{ $name }}" id="{{ $name }}">
        @foreach ($option as $key => $value)
            <option value="{{ $value }}">{{ $key }}</option>
        @endforeach
    </select>
</div>
