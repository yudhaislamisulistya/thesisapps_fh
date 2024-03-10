<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class mst_ruangan extends Model
{
    protected $table = 'mst_ruangan';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nama_ruangan'];
}
