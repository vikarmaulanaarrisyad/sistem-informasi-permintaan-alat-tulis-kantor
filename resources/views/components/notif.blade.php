@push('scripts')
    @if (session()->has('success'))
        <script>
            Swal.fire({
                title: 'Sukses!',
                text: '{{ session('message') }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 3000
            })
            setTimeout(() => {
                $('.toasts-top-right').remove();
            }, 3000);
        </script>
    @elseif (session()->has('error'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: '{{ session('message') }}',
                icon: 'error',
            })
            setTimeout(() => {
                $('.toasts-top-right').remove();
            }, 3000);
        </script>
    @endif
@endpush
