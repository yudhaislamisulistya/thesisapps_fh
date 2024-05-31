<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class Helper
{

    // get tanggal 1-31
    // public static function fortgl() {
    //     for($i=1; $i<=31; $i++){
    //         $data[] = $i;
    //     }
    //     return $data;
    // }
    // get tahun 1945-sekarang
    // public static function forthn() {
    //     for($i=date('Y'); $i>='1935'; $i--){
    //         $data[] = $i;
    //     }
    //     return $data;
    // }
    // 01- januari- 2018

    public static function tgl_indo($tgl)
    {
        $tanggal = substr($tgl, 8, 2);
        $bulan = Helper::getBulan((int) substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        $tgl = $tanggal . " " . $bulan . " " . $tahun;
        if ($tgl != "--") {
            return $tanggal . " " . $bulan . " " . $tahun;
        }
    }

    public static function getHariNew($hari)
    {
    }

    // tahun - bulan -tanggal

    public static function getBulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

    // tanggal -bulan -tahun

    public static function tgl($tgl)
    {
        $tanggal = substr($tgl, 3, 2);
        $bulan = substr($tgl, 0, 2);
        $tahun = substr($tgl, 6, 2);
        if ($tgl == '') {
            return null;
        } else {
            return "20" . $tahun . "-" . $bulan . "-" . $tanggal;
        }
    }

    public static function tgl1($tgl)
    {
        $tanggal = substr($tgl, 8, 2);
        $bulan = substr($tgl, 5, 2);
        $tahun = substr($tgl, 0, 4);
        if ($tgl == '') {
            return null;
        } else {
            return $tanggal . "-" . $bulan . "-" . $tahun;
        }
    }

    public static function tgl1_new($tgl)
    {
        $tanggal = substr($tgl, 8, 2);
        $bulan = substr($tgl, 5, 2);
        $tahun = substr($tgl, 0, 2);
        if ($tgl == '') {
            return null;
        } else {
            return $tanggal . "-" . $bulan . "-" . $tahun;
        }
    }

    public static function bln($tgl)
    {
        $bulan = Helper::getBulan(substr($tgl, 5, 2));
        return $bulan;
    }

    public static function thn($tgl)
    {
        $tahun = substr($tgl, 0, 4);
        return $tahun;
    }

    // fungsi upload gambar produk

    public static function uploadImage($image, $folder, $fileold)
    {
        $tgl = date('Y-m-d');
        $file = ['file' => $image];
        $rules = ['file' => 'mimes:jpeg,jpg,gif,png'];
        $validator = Validator::make($file, $rules);

        if ($validator->fails() or $image == null) {
            $fileName = $fileold == '' ? '' : $fileold;
        } else {
            $extension = strstr($image->getClientOriginalName(), '.');
            $uniq = uniqid();
            $fileName = $tgl . "-" . $uniq . $extension;
            $fileName = str_replace('-', '', $fileName);

            $image->move($folder, $fileName);
            // list($w, $h) = getimagesize($folder.$fileName);
            // $w = $w / 2;
            // $h = $h / 2;
            //  // open an image file
            // $img_medium = Image::make($folder.$fileName);
            // // resize image instance
            // $img_medium->resize($w, $h);
            // // save image in desired format
            // $img_medium->save($folder."medium/".$fileName);

            // $w = $w / 2;
            // $h = $h / 2;
            //  // open an image file
            // $img_small = Image::make($folder.$fileName);
            // // resize image instance
            // $img_small->resize($w, $h);
            // // save image in desired format
            // $img_small->save($folder."small/".$fileName);

            Helper::DeleteImage($fileold, $folder);
        }
        return $fileName;
    }

    // delete foto produk
    public static function deleteImage($image, $folder)
    {
        File::delete($folder . $image);
        // File::delete($folder."medium/".$image);
        // File::delete($folder."small/".$image);
    }

    public static function uploadFile($image, $path, $file_old)
    {
        $tgl = date('Y-m-d');
        $file = ['file' => $image];
        $rules = ['file' => 'mimes:pdf,xls,doc,docx,pptx,pps,jpeg,bmp,png,xlsx,zip,rar'];
        $validator = Validator::make($file, $rules);

        if ($validator->fails() or $image == null) {
            $fileName = $file_old == '' ? '' : $file_old;
        } else {
            $extension = strstr($image->getClientOriginalName(), '.');
            $uniq = uniqid();
            $fileName = $tgl . "_" . $uniq . $extension;
            $image->move($path, $fileName);
            Helper::deleteFile($file_old, $path);
        }
        return $fileName;
    }

    public static function deleteFile($file, $path)
    {
        File::delete($path . $file);
    }

    public static function Option($kode)
    {
        $Model = DB::table('option')->select('option', 'deskripsi')->where('kode', '=', $kode)->orderBy('urutan', 'asc')->get();
        return isset($Model) ? $Model : "";
    }

    public static function noRegister($tabel, $key)
    {
        $v = DB::table($tabel)->select('no_reg', 'created_at')->where('no_reg', '<>', '')->orderBy($key, 'desc')->first();
        $no = isset($v->no_reg) ? $v->no_reg : '';
        $tgl = isset($v->created_at) ? $v->created_at : '';
        if (substr($tgl, 0, 4) == date('Y')) {
            $no = (int) substr($no, -4);
            $no++;
        } else {
            $no = "0001";
        }
        return sprintf("%04s", $no);
    }

    public static function nomor($tabel, $no_reg, $kode, $kd)
    {
        $v = DB::table($tabel)->select($no_reg, 'created_at')->where($no_reg, '<>', '')->orderBy('id', 'desc')->first();
        $no = isset($v->$no_reg) ? $v->$no_reg : '';
        $tgl = isset($v->created_at) ? $v->created_at : '';
        if (substr($tgl, 0, 7) == date('Y-m')) {
            $jml = 1 + (strlen($kode));
            $no = (int) substr($no, $jml, 3);
            $no++;
        } else {
            $no = "001";
        }
        return $kode . '-' . sprintf("%03s", $no) . $kd . date('m/Y');
    }

    public static function nomorKep($kode)
    {
        $v = DB::table('surat_keputusan_wja')->select('no_surat', 'tipe_surat', 'created_at')->where('no_surat', '<>', '')->where('tipe_surat', $kode)->orderBy('id', 'desc')->first();
        $no = isset($v->no_surat) ? $v->no_surat : '';
        $tgl = isset($v->created_at) ? $v->created_at : '';
        if (substr($tgl, 0, 7) == date('Y-m')) {
            $no = (int) substr($no, -17, 3);
            $no++;
        } else {
            $no = "001";
        }
        return 'KEP-' . $kode . '-' . sprintf("%03s", $no) . '/B/WJA/' . date('m/Y');
    }

    public static function nomorReg($tabel, $kode, $id)
    {
        $v = DB::table($tabel)->select('no_reg', 'created_at')->where('no_reg', '<>', '')->where('no_reg', 'like', '%' . $kode . '%')->orderBy($id, 'desc')->first();
        $no = isset($v->no_reg) ? $v->no_reg : '';
        $tgl = isset($v->created_at) ? $v->created_at : '';
        if (substr($tgl, 0, 7) == date('Y-m')) {
            $no = (int) substr($no, -4);
            $no++;
            // dd($no);
        } else {
            $no = "0001";
        }
        return $kode . '-' . sprintf("%04s", $no);
    }

    public static function getDeskripsi($id)
    {
        $v = DB::table('t_mst_dosen')
            ->select('*')
            ->Where('C_KODE_DOSEN', $id)
            ->first();
        return isset($v) ? $v->NAMA_DOSEN : '--';
    }

    public static function getNamaMhs($id)
    {
        $v = DB::table('t_mst_mahasiswa')
            ->select('*')
            ->Where('C_NPM', $id)
            ->first();
        return isset($v) ? $v->NAMA_MAHASISWA : '';
    }

    // fungsi implode
    public static function gabungBidang($id)
    {
        $kepada = '';
        if ($id != '') {
            foreach ($id as $v) {
                if ($v != '') {
                    $option = $v;
                    if ($kepada == null) {
                        $kepada = $option;
                    } else {
                        $kepada = $kepada . ',' . $option;
                    }
                }
            }
        }
        return isset($kepada) ? $kepada : "";
    }

    // fungsi implode
    public static function getHari($tgl)
    {
        $daftar_hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $tgl = str_replace('-', '/', $tgl);
        $namahari = date('l', strtotime($tgl));

        return $daftar_hari[$namahari];
    }

    public static function rekap($tglm, $tgls, $asal, $tujuan, $sifat)
    {
        if ($asal == '1') {
            if ($tujuan == 'all') {
                $Model = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get();
            } else {
                $Model = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('sifat_surat', $sifat)->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get();
            }
        } elseif ($asal == '2') {
            if ($sifat == '') {
                $Model = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('tujuan', $tujuan)->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get();
            } else {
                $Model = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('tujuan', $tujuan)->where('sifat_surat', $sifat)->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get();
            }
        } elseif ($asal == '3') {
            if ($sifat == '') {
                $Model = DB::table('surat_masuk')->select('id')->where('wilayah', '=', '4')->where('tujuan', $tujuan)->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get();
            } else {
                $Model = DB::table('surat_masuk')->select('id')->where('wilayah', '=', '4')->where('tujuan', $tujuan)->where('sifat_surat', $sifat)->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get();
            }
        } elseif ($asal == '4') {
            if ($sifat != '') {
                $data1 = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('sifat_surat', $sifat)->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get()->count();
                $data2 = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('sifat_surat', $sifat)->where('tujuan', 'ja')->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get()->count();
                $data3 = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('sifat_surat', $sifat)->where('tujuan', 'wja')->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get()->count();
                $data4 = DB::table('surat_masuk')->select('id')->where('wilayah', '=', '4')->where('sifat_surat', $sifat)->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get()->count();
            } else {
                $data1 = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get()->count();
                $data2 = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('tujuan', 'ja')->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get()->count();
                $data3 = DB::table('surat_masuk')->select('id')->where('wilayah', '<>', '4')->where('tujuan', 'wja')->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get()->count();
                $data4 = DB::table('surat_masuk')->select('id')->where('wilayah', '=', '4')->where('tgl_masuk', '>=', $tglm)->where('tgl_masuk', '<=', $tgls)->get()->count();
            }
            $data = $data1 + $data2 + $data3 + $data4;
            return $data;
        }
        $data = $Model->count();
        return ($data != 0) ? $data : '';
    }

    public static function cekNosurat($table, $no_surat)
    {
        if ($no_surat != '') {
            $Model = DB::table($table)->select('no_surat')->where('no_surat', '=', $no_surat)->first();
        }
        return isset($Model) ? $Model : "";
    }

    public static function getJabatanFungsionalByNIDN($nidn)
    {
        $v = DB::table('t_mst_dosen')
            ->select('*')
            ->Where('C_KODE_DOSEN', $nidn)
            ->first();
        return isset($v) ? $v->jabatan_fungsional . " / " . $v->website : '';
    }

    public static function getNomorSkPerMhs($bimbingan_id)
    {
        $v = DB::table('mst_sk_pembimbing')
            ->select('*')
            ->Where('bimbingan_id', $bimbingan_id)
            ->first();
        return isset($v) ? $v->nomor_sk : '';
    }

    public static function getStatusSuratUsulan($nomor)
    {
        $data = DB::table('trt_bimbingan')
            ->join('trt_sk', 'trt_sk.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->select('*')
            ->where('nomor', $nomor)
            ->get();

        $data_sk_selesai = DB::table('trt_bimbingan')
            ->join('trt_sk', 'trt_sk.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->join('mst_sk_pembimbing', 'mst_sk_pembimbing.bimbingan_id', '=', 'trt_sk.bimbingan_id')
            ->select('*')
            ->where('nomor', $nomor)
            ->get();

        $status = "";
        if (count($data) == count($data_sk_selesai)) {
            $status = '<i class="fa fa-check-circle text-success"></i>';
        } else {
            $status = '<i class="fa fa-times-circle text-danger"></i>';
        }

        return $status;
    }

    public static function getStatusSuratUsulanTIMUjianTa($id, $nomor)
    {
        $data = DB::select('SELECT * FROM trt_sk_ujian_ta, trt_reg, trt_bimbingan WHERE trt_sk_ujian_ta.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND  trt_sk_ujian_ta.pendaftaran_id = ? AND trt_sk_ujian_ta.nomor = ?', [$id, $nomor]);

        $data_sk_selesai = DB::select('SELECT * FROM trt_sk_ujian_ta, trt_reg, trt_bimbingan, mst_sk_penugasan WHERE trt_sk_ujian_ta.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND mst_sk_penugasan.bimbingan_id = trt_bimbingan.bimbingan_id AND  trt_sk_ujian_ta.pendaftaran_id = ? AND trt_sk_ujian_ta.nomor = ?', [$id, $nomor]);




        $status = "";
        if (count($data) == count($data_sk_selesai)) {
            $status = '<i class="fa fa-check-circle text-success"></i>';
        } else {
            $status = '<i class="fa fa-times-circle text-danger"></i>';
        }

        return $status;
    }

    public static function getProgramStudiByNim($nim)
    {
        $v = DB::table('t_mst_mahasiswa', 'trt_prodi')
            ->select('*')
            ->join('trt_prodi', 'trt_prodi.kode_prodi', '=', 't_mst_mahasiswa.C_KODE_PRODI')
            ->where('t_mst_mahasiswa.C_NPM', $nim)
            ->first();
        return isset($v) ? $v->nama : '';
    }

    public static function getNomorSkPenugasanPerMhs($bimbingan_id)
    {
        $v = DB::table('mst_sk_penugasan')
            ->select('*')
            ->Where('bimbingan_id', $bimbingan_id)
            ->first();
        return isset($v) ? $v->nomor_sk : '';
    }

    public static function tgl_indo_lengkap($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
        return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
    }

    public static function getJudulTugasAkhirByNim($nim)
    {
        $v = DB::table('trt_bimbingan')
            ->select('*')
            ->Where('C_NPM', $nim)
            ->first();
        return isset($v) ? $v->judul : '';
    }

    public static function getSaranByNidnAndRegId($nidn, $reg_id)
    {
        $v = DB::table('trt_hasil')
            ->select('*')
            ->Where('nidn', $nidn)
            ->Where('reg_id', $reg_id)
            ->first();
        return isset($v) ? $v->saran : '-';
    }

    public static function getTotalNilaByNidnAndRegId($nidn, $reg_id)
    {
        $v = DB::table('trt_hasil')
            ->select('*')
            ->Where('nidn', $nidn)
            ->Where('reg_id', $reg_id)
            ->first();


        return isset($v) ? ($v->nilai_1 + $v->nilai_2  + $v->nilai_3  + $v->nilai_4 + $v->nilai_5) : 0;
    }

    public static function getStatusBimbinganByNim($nim)
    {
        $v = DB::table('trt_bimbingan')
            ->select('*')
            ->Where('C_NPM', $nim)
            ->first();
        return isset($v) ? $v->status_bimbingan : '999';
    }

    public static function getJumlahTrtHasil($reg_id)
    {
        $v = DB::table('trt_hasil')
            ->select('*')
            ->Where('reg_id', $reg_id)
            ->get();

        return isset($v) ? count($v) : '';
    }

    public static function getNomorSkByNIM($nim)
    {
        $v = DB::table('trt_bimbingan')
            ->select("*")
            ->where('trt_bimbingan.bimbingan_id', 'mst_sk_pembimbing.bimbingan_id')
            ->where('trt_bimbingan.C_NPM', $nim)
            ->get();
        return isset($v) ? $v->nomor_sk : '-';
    }

    public static function getRuanganByNim($nim)
    {
        $v = DB::table('trt_jadwal_ujian_per_mhs')
            ->join('trt_jadwal_ujian', 'trt_jadwal_ujian.id', '=', 'trt_jadwal_ujian_per_mhs.jadwal_ujian')
            ->select("*")
            ->where('trt_jadwal_ujian_per_mhs.C_NPM', $nim)
            ->where('trt_jadwal_ujian.status', 0)
            ->first();
        return $v;

        if ($v == null) {
            return '-';
        } else {
            return $v->ruangan;
        }
    }

    public static function getRuanganUjianTAByNim($nim)
    {
        $v = DB::table('trt_jadwal_ujian_per_mhs')
            ->join('trt_jadwal_ujian', 'trt_jadwal_ujian.id', '=', 'trt_jadwal_ujian_per_mhs.jadwal_ujian')
            ->select("*")
            ->where('trt_jadwal_ujian_per_mhs.C_NPM', $nim)
            ->where('trt_jadwal_ujian.status', 2)
            ->first();
        return $v;

        if ($v == null) {
            return '-';
        } else {
            return $v->ruangan;
        }
    }

    public static function getTotalUsulanJudulFromDosen($kode_dosen)
    {
        $v = DB::table('trt_usulan_judul')
            ->select("*")
            ->where('trt_usulan_judul.KODE_DOSEN', $kode_dosen)
            ->get();
        return isset($v) ? $v : '0';
    }

    public static function get5Pengumuman()
    {
        $v = DB::table('mst_pengumuman')
            ->select("*")
            ->limit(5)
            ->orderBy('last_update', 'desc')
            ->get();
        return isset($v) ? $v : 'Tidak Ada Pengumuman';
    }

    public static function getStatusBimbinganByStatus($status)
    {
        $v = DB::table('trt_bimbingan')
            ->select("*")
            ->where('trt_bimbingan.status_bimbingan', $status)
            ->get();
        return isset($v) ? $v : '-';
    }

    public static function getStatusBimbinganByStatusTi($status)
    {
        $v = DB::table('trt_bimbingan')
            ->select("*")
            ->where('trt_bimbingan.status_bimbingan', $status)
            ->where('trt_bimbingan.C_NPM', 'LIKE', '040%')
            ->get();
        return isset($v) ? $v : '-';
    }

    public static function getStatusBimbinganByStatusSi($status)
    {
        $v = DB::table('trt_bimbingan')
            ->select("*")
            ->where('trt_bimbingan.status_bimbingan', $status)
            ->where('trt_bimbingan.C_NPM', 'LIKE', '131%')
            ->get();
        return isset($v) ? $v : '-';
    }

    public static function getStatusAkunPerMahasiswa($nim)
    {
        $data = DB::table('users')
            ->select('*')
            ->where('users.name', $nim)
            ->first();
        $status = "";
        if ($data == null || $data == '') {
            $status = '<i class="fa fa-times-circle text-danger"></i>';
        } else {
            $status = '<i class="fa fa-check-circle text-success"></i>';
        }
        return $status;
    }

    public static function getPengujiByNim($nim)
    {
        $v = DB::table('trt_penguji')
            ->select("*")
            ->where('trt_penguji.C_NPM', $nim)
            ->get();
        return isset($v) ? $v : '-';
    }

    public static function getMahasiswaByPenguji($kode_dosen)
    {
        $v = DB::table('trt_penguji')
            ->select("trt_penguji.C_NPM")
            ->where('trt_penguji.penguji_I_id', $kode_dosen)
            ->orWhere('trt_penguji.penguji_II_id', $kode_dosen)
            ->orWhere('trt_penguji.penguji_III_id', $kode_dosen)
            ->distinct()
            ->get();
        return isset($v) ? $v : '-';
    }

    public static function getNomorSkPerMhsFromTrtPenguji($nim)
    {
        $v = DB::table('trt_penguji')
            ->select("trt_penguji.nomor_sk")
            ->where('trt_penguji.C_NPM', $nim)
            ->where('trt_penguji.tipe_ujian', 0)
            ->first();
        return isset($v) ? $v->nomor_sk : '';
    }

    public static function getNomorSkPerMhsFromTrtPengujiSeminar($nim)
    {
        $v = DB::table('trt_penguji')
            ->select("trt_penguji.nomor_sk")
            ->where('trt_penguji.C_NPM', $nim)
            ->where('trt_penguji.tipe_ujian', 1)
            ->first();
        return isset($v) ? $v->nomor_sk : '';
    }

    public static function getStatusPenilaianPerDosen($nim, $reg_id)
    {
        $data = DB::table('trt_hasil')
            ->select('*')
            ->where('trt_hasil.nidn', $nim)
            ->where('trt_hasil.reg_id', $reg_id)
            ->first();
        $status = "";
        if ($data == null || $data == '') {
            $status = "<i class='fa fa-times-circle text-danger'></i>";
        } else {
            $status = "<i class='fa fa-check-circle text-success'></i>";
        }
        return $status;
    }

    public static function getPenilaianPerDosen($nim, $reg_id)
    {
        $data = DB::table('trt_hasil')
            ->select('*')
            ->where('trt_hasil.nidn', $nim)
            ->where('trt_hasil.reg_id', $reg_id)
            ->first();
        $status = "";
        if ($data == null || $data == '') {
            $status = "Belum Dinilai";
        } else {
            $status = "Sudah Dinilai";
        }
        return $status;
    }

    public static function getDataSuratUsulanTa($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();
        $data = DB::select("SELECT * FROM mst_pendaftaran,trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa , trt_jadwal_ujian, trt_jadwal_ujian_per_mhs , mst_ruangan WHERE mst_ruangan.id =  trt_jadwal_ujian_per_mhs.ruangan AND trt_bimbingan.C_NPM = trt_jadwal_ujian_per_mhs.C_NPM AND trt_jadwal_ujian.id = trt_jadwal_ujian_per_mhs.jadwal_ujian AND trt_jadwal_ujian.pendaftaran_id = trt_reg.pendaftaran_id AND mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND trt_reg.pendaftaran_id = ? AND trt_reg.status = ?", [$id, $info->tipe_ujian]);

        return $data;
    }

    public static function getPendaftaranIdForMahasiswa($tipe_ujian)
    {
        $v = DB::table('trt_bimbingan')
            ->select('trt_reg.pendaftaran_id')
            ->join("trt_reg", 'trt_reg.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->where('trt_bimbingan.C_NPM', auth()->user()->name)
            ->where('trt_reg.status', $tipe_ujian)
            ->first();
        return isset($v) ? $v->pendaftaran_id : '';
    }

    public static function getPendaftaranIdForDosen($nim, $tipe_ujian)
    {
        $v = DB::table('trt_bimbingan')
            ->select('trt_reg.pendaftaran_id')
            ->join("trt_reg", 'trt_reg.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->where('trt_bimbingan.C_NPM', $nim)
            ->where('trt_reg.status', $tipe_ujian)
            ->first();
        return isset($v) ? $v->pendaftaran_id : '';
    }

    public static function getStatusSKPembimbingForMahasiswa($nim)
    {
        $v = DB::table('mst_sk_pembimbing')
            ->select(["mst_sk_pembimbing.status", "mst_sk_pembimbing.nomor_sk"])
            ->join("trt_bimbingan", 'trt_bimbingan.bimbingan_id', '=', 'mst_sk_pembimbing.bimbingan_id')
            ->where('trt_bimbingan.C_NPM', $nim)
            ->first();
        return isset($v) ? $v : '';
    }

    public static function getStatusSKUjianProposalForMahasiswa($nim)
    {
        $v = DB::table('trt_penguji')
            ->select("trt_penguji.nomor_sk")
            ->where('trt_penguji.C_NPM', $nim)
            ->where('trt_penguji.tipe_ujian', 0)
            ->first();
        return isset($v) ? $v->nomor_sk : '';
    }

    public static function getStatusSKUjianSeminarForMahasiswa($nim)
    {
        $v = DB::table('trt_penguji')
            ->select("trt_penguji.nomor_sk")
            ->where('trt_penguji.C_NPM', $nim)
            ->where('trt_penguji.tipe_ujian', 1)
            ->first();
        return isset($v) ? $v->nomor_sk : '';
    }

    public static function getStatusSKUjianMejaForMahasiswa($nim)
    {
        $v = DB::table('mst_sk_penugasan')
            ->select(["mst_sk_penugasan.status", "mst_sk_penugasan.nomor_sk"])
            ->join("trt_bimbingan", 'trt_bimbingan.bimbingan_id', '=', 'mst_sk_penugasan.bimbingan_id')
            ->where('trt_bimbingan.C_NPM', $nim)
            ->first();
        return isset($v) ? $v : '';
    }

    public static function getStatusApproveWakilDekan($id)
    {
        $v = DB::table('mst_sk_pembimbing')
            ->select("mst_sk_pembimbing.status")
            ->where('mst_sk_pembimbing.sk_pembimbing_id', $id)
            ->first();
        return isset($v) ? $v->status : '';
    }

    public static function getStatusFromSkPenugasan($id)
    {
        $v = DB::table('mst_sk_penugasan')
            ->select("mst_sk_penugasan.status")
            ->where('mst_sk_penugasan.sk_penugasan_id', $id)
            ->first();
        return isset($v) ? $v->status : '';
    }

    public static function getNomorSkProdi($nim)
    {
        $v = DB::table('trt_penguji')
            ->select("trt_penguji.nomor_sk")
            ->where('trt_penguji.C_NPM', $nim)
            ->first();
        return isset($v) ? $v->nomor_sk : 'Belum Ada';
    }

    public static function getNomorSKWithBimbinganId($id)
    {
        $v = DB::table('trt_sk')
            ->select("trt_sk.nomor")
            ->where('trt_sk.bimbingan_id', $id)
            ->first();
        return isset($v) ? $v->nomor : '';
    }

    public static function getNomorSKPenugasanWithBimbinganId($id)
    {
        $v = DB::table('trt_sk_ujian_ta')
            ->select("trt_sk_ujian_ta.nomor")
            ->where('trt_sk_ujian_ta.pendaftaran_id', $id)
            ->first();
        return isset($v) ? $v->nomor : '';
    }

    public static function getStatusTolakBimbinganProposalByNim($nim)
    {
        $v = DB::table('trt_bimbingan')
            ->select("trt_bimbingan.status_tolak_proposal")
            ->where('trt_bimbingan.C_NPM', $nim)
            ->first();
        return isset($v) ? $v->status_tolak_proposal : '';
    }

    public static function getStatusTolakBimbinganSeminarByNim($nim)
    {
        $v = DB::table('trt_bimbingan')
            ->select("trt_bimbingan.status_tolak_seminar")
            ->where('trt_bimbingan.C_NPM', $nim)
            ->first();
        return isset($v) ? $v->status_tolak_seminar : '';
    }

    public static function getStatusTolakBimbinganMejaByNim($nim)
    {
        $v = DB::table('trt_bimbingan')
            ->select("trt_bimbingan.status_tolak_meja")
            ->where('trt_bimbingan.C_NPM', $nim)
            ->first();
        return isset($v) ? $v->status_tolak_meja : '';
    }

    public static function getDataPesanMasuk($nim)
    {
        $v = DB::table('trt_konsultasi')
            ->select("*")
            ->where('trt_konsultasi.penerima_id', $nim)
            ->where('trt_konsultasi.status_baca', 0)
            ->get();
        return isset($v) ? count($v) : '0';
    }

    public static function getDataPesanKeluar($nim)
    {
        $v = DB::table('trt_konsultasi')
            ->select("*")
            ->where('trt_konsultasi.pengirim_id', $nim)
            ->where('trt_konsultasi.status_baca', 0)
            ->get();
        return isset($v) ? count($v) : '0';
    }

    public static function getNilaiKetuaSidangByDosen($dosen, $reg_id)
    {
        $v = DB::table('trt_hasil')
            ->select("*")
            ->where('trt_hasil.nidn', $dosen)
            ->where('trt_hasil.reg_id', $reg_id)
            ->first();
        return isset($v) ? $v : '0';
    }

    public static function getPeriodePendaftaranByStatusUjian($status_ujian, $tipe_ujian)
    {
        $v = DB::table('mst_pendaftaran')
            ->select("*")
            ->where('status_ujian', $status_ujian)
            ->where('tipe_ujian', $tipe_ujian)
            ->get();

        return $v;
    }

    //  Mengecek Status Konfirmasi Pada Usulan Judul Berdasarkan NIM
    public static function getStatusKonfirmasiTopikPenelitian($nim)
    {
        $v = DB::table('trt_topik')
            ->select('status')
            ->where('C_NPM', $nim)
            ->where('status', 1)
            ->first();
        return isset($v) ? $v->status : '0';
    }


    public static function formatTanggalIndonesia($tanggal)
    {
        // Setel locale Carbon ke bahasa Indonesia
        Carbon::setLocale('id');

        // Array untuk menerjemahkan nama hari
        $hariIndonesia = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        // Array untuk menerjemahkan nama bulan
        $bulanIndonesia = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        // Parse tanggal menggunakan Carbon
        $tanggalCarbon = Carbon::parse($tanggal);

        // Format hari dan bulan
        $hari = $hariIndonesia[$tanggalCarbon->format('l')]; // Mengambil nama hari dalam bahasa Inggris dan menerjemahkannya
        $bulan = $bulanIndonesia[$tanggalCarbon->format('F')]; // Mengambil nama bulan dalam bahasa Inggris dan menerjemahkannya

        // Mengembalikan string tanggal dalam format bahasa Indonesia
        return "{$tanggalCarbon->format('d')} {$bulan} {$tanggalCarbon->format('Y')}";
    }

    // Get All Bidang Ilmu -> mst_bidangilmu
    public static function getAllBidangIlmu()
    {
        $v = DB::table('mst_bidangilmu')
            ->select("*")
            ->get();
        return isset($v) ? $v : '-';
    }

    // Get Bidang Ilmu By bidangilmu_id
    public static function getBidangIlmuById($id)
    {
        $v = DB::table('mst_bidangilmu')
            ->select("*")
            ->where('bidangilmu_id', $id)
            ->first();
        return isset($v) ? $v : '-';
    }

    // Get Dosen by C_KODE_DOSEN -> t_mst_dosen
    public static function getDosenByKodeDosen($kode_dosen)
    {
        $v = DB::table('t_mst_dosen')
            ->select("*")
            ->where('C_KODE_DOSEN', $kode_dosen)
            ->first();
        return isset($v) ? $v : '-';
    }

    // Get users by Email -> users
    public static function getUserByEmail($email)
    {
        $v = DB::table('users')
            ->select("*")
            ->where('email', $email)
            ->first();
        return isset($v) ? $v : '-';
    }

    // Get Deskripsi for Ketua Bidang Ilmu from table users
    public static function getCKodeDosenKetuaBidangIlmu($name)
    {
        $v = DB::table('users')
            ->select("*")
            ->where('name', $name)
            ->first();
        $kode_dosen = substr($v->email, 0, strpos($v->email, '@'));
        return isset($v) ? $kode_dosen : '-';
    }

    public static function getBidangIlmubyBidangIlmu($bidangilmu)
    {
        $v = DB::table('mst_bidangilmu')
            ->select("*")
            ->whereRaw("LOWER(REPLACE(mst_bidangilmu.bidang_ilmu, ' ', '')) = ?", [$bidangilmu])
            ->first();
        return isset($v) ? $v : '-';
    }
}

// Menghilngkan Tag HTML
