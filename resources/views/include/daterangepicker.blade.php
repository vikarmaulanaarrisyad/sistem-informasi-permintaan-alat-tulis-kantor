@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('/AdminLTE') }}/plugins/daterangepicker/daterangepicker.css">
@endpush

@push('scripts_vendor')
    <script src="{{ asset('/AdminLTE') }}/plugins/daterangepicker/daterangepicker.js"></script>
@endpush

@push('scripts')
    <script>
        //Date range picker with time picker
        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            autoApply: true,
            locale: {
                format: "YYYY-MM-DD",
                cancelLabel: 'Clear',
                separator: "-",
                daysOfWeek: [
                    "Min",
                    "Sen",
                    "Sel",
                    "Rab",
                    "Kam",
                    "Jum",
                    "Sab",
                ],
                monthNames: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ],
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    </script>
@endpush
