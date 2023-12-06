<div class="modal fade text-left" id="modal-ubah-sub-kategori" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulir Kategori</h4>
                <button type="button" class="btn-close text-dark batal" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x">×</i>
                </button>
            </div>
            <form id="form-ubah-sub-kategori" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="sub_kategori_id" hidden>
                    <div class="input-group input-group-static mb-4">
                        <label>Kategori</label>
                        <input name="sub_kategori" id="ubah_sub_kategori" class="form-control" type="text">
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
                    <button type="submit" class="btn btn-primary ml-1" id="button-ubah-sub-kategori">
                        <i id="icon-button-ubah-sub-kategori"></i>
                        <span id="text-ubah-sub-kategori" class="d-sm-block">
                            Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $('body').on('click', '.btn-ubah-sub-kategori', function(e) {
            e.preventDefault();
            let sub_kategori_id = $(this).data('id');
            $.ajax({
                url: `/admin/tampil-data-sub-kategori/${sub_kategori_id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#sub_kategori_id').val(response.data.id);
                    $('#ubah_sub_kategori').val(response.data.sub_kategori);
                    $("#modal-ubah-sub-kategori").modal('show')
                }
            });
        });

        $('#form-ubah-sub-kategori').on('submit', function(e) {
            e.preventDefault();
            var $search = $("#icon-button-ubah-sub-kategori")
            $("#icon-button-ubah-sub-kategori").addClass("fa fa-spinner fa-spin")
            $("#text-ubah-sub-kategori").html('')
            $("#button-ubah-sub-kategori").prop('disabled', true);

            var data = new FormData(this);
            data.append('sub_kategori_id', $('#sub_kategori_id').val());

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.ProsesUbahSubKategori') }}",
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
                        $("#text-ubah-sub-kategori").html(
                            '<span id="text-ubah-sub-kategori" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-ubah-sub-kategori").prop('disabled', false);
                    } else if (data.status_berhasil == 1) {
                        $("#form-ubah-sub-kategori").trigger('reset');
                        $("#modal-ubah-sub-kategori").modal('hide')
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
                        $("#text-ubah-sub-kategori").html(
                            '<span id="text-ubah-sub-kategori" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-ubah-sub-kategori").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                        $("#daftar-kategori").load(location.href +
                            " #daftar-kategori>*", "");
                    }
                },
            });
        });
    </script>
@endpush
