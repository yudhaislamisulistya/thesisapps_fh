<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class t_mst_dosen extends Model
{
    protected $table = 't_mst_dosen';
    protected $primaryKey = 'id';
    protected $fillable = ['C_KODE_DOSEN', 'C_NIP', 'NAMA_DOSEN', 'C_KODE_PRODI', 'jabatan_id', 'JENIS_KELAMIN', 'TEMPAT_LAHIR', 'TGL_LAHIR', 'kota', 'ALAMAT', 'NO_HP', 'website', 'pendidikan_terakhir', 'waktu_masuk', 'foto', 'jabatan_fungsional', 'ruang', 'user_id', 'C_KODE_KAB_KOTA', 'C_KODE_PROPINSI', 'KODE_POS', 'NO_TELP', 'EMAIL', 'GOLONGAN_DARAH', 'NO_KTP', 'C_KODE_AGAMA', 'NO_NPWP', 'NO_REK_BANK', 'ATAS_NAMA_REK', 'NAMA_BANK', 'NAMA_CAB_BANK', 'AKRONIM_DOSEN', 'C_KODE_STATUS_IKATAN_KERJA', 'C_KODE_STATUS_BEBAN_KERJA_DOSEN', 'SEMESTER_DOSEN_MULAI', 'ADA_SERTIFIKAT_MENGAJAR', 'ADA_SURAT_IJIN_MENGAJAR', 'NIP_PNS', 'KODE_INSTANSI_INDUK', 'C_KODE_STATUS_AKTIF_DOSEN', 'SEMESTER_DOSEN_KELUAR', 'D_FOTO_DOSEN', 'F_AKTIF', 'F_IS_C', 'F_IS_U', 'F_IS_D', 'F_CHANGE_LOG'];
}
