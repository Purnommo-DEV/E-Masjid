<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Auth_RegisterController extends Controller
{
    public function halaman_register()
    {
        return view('Auth.register');
    }

    public function proses_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ], [
            'nama.required' => 'Nama Wajib diisi',
            'email.required' => 'Email Wajib diisi',
            'email.email' => 'Masukkan Email dengan benar',
            'email.unique' => 'Email yang anda masukkan telah terdaftar',
            'password.required' => 'Password Wajib diisi',
            'password.min' => 'Minimal 8 karakter'
        ]);

        if (!$validator->passes()) {
            return response()->json([
                'status_form_kosong' => 1,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            User::create([
                'nama' => help_hapus_spesial_karakter($request->nama),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 1
            ]);

            return response()->json([
                'status_berhasil' => 1,
                'msg' => 'Berhasil Melakukan Pendaftaran',
                'route' => route('HalamanLogin')
            ]);
        }
    }
}
