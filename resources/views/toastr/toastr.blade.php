@if (session('status'))
<script>
    toastr.options = {
        "progressBar": true,
        "closeButton": true,
        // timeOut: 0,
        // extendedTimeOut: 0,
        // tapToDismiss: false,
        // disableTimeOut: true, //Equivalent ot timeOut: 0 and extendedTimeOut: 0
    }
    toastr.success("{{ session('status') }}");
</script>
@endif

@if (session('info'))
<script>
    toastr.options = {
        "progressBar": true,
        "closeButton": true,
    }
    toastr.info("{{ session('info') }}");
</script>
@endif
@if (session('error'))
<script>
    toastr.options = {
        "progressBar": true,
        "closeButton": true,
        // timeOut: 0,
        // extendedTimeOut: 0,
        // tapToDismiss: false,
        // disableTimeOut: true, //Equivalent ot timeOut: 0 and extendedTimeOut: 0
    }
    toastr.error("{{ session('error') }}");
</script>
@endif