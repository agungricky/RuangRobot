<label for="{{ $name }}">{{ $label }}</label>
<input type="text" class="form-control" id="{{ $name }}" 
       placeholder="{{ $placeholder }}" name="{{ $name }}" 
       oninput="validateInput(this)">
<div class="invalid-feedback">
    Hanya boleh angka.
</div>

<script>
    function validateInput(input) {
        const regex = /^[0-9]*$/;
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^0-9]/g, '');
            input.classList.add('is-invalid');
        } else {
            input.classList.remove('is-invalid');
        }
    }
</script>
