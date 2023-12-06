@extends('Back.layout_back.master', ['title' => 'Profil Masjid'])
@section('konten')
    <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Kategori Infaq</h6>
                    <p class="text-sm mb-0">
                    <p>Berikut ini merupakan daftar kategori infaq</p>
                    </p>
                </div>
                <div class="card-body">
                    <div class="accordion" id="daftar-kategori">
                        <button class="btn btn-sm btn-icon btn-2 btn-primary tambah-kategori" type="button">
                            + Tambah Kategori
                        </button>
                        @foreach ($data_kategori as $kategori)
                            @php
                                $data_sub_kategori = \App\Models\SubKategori::where('kategori_id', $kategori->id)->get();
                            @endphp
                            <div class="accordion-item my-3 shadow">
                                <h2 class="accordion-header">
                                    <div class="btn-group col-md-12" role="group">
                                        <button style="margin-bottom:0% !important"
                                            class="btn btn-sm btn-warning btn-ubah-kategori"
                                            data-id="{{ $kategori->id }}"><i class="fas fa-pen"></i></button>
                                        <button style="margin-bottom:0% !important"
                                            class="btn btn-sm btn-danger btn-hapus-kategori"
                                            data-id="{{ $kategori->id }}"><i class="fas fa-trash"></i></button>
                                        <button style="margin-bottom:0% !important"
                                            class="btn btn-sm btn-primary btn-tambah-sub-kategori"
                                            data-id="{{ $kategori->id }}"><i class="fas fa-plus"></i></button>

                                        <button style="padding: 1rem; !important"
                                            class="accordion-button border-bottom font-weight-bold collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#konten-{{ $kategori->id }}">{{ $kategori->kategori }}<i
                                                class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                aria-hidden="true"></i>
                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                aria-hidden="true"></i></button>
                                    </div>
                                </h2>
                                <div id="konten-{{ $kategori->id }}" class="accordion-collapse collapse"
                                    data-bs-parent="#daftar-materi" style="padding: 1rem;">
                                    <div class="col-md-8">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Sub Kategori</th>
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data_sub_kategori as $sub_kategori)
                                                    <tr>
                                                        <td scope="row">
                                                            {{ $sub_kategori->sub_kategori }}</td>
                                                        <td scope="row">
                                                            <button class="btn btn-sm btn-warning btn-ubah-sub-kategori"
                                                                data-id="{{ $sub_kategori->id }}">Ubah</button>
                                                            <button class="btn btn-sm btn-danger btn-hapus-sub-kategori"
                                                                data-id="{{ $sub_kategori->id }}">Hapus</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    @include('Back.Infaq.kategori._form_tambah_kategori')
                    @include('Back.Infaq.kategori._form_tambah_sub_kategori')
                    @include('Back.Infaq.kategori._form_ubah_kategori')
                    @include('Back.Infaq.kategori._form_ubah_sub_kategori')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('.batal').on('click', function() {
            $(document).find('label.error-text').text('');
            $("#form-ubah-kategori").trigger('reset');
            $("#form-tambah-kategori").trigger('reset');
            $("#form-ubah-sub-kategori").trigger('reset');
            $("#form-tambah-sub-kategori").trigger('reset');
        });

        $(document).on('click', '.btn-hapus-kategori', function(event) {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "/admin/hapus-data-kategori/" + id,
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
                                $("#daftar-kategori").load(location.href +
                                    " #daftar-kategori>*", "");
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-hapus-sub-kategori', function(event) {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin mengahpus data ini?',
                icon: 'warning',
                showDenyButton: true,
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "/admin/hapus-data-sub-kategori/" + id,
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
                                $("#daftar-kategori").load(location.href +
                                    " #daftar-kategori>*", "");
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
