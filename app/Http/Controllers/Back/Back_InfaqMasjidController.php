<?php

namespace App\Http\Controllers\Back;

use App\Models\Infaq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InfaqRincian;
use App\Models\KategoriInfaq;
use App\Models\PecahanMaster;
use App\Models\SubKategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Back_InfaqMasjidController extends Controller
{
    public function infaq()
    {
        $data_kategori = KategoriInfaq::where('masjid_id', Auth::user()->masjid_id)->get();
        return view('Back.Infaq.data_infaq.data_infaq', compact('data_kategori'));
    }

    public function data_infaq_masjid(Request $request)
    {
        $data = Infaq::select([
            'infaq.*'
        ])->with('relasi_kategori')->orderBy('created_at', 'desc');

        $rekamFilter = $data->get()->count();
        if ($request->input('length') != -1)
            $data = $data->skip($request->input('start'))->take($request->input('length'));
        $rekamTotal = $data->count();
        $data = $data->get();
        return response()->json([
            'draw' => $request->input('draw'),
            'data' => $data,
            'recordsTotal' => $rekamTotal,
            'recordsFiltered' => $rekamFilter
        ]);
    }

    public function tambah_infaq_masjid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'kategori_id' => 'required',
            'jenis' => 'required',
            'satuan' => 'required',
        ], [
            'tanggal.required' => 'Wajib diisi',
            'kategori_id.required' => 'Wajib diisi',
            'jenis.required' => 'Wajib diisi',
            'satuan.required' => 'Wajib diisi',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            Infaq::create([
                'kode' => $this->generateUniqueCode(),
                'masjid_id' => Auth::user()->masjid_id,
                'tanggal' => $request->tanggal,
                'kategori_id' => $request->kategori_id,
                'jenis' => help_hapus_spesial_karakter($request->jenis),
                'satuan' => help_hapus_spesial_karakter($request->satuan),
                'jumlah' => help_hapus_format_rupiah($request->jumlah),
                'keterangan' => help_hapus_spesial_karakter($request->keterangan)
            ]);

            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Menambahkan Data'
            ]);
        }
    }

    public function generateUniqueCode()
    {
        do {
            $referal_code = random_int(10000000000000000, 99999999999999999);
        } while (Infaq::where("kode", "=", $referal_code)->first());

        return $referal_code;
    }

    public function tampirincian_l_data_infaq_masjid($infaq_id)
    {
        $data_rincian_infaq_masjid = Infaq::where('id', $infaq_id)->first();
        return response()->json([
            'data' => $data_rincian_infaq_masjid
        ]);
    }

    public function proses_ubah_data_infaq_masjid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'ubah_kategori_id' => 'required',
            'jenis' => 'required',
            'satuan' => 'required',
        ], [
            'tanggal.required' => 'Wajib diisi',
            'ubah_kategori_id.required' => 'Wajib diisi',
            'jenis.required' => 'Wajib diisi',
            'satuan.required' => 'Wajib diisi',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_infaq_masjid = Infaq::where('id', $request->infaq_id)->first();
            $data_infaq_masjid->update([
                'tanggal' => $request->tanggal,
                'kategori_id' => $request->ubah_kategori_id,
                'jenis' => help_hapus_spesial_karakter($request->jenis),
                'satuan' => help_hapus_spesial_karakter($request->satuan),
                'jumlah' => help_hapus_format_rupiah($request->jumlah),
                'keterangan' => help_hapus_spesial_karakter($request->keterangan)
            ]);

            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Mengubah Data'
            ]);
        }
    }

    public function hapus_data_infaq_masjid($infaq_id)
    {
        $hapus_infaq_masjid = Infaq::find($infaq_id);
        $hapus_infaq_masjid->delete();
        return response()->json([
            'status_berhasil' => 1,
            'msg'   => 'Berhasil Menghapus Data',
        ]);
    }

    public function rincian_data_infaq_masjid($kode)
    {
        $data_pecahan = PecahanMaster::select(['id', 'pecahan'])->get();
        $data_infaq = Infaq::with('relasi_kategori')->where('kode', $kode)->first();
        $data_infaq_rincian = InfaqRincian::with('relasi_sub_kategori', 'relasi_pecahan', 'relasi_infaq')->where('infaq_id', $data_infaq->id)->get()->groupBy('sub_kategori_id');

        $data_sub_kategori = SubKategori::where('kategori_id', $data_infaq->kategori_id)->with('relasi_infaq_rincian')->get();
        return view('Back.Infaq.data_infaq.rincian_data_infaq.rincian_data_infaq', compact('data_infaq', 'data_sub_kategori', 'data_pecahan', 'data_infaq_rincian'));
    }

    public function tambah_rincian_data_infaq_masjid(Request $request)
    {
        // $rules = [];
        // foreach ($request->input('pecahan') as $key => $value) {
        //     $rules["pecahan.{$key}"] = 'required';
        // }
        // $validator = Validator::make($request->all(), $rules);

        // $produk_variasi = $request->input('produk_variasi');

        // if ($validator->passes()) {
        //     for ($x = 0; $x < count($produk_variasi); $x++) {
        //         $tampung_produk_variasi = $produk_variasi[$x];
        //         $tampung_harga_produk_variasi = $harga_produk_variasi[$x];
        //         $tampung_berat_produk_variasi = $berat_produk_variasi[$x];
        //         $tampung_stok_produk_variasi = $stok_produk_variasi[$x];

        //         if (trim($tampung_produk_variasi) == "" || is_null($tampung_produk_variasi))
        //             continue;
        //             ProdukDetail::create([
        //                 'produk_id' => $tambah_produk->id,
        //                 'produk_variasi' => $tampung_produk_variasi,
        //                 'harga' => $tampung_harga_produk_variasi,
        //                 'berat' => $tampung_berat_produk_variasi,
        //                 'stok'  => $tampung_stok_produk_variasi
        //         ]);
        //     }
        // }

        $data_infaq = Infaq::with('relasi_kategori')->where('id', $request->infaq_id)->first();
        $cek_sub_kategori = SubKategori::where('kategori_id', $data_infaq->kategori_id)->first();
        if ($cek_sub_kategori != null) {
            $validator = Validator::make($request->all(), [
                'sub_kategori_id' => 'required'
            ], [
                'sub_kategori_id.required' => 'Wajib diisi'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'sub_kategori_id' => 'number'
            ], [
                'sub_kategori_id.number' => 'Wajib berisi angka'
            ]);
        }

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_infaq_rincian = InfaqRincian::where([['infaq_id', $request->infaq_id], ['sub_kategori_id', $request->sub_kategori_id]])->first();
            $data_sub_kategori = SubKategori::where('id', $request->sub_kategori_id)->first();

            if ($data_infaq_rincian == null) {
                // DB::beginTransaction();
                foreach ($request->input('pecahan_id') as $key => $value) {
                    $data_pecahan = PecahanMaster::where('id', $request->pecahan_id[$key])->first();
                    InfaqRincian::create(
                        [
                            'infaq_id' => $request->infaq_id,
                            'sub_kategori_id' => $request->sub_kategori_id,
                            'pecahan_id' => $request->pecahan_id[$key],
                            'jumlah' => $request->jumlah[$key],
                            'subtotal' => $request->jumlah[$key] * $data_pecahan->pecahan
                        ]
                    );
                }

                $total_rincian_infaq = InfaqRincian::with('relasi_pecahan')->where('infaq_id', $request->infaq_id)->get();
                $total = 0;
                foreach ($total_rincian_infaq as $hitung_total_rincian_infaq) {
                    $total += $hitung_total_rincian_infaq->jumlah * $hitung_total_rincian_infaq->relasi_pecahan->pecahan;
                }

                $data_infaq = Infaq::where('id', $request->infaq_id)->first();
                $data_infaq->update([
                    'jumlah' => $total
                ]);

                return response()->json([
                    'status_berhasil' => 1,
                    'msg'   => 'Berhasil Menambah Data',
                ]);
                // DB::commit();
            } else {
                return response()->json([
                    'status_gagal' => 1,
                    'msg'   => 'Data infaq dengan sub kategori ' . $data_sub_kategori->sub_kategori . ' telah ada',
                ]);
            }
        }
    }

    public function tampil_data_rincian_infaq_masjid($rincian_infaq_id)
    {
        $data_rincian_infaq_masjid = InfaqRincian::with('relasi_pecahan', 'relasi_sub_kategori', 'relasi_infaq.relasi_kategori')->where('id', $rincian_infaq_id)->first();
        return response()->json([
            'data' => $data_rincian_infaq_masjid
        ]);
    }

    public function proses_ubah_rincian_infaq_masjid(Request $request)
    {
        $data_rincian_infaq_masjid = InfaqRincian::with('relasi_pecahan')->where('id', $request->req_rincian_infaq_masjid_id)->first();
        $data_rincian_infaq_masjid->update([
            'jumlah' => $request->req_jumlah,
            'subtotal' =>  $data_rincian_infaq_masjid->relasi_pecahan->pecahan * $request->req_jumlah
        ]);

        $total_rincian_infaq = InfaqRincian::with('relasi_pecahan')->where('infaq_id', $data_rincian_infaq_masjid->infaq_id)->get();
        $total = 0;
        foreach ($total_rincian_infaq as $hitung_total_rincian_infaq) {
            $total += $hitung_total_rincian_infaq->jumlah * $hitung_total_rincian_infaq->relasi_pecahan->pecahan;
        }

        $data_infaq = Infaq::where('id', $data_rincian_infaq_masjid->infaq_id)->first();
        $data_infaq->update([
            'jumlah' => $total
        ]);

        return response()->json([
            'status_berhasil' => 1,
            'msg' => 'Berhasil Mengubah Data'
        ]);
    }
}
