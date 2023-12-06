@extends('Back.layout_back.master', ['title' => 'Data Infaq'])
@section('konten')
    <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Informasi Infaq Masjid</h6>
                    <p class="text-sm mb-0">
                    <p>Berikut ini merupakan rekapan data infaq Masjid </p>
                    </p>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-light btn-sm mt-2 mb-2 btn-tambah-data-infaq-masjid"><i
                            class="bi bi-plus"></i> Tambah
                        Data Infaq
                    </button>
                    @include('Back.Infaq.data_infaq._form_tambah_data_infaq')
                    <table class="table table-striped" id="table-data-infaq-masjid">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                    @include('Back.Infaq.data_infaq._form_ubah_data_infaq')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('#ubah_jumlah, #tambah_jumlah').mask('#.##0', {
            reverse: true
        });

        $('.batal').on('click', function() {
            $(document).find('label.error-text').text('');
            $("#form-ubah-data-infaq-masjid").trigger('reset');
            $("#form-tambah-data-infaq-masjid").trigger('reset');
            $("#ubah_kategori_id").empty().append('');
        });


        let daftar_data_infaq_masjid = [];
        const table_data_infaq_masjid = $('#table-data-infaq-masjid').DataTable({
            "destroy": true,
            "pageLength": 10,
            "lengthMenu": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": true,
            "processing": true,
            "bServerSide": true,
            "responsive": false,
            "sScrollX": '100%',
            "sScrollXInner": "100%",
            ajax: {
                url: "{{ route('admin.DataInfaqMasjid') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columnDefs: [{
                    targets: '_all',
                    visible: true
                },
                {
                    "targets": 0,
                    "class": "text-nowrap text-center",
                    "render": function(data, type, row, meta) {
                        let i = 1;
                        daftar_data_infaq_masjid[row.id] = row;
                        return meta.row + 1;
                    }
                },
                {
                    "targets": 1,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_infaq_masjid[row.id] = row;
                        return row.tanggal;
                    }
                },
                {
                    "targets": 2,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_infaq_masjid[row.id] = row;
                        return row.relasi_kategori.kategori;
                    }
                },
                {
                    "targets": 3,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_infaq_masjid[row.id] = row;
                        return row.jenis;
                    }
                },
                {
                    "targets": 4,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_infaq_masjid[row.id] = row;
                        return row.satuan;
                    }
                },
                {
                    "targets": 5,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_infaq_masjid[row.id] = row;
                        return $.fn.dataTable.render.number('.', ',', 0, 'Rp ').display(row.jumlah);
                    }
                },
                {
                    "targets": 6,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_infaq_masjid[row.id] = row;
                        return row.keterangan;
                    }
                },
                {
                    "targets": 7,
                    "class": "text-nowrap text-center",
                    "render": function(data, type, row, meta) {
                        let tampilan;
                        tampilan = `
                                <div class="ms-auto">
                                    <a class="btn btn-success btn-sm" href="/admin/rincian-infaq-masjid/${row.kode}">Rincian</a>
                                    <button type="button" class="btn btn-warning btn-sm btn-ubah-data-infaq-masjid" data-id = "${row.id}" href="#!">Ubah</button>
                                    <button type="button" class="btn btn-danger btn-sm btn-hapus-data-infaq-masjid" data-id = "${row.id}" href="#!">Hapus</button>
                                </div>
                                `
                        // <a class="btn btn-link text-dark text-gradient px-3 mb-0 edit_infaq_masjid" id-paket-pajak = "${row.id}" href="#!" ><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Ubah</a>
                        return tampilan;
                    }
                },
            ]
        });

        $(document).on('click', '.btn-hapus-data-infaq-masjid', function(event) {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "/admin/hapus-data-infaq-masjid/" + id,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status_berhasil == 1) {
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
                                table_data_infaq_masjid.draw();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
