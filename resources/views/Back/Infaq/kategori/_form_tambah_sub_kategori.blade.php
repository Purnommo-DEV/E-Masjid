<div class="modal fade text-left" id="modal-tambah-sub-kategori" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulir Kategori</h4>
                <button type="button" class="btn-close text-dark batal" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x">×</i>
                </button>
            </div>
            <form id="form-tambah-sub-kategori" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="kategori_id" hidden>
                    <div class="input-group input-group-static mb-4">
                        <label>Kategori</label>
                        <input id="kategori" class="form-control" type="text" readonly>
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Sub Kategori</label>
                        <input name="sub_kategori" id="sub_kategori" class="form-control" type="text">
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text sub_kategori_error">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary batal" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="button-tambah-sub-kategori">
                        <i id="icon-button-tambah-sub-kategori"></i>
                        <span id="text-tambah-sub-kategori" class="d-sm-block">
                            Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $('body').on('click', '.btn-tambah-sub-kategori', function(e) {
            e.preventDefault();
            let kategori_id = $(this).data('id');
            $.ajax({
                url: `/admin/tampil-data-kategori/${kategori_id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#kategori_id').val(response.data.id);
                    $('#kategori').val(response.data.kategori);
                    $("#modal-tambah-sub-kategori").modal('show')
                }
            });
        });

        $('#form-tambah-sub-kategori').on('submit', function(e) {
            e.preventDefault();
            var $search = $("#icon-button-tambah-sub-kategori")
            $("#icon-button-tambah-sub-kategori").addClass("fa fa-spinner fa-spin")
            $("#text-tambah-sub-kategori").html('')
            $("#button-tambah-sub-kategori").prop('disabled', true);

            var data = new FormData(this);
            data.append('kategori_id', $('#kategori_id').val());

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.ProsesTambahSubKategori') }}",
                method: "POST",
                data: data,
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
                        $("#text-tambah-sub-kategori").html(
                            '<span id="text-tambah-sub-kategori" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-sub-kategori").prop('disabled', false);
                    } else if (data.status_berhasil == 1) {
                        $("#form-tambah-sub-kategori").trigger('reset');
                        $("#modal-tambah-sub-kategori").modal('hide')
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
                        $("#text-tambah-sub-kategori").html(
                            '<span id="text-tambah-sub-kategori" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-sub-kategori").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                        $("#daftar-kategori").load(location.href +
                            " #daftar-kategori>*", "");
                    }
                },
            });
        });
    </script>
@endpush
