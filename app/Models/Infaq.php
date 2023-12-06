<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infaq extends Model
{
    use HasFactory;
    protected $table = "infaq";
    protected $guarded = ["id"];

    public function relasi_masjid()
    {
        return $this->belongsTo(Masjid::class, 'masjid_id', 'id');
    }

    public function relasi_kategori()
    {
        return $this->belongsTo(KategoriInfaq::class, 'kategori_id', 'id');
    }
}
