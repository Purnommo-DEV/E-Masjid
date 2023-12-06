<div class="modal fade text-left" id="modal-tambah-kategori" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulir Kategori</h4>
                <button type="button" class="btn-close text-dark batal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah-kategori" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="input-group input-group-static mb-4">
                        <label>Kategori</label>
                        <input name="kategori" class="form-control" type="text"
                            placeholder="Masukkan kategori infaq, contoh : infaq jum'at, Infaq instansi">
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text kategori_error">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary batal" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm" id="button-tambah-kategori">
                        <i id="icon-button-tambah-kategori"></i>
                        <span id="text-tambah-kategori" class="d-sm-block">
                            Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $('.tambah-kategori').on('click', function() {
            $("#modal-tambah-kategori").modal('show')
        });

        $('#form-tambah-kategori').on('submit', function(e) {
            e.preventDefault();
            var $search = $("#icon-button-tambah-kategori")
            $("#icon-button-tambah-kategori").addClass("fa fa-spinner fa-spin")
            $("#text-tambah-kategori").html('')
            $("#button-tambah-kategori").prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.TambahDataKategori') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $(document).find('label.error-text').text('');
                },
                success: function(data) {
                    if (data.status_form_kosong == 1) {
                        $.each(data.error, function(prefix, val) {
                            $('label.' + prefix + '_error').text(val[0]);
                            // $('span.'+prefix+'_error').text(val[0]);
                        });
                        $search.removeClass("fa fa-spinner fa-spin")
                        $("#text-tambah-kategori").html(
                            '<span id="text-tambah-kategori" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-kategori").prop('disabled', false);
                    } else if (data.status_berhasil == 1) {
                        $("#form-tambah-kategori").trigger('reset');
                        $("#modal-tambah-kategori").modal('hide')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal
                                    .stopTimer)
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: data.msg
                        })
                        $search.removeClass("fa fa-spinner fa-spin")
                        $("#text-tambah-kategori").html(
                            '<span id="text-tambah-kategori" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-kategori").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                        $("#daftar-kategori").load(location.href +
                            " #daftar-kategori>*", "");
                    }
                },
            });
        });
    </script>
@endpush
