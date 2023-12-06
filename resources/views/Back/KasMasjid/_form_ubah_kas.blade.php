<div class="modal fade text-left" id="modal-ubah-kas-masjid" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulir Kas</h4>
                <button type="button" class="btn-close text-dark batal" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x">×</i>
                </button>
            </div>
            <form id="form-ubah-kas-masjid" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="kas_id" hidden>
                    <div class="input-group input-group-static mb-4">
                        <label>Tanggal Transaksi</label>
                        <input name="tanggal_transaksi" id="ubah_tanggal_transaksi" class="form-control"
                            type="datetime-local">
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text tanggal_transaksi_error">
                            </label>
                        </div>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label>Keterangan</label>
                        <textarea class="form-control" rows="2" name="keterangan" id="ubah_keterangan"
                            placeholder="Silahkan isikan keterangan disini"></textarea>
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text keterangan_error">
                            </label>
                        </div>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label for="exampleFormControlSelect1" class="ms-0">Jenis
                            Transaksi</label>
                        <select name="jenis_transaksi" id="ubah_jenis_transaksi" class="form-control">
                        </select>
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text jenis_transaksi_error">
                            </label>
                        </div>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label>Jumlah (Rp)</label>
                        <input name="jumlah" id="ubah_jumlah" class="form-control" id="ubah_jumlah"
                            placeholder="Silahkan isikan jumlah pembayaran disini">
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text jumlah_error">
                            </label>
                        </div>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label>Bukti Pembayaran</label>
                        <input class="form-control path" type="file" id="ubah-path" name="path"
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
                    <button type="submit" class="btn btn-primary ml-1" id="button-ubah-kas">
                        <i id="icon-button-ubah-kas"></i>
                        <span id="text-ubah-kas" class="d-sm-block">
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
            $("#ubah-path").on('change', function() {
                let file = this.files[0];
                let reader = new FileReader();
                var ext = $("#ubah-path").val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {

                    $(document).find('label.error-text.path_error').html(
                        "<label style='margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600; 'class='text-danger error-text path_error'>Format gambar yang diizinkan jpeg, jpg dan png</label>"
                    )
                    $("#ubah-path").val(null);
                } else {
                    if (file['size'] < 1111775) {
                        $(document).find('label.error-text.path_error').text('');
                        reader.readAsDataURL(this.files[0]);
                    } else if (file['size'] > 1111775) {
                        $(document).find('label.error-text.path_error').html(
                            "<label style='margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600; 'class='text-danger error-text path_error'>Ukuran gambar maksimal 1MB</label>"
                        )
                        $("#ubah-path").val(null);
                    }
                }
            });
        });

        $('body').on('click', '.ubah-kas', function(e) {
            e.preventDefault();
            let kas_id = $(this).data('id');
            $.ajax({
                url: `/admin/tampil-data-kas-masjid/${kas_id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#kas_id').val(response.data.id);
                    $('#ubah_tanggal_transaksi').val(response.data.tanggal_transaksi);
                    $('#ubah_keterangan').val(response.data.keterangan);
                    $('#ubah_jumlah').val(response.data.jumlah);

                    $("#ubah_jenis_transaksi").append($(
                        `<option value='masuk' ${'masuk' === response.data.jenis_transaksi ? 'selected' : ''}>Pemasukkan</option>
                        <option value='keluar' ${'keluar' === response.data.jenis_transaksi ? 'selected' : ''}>Pengeluaran</option>`
                    ));
                    $("#modal-ubah-kas-masjid").modal('show')
                }
            });
        });

        $('#form-ubah-kas-masjid').on('submit', function(e) {
            e.preventDefault();
            var $search = $("#icon-button-ubah-kas")
            $("#icon-button-ubah-kas").addClass("fa fa-spinner fa-spin")
            $("#text-ubah-kas").html('')
            $("#button-ubah-kas").prop('disabled', true);

            var data = new FormData(this);
            data.append('kas_id', $('#kas_id').val());
            data.append("path", $('input[name="path"]')[0].files);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.ProsesUbahKasMasjid') }}",
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
                        $("#text-ubah-kas").html(
                            '<span id="text-ubah-kas" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-ubah-kas").prop('disabled', false);
                    } else if (data.status_berhasil == 1) {
                        $("#form-ubah-kas-masjid").trigger('reset');
                        $("#modal-ubah-kas-masjid").modal('hide')
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
                        $("#text-ubah-kas").html(
                            '<span id="text-ubah-kas" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-ubah-kas").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                        table_data_kas_masjid.draw();
                    }
                },
            });
        });
    </script>
@endpush
