<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="form-control" name="{{ $name }}" id="{{ $name }}">
        {{-- @foreach ($option as $key => $value) --}}
        {{-- <option value="{{ $value }}">{{ $key }}</option> --}}
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
        {{-- @endforeach --}}
    </select>
</div>

