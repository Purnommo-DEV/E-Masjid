@extends('Back.layout_back.master', ['title' => 'Profil Masjid'])
@section('konten')
    <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Profil Masjid</h6>
                    <p class="text-sm mb-0">
                    <p>Berikut ini merupakan form yang disediakan untuk diisi
                        atau dilengkapi terkait profil masjid</p>
                    </p>
                </div>
                <div class="card-body">
                    <form id="form-profil-masjid">
                        <div
                            class="input-group input-group-outline @empty($data_masjid->relasi_masjid->nama) @else is-filled @endempty">
                            <label class="form-label">Nama Masjid</label>
                            <input type="text" class="form-control" name="nama"
                                value="{{ $data_masjid->relasi_masjid->nama ?? '' }}">
                            <div class="input-group has-validation" style="margin-bottom: 10px; margin-top: 2px;">
                                <label style="margin-top: 0.2rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text nama_error"></label>
                            </div>
                        </div>

                        <div
                            class="input-group input-group-outline @empty($data_masjid->relasi_masjid->alamat) @else is-filled @endempty">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control" name="alamat"
                                value="{{ $data_masjid->relasi_masjid->alamat ?? '' }}">
                            <div class="input-group has-validation" style="margin-bottom: 10px; margin-top: 2px;">
                                <label style="margin-top: 0.2rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text alamat_error"></label>
                            </div>
                        </div>

                        <div
                            class="input-group input-group-outline @empty($data_masjid->relasi_masjid->telp) @else is-filled @endempty">
                            <label class="form-label">Telepon/WA</label>
                            <input type="text" class="form-control" name="telp"
                                value="{{ $data_masjid->relasi_masjid->telp ?? '' }}">
                            <div class="input-group has-validation" style="margin-bottom: 10px; margin-top: 2px;">
                                <label style="margin-top: 0.2rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text telp_error"></label>
                            </div>
                        </div>

                        <div
                            class="input-group input-group-outline @empty($data_masjid->relasi_masjid->email) @else is-filled @endempty">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ $data_masjid->relasi_masjid->email ?? '' }}">
                            <div class="input-group has-validation" style="margin-bottom: 10px; margin-top: 2px;">
                                <label style="margin-top: 0.2rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text email_error"></label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0"
                                    id="button-profil-masjid">
                                    <i id="icon-button-profil-masjid"></i>
                                    <span id="text-profil-masjid" class="d-sm-block">
                                        Simpan</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('#form-profil-masjid').on('submit', function(e) {
            e.preventDefault();
            // Form data (Input yang ada di FORM, kecuali type file)
            var $search = $("#icon-button-profil-masjid")
            $("#icon-button-profil-masjid").addClass("fa fa-spinner fa-spin")
            $("#text-profil-masjid").html('')
            $("#button-profil-masjid").prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.ProsesSimpanProfilMasjid') }}",
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
                        $("#text-profil-masjid").html(
                            '<span id="text-profil-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-profil-masjid").prop('disabled', false);
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
                        $search.removeClass("fa fa-spinner fa-spin")
                        $("#text-profil-masjid").html(
                            '<span id="text-profil-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#form-profil-masjid").load(location.href +
                            " #form-profil-masjid>*", "");
                    }
                }
            });
        });
    </script>
@endpush
