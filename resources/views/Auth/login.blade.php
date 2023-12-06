@extends('Auth.layout_auth.master_auth', ['title' => 'Login'])
@section('konten-auth')
    <div class="page-header align-items-start min-vh-100"
        style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-4 col-md-8 col-12 mx-auto">
                    <div class="card z-index-0 fadeIn3 fadeInBottom">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                                <div class="row mt-3">
                                    <div class="col-2 text-center ms-auto">
                                        <a class="btn btn-link px-3" href="javascript:;">
                                            <i class="fa fa-facebook text-white text-lg"></i>
                                        </a>
                                    </div>
                                    <div class="col-2 text-center px-1">
                                        <a class="btn btn-link px-3" href="javascript:;">
                                            <i class="fa fa-github text-white text-lg"></i>
                                        </a>
                                    </div>
                                    <div class="col-2 text-center me-auto">
                                        <a class="btn btn-link px-3" href="javascript:;">
                                            <i class="fa fa-google text-white text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="form-login-pengguna" class="text-start">

                                <div class="input-group input-group-outline">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email">

                                    <div class="input-group has-validation" style="margin-bottom: 10px; margin-top: 5px;">
                                        <label style="margin-top: 0.2rem; font-size: 0.8rem; font-weight: 600;"
                                            class="text-danger error-text email_error"></label>
                                    </div>
                                </div>

                                <div class="input-group input-group-outline">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password">

                                    <div class="input-group has-validation" style="margin-bottom: 10px; margin-top: 5px;">
                                        <label style="margin-top: 0.2rem; font-size: 0.8rem; font-weight: 600;"
                                            class="text-danger error-text password_error"></label>
                                    </div>
                                </div>

                                <div class="form-check form-switch d-flex align-items-center">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                                </div>
                                <div class="text-center">
                                    <button class="btn bg-gradient-primary w-100 my-4 mb-2" id="button-login-pengguna">
                                        <i id="icon-button-login-pengguna"></i>
                                        <span id="text-login-pengguna" class="d-sm-block">
                                            Login</span>
                                    </button>
                                </div>
                                <p class="mt-4 text-sm text-center">
                                    Belum memiliki akun?
                                    <a href="{{ route('HalamanRegister') }}"
                                        class="text-primary text-gradient font-weight-bold">Daftar</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        if ($("#form-login-pengguna").length > 0) {
            $("#form-login-pengguna").validate({
                submitHandler: function(form) {
                    var data = new FormData();
                    var $search = $("#icon-button-login-pengguna")
                    $("#icon-button-login-pengguna").addClass("fa fa-spinner fa-spin")
                    $("#text-login-pengguna").html('')
                    $("#button-login-pengguna").prop('disabled', true);
                    // Form data (Input yang ada di FORM, kecuali type file)
                    var form_data = $('#form-login-pengguna').serializeArray();
                    $.each(form_data, function(key, input) {
                        data.append(input.name, input.value);
                    });

                    //KASUS : Jika id tidak ditemukan maka ketika menekan tombol submit maka halaman akan reload
                    // data.append('pengguna_id', id);

                    //Custom data
                    data.append('key', 'value');

                    // AJAX request
                    $.ajax({
                        url: "{{ route('ProsesLogin') }}",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: data,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $(document).find('label.error-text').text('');
                        },
                        success: function(data) {
                            if (data.status_form_kosong == 1) {
                                $.each(data.error, function(prefix, val) {
                                    $('label.' + prefix + '_error').text(val[
                                        0]);
                                    // $('span.'+prefix+'_error').text(val[0]);
                                });
                                $search.removeClass("fa fa-spinner fa-spin")
                                $("#text-login-pengguna").html(
                                    '<span id="text-login-pengguna" class="d-sm-block">Login</span>'
                                )
                                $("#button-login-pengguna").prop('disabled', false);
                            } else if (data.status_berhasil == 1) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter',
                                            Swal
                                            .stopTimer)
                                        toast.addEventListener('mouseleave',
                                            Swal
                                            .resumeTimer)
                                    }
                                })

                                Toast.fire({
                                    icon: 'success',
                                    title: data.msg
                                })
                                window.location.href = `${data.route}`;
                                $search.removeClass("fa fa-spinner fa-spin")
                                $("#text-login-pengguna").html(
                                    '<span id="text-login-pengguna" class="d-sm-block">Login</span>'
                                )
                            } else if (data.status_user_pass_salah == 1) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter',
                                            Swal
                                            .stopTimer)
                                        toast.addEventListener('mouseleave',
                                            Swal
                                            .resumeTimer)
                                    }
                                })
                                Toast.fire({
                                    icon: 'error',
                                    title: data.msg
                                })
                                $search.removeClass("fa fa-spinner fa-spin")
                                $("#text-login-pengguna").html(
                                    '<span id="text-login-pengguna" class="d-sm-block">Login</span>'
                                )
                                $("#button-login-pengguna").prop('disabled', false);
                            }
                        }
                    });
                }
            })
        }
    </script>
@endpush
