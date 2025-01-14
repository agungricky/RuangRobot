<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        timer: 1500,
        showConfirmButton: false
    });
</script>
