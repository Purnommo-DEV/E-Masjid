<?php

namespace App\Http\Controllers\Back;

use App\Models\KasMasjid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Back_KasMasjidController extends Controller
{
    public function kas_masjid()
    {
        return view('Back.KasMasjid.kas_masjid');
    }

    public function data_kas_masjid(Request $request)
    {
        $data = KasMasjid::select([
            'kas.*'
        ])->with('relasi_user')->orderBy('created_at', 'desc');

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

    public function tambah_kas_masjid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_transaksi' => 'required',
            'keterangan' => 'required',
            'jenis_transaksi' => 'required|in:keluar,masuk',
            'jumlah' => 'required',
        ], [
            'tanggal_transaksi.required' => 'Wajib diisi',
            'keterangan.required' => 'Wajib diisi',
            'jenis_transaksi.required' => 'Wajib diisi',
            'jumlah.required' => 'Wajib diisi',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            if ($request->hasFile('path')) {
                $filenameWithExt = $request->file('path')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('path')->getClientOriginalExtension();
                $filenameSimpan = $filename . '_' . time() . '.' . $extension;
                $path = $request->file('path')->store('bukti_pembayaran_kas', 'public');
            }
            KasMasjid::create([
                'masjid_id' => Auth::user()->masjid_id,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'keterangan' => help_hapus_spesial_karakter($request->keterangan),
                'jenis_transaksi' => $request->jenis_transaksi,
                'jumlah' => help_hapus_format_rupiah($request->jumlah),
                'created_by' => Auth::user()->id,
                'path' => $path ?? ''
            ]);

            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Menambahkan Data'
            ]);
        }
    }

    public function tampil_data_kas_masjid($kas_id)
    {
        $data_kas_masjid = KasMasjid::where('id', $kas_id)->first();
        return response()->json([
            'data' => $data_kas_masjid
        ]);
    }

    public function proses_ubah_data_kas_masjid(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_transaksi' => 'required',
            'keterangan' => 'required',
            'jenis_transaksi' => 'required|in:keluar,masuk',
            'jumlah' => 'required',
        ], [
            'tanggal_transaksi.required' => 'Wajib diisi',
            'keterangan.required' => 'Wajib diisi',
            'jenis_transaksi.required' => 'Wajib diisi',
            'jumlah.required' => 'Wajib diisi',
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data_kas_masjid = KasMasjid::where('id', $request->kas_id)->first();
            if ($request->hasFile('path')) {
                $filenameWithExt = $request->file('path')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('path')->getClientOriginalExtension();
                $filenameSimpan = $filename . '_' . time() . '.' . $extension;
                $path = $request->file('path')->store('bukti_pembayaran_kas', 'public');
                $posisi_file = 'storage/' . $data_kas_masjid->path;
                if (File::exists($posisi_file)) {
                    File::delete($posisi_file);
                }
            }
            $data_kas_masjid->update([
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'keterangan' => $request->keterangan,
                'jenis_transaksi' => $request->jenis_transaksi,
                'jumlah' => $request->jumlah,
                'path' => $path ?? $data_kas_masjid->path
            ]);

            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Mengubah Data'
            ]);
        }
    }

    public function hapus_data_kas_masjid($kas_masid_id)
    {
        $hapus_kas_masjid = KasMasjid::find($kas_masid_id);
        $path = 'storage/' . $hapus_kas_masjid->path;
        $hapus_kas_masjid->delete();
        return response()->json([
            'status_berhasil' => 1,
            'msg'   => 'Berhasil Menghapus Data',
        ]);
    }
}
