<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriInfaq extends Model
{
    use HasFactory;
    protected $table = "kategori";
    protected $guarded = ["id"];
}
