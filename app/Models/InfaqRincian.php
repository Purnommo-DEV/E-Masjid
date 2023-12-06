<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfaqRincian extends Model
{
    use HasFactory;
    protected $table = "infaq_rincian";
    protected $guarded = ["id"];

    public function relasi_infaq()
    {
        return $this->belongsTo(Infaq::class, 'infaq_id', 'id');
    }

    public function relasi_sub_kategori()
    {
        return $this->belongsTo(SubKategori::class, 'sub_kategori_id', 'id');
    }

    public function relasi_pecahan()
    {
        return $this->belongsTo(PecahanMaster::class, 'pecahan_id', 'id');
    }
}
