@extends('Back.layout_back.master', ['title' => 'Kas Masjid'])
@section('konten')
    <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Informasi Kas Masjid</h6>
                    <p class="text-sm mb-0">
                    <p>Berikut ini merupakan informasi terkait kas masjid </p>
                    </p>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-light btn-sm mt-2 mb-2 tambah-kas"><i class="bi bi-plus"></i> Tambah
                        Kas
                    </button>
                    @include('Back.KasMasjid._form_tambah_kas')
                    <table class="table table-striped" id="table-data-kas-masjid">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Transaksi</th>
                                <th>Keterangan</th>
                                <th>Jenis Transaksi</th>
                                <th>Jumlah</th>
                                <th>Bukti Pembayaran</th>
                                <th>Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                    @include('Back.KasMasjid._form_ubah_kas')
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
            $("#form-ubah-kas-masjid").trigger('reset');
            $("#form-tambah-kas-masjid").trigger('reset');
        });

        $('.portfolio-popup').magnificPopup({
            type: 'image',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true,
                duration: 300,
                easing: 'ease-in-out',
                opener: function(openerElement) {
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });

        let daftar_data_kas_masjid = [];
        const table_data_kas_masjid = $('#table-data-kas-masjid').DataTable({
            "fnDrawCallback": function() {
                $('.portfolio-popup').magnificPopup({
                    type: 'image',
                    removalDelay: 300,
                    mainClass: 'mfp-fade',
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                        easing: 'ease-in-out',
                        opener: function(openerElement) {
                            return openerElement.is('img') ? openerElement : openerElement.find(
                                'img');
                        }
                    }
                });
            },
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
                url: "{{ route('admin.DataKasMasjid') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: function(d) {
                //     d.role_pengguna = data_role_pengguna;
                //     d.jurusan_pengguna = data_filter_jurusan;
                //     return d
                // }
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
                        daftar_data_kas_masjid[row.id] = row;
                        return meta.row + 1;
                    }
                },
                {
                    "targets": 1,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_kas_masjid[row.id] = row;
                        return row.tanggal_transaksi;
                    }
                },
                {
                    "targets": 2,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_kas_masjid[row.id] = row;
                        return row.keterangan;
                    }
                },
                {
                    "targets": 3,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_kas_masjid[row.id] = row;
                        if (row.jenis_transaksi == "keluar") {
                            return "Pengeluaran";
                        } else if (row.jenis_transaksi == "masuk") {
                            return "Pemasukkan";
                        }
                    }
                },
                {
                    "targets": 4,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_kas_masjid[row.id] = row;
                        return $.fn.dataTable.render.number('.', ',', 0, 'Rp ').display(row.jumlah);
                    }
                },
                {
                    "targets": 5,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_kas_masjid[row.id] = row;
                        return row.relasi_user.nama;
                    }
                },
                {
                    "targets": 6,
                    "class": "text-wrap text-center",
                    "render": function(data, type, row, meta) {
                        daftar_data_kas_masjid[row.id] = row;
                        if (row.path == null || row.path == "") {
                            return `<img src="/All/img/no_image.jpg" width="100">`
                        } else if (row.path != null) {
                            return `<a href="/storage/${row.path}" class="portfolio-popup">
                                                <img src="/storage/${row.path}" width="100" class="img-fluid">
                                            </a>`
                        }
                    }
                },
                {
                    "targets": 7,
                    "class": "text-nowrap text-center",
                    "render": function(data, type, row, meta) {
                        let tampilan;
                        tampilan = `
                                <div class="ms-auto">
                                    <button type="button" class="btn btn-warning btn-sm ubah-kas" data-id = "${row.id}" href="#!">Ubah</button>
                                    <button type="button" class="btn btn-danger btn-sm hapus-kas" data-id = "${row.id}" href="#!">Hapus</button>
                                </div>
                                `
                        // <a class="btn btn-link text-dark text-gradient px-3 mb-0 edit_kas_masjid" id-paket-pajak = "${row.id}" href="#!" ><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Ubah</a>
                        return tampilan;
                    }
                },
            ]
        });

        $(document).on('click', '.hapus_kas_masjid', function(event) {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "/admin/hapus-data-kas_masjid/" + id,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status_berhasil_hapus == 1) {
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
                                table_data_kas_masjid.ajax.reload(null, false);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
