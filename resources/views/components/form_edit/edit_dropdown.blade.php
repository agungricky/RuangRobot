    <label for="{{ $name }}">{{ $label }}</label>
    <select class="form-control" name="{{ $name }}" id="{{ $name }}">
        @foreach ($option as $key => $value)
            <option value="{{ $key }}" {{$data == $key ? 'selected' : ''}}>{{ $value }}</option>
        @endforeach
    </select>
