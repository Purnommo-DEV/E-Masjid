<div class="modal fade text-left" id="modal-tambah-data-rincian-infaq-masjid" data-bs-backdrop="static"
    data-bs-keyboard="false" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Formulir Rincian</h4>
                <button type="button" class="btn-close text-dark batal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-tambah-data-rincian-infaq-masjid" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="input-group input-group-static mb-4">
                        <label>Kategori</label>
                        <input class="form-control" value="{{ $data_infaq->relasi_kategori->kategori }}" readonly>
                    </div>
                    <input type="hidden" name="infaq_id" value="{{ $data_infaq->id }}">
                    <div class="input-group input-group-static mb-4">
                        <label for="exampleFormControlSelect1" class="ms-0">Kategori Infaq</label>
                        <select name="sub_kategori_id" class="form-control">
                            <option value="" selected disabled>-- Pilih Kategori --
                            </option>
                            @foreach ($data_sub_kategori as $sub_kategori)
                                <option value="{{ $sub_kategori->id }}">&nbsp;{{ $sub_kategori->sub_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-group has-validation">
                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                class="text-danger error-text sub_kategori_id_error">
                            </label>
                        </div>
                    </div>

                    {{-- Versi 1 : Input Pecahannya Manual, Form Input Dinamis --}}
                    {{-- <table class="table" id="pecahan-jumlah">
                            <tr>
                                <td>
                                    <div class="input-group input-group-static mb-4">
                                        <label>Pecahan (Rp)</label>
                                        <input name="pecahan[]" id="pecahan_id" class="form-control" type="text"
                                            placeholder="Contoh : 100000">
                                        <div class="input-group has-validation">
                                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                                class="text-danger error-text jenis_error">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group input-group-static mb-4">
                                        <label>Jumlah</label>
                                        <input name="jumlah[]" class="form-control" type="number">
                                        <div class="input-group has-validation">
                                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                                class="text-danger error-text jumlah_error">
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td><button type="button" name="add" id="add" class="btn btn-success">Add
                                        More</button></td>
                            </tr>
                                </table> --}}

                    {{-- Versi 2 : Data Pecahan diambil dari data Master --}}
                    @foreach ($data_pecahan as $pecahan)
                        <div class="row">
                            <div class="col">
                                <div class="input-group input-group-static mb-4">
                                    <label>Pecahan</label>
                                    <input value="{{ help_format_rupiah($pecahan->pecahan) }}" class="form-control"
                                        readonly>
                                    <input name="pecahan_id[]" value="{{ $pecahan->id }}" class="form-control"
                                        type="hidden" hidden>
                                    <div class="input-group has-validation">
                                        <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                            class="text-danger error-text jenis_error">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-static mb-4">
                                    <label>Jumlah</label>
                                    <input name="jumlah[]" class="form-control" type="number" min="0"
                                        oninput="this.value = Math.abs(this.value)">
                                    <div class="input-group has-validation">
                                        <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                            class="text-danger error-text jumlah_error">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label>Pecahan</label>
                                    <input value="{{ help_format_rupiah($pecahan->pecahan) }}" class="form-control"
                                        readonly>
                                    <input name="pecahan[]" id="pecahan_id" value="{{ $pecahan->id }}"
                                        class="form-control" type="hidden" hidden>
                                    <div class="input-group has-validation">
                                        <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                            class="text-danger error-text jenis_error">
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <label>Jumlah</label>
                                    <input name="jumlah[]" class="form-control" type="number">
                                    <div class="input-group has-validation">
                                        <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                            class="text-danger error-text jumlah_error">
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label>Jumlah</label>
                                        <input name="jumlah[]" class="form-control" type="number">
                                        <div class="input-group has-validation">
                                            <label style="margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"
                                                class="text-danger error-text jumlah_error">
                                            </label>
                                        </div>
                                    </div>
                                </div> --}}
                        </div>
                    @endforeach

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary batal" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm" id="button-tambah-data-rincian-infaq-masjid">
                        <i id="icon-button-tambah-data-rincian-infaq-masjid"></i>
                        <span id="text-tambah-data-rincian-infaq-masjid" class="d-sm-block">
                            Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        $('.btn-tambah-data-rincian-infaq-masjid').on('click', function() {
            $("#modal-tambah-data-rincian-infaq-masjid").modal('show')
        });

        // ------------- Versi 1: Input Pecahannya Manual, Form Input Dinamis
        // var i = 1;
        // $('#add').click(function() {
        //     i++;
        //     $('#pecahan-jumlah').append(
        //         '<tr id="row' + i +
        //         '" class="dynamic-added"> <td ><div class = "input-group input-group-static mb-4"><label> Pecahan(Rp) </label><input onkeyup="format_uang(this)" name ="pecahan[]" class ="form-control" type ="text" placeholder = "Contoh : 100000" ><div class = "input-group has-validation" ><label style = "margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;"class ="text-danger error-text jenis_error"></label></div></div></td><td><div class ="input-group input-group-static mb-4"><label>Jumlah</label><input name ="jumlah[]" class ="form-control" type ="number"><div class ="input-group has-validation"><label style = "margin-top: 0.1rem; font-size: 0.8rem; font-weight: 600;" class = "text-danger error-text jumlah_error"></label></div></div></td><td><button type ="button" name ="remove" id ="' +
        //         i + '" class = "btn btn-danger btn_remove"> X </button></td></tr>');
        // });

        // $(document).on('click', '.btn_remove', function() {
        //     var button_id = $(this).attr("id");
        //     $('#row' + button_id + '').remove();
        // });

        // $('#pecahan_id').mask('#.##0', {
        //     reverse: true
        // });

        // function format_uang(input) {
        //     let v = input.value.replace(/\D+/g, '');
        //     if (v.length > 14) v = v.slice(0, 14);
        //     input.value =
        //         v.replace(/(\d)(\d\d)$/, "$1,$2")
        //         .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        // }

        $('#form-tambah-data-rincian-infaq-masjid').on('submit', function(e) {
            e.preventDefault();
            var $search = $("#icon-button-tambah-data-rincian-infaq-masjid")
            $("#icon-button-tambah-data-rincian-infaq-masjid").addClass("fa fa-spinner fa-spin")
            $("#text-tambah-data-rincian-infaq-masjid").html('')
            $("#button-tambah-data-rincian-infaq-masjid").prop('disabled', true);
            $.ajax({
                url: "{{ route('admin.ProsesTambahRincianMasjid') }}",
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
                        $("#text-tambah-data-rincian-infaq-masjid").html(
                            '<span id="text-tambah-data-rincian-infaq-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-data-rincian-infaq-masjid").prop('disabled', false);
                    } else if (data.status_berhasil == 1) {
                        $("#form-tambah-data-rincian-infaq-masjid").trigger('reset');
                        $("#modal-tambah-data-rincian-infaq-masjid").modal('hide')
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
                        $("#text-tambah-data-rincian-infaq-masjid").html(
                            '<span id="text-tambah-data-rincian-infaq-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-data-rincian-infaq-masjid").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                        $("#data-rincian-infaq-masjid").load(location.href +
                            " #data-rincian-infaq-masjid>*", "");
                        $("#data-ringkasan-infaq-masjid").load(location.href +
                            " #data-ringkasan-infaq-masjid>*", "");
                    } else if (data.status_gagal == 1) {
                        $("#form-tambah-data-rincian-infaq-masjid").trigger('reset');
                        $("#modal-tambah-data-rincian-infaq-masjid").modal('hide')
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
                            icon: 'error',
                            title: data.msg
                        })
                        $search.removeClass("fa fa-spinner fa-spin")
                        $("#text-tambah-data-rincian-infaq-masjid").html(
                            '<span id="text-tambah-data-rincian-infaq-masjid" class="d-sm-block">Simpan</span>'
                        )
                        $("#button-tambah-data-rincian-infaq-masjid").prop('disabled', false);
                        $(document).find('label.error-text').text('');
                    }
                },
            });
        });
    </script>
@endpush
