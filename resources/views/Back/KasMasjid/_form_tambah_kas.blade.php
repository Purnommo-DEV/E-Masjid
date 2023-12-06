<div class="modal fade text-left" id="modal-tambah-kas-masjid" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulir Kas</h4>
                <button type="button" class="btn-close text-dark batal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah-kas-masjid" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="input-group input-group-static mb-4">
                        <label>Tanggal Transaksi</label>
                        <input name="tanggal_transaksi" class="form-control" type="datetime-local">
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text tanggal_transaksi_error">
                            </label>
                        </div>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label>Keterangan</label>
                        <textarea class="form-control" rows="2" name="keterangan" placeholder="Silahkan isikan keterangan disini"></textarea>
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text keterangan_error">
                            </label>
                        </div>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label for="exampleFormControlSelect1" class="ms-0">Jenis
                            Transaksi</label>
                        <select name="jenis_transaksi" class="form-control">
                            <option value="" selected disabled>-- Pilih Jenis Transaksi --
                            </option>
                            <option value="masuk">Pemasukkan</option>
                            <option value="keluar">Pengeluaran</option>
                        </select>
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text jenis_transaksi_error">
                            </label>
                        </div>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label>Jumlah (Rp)</label>
                        <input name="jumlah" class="form-control" id="tambah_jumlah"
                            placeholder="Silahkan isikan jumlah pembayaran disini">
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text jumlah_error">
                            </label>
                        </div>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label>Bukti Pembayaran</label>
                        <input class="form-control" type="file" id="tambah-path" name="path"
                            accept="image/png, image/jpeg, image/jpg">
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text path_error">
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary batal" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm" id="button-tambah-kas">
                        <i id="icon-button-tambah-kas"></i>
                        <span id="text-tambah-kas" class="d-sm-block">
                            Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function(e) {
            $("#tambah-path").on('change', function() {
                let file = this.files[0];
                let reader = new FileReader();
                var ext = $("#tambah-path").val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {

                    $(document).find('label.error-text.path_error').html(
                        "<label style='margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600; 'class='text-danger error-text path_error'>Format gambar yang diizinkan jpeg, jpg dan png</label>"
                    )
                    $("#tambah-path").val(null);
                } else {
                    if (file['size'] < 1111775) {
                        $(document).find('label.error-text.path_error').text('');
                        reader.readAsDataURL(this.files[0]);
                    } else if (file['size'] > 1111775) {
                        $(document).find('label.error-text.path_error').html(
                            "<label style='margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600; 'class='text-danger error-text path_error'>Ukuran gambar maksimal 1MB</label>"
                        )
                        $("#tambah-path").val(null);
                    }
                }
            });
        });

        $('.tambah-kas').on('click', function() {
            $("#modal-tambah-kas-masjid").modal('show')
        });

        $('#form-tambah-kas-masjid').on('submit', function(e) {
            e.preventDefault();
            var $search = $("#icon-button-tambah-kas")
            $("#icon-button-tambah-kas").addClass("fa fa-spinner fa-spin")
            $("#text-tambah-kas").html('')
            $("#button-tambah-kas").prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.TambahDataKasMasjid') }}",
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
                        $("#text-tambah-kas").html(
                            '<span id="text-tambah-kas" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-kas").prop('disabled', false);
                    } else if (data.status_berhasil == 1) {
                        $("#form-tambah-kas-masjid").trigger('reset');
                        $("#modal-tambah-kas-masjid").modal('hide')
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
                        $("#text-tambah-kas").html(
                            '<span id="text-tambah-kas" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-kas").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                        table_data_kas_masjid.draw();
                    }
                },
            });
        });
    </script>
@endpush
