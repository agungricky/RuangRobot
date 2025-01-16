<label for="{{ $name }}">{{ $label }}</label>
<input type="text" class="form-control" id="{{ $name }}" placeholder="{{ $placeholder }}"
    oninput="formatToRupiah(this)">
<input type="hidden" id="hidden_{{ $name }}" name="{{ $name }}">

<script>
    function formatToRupiah(element) {
        // Hapus semua karakter kecuali angka
        let rawValue = element.value.replace(/[^0-9]/g, "");

        // Format angka ke Rupiah dengan menambahkan titik setiap 3 digit
        let formattedValue = rawValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        // Update nilai input utama dengan format "Rp"
        element.value = rawValue ? "Rp " + formattedValue : "";

        // Update nilai input hidden dengan angka asli tanpa format
        document.getElementById("hidden_" + element.id).value = rawValue;
    }
</script>
