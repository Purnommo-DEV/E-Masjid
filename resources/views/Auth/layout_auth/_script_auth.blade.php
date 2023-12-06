<script src="{{ asset('Back/js/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('Back/js/core/popper.min.js') }}"></script>
<script src="{{ asset('Back/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('Back/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('Back/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('All/js/form/jquery.form.min.js') }}"></script>
<script src="{{ asset('All/js/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('All/js/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('All/js/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('Back/js/material-dashboard.min.js?v=3.1.0') }}"></script>
@stack('script')
