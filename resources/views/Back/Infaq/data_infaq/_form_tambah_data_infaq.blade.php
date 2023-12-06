<div class="modal fade text-left" id="modal-tambah-data-infaq-masjid" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulir Infaq</h4>
                <button type="button" class="btn-close text-dark batal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah-data-infaq-masjid" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="input-group input-group-static mb-4">
                            <label>Tanggal</label>
                            <input name="tanggal" class="form-control" type="datetime-local">
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text tanggal_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Kategori Infaq</label>
                            <select name="kategori_id" id="tambah_kategori_id" class="form-control">
                                <option value="" selected disabled>-- Pilih Kategori --
                                </option>
                                @foreach ($data_kategori as $kategori)
                                    <option value="{{ $kategori->id }}">&nbsp;{{ $kategori->kategori }}</option>
                                @endforeach
                            </select>
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text kategori_id_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label>Jenis</label>
                            <input name="jenis" class="form-control" type="text" placeholder="Jenis: uang, barang">
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text jenis_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label>Satuan</label>
                            <input name="satuan" class="form-control" type="text" placeholder="Satuan: rupiah, dus">
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text satuan_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label>Jumlah</label>
                            <input name="jumlah" id="tambah_jumlah" class="form-control" type="text"
                                placeholder="100000000">
                            <div class="input-group has-validation">
                                <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                    class="text-danger error-text jumlah_error">
                                </label>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <label>Keterangan (Opsional)</label>
                            <input name="keterangan" class="form-control" type="text"
                                placeholder="Masukkan keterangan, jika diperlukan">
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary batal" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm" id="button-tambah-data-infaq-masjid">
                        <i id="icon-button-tambah-data-infaq-masjid"></i>
                        <span id="text-tambah-data-infaq-masjid" class="d-sm-block">
                            Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $('#tambah_jumlah').mask('#.##0', {
            reverse: true
        });

        $('.btn-tambah-data-infaq-masjid').on('click', function() {
            $("#modal-tambah-data-infaq-masjid").modal('show')
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        $('#form-tambah-data-infaq-masjid').on('submit', function(e) {
            e.preventDefault();
            var $search = $("#icon-button-tambah-data-infaq-masjid")
            $("#icon-button-tambah-data-infaq-masjid").addClass("fa fa-spinner fa-spin")
            $("#text-tambah-data-infaq-masjid").html('')
            $("#button-tambah-data-infaq-masjid").prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.ProsesTambahInfaqMasjid') }}",
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
                        $("#text-tambah-data-infaq-masjid").html(
                            '<span id="text-tambah-data-infaq-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-data-infaq-masjid").prop('disabled', false);
                    } else if (data.status_berhasil == 1) {
                        $("#form-tambah-data-infaq-masjid").trigger('reset');
                        $("#modal-tambah-data-infaq-masjid").modal('hide')
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
                        $("#text-tambah-data-infaq-masjid").html(
                            '<span id="text-tambah-data-infaq-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-data-infaq-masjid").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                        $("#tambah_kategori_id").append('');
                        table_data_infaq_masjid.draw();
                    }
                },
            });
        });
    </script>
@endpush
