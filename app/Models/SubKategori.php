<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    use HasFactory;
    protected $table = "sub_kategori";
    protected $guarded = ["id"];

    public function relasi_infaq_rincian()
    {
        return $this->hasOne(InfaqRincian::class);
    }
}
