<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
        timer: 1500,
        showConfirmButton: false
    });
</script>