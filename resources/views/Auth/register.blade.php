@extends('Auth.layout_auth.master_auth', ['title' => 'Daftar'])
@section('konten-auth')
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div
                        class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
                            style="background-image: url('{{ asset('Back/img/illustrations/illustration-signup.jpg') }}'); background-size: cover;">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
                        <div class="card card-plain">
                            <div class="card-header">
                                <h4 class="font-weight-bolder">Sign Up</h4>
                                <p class="mb-0">Silahkan lengkapi form pendaftaran berikut</p>
                            </div>
                            <div class="card-body">
                                <form id="form-daftar-pengguna">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">Nama Pengguna</label>
                                        <input type="text" class="form-control" name="nama">
                                        <div class="input-group has-validation"
                                            style="margin-bottom: 10px; margin-top: 2px;">
                                            <label style="margin-top: 0.2rem; font-size: 0.8rem; font-weight: 600;"
                                                class="text-danger error-text nama_error"></label>
                                        </div>
                                    </div>

                                    <div class="input-group input-group-outline">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">

                                        <div class="input-group has-validation"
                                            style="margin-bottom: 10px; margin-top: 2px;">
                                            <label style="margin-top: 0.2rem; font-size: 0.8rem; font-weight: 600;"
                                                class="text-danger error-text email_error"></label>
                                        </div>
                                    </div>

                                    <div class="input-group input-group-outline ">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password">

                                        <div class="input-group has-validation"
                                            style="margin-bottom: 10px; margin-top: 2px;">
                                            <label style="margin-top: 0.2rem; font-size: 0.8rem; font-weight: 600;"
                                                class="text-danger error-text password_error"></label>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0"
                                            id="button-daftar-pengguna">
                                            <i id="icon-button-daftar-pengguna"></i>
                                            <span id="text-daftar-pengguna" class="d-sm-block">
                                                Daftar</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-2 text-sm mx-auto">
                                    Sudah memiliki akun?
                                    <a href="{{ route('HalamanLogin') }}"
                                        class="text-primary text-gradient font-weight-bold">Login</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        $('#form-daftar-pengguna').on('submit', function(e) {
            e.preventDefault();
            // Form data (Input yang ada di FORM, kecuali type file)
            var $search = $("#icon-button-daftar-pengguna")
            $("#icon-button-daftar-pengguna").addClass("fa fa-spinner fa-spin")
            $("#text-daftar-pengguna").html('')
            $("#button-daftar-pengguna").prop('disabled', true);
            $.ajax({
                url: "{{ route('ProsesRegister') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: new FormData(this),
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
                        $("#text-daftar-pengguna").html(
                            '<span id="text-daftar-pengguna" class="d-sm-block">Daftar</span>'
                        )
                        $("#button-daftar-pengguna").prop('disabled', false);
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
                        $("#text-daftar-pengguna").html(
                            '<span id="text-daftar-pengguna" class="d-sm-block">Daftar</span>'
                        )
                    }
                }
            });
        });
    </script>
@endpush
