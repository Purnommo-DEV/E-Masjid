<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PecahanMaster extends Model
{
    use HasFactory;
    protected $table = "pecahan_master";
    protected $guarded = ["id"];
}
