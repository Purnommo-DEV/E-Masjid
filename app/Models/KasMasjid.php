<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasMasjid extends Model
{
    use HasFactory;
    protected $table = "kas";
    protected $guarded = ["id"];

    public function relasi_masjid()
    {
        return $this->belongsTo(Masjid::class, 'masjid_id', 'id');
    }

    public function relasi_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
