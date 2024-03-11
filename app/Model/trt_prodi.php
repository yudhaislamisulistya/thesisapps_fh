<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class trt_prodi extends Model
{
    protected $table = 'trt_prodi';
    protected $primaryKey = 'prodi_id';
    protected $fillable = ['prodi_id', 'kode_prodi', 'nama'];
}
