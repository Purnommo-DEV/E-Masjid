@extends('Back.layout_back.master', ['title' => 'Rincian Infaq'])
@section('konten')
    <div class="row mb-5">
        <div class="col-lg-3">
            <div class="card my-4" id="data-ringkasan-infaq-masjid">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Ringkasan</h6>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <div class="my-auto mb-3">
                        <span class="text-dark d-block text-sm">Tanggal</span>
                        <span
                            class="text-xs font-weight-normal">{{ help_tanggal_jam($data_infaq->relasi_kategori->tanggal) }}</span>
                    </div>
                    <div class="my-auto mb-3">
                        <span class="text-dark d-block text-sm">Kategori</span>
                        <span class="text-xs font-weight-normal">{{ $data_infaq->relasi_kategori->kategori }}</span>
                    </div>
                    <div class="my-auto mb-3">
                        <span class="text-dark d-block text-sm">Jenis</span>
                        <span class="text-xs font-weight-normal">{{ help_kapital_awal($data_infaq->jenis) }}</span>
                    </div>
                    <div class="my-auto mb-3">
                        <span class="text-dark d-block text-sm">Satuan</span>
                        <span class="text-xs font-weight-normal">{{ help_kapital_awal($data_infaq->satuan) }}</span>
                    </div>
                    <div class="my-auto mb-3">
                        <span class="text-dark d-block text-sm">Jumlah</span>
                        <span class="text-xs font-weight-normal">
                            @if (@empty($data_infaq->jumlah))
                                Rp 0
                            @else
                                {{ help_format_rupiah($data_infaq->jumlah) }}
                            @endempty

                    </span>
                </div>
                <div class="my-auto mb-3">
                    <span class="text-dark d-block text-sm">Keterangan</span>
                    <span class="text-xs font-weight-normal">{{ $data_infaq->keterangan ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 mt-lg-0 mt-4">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Rincian</h6>
                </div>
            </div>
            <div class="card-body px-4 pb-2">
                <button type="button" class="btn btn-light btn-sm mt-2 mb-2 btn-tambah-data-rincian-infaq-masjid"><i
                        class="fa fa-plus"></i> Tambah Rincian
                </button>

                <div class="table-responsive p-0" id="data-rincian-infaq-masjid">
                    @php
                        $total_sub_kategori = $data_sub_kategori->count();
                    @endphp

                    @if ($total_sub_kategori == 0)
                        <table class="table align-items-center mb-0 table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Pecahan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sub Total</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sub_total = 0;
                                    $total = 0;
                                @endphp
                                @foreach ($data_infaq_rincian as $sub_kategori_id => $outer)
                                    @php
                                        $total = $outer->sum('subtotal');
                                        // dd($outer);
                                    @endphp
                                    @foreach ($outer as $k => $item_0)
                                        @php
                                            $sub_total = $item_0->relasi_pecahan->pecahan * $item_0->jumlah;
                                        @endphp
                                        <tr>
                                            <td>
                                                <p class="text-xs mb-0">{{ $loop->index }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0">
                                                    {{ help_format_rupiah($item_0->relasi_pecahan->pecahan) }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0">{{ $item_0->jumlah }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0">{{ help_format_rupiah($item_0->subtotal) }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">Ubah</span>
                                                <span class="badge badge-sm bg-gradient-danger">Hapus</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3">
                                            <p class="text-xs font-weight-bold mb-0 text-left">Total</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ help_format_rupiah($total) }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        @php
                            $sub_total = 0;
                            $total = 0;
                        @endphp
                        @foreach ($data_infaq_rincian as $sub_kategori_id => $outer)
                            @php
                                $total = $outer->sum('subtotal');
                                // dd($outer);
                            @endphp
                            <table class="table align-items-center mb-4 table-bordered border border-dark-subtl">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-xxs font-weight-bold">
                                            No.
                                        </th>
                                        <th class="text-uppercase text-xxs font-weight-bold ps-2">
                                            Sub Kategori</th>
                                        <th class="text-uppercase text-xxs font-weight-bold ps-2">
                                            Pecahan</th>
                                        <th class="text-center text-uppercase text-xxs font-weight-bold">
                                            Jumlah</th>
                                        <th class="text-center text-uppercase text-xxs font-weight-bold">
                                            Sub Total</th>
                                        <th class="text-center text-uppercase text-xxs font-weight-bold">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($outer as $k => $item_1)
                                        @php
                                            $sub_total = $item_1->relasi_pecahan->pecahan * $item_1->jumlah;
                                        @endphp
                                        <tr>
                                            <td>
                                                <p class="text-xs mb-0">{{ $loop->index + 1 }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0">
                                                    {{ $item_1->relasi_sub_kategori->sub_kategori }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0">
                                                    {{ help_format_rupiah($item_1->relasi_pecahan->pecahan) }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0">{{ $item_1->jumlah }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs mb-0">{{ help_format_rupiah($item_1->subtotal) }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">Ubah</span>
                                                <span class="badge badge-sm bg-gradient-danger">Hapus</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">
                                            <p class="text-xs font-weight-bold mb-0 text-left">Total</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ help_format_rupiah($total) }}
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach

                    @endif
                </div>
                @include('Back.Infaq.data_infaq.rincian_data_infaq._form_rincian_tambah_data_infaq')
                {{-- @include('Back.Infaq.data_infaq._form_ubah_data_infaq') --}}
            </div>
        </div>
    </div>
</div>
@endsection
