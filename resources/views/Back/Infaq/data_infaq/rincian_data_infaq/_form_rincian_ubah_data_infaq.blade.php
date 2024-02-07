<div class="modal fade text-left" id="modal-ubah-data-rincian-infaq-masjid" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulir Rincian</h4>
                <button type="button" class="btn-close text-dark batal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-ubah-data-rincian-infaq-masjid" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="data_rincian_infaq_id" hidden>
                    <div class="input-group input-group-static mb-4">
                        <label>Kategori</label>
                        <input class="form-control" id="data_kategori_id" readonly>
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <label>Sub Kategori</label>
                        <input class="form-control" id="data_sub_kategori_id" readonly>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="input-group input-group-static mb-4">
                                <label>Pecahan</label>
                                <input class="form-control" id="data_pecahan_id" type="text" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group input-group-static mb-4">
                                <label>Jumlah</label>
                                <input id="data_jumlah" class="form-control" type="number" min="0"
                                    oninput="this.value = Math.abs(this.value)">
                                <div class="input-group has-validation">
                                    <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                        class="text-danger error-text jumlah_error">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary batal" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm" id="button-ubah-data-rincian-infaq-masjid">
                        <i id="icon-button-ubah-data-rincian-infaq-masjid"></i>
                        <span id="text-ubah-data-rincian-infaq-masjid" class="d-sm-block">
                            Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $('body').on('click', '.btn-ubah-data-rincian-infaq-masjid', function(e) {
            e.preventDefault();
            let rincian_infaq_id = $(this).data('id');
            $.ajax({
                url: `/admin/tampil-data-rincian-infaq-masjid/${rincian_infaq_id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#data_rincian_infaq_id').val(response.data.id);
                    $('#data_kategori_id').val(response.data.relasi_infaq.relasi_kategori.kategori);
                    $('#data_sub_kategori_id').val(response.data.relasi_sub_kategori.sub_kategori);
                    $('#data_pecahan_id').val('Rp. ' + response.data.relasi_pecahan
                        .pecahan.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));
                    $('#data_jumlah').val(response.data.jumlah);

                    $("#modal-ubah-data-rincian-infaq-masjid").modal('show')
                }
            });
        });


        $('#form-ubah-data-rincian-infaq-masjid').on('submit', function(e) {
            e.preventDefault();
            var $search = $("#icon-button-ubah-data-rincian-infaq-masjid")
            $("#icon-button-ubah-data-rincian-infaq-masjid").addClass("fa fa-spinner fa-spin")
            $("#text-ubah-data-rincian-infaq-masjid").html('')
            $("#button-ubah-data-rincian-infaq-masjid").prop('disabled', true);
            var data = new FormData(this);
            data.append('req_rincian_infaq_masjid_id', $('#data_rincian_infaq_id').val());
            data.append('req_jumlah', $('#data_jumlah').val());
            $.ajax({
                url: "{{ route('admin.ProsesUbahRincianMasjid') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                processData: false,
                dataType: 'json',
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $(document).find('label.error-text').text('');
                },
                success: function(data) {
                    if (data.status_berhasil == 1) {
                        $("#form-ubah-data-rincian-infaq-masjid").trigger('reset');
                        $("#modal-ubah-data-rincian-infaq-masjid").modal('hide')
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
                        $("#text-ubah-data-rincian-infaq-masjid").html(
                            '<span id="text-ubah-data-rincian-infaq-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-ubah-data-rincian-infaq-masjid").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                        $("#data-rincian-infaq-masjid").load(location.href +
                            " #data-rincian-infaq-masjid>*", "");
                        $("#data-ringkasan-infaq-masjid").load(location.href +
                            " #data-ringkasan-infaq-masjid>*", "");
                    }
                },
            });
        });
    </script>
@endpush
