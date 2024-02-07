<?php

use App\Http\Controllers\Auth\Auth_LoginController;
use App\Http\Controllers\Auth\Auth_RegisterController;
use App\Http\Controllers\Back\Back_InfaqMasjidController;
use App\Http\Controllers\Back\Back_KasMasjidController;
use App\Http\Controllers\Back\Back_KategoriInfaqController;
use App\Http\Controllers\Back\Back_ProfilController;
use App\Http\Controllers\Back\Back_ProfilMasjidController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware(['guest'])->group(function () {
    Route::get('/register', [Auth_RegisterController::class, 'halaman_register'])->name('HalamanRegister');
    Route::post('/proses-register', [Auth_RegisterController::class, 'proses_register'])->name('ProsesRegister');

    Route::controller(Auth_LoginController::class)->group(function () {
        Route::get('/login', 'halaman_login')->name('HalamanLogin');
        Route::post('/proses-login', 'proses_login')->name('ProsesLogin');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/proses-logout', [Auth_LoginController::class, 'proses_logout'])->name('ProsesLogout');

    Route::prefix('admin')->name('admin.')->middleware(['isAdmin'])->group(function () {
        Route::controller(Back_ProfilMasjidController::class)->group(function () {
            Route::get('/profil-masjid', 'profil_masjid')->name('ProfilMasjid');
            Route::post('/simpan-profil-masjid', 'proses_simpan_profil_masjid')->name('ProsesSimpanProfilMasjid');
        });
        Route::controller(Back_KasMasjidController::class)->group(function () {
            Route::get('/kas-masjid', 'kas_masjid')->name('HalamanKasMasjid');
            Route::post('/tambah-kas-masjid', 'tambah_kas_masjid')->name('TambahDataKasMasjid');
            Route::any('/data-kas-masjid', 'data_kas_masjid')->name('DataKasMasjid');
            Route::get('/tampil-data-kas-masjid/{paket_pakjak_id}', 'tampil_data_kas_masjid');
            Route::post('/proses-ubah-kas-masjid', 'proses_ubah_data_kas_masjid')->name('ProsesUbahKasMasjid');
            Route::get('/hapus-data-kas-masjid/{paket_pakjak_id}', 'hapus_data_kas_masjid');
        });

        Route::controller(Back_KategoriInfaqController::class)->group(function () {
            Route::get('/kategori', 'kategori')->name('InformasiInfaq.HalamanKategori');
            Route::post('/tambah-kategori', 'tambah_kategori')->name('TambahDataKategori');
            Route::any('/data-kategori', 'data_kategori')->name('DataKategori');
            Route::get('/tampil-data-kategori/{kategori_id}', 'tampil_data_kategori');
            Route::post('/proses-ubah-kategori', 'proses_ubah_data_kategori')->name('ProsesUbahKategori');
            Route::get('/hapus-data-kategori/{kategori_id}', 'hapus_data_kategori');

            Route::post('/proses-tambah-sub-kategori', 'proses_tambah_data_sub_kategori')->name('ProsesTambahSubKategori');
            Route::get('/tampil-data-sub-kategori/{sub_kategori_id}', 'tampil_data_sub_kategori');
            Route::post('/proses-ubah-sub-kategori', 'proses_ubah_data_sub_kategori')->name('ProsesUbahSubKategori');
            Route::get('/hapus-data-sub-kategori/{sub_kategori_id}', 'hapus_data_sub_kategori');
        });

        Route::controller(Back_InfaqMasjidController::class)->group(function () {
            Route::get('/infaq', 'infaq')->name('InformasiInfaq.HalamanInfaq.Infaq');
            Route::post('/tambah-infaq-masjid', 'tambah_infaq_masjid')->name('ProsesTambahInfaqMasjid');
            Route::any('/data-infaq-masjid', 'data_infaq_masjid')->name('DataInfaqMasjid');
            Route::get('/tampil-data-infaq-masjid/{infaq_id}', 'tampil_data_infaq_masjid');
            Route::post('/proses-ubah-infaq-masjid', 'proses_ubah_data_infaq_masjid')->name('ProsesUbahInfaqMasjid');
            Route::get('/hapus-data-infaq-masjid/{infaq_id}', 'hapus_data_infaq_masjid');


            Route::get('/rincian-infaq-masjid/{kode}', 'rincian_data_infaq_masjid')->name('InformasiInfaq.HalamanInfaq.HalamanRincianInfaq');
            Route::post('/tambah-rincian-infaq-masjid', 'tambah_rincian_data_infaq_masjid')->name('ProsesTambahRincianMasjid');
            Route::get('/tampil-data-rincian-infaq-masjid/{rincian_infaq_id}', 'tampil_data_rincian_infaq_masjid');
            Route::post('/proses-ubah-rincian-infaq-masjid', 'proses_ubah_rincian_infaq_masjid')->name('ProsesUbahRincianMasjid');
        });
    });
});
