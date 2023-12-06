<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Models\KategoriInfaq;
use App\Http\Controllers\Controller;
use App\Models\SubKategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Back_KategoriInfaqController extends Controller
{
    public function kategori()
    {
        $data_kategori = KategoriInfaq::where('masjid_id', Auth::user()->masjid_id)->get();
        return view('Back.Infaq.kategori.kategori', compact('data_kategori'));
    }

    // KATEGORI
    public function data_kategori(Request $request)
    {
        $data = KategoriInfaq::select([
            'kategori.*'
        ])->orderBy('created_at', 'desc');

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

    public function tambah_kategori(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required'
        ], [
            'kategori.required' => 'Wajib diisi'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            KategoriInfaq::create([
                'masjid_id' => Auth::user()->masjid_id,
                'kategori' => $request->kategori
            ]);
            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Menambahkan Data'
            ]);
        }
    }

    public function tampil_data_kategori($kategori_id)
    {
        $data_kategori = KategoriInfaq::where('id', $kategori_id)->first();
        return response()->json([
            'data' => $data_kategori
        ]);
    }

    public function proses_ubah_data_kategori(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required'
        ], [
            'kategori.required' => 'Wajib diisi'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_kategori = KategoriInfaq::where('id', $request->kategori_id)->first();
            $data_kategori->update([
                'kategori' => $request->kategori
            ]);

            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Mengubah Data'
            ]);
        }
    }

    public function hapus_data_kategori($kategori_id)
    {
        $hapus_kategori = KategoriInfaq::find($kategori_id);
        $hapus_kategori->delete();
        return response()->json([
            'status_berhasil' => 1,
            'msg'   => 'Berhasil Menghapus Data',
        ]);
    }

    // SUB KATEGORI
    public function proses_tambah_data_sub_kategori(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_kategori' => 'required'
        ], [
            'sub_kategori.required' => 'Wajib diisi'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            SubKategori::create([
                'kategori_id' => $request->kategori_id,
                'sub_kategori' => $request->sub_kategori
            ]);
            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Menambahkan Data'
            ]);
        }
    }

    public function tampil_data_sub_kategori($sub_kategori_id)
    {
        $data_sub_kategori = SubKategori::where('id', $sub_kategori_id)->first();
        return response()->json([
            'data' => $data_sub_kategori
        ]);
    }

    public function proses_ubah_data_sub_kategori(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_kategori' => 'required'
        ], [
            'sub_kategori.required' => 'Wajib diisi'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_sub_kategori = SubKategori::where('id', $request->sub_kategori_id)->first();
            $data_sub_kategori->update([
                'sub_kategori' => $request->sub_kategori
            ]);

            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Mengubah Data'
            ]);
        }
    }

    public function hapus_data_sub_kategori($sub_kategori_id)
    {
        $hapus_kategori = SubKategori::find($sub_kategori_id);
        $hapus_kategori->delete();
        return response()->json([
            'status_berhasil' => 1,
            'msg'   => 'Berhasil Menghapus Data',
        ]);
    }
}
