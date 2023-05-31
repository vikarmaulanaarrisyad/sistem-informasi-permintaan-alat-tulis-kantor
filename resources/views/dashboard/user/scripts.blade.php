@push('scripts')
    <script>
        let table;

        table = ('.daftar-ajuan').DataTable({
            processing: true,
            serverside: true,
            autoWidth: false,
        });
    </script>
@endpush
