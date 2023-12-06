<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use App\Models\Masjid;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Back_ProfilMasjidController extends Controller
{
    public function profil_masjid()
    {
        $data_masjid = User::with('relasi_masjid')->where('id', Auth::user()->id)->first();
        return view('Back.ProfilMasjid.profil_masjid', compact('data_masjid'));
    }

    public function proses_simpan_profil_masjid(Request $request)
    {
        $data_user = User::where('id', Auth::user()->id)->first();
        if ($data_user->relasi_masjid != null) {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required',
                'alamat' => 'required',
                'telp' => 'required'
            ], [
                'nama.required' => 'Nama Wajib diisi',
                'email.required' => 'Email Wajib diisi',
                'email.email' => 'Masukkan Email dengan benar',
                'alamat.required' => 'Wajib diisi',
                'telp.required' => 'Telepon Wajib diisi',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|email|unique:masjid',
                'alamat' => 'required',
                'telp' => 'required'
            ], [
                'nama.required' => 'Nama Wajib diisi',
                'email.required' => 'Email Wajib diisi',
                'email.email' => 'Masukkan Email dengan benar',
                'email.unique' => 'Email yang anda masukkan telah terdaftar',
                'alamat.required' => 'Wajib diisi',
                'telp.required' => 'Telepon Wajib diisi',
            ]);
        }

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            if ($data_user->relasi_masjid == null) {
                $data_masjid = Masjid::create([
                    'nama' => $request->nama,
                    'slug' => Str::slug($request->nama),
                    'email' => $request->email,
                    'alamat' => $request->alamat,
                    'telp' => $request->telp
                ]);
                $data_user->update([
                    'masjid_id' => $data_masjid->id
                ]);
            } else {
                $data_user->relasi_masjid->update([
                    'nama' => $request->nama,
                    'slug' => Str::slug($request->nama),
                    'email' => $request->email,
                    'alamat' => $request->alamat,
                    'telp' => $request->telp
                ]);
            };
            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Melengkapi Profil Masjid'
            ]);
        }
    }
}
