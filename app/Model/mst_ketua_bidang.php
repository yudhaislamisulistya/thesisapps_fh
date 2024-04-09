<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class mst_ketua_bidang extends Model
{
    protected $table = 'mst_ketua_bidang';
    protected $primaryKey = 'id_ketua_bidang';
    protected $fillable = ['id_bidang_ilmu', 'C_KODE_DOSEN', 'ttd'];
}