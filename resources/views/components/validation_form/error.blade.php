@if ($errors->has($name))
    <span class="error text-danger mb-2">
        {{ $errors->first($name) }}
    </span>
@endif
