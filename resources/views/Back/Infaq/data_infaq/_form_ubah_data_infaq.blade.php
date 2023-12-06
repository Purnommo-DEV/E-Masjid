<div class="modal fade text-left" id="modal-ubah-data-infaq-masjid" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulir Infaq</h4>
                <button type="button" class="btn-close text-dark batal" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x">×</i>
                </button>
            </div>
            <form id="form-ubah-data-infaq-masjid" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="infaq_id">
                        <div class="input-group input-group-static mb-4">
                            <label>Tanggal</label>
                            <input name="tanggal" id="ubah_tanggal" class="form-control" type="datetime-local">
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text tanggal_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Kategori Infaq</label>
                            <select name="ubah_kategori_id" id="ubah_kategori_id" class="form-control">
                                <option value="" selected disabled>-- Pilih Kategori --
                                </option>
                            </select>
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text ubah_kategori_id_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label>Jenis</label>
                            <input name="jenis" id="ubah_jenis" class="form-control" type="text"
                                placeholder="Jenis: uang, barang">
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text jenis_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label>Satuan</label>
                            <input name="satuan" id="ubah_satuan" class="form-control" type="text"
                                placeholder="Satuan: rupiah, dus">
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text satuan_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label>Jumlah</label>
                            <input name="jumlah" id="ubah_jumlah" class="form-control" type="text"
                                placeholder="100000000">
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text jumlah_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label>Keterangan (Opsional)</label>
                            <textarea name="keterangan" id="ubah_keterangan" class="form-control" type="text"
                                placeholder="Masukkan keterangan, jika diperlukan"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary batal" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" id="button-data-infaq-masjid">
                        <i id="icon-button-data-infaq-masjid"></i>
                        <span id="text-data-infaq-masjid" class="d-sm-block">
                            Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $('#ubah_jumlah').mask('#.##0', {
            reverse: true
        });

        let kategori_infaq = @json($data_kategori);
        $('body').on('click', '.btn-ubah-data-infaq-masjid', function(e) {
            e.preventDefault();
            let infaq_id = $(this).data('id');
            $.ajax({
                url: `/admin/tampil-data-infaq-masjid/${infaq_id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#infaq_id').val(response.data.id);
                    $('#ubah_tanggal').val(response.data.tanggal);
                    $('#ubah_jenis').val(response.data.jenis);
                    $('#ubah_jumlah').val(response.data.jumlah);
                    $('#ubah_satuan').val(response.data.satuan);
                    $('#ubah_keterangan').val(response.data.keterangan);

                    $.each(kategori_infaq, function(key, value) {
                        $("#form-ubah-data-infaq-masjid [name='ubah_kategori_id']")
                            .append(
                                `<option value="${value.id}" ${value.id == response.data.kategori_id ? 'selected' : ''}>&nbsp;${value.kategori}</option>`
                            )
                    });
                    $("#modal-ubah-data-infaq-masjid").modal('show')
                }
            });
        });

        $('#form-ubah-data-infaq-masjid').on('submit', function(e) {
            e.preventDefault();
            var $search = $("#icon-button-data-infaq-masjid")
            $("#icon-button-data-infaq-masjid").addClass("fa fa-spinner fa-spin")
            $("#text-data-infaq-masjid").html('')
            $("#button-data-infaq-masjid").prop('disabled', true);

            var data = new FormData(this);
            data.append('infaq_id', $('#infaq_id').val());

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.ProsesUbahInfaqMasjid') }}",
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
                        $("#text-data-infaq-masjid").html(
                            '<span id="text-data-infaq-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-data-infaq-masjid").prop('disabled', false);
                    } else if (data.status_berhasil == 1) {
                        $("#form-ubah-data-infaq-masjid").trigger('reset');
                        $("#ubah_kategori_id").empty().append('');
                        $("#modal-ubah-data-infaq-masjid").modal('hide');
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
                        $("#text-data-infaq-masjid").html(
                            '<span id="text-data-infaq-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-data-infaq-masjid").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                        table_data_infaq_masjid.draw();
                    }
                },
            });
        });
    </script>
@endpush
