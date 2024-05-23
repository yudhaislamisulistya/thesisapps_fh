<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Model\mst_pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Model\mst_sk_pembimbing;
use App\Model\mst_sk_penugasan;
use App\Model\mst_syarat_ujian;
use App\Model\mst_tmp_usulan;
use App\Model\t_mst_mahasiswa;
use App\Model\trt_bimbingan;
use App\Model\trt_hasil;
use App\Model\trt_reg;
use App\Model\trt_sk;
use App\MstRuangan;
use App\TrtJadwalUjian;
use App\TrtJadwalUjianPerMhs;
use App\TrtPengajuanDokumen;
use App\TrtPenguji;
use App\TrtSyaratUjian;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as DB;

class fakultas extends Controller
{

    // Halaman Approve Hasil Ujian TA
    public function rekap_nilai_proposal()
    {
        $data = DB::select("SELECT DISTINCT mst_pendaftaran.pendaftaran_id, mst_pendaftaran.nama_periode, mst_pendaftaran.kuota, mst_pendaftaran.jml_peserta, trt_jadwal_ujian.tgl_ujian FROM mst_pendaftaran, trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa, trt_jadwal_ujian, trt_jadwal_ujian_per_mhs , mst_ruangan WHERE mst_pendaftaran.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND mst_ruangan.id =  trt_jadwal_ujian_per_mhs.ruangan AND trt_bimbingan.C_NPM = trt_jadwal_ujian_per_mhs.C_NPM AND trt_jadwal_ujian.id = trt_jadwal_ujian_per_mhs.jadwal_ujian AND trt_jadwal_ujian.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND mst_pendaftaran.tipe_ujian = ? AND  trt_penguji.tipe_ujian = ? AND trt_reg.status = ? ORDER BY trt_reg.pendaftaran_id", [0, 0, 0]);
        return view('tugasakhir.fakultas.rekap_nilai_proposal', compact('data'));
    }
    // Akhir Approve Hasil Ujian TA

    // Halaman Approve Hasil Ujian TA
    public function detail_rekap_nilai_proposal($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();
        $data = DB::select("SELECT * FROM mst_pendaftaran,trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa WHERE mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND trt_reg.pendaftaran_id = ? AND trt_reg.status = ?", [$id, $info->tipe_ujian]);
        return view('tugasakhir.fakultas.detail_rekap_nilai_proposal', compact("data", "info"));
    }
    // Akhir Approve Hasil Ujian TA

    public function detail_ujian($nim, $tipe_ujian)
    {
        $data = DB::select("SELECT * FROM trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa WHERE trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND trt_penguji.C_NPM = ? AND trt_reg.status = ?", [$nim, $tipe_ujian]);
        return view('tugasakhir.mhs.detail_ujian', compact('data'));
    }

    // Halaman Lembaran Hasil Ujian
    public function lembaran_hasilujian_proposal($pendaftaran_id, $nim, $reg_id)
    {
        $trtjadwalujian = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("trt_jadwal_ujian.pendaftaran_id", $pendaftaran_id)->first();
        $trtjadwalujianpermhs = TrtJadwalUjianPerMhs::join("mst_ruangan", "mst_ruangan.id", "trt_jadwal_ujian_per_mhs.ruangan")
            ->where([
                "C_NPM" => $nim,
                "jadwal_ujian" => $trtjadwalujian->id
            ])->first();
        $trt_bimbingan = trt_bimbingan::where("C_NPM", $nim)->first();
        $mst_pendaftaran = mst_pendaftaran::find($pendaftaran_id);
        $trt_penguji = TrtPenguji::where([
            "C_NPM" => $nim,
            "tipe_ujian" => $mst_pendaftaran->tipe_ujian
        ])->first();

        $ruangan = MstRuangan::find($trtjadwalujianpermhs->ruangan)->nama_ruangan;
        $tgl_ujian = Carbon::parse($trtjadwalujian->tgl_ujian)->formatLocalized("%A, %d %B %Y");
        switch ($mst_pendaftaran->tipe_ujian) {
            case "0":
                $tipe_ujian = "Proposal";
                break;
            case "2":
                $tipe_ujian = "Meja";
                break;
        }

        $reg_id = $reg_id;

        $data_hasil = trt_hasil::where('reg_id', $reg_id)->get();
        $data_dosen_selesai = DB::table('trt_penguji')
            ->select('*')
            ->where('trt_penguji.C_NPM', $nim)
            ->where('trt_penguji.tipe_ujian', 0)
            ->first();

        $data_dosen_pembimbing = DB::table('trt_bimbingan')
            ->select("*")
            ->where("trt_bimbingan.C_NPM", $nim)
            ->first();

        return view("tugasakhir.fakultas.lembaran_hasilujian_proposal", compact(
            "nim",
            "trt_bimbingan",
            "trt_penguji",
            "tipe_ujian",
            "ruangan",
            "tgl_ujian",
            "data_hasil",
            'data_dosen_selesai',
            'reg_id',
            'data_dosen_pembimbing'
        ));
    }
    // Akhir Halaman Lembaran Hasil Ujian

    // Halaman Approve Hasil Ujian TA
    public function rekap_nilai_ujian_ta()
    {
        $data = DB::select("SELECT DISTINCT mst_pendaftaran.pendaftaran_id, mst_pendaftaran.nama_periode, mst_pendaftaran.kuota, mst_pendaftaran.jml_peserta, trt_jadwal_ujian.tgl_ujian FROM mst_pendaftaran, trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa, trt_jadwal_ujian, trt_jadwal_ujian_per_mhs , mst_ruangan WHERE mst_pendaftaran.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND mst_ruangan.id =  trt_jadwal_ujian_per_mhs.ruangan AND trt_bimbingan.C_NPM = trt_jadwal_ujian_per_mhs.C_NPM AND trt_jadwal_ujian.id = trt_jadwal_ujian_per_mhs.jadwal_ujian AND trt_jadwal_ujian.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM  AND mst_pendaftaran.tipe_ujian = ? AND  trt_penguji.tipe_ujian = ? AND trt_reg.status = ? ORDER BY trt_reg.pendaftaran_id", [2, 2, 2]);
        return view('tugasakhir.fakultas.rekap_nilai_ujian_ta', compact('data'));
    }
    // Akhir Approve Hasil Ujian TA

    // Halaman Approve Hasil Ujian TA
    public function detail_rekap_nilai_ujian_ta($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();
        $data = DB::select("SELECT * FROM mst_pendaftaran,trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa WHERE mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND trt_reg.pendaftaran_id = ? AND trt_reg.status = ? ", [$id, $info->tipe_ujian]);
        return view('tugasakhir.fakultas.detail_rekap_nilai_ujian_ta', compact("data", "info"));
    }
    // Akhir Approve Hasil Ujian TA

    // Halaman Lembaran Hasil Ujian
    public function lembaran_hasilujian_ujian_ta($pendaftaran_id, $nim, $reg_id)
    {
        $trtjadwalujian = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("trt_jadwal_ujian.pendaftaran_id", $pendaftaran_id)->first();
        $trtjadwalujianpermhs = TrtJadwalUjianPerMhs::join("mst_ruangan", "mst_ruangan.id", "trt_jadwal_ujian_per_mhs.ruangan")
            ->where([
                "C_NPM" => $nim,
                "jadwal_ujian" => $trtjadwalujian->id
            ])->first();
        $trt_bimbingan = trt_bimbingan::where("C_NPM", $nim)->first();
        $mst_pendaftaran = mst_pendaftaran::find($pendaftaran_id);
        $trt_penguji = TrtPenguji::where([
            "C_NPM" => $nim,
            "tipe_ujian" => $mst_pendaftaran->tipe_ujian
        ])->first();

        $ruangan = MstRuangan::find($trtjadwalujianpermhs->ruangan)->nama_ruangan;
        $tgl_ujian = Carbon::parse($trtjadwalujian->tgl_ujian)->formatLocalized("%A, %d %B %Y");
        switch ($mst_pendaftaran->tipe_ujian) {
            case "0":
                $tipe_ujian = "Proposal";
                break;
            case "2":
                $tipe_ujian = "Meja";
                break;
        }

        $reg_id = $reg_id;

        $data_hasil = trt_hasil::where('reg_id', $reg_id)->get();
        $data_dosen_selesai = DB::table('trt_penguji')
            ->select('*')
            ->where('trt_penguji.C_NPM', $nim)
            ->where('trt_penguji.tipe_ujian', 2)
            ->first();

        $data_dosen_pembimbing = DB::table('trt_bimbingan')
            ->select("*")
            ->where("trt_bimbingan.C_NPM", $nim)
            ->first();

        return view("tugasakhir.fakultas.lembaran_hasilujian_ujian_ta", compact(
            "nim",
            "trt_bimbingan",
            "trt_penguji",
            "tipe_ujian",
            "ruangan",
            "tgl_ujian",
            "data_hasil",
            "reg_id",
            "data_dosen_selesai",
            "data_dosen_pembimbing"
        ));
    }
    // Akhir Halaman Lembaran Hasil Ujian

    // Halaman Ubah Password
    public function ubah_password()
    {
        return view('tugasakhir.fakultas.ubah_password');
    }
    // Akhir Halaman Ubah Passoword

    // Ubah password
    public function ubah_password_post(Request $request)
    {
        if ($request->password_baru == $request->ulangi_password) {
            $status = DB::update('update users set password = ? where name = ?', [Hash::make($request->password_baru), $request->name]);
            return redirect()->back()->with('success', 'Password Berhasil Diubah');
        } else {
            return redirect()->back()->with('error', 'Password Tidak Sama');
        }
    }
    // Akhir Ubah Password


    // Cetak SK TIM Ujian TA Oleh Fakultas

    public function usulan_timujianta($id)
    {
        $datax = DB::table('mst_pendaftaran')
            ->select('*')
            ->whereIn('mst_pendaftaran.pendaftaran_id', $id)
            ->get();
        $a = 0;
        foreach ($datax as $key => $value) {
            $simpan['pendaftaran_id'] = $datax[$a]->pendaftaran_id;
            // $simpan['nomor'] = $nomor;
            // $simpan['perihal'] = $perihal;
            // $simpan['tgl_surat'] = $tgl;
            DB::table('mst_pendaftaran')
                ->where('pendaftaran_id', $datax[$a]->pendaftaran_id)
                ->update(['status_sk' => '1']);
            $a++;
        }
        return view('tugasakhir.prodi.surat_usulantimujian', compact('datax'));
    }

    // Menampilkan Daftar atau List SK Penugasan TIM Ujian TA

    public function surat_penugasan_ujian_ta()
    {

        $data_sk_penugasan = DB::table('mst_sk_penugasan')
            ->select('*')
            ->join('trt_bimbingan', 'trt_bimbingan.bimbingan_id', '=', 'mst_sk_penugasan.bimbingan_id')
            ->orderBy('mst_sk_penugasan.sk_penugasan_id', 'DESC')
            ->get();

        $daftar_surat_usulan = DB::table('trt_sk_ujian_ta')
            ->select('*')
            ->join('mst_pendaftaran', 'mst_pendaftaran.pendaftaran_id', '=', 'trt_sk_ujian_ta.pendaftaran_id')
            ->orderBy('trt_sk_ujian_ta.sk_id', 'DESC')
            ->get();
        return view('tugasakhir.fakultas.surat_penugasan_ujian_ta', compact('daftar_surat_usulan', 'data_sk_penugasan'));
    }

    //  Membuat SK Per Mahasiswa Melalui TIM Ujian TA

    public function sk_penetapan_tim_ujian_ta(Request $request)
    {
        $datapost = $request->all();
        $data = DB::table('trt_sk_ujian_ta')
            ->join('trt_reg', 'trt_sk_ujian_ta.pendaftaran_id', '=', 'trt_reg.pendaftaran_id')
            ->join('trt_bimbingan', 'trt_bimbingan.bimbingan_id', '=', 'trt_reg.bimbingan_id')
            ->select('*')
            ->where('trt_sk_ujian_ta.pendaftaran_id', $datapost['pendaftaran_id'])
            ->get();
        return view('tugasakhir.fakultas.sk_penetapan_tim_ujian_ta', compact('data'));
    }

    // Menambah SK Penugasan Per Setiap Mahasiswa

    public function add_sk_penugasan_per_mahasiswa(Request $request)
    {
        $datapost = $request->all();
        try {
            mst_sk_penugasan::updateOrcreate(
                [
                    "bimbingan_id" => $datapost['bimbingan_id'],
                ],
                [
                    "nomor_sk" => $datapost['nomor_sk'],
                ]
            );
            return redirect::to('fakultas/surat_penugasan_ujian_ta')->with('status', 'success');
        } catch (Exception $exception) {
            return redirect::to('fakultas/surat_penugasan_ujian_ta')->with('status', 'error');
        }
    }

    // Menampilkan Dan Mencetak SK Penugasan Setiap Mahasiswa

    public function cetakskpenugasan(Request $request)
    {
        $datapost = $request->all();
        $data_sk = DB::table('mst_sk_penugasan')
            ->join('trt_bimbingan', 'mst_sk_penugasan.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->join('trt_penguji', 'trt_penguji.C_NPM', '=', 'trt_bimbingan.C_NPM')
            ->join('trt_jadwal_ujian_per_mhs', 'trt_jadwal_ujian_per_mhs.C_NPM', '=', 'trt_bimbingan.C_NPM')
            ->join('trt_jadwal_ujian', 'trt_jadwal_ujian.id', '=', 'trt_jadwal_ujian_per_mhs.jadwal_ujian')
            ->join('mst_ruangan', 'mst_ruangan.id', '=', 'trt_jadwal_ujian_per_mhs.ruangan')
            ->select(['mst_sk_penugasan.created_at', 'mst_sk_penugasan.sk_penugasan_id', 'mst_sk_penugasan.nomor_sk', 'trt_bimbingan.pembimbing_I_id', "trt_bimbingan.pembimbing_II_id", "trt_penguji.ketua_sidang_id", "trt_penguji.penguji_I_id", "trt_penguji.penguji_II_id", "trt_penguji.penguji_III_id", "trt_penguji.C_NPM", "trt_jadwal_ujian.tgl_ujian", "trt_jadwal_ujian_per_mhs.jam_ujian", "mst_ruangan.nama_ruangan", "trt_jadwal_ujian.pendaftaran_id"])
            ->where('trt_bimbingan.bimbingan_id', $datapost['bimbingan_id'])
            ->where('trt_penguji.tipe_ujian', 2)
            ->where('trt_jadwal_ujian.status', 2)
            ->get();

        return view('tugasakhir.fakultas.cetakskpenugasan', compact('data_sk'));
    }


    public function sk_penetapan(Request $request)
    {
        $datapost = $request->all();
        $bimbingan_id = DB::table('trt_sk')
            ->select('bimbingan_id')
            ->where('nomor', $datapost['nomor'])
            ->get();
        $data = DB::table('trt_bimbingan')
            ->join('trt_sk', 'trt_sk.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->select('*')
            ->where('nomor', $datapost['nomor'])
            ->get();

        return view('tugasakhir.fakultas.sk_penetapan', compact('data', 'datapost'));
    }

    public function cetakskpembimbing(Request $request)
    {
        $datapost = $request->all();
        $data_sk = DB::table('mst_sk_pembimbing')
            ->join('trt_bimbingan', 'mst_sk_pembimbing.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->select('*')
            ->where('mst_sk_pembimbing.nomor_sk', $datapost['nomor'])
            ->get();
        $tgl_ujian = Helper::tgl_indo_lengkap(date('Y-m-d'));
        return view('tugasakhir.fakultas.cetakskpembimbing', compact('data_sk', 'tgl_ujian'));
    }

    public function sk_pembimbing()
    {
        $data = DB::table('t_mst_mahasiswa')
            ->join('trt_bimbingan', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->join('t_mst_dosen', 'C_KODE_DOSEN', '=', 'trt_bimbingan.pembimbing_I_id')
            ->select('t_mst_mahasiswa.NAMA_MAHASISWA', 't_mst_dosen.NAMA_DOSEN')
            ->get();

        $penetapan_pengusulan = DB::table('trt_bimbingan')
            ->join('t_mst_mahasiswa', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->select('*')
            ->where('status_sk', '<>', 1)
            ->get();

        $riwayat_usulan = DB::table('trt_sk')
            ->select('nomor', 'tgl_surat')
            ->distinct('nomor')
            ->orderBy('trt_sk.sk_id', 'DESC')
            ->get();

        $data_sk = DB::table('mst_sk_pembimbing')
            ->join('trt_bimbingan', 'mst_sk_pembimbing.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->select('*')
            ->orderBy('mst_sk_pembimbing.sk_pembimbing_id', 'DESC')
            ->get();

        return view('tugasakhir.fakultas.sk_pembimbing', compact('riwayat_usulan', 'penetapan_pengusulan', 'data', 'data_sk'));
    }



    public function chart_morris()
    {
        return view('tugasakhir.fakultas.chart_morris');
    }

    public function chart_c3()
    {
        return view('tugasakhir.fakultas.chart_c3');
    }

    public function chart_flot()
    {
        return view('tugasakhir.fakultas.chart_flot');
    }

    public function chart_easy_knob()
    {
        return view('tugasakhir.fakultas.chart_easy_knob');
    }

    public function addskpembimbing(Request $request)
    {
        $datapost = $request->all();
        try {
            $status_ = mst_sk_pembimbing::updateOrcreate(
                [
                    "bimbingan_id" => $datapost['bimbingan_id'],
                ],
                [
                    "nomor_sk" => $datapost['nomor_sk'],
                ]
            );
            return redirect::to('fakultas/sk_pembimbing')->with('status', 'success');
        } catch (Exception $exception) {
            return redirect::to('fakultas/sk_pembimbing')->with('status', 'error');
        }
    }

    // Surat Keputusan
    // Menampilkan Surat Ujian Berlaku Untuk Proposal, Ujian Meja dan Umum
    public function sk_ujian()
    {
        $pendaftaran = mst_pendaftaran::get();
        $jadwalujian = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where('mst_pendaftaran.tipe_ujian', '=', 0)
            ->orderBy('mst_pendaftaran.created_at', 'desc')
            ->get();
        return view('tugasakhir.fakultas.sk_ujian', compact('pendaftaran', "jadwalujian"));
    }

    // Menampilkan Halaman Penentuan Bidang
    public function penentuan_bidang()
    {
        $data_riwayat_usulan = DB::table('trt_topik')
            ->join('t_mst_mahasiswa', 'trt_topik.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->select('t_mst_mahasiswa.C_NPM', 't_mst_mahasiswa.NAMA_MAHASISWA', 'trt_topik.topik', 'trt_topik.kerangka', 'trt_topik.status', 'trt_topik.status_penetapan', 'trt_topik.bidang_ilmu_peminatan')
            ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '040%')
            ->get();

        $data_bidang_ilmu = DB::table('mst_bidangilmu')
            ->select('*')
            ->get();


        return view('tugasakhir.fakultas.penentuan_bidang', compact('data_riwayat_usulan', 'data_bidang_ilmu'));
    }

    // Menentukan Bidang Ilmu
    public function post_penentuan_bidang(Request $request)
    {
        try {
            $data = $request->all();
            $status = DB::table('trt_topik')
                ->where('C_NPM', $data['C_NPM'])
                ->update([
                    'bidang_ilmu_peminatan' => $data['bidang_ilmu_peminatan'],
                    'status_penetapan' => 1
                ]);

            $queryMstTmpUsulan = DB::table('mst_tmp_usulan')
                ->updateOrInsert(
                    ['C_NPM' => $data['C_NPM']], // Kondisi untuk mengecek apakah record ada
                    [
                        'pembimbing_I_id' => null,
                        'pembimbing_II_id' => null,
                        'updated_at' => Carbon::now(), // Menambahkan nilai untuk kolom updated_at
                        'created_at' => Carbon::now() // Menambahkan nilai untuk kolom created_at jika diperlukan
                    ]
                );

            if ($status && $queryMstTmpUsulan) {
                return redirect::back()->with((['status' => "berhasil", 'message' => "berhasil menentukan bidang ilmu"]));
            } else {
                return redirect::back()->with((['status' => "gagal", 'message' => "gagal menentukan bidang ilmu"]));
            }
        } catch (\Throwable $th) {
            var_dump($th);
            die();
            return redirect::back()->with((['status' => "gagal", 'message' => "gagal menentukan bidang ilmu"]));
        }
    }

    public function usulan_pembimbing()
    {
        if (Auth::user()->name == 'akademikfakultasfh') {
            $data = DB::table('trt_topik')
                ->join('t_mst_mahasiswa', 'trt_topik.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
                ->select('t_mst_mahasiswa.*', 'trt_topik.*')
                ->orderBy('trt_topik.topik_id', 'DESC')
                ->where('trt_topik.status', 1)
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '040%')
                ->whereNotIn(
                    't_mst_mahasiswa.C_NPM',
                    function ($q) {
                        $q
                            ->select('C_NPM')
                            ->from('trt_bimbingan');
                    }
                )
                ->get();
        } else {
            $data = DB::table('trt_topik')
                ->join('t_mst_mahasiswa', 'trt_topik.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
                ->select('t_mst_mahasiswa.*', 'trt_topik.*')
                ->orderBy('trt_topik.topik_id', 'DESC')
                ->where('trt_topik.status', 1)
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '131%')
                ->whereNotIn(
                    't_mst_mahasiswa.C_NPM',
                    function ($q) {
                        $q
                            ->select('C_NPM')
                            ->from('trt_bimbingan');
                    }
                )
                ->get();
        }
        return view('tugasakhir.fakultas.usulan_pembimbing', compact('data'));
    }

    public function usulan_pembimbingpostadd(Request $request)
    {
        try {
            $datapost = $request->all();
            $datapost['status_I'] = '0';
            $datapost['status_II'] = '0';
            $datapost['status_bimbingan'] = '0';
            $datapost['status_sk'] = '0';
            $datapost['user_id'] = '1';
            trt_bimbingan::updateOrCreate([
                "C_NPM" => $request->C_NPM,
            ], $datapost);
            mst_tmp_usulan::where("C_NPM", $request->C_NPM)->delete();

            return redirect()->to('fakultas/usulan_pembimbing')->with((['status' => "berhasil", 'message' => "berhasil menambahkan data bimbingan"]));
        } catch (\Throwable $th) {
            return redirect()->to('fakultas/usulan_pembimbing')->with((['status' => "gagal", 'message' => "gagal menambahkan data bimbingan"]));
        }
    }

    public function set_pembimbing($id, $status)
    {
        $data_mahasiswa = DB::table('t_mst_mahasiswa')
            ->select('*')
            ->where('C_NPM', $id)
            ->first();
        $data_topik = DB::table('trt_topik')
            ->select('*')
            ->where('C_NPM', $id)
            ->where('status', 1)
            ->first();

        $data = DB::table('t_mst_dosen')
            ->leftJoin("trt_level_pembimbing", "trt_level_pembimbing.C_KODE_DOSEN", "=", "t_mst_dosen.C_KODE_DOSEN")
            ->select('t_mst_dosen.*', 'trt_level_pembimbing.level')
            ->get();


        if ($status == 1) {
            $cek = DB::table('mst_tmp_usulan')
                ->select('*')
                ->where('C_NPM', $id)
                ->get();
        } else if ($status == 2) {
            $cek = DB::table('trt_bimbingan')
                ->select('*')
                ->where('C_NPM', $id)
                ->get();
        }

        return view('tugasakhir.fakultas.set_pembimbing', compact('data', 'data_mahasiswa', 'data_topik', 'cek'));
    }

    public function surat_usulan_pembimbing()
    {
        if (Auth::user()->name == 'akademikfakultasfh') {
            $data = DB::table('t_mst_mahasiswa')
                ->join('trt_bimbingan', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
                ->join('t_mst_dosen', 'C_KODE_DOSEN', '=', 'trt_bimbingan.pembimbing_I_id')
                ->select('t_mst_mahasiswa.NAMA_MAHASISWA', 't_mst_dosen.NAMA_DOSEN')
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '040%')
                ->get();

            $penetapan_pengusulan = DB::table('trt_bimbingan')
                ->join('users', 'trt_bimbingan.C_NPM', '=', 'users.name')
                ->select('*')
                ->where('status_sk', '<>', 1)
                ->where('trt_bimbingan.C_NPM', 'LIKE', '040%')
                ->get();

            $riwayat_usulan = DB::table('trt_sk')
                ->select('nomor', 'tgl_surat')
                ->distinct('nomor')
                ->get();
        } else {
            $data = DB::table('t_mst_mahasiswa')
                ->join('trt_bimbingan', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
                ->join('t_mst_dosen', 'C_KODE_DOSEN', '=', 'trt_bimbingan.pembimbing_I_id')
                ->select('t_mst_mahasiswa.NAMA_MAHASISWA', 't_mst_dosen.NAMA_DOSEN')
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '131%')
                ->get();

            $penetapan_pengusulan = DB::table('trt_bimbingan')
                ->join('users', 'trt_bimbingan.C_NPM', '=', 'users.name')
                ->select('*')
                ->where('status_sk', '<>', 1)
                ->where('trt_bimbingan.C_NPM', 'LIKE', '131%')
                ->get();

            $riwayat_usulan = DB::table('trt_sk')
                ->select('nomor', 'tgl_surat')
                ->distinct('nomor')
                ->get();
        }
        return view('tugasakhir.fakultas.surat_usulan_pembimbing', compact('riwayat_usulan', 'penetapan_pengusulan', 'data'));
    }

    function riwayat_sk_pengusulan()
    {
        $data = DB::select('SELECT DISTINCT nomor, tgl_surat, perihal FROM trt_sk');
        return view('tugasakhir.prodi.riwayat_sk_pengusulan', compact('data'));
    }

    public function sk_pengusulanpost(Request $request)
    {
        $datapost = $request->all();
        if (isset($datapost["data"])) {
            $data = $datapost['data'];

            $datax = DB::table('trt_bimbingan')
                ->join('t_mst_mahasiswa', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
                ->select('*')
                ->whereIn('trt_bimbingan.C_NPM', $data)
                ->get();

            return view('tugasakhir.fakultas.sk_pengusulan', compact('datax', 'data'));
        }
        return redirect()->back();
    }

    public function surat_pengusulan(Request $request)
    {
        $datapost = $request->all();
        $nomor = $datapost['nomor'];
        $perihal = $datapost['perihal'];
        $tgl = $datapost['tgl'];
        $tgl = substr($tgl, 6, 4) . "-" . substr($tgl, 3, 2) . "-" . substr($tgl, 0, 2);

        $data = $datapost['data'];
        $datax = DB::table('trt_bimbingan')
            ->join('t_mst_mahasiswa', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->select('*')
            ->whereIn('trt_bimbingan.C_NPM', $data)
            ->get();
        $a = 0;
        foreach ($datax as $key => $value) {
            $simpan['bimbingan_id'] = $datax[$a]->bimbingan_id;
            $simpan['tipe'] = 1;
            $simpan['nomor'] = $nomor;
            $simpan['perihal'] = $perihal;
            $simpan['tgl_surat'] = $tgl;
            $simpan['user_id'] = 0;
            trt_sk::create($simpan);

            DB::table('trt_bimbingan')
                ->where('bimbingan_id', $datax[$a]->bimbingan_id)
                ->update(['status_sk' => '1']);
            $a++;
        }

        $tgl = helper::tgl_indo_lengkap($tgl);

        return view('tugasakhir.fakultas.suratpengusulan', compact('nomor', 'perihal', 'tgl', 'datax'));
    }

    function detail_riwayat_sk_pengusulan($nomor)
    {
        $data = DB::table("trt_sk")
            ->select("*")
            ->join('trt_bimbingan', 'trt_bimbingan.bimbingan_id', '=', 'trt_sk.bimbingan_id')
            ->where('trt_sk.nomor', '=', str_replace("$", "/", $nomor))
            ->get();

        return view('tugasakhir.prodi.detail_riwayat_sk_pengusulan', compact('data'));
    }

    public function get_surat_pengusulan($nomor)
    {
        $datax = DB::table("trt_sk")
            ->select("*")
            ->join('trt_bimbingan', 'trt_bimbingan.bimbingan_id', '=', 'trt_sk.bimbingan_id')
            ->join('t_mst_mahasiswa', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->where('trt_sk.nomor', '=', str_replace("$", "/", $nomor))
            ->get();

        $perihal = $datax[0]->perihal;
        $tgl = $datax[0]->tgl_surat;
        $nomor = $datax[0]->nomor;

        return view('tugasakhir.prodi.suratpengusulan', compact('nomor', 'perihal', 'tgl', 'datax'));
    }

    public function persyaratan_proposal()
    {
        if (Auth::user()->name == 'akademikfakultasfh') {
            $data = TrtPengajuanDokumen::join("t_mst_mahasiswa", "trt_pengajuan_dokumen.C_NPM", "=", "t_mst_mahasiswa.C_NPM")
                ->where("type", 0)
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '040%')
                ->get(["NAMA_MAHASISWA", "t_mst_mahasiswa.C_NPM"]);
        } else {
            $data = TrtPengajuanDokumen::join("t_mst_mahasiswa", "trt_pengajuan_dokumen.C_NPM", "=", "t_mst_mahasiswa.C_NPM")
                ->where("type", 0)
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '131%')
                ->get(["NAMA_MAHASISWA", "t_mst_mahasiswa.C_NPM"]);
        }
        return view("tugasakhir.prodi.persyaratan_proposal", compact("data"));
    }

    public function persyaratan_ujianmeja()
    {
        if (Auth::user()->name == 'akademikfakultasfh') {
            $data = TrtPengajuanDokumen::join("t_mst_mahasiswa", "trt_pengajuan_dokumen.C_NPM", "=", "t_mst_mahasiswa.C_NPM")
                ->where("type", 2)
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '040%')
                ->get(["NAMA_MAHASISWA", "t_mst_mahasiswa.C_NPM"]);
        } else {
            $data = TrtPengajuanDokumen::join("t_mst_mahasiswa", "trt_pengajuan_dokumen.C_NPM", "=", "t_mst_mahasiswa.C_NPM")
                ->where("type", 2)
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '131%')
                ->get(["NAMA_MAHASISWA", "t_mst_mahasiswa.C_NPM"]);
        }
        return view("tugasakhir.prodi.persyaratan_ujianmeja", compact("data"));
    }

    public function detail_persyaratan_proposal($id)
    {
        $mhs = t_mst_mahasiswa::where("C_NPM", $id)->first();
        $data = TrtSyaratUjian::join("mst_syarat_ujian", "trt_syarat_ujian.syarat_ujian_id", "=", "mst_syarat_ujian.syarat_ujian_id")->where(["tipe_ujian" => 0, "C_NPM" => $id])->get();
        return view("tugasakhir.prodi.detail_persyaratan_proposal", compact("data", "mhs"));
    }

    public function detail_persyaratan_ujianmeja($id)
    {
        $mhs = t_mst_mahasiswa::where("C_NPM", $id)->first();
        $data = TrtSyaratUjian::join("mst_syarat_ujian", "trt_syarat_ujian.syarat_ujian_id", "=", "mst_syarat_ujian.syarat_ujian_id")->where(["tipe_ujian" => 2, "C_NPM" => $id])->get();
        return view("tugasakhir.prodi.detail_persyaratan_ujianmeja", compact("data", "mhs"));
    }

    public function konfirmasi_persyaratan_ujian_by_nim($status, $nim)
    {
        try {
            $data = TrtSyaratUjian::where([
                "C_NPM" => $nim
            ])->update([
                "status" => $status
            ]);
            return redirect()->back()->with((['status' => "berhasil", 'message' => "berhasil mengkonfirmasi persyaratan"]));
        } catch (\Throwable $th) {
            return redirect()->back()->with((['status' => "gagal", 'message' => "gagal mengkonfirmasi persyaratan"]));
        }
    }

    public function konfirmasi_persyaratan_ujian($status, $id, $nim)
    {
        try {
            TrtSyaratUjian::where([
                "syarat_ujian_id" => $id,
                "C_NPM" => $nim
            ])->update([
                "status" => $status
            ]);
            return redirect()->back()->with((['status' => "berhasil", 'message' => "berhasil mengkonfirmasi persyaratan"]));
        } catch (\Throwable $th) {
            return redirect()->back()->with((['status' => "gagal", 'message' => "gagal mengkonfirmasi persyaratan"]));
        }
    }

    // Tampil Catatan Pada Syarat Ujian
    public function detail_persyaratan_proposal_catatan($id, $nim)
    {
        $data = DB::table('trt_syarat_ujian')
            ->select("*")
            ->where("id", $id)
            ->where("C_NPM", $nim)
            ->get();

        return view('tugasakhir.prodi.detail_persyaratan_proposal_catatan', compact('data', 'nim'));
    }

    public function detail_persyaratan_proposal_catatan_post(Request $request)
    {
        try {
            TrtSyaratUjian::where("id", $request->id)
                ->where('C_NPM', $request->C_NPM)
                ->update([
                    "catatan" => $request->catatan
                ]);
            return redirect::to('akademikprodi/detail_persyaratan_proposal/' . $request->C_NPM)->with('status', 'success');
        } catch (Exception $exception) {
            return redirect::to('akademikprodi/detail_persyaratan_proposal/' . $request->C_NPM)->with('status', 'error');
        }
    }

    // Tampil Catatan Pada Syarat Ujian
    public function detail_persyaratan_ujianmeja_catatan($id, $nim)
    {
        $data = DB::table('trt_syarat_ujian')
            ->select("*")
            ->where("id", $id)
            ->where("C_NPM", $nim)
            ->get();

        return view('tugasakhir.prodi.detail_persyaratan_ujianmeja_catatan', compact('data', 'nim'));
    }

    public function detail_persyaratan_ujianmeja_catatan_post(Request $request)
    {
        try {
            TrtSyaratUjian::where("id", $request->id)
                ->where('C_NPM', $request->C_NPM)
                ->update([
                    "catatan" => $request->catatan
                ]);
            return redirect::to('akademikprodi/detail_persyaratan_ujianmeja/' . $request->C_NPM)->with('status', 'success');
        } catch (Exception $exception) {
            return redirect::to('akademikprodi/detail_persyaratan_ujianmeja/' . $request->C_NPM)->with('status', 'error');
        }
    }

    public function selesaiKonfirmasi($nim, $type)
    {
        TrtPengajuanDokumen::where([
            "C_NPM" => $nim,
            "type" => $type
        ])->delete();

        switch ($type) {
            case "0":
                $to = "persyaratan_proposal";
                break;
            case "1":
                $to = "persyaratan_seminarhasil";
                break;
            case "2":
                $to = "persyaratan_ujianmeja";
                break;
        }
        return redirect("/akademikprodi/$to");
    }

    public function jadwal()
    {
        if (Auth::user()->name == 'akademikfakultasfh') {
            $pendaftaran = Collection::make(mst_pendaftaran::get())
                ->where('status_ujian', 0)
                ->where('status_prodi', 1)
                ->unique("nama_periode")
                ->sortByDesc('created_at');
            $jadwalujian = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
                ->where('mst_pendaftaran.status_prodi', 1)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        } else {
            $pendaftaran = Collection::make(mst_pendaftaran::get())
                ->where('status_ujian', 0)
                ->where('status_prodi', 2)
                ->unique("nama_periode")
                ->sortByDesc('created_at');
            $jadwalujian = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
                ->where('mst_pendaftaran.status_prodi', 2)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        }
        return view('tugasakhir.fakultas.jadwal', compact('pendaftaran', "jadwalujian"));
    }

    public function jadwalpostadd(Request $request)
    {
        try {
            $mst = mst_pendaftaran::where("nama_periode", $request->nama_periode)->first();
            if (empty($mst)) {
                if ($request->tipe_ujian == "3") {
                    for ($i = 0; $i < 3; $i++) {
                        if (Auth::user()->name == "akademikfakultasfh") {
                            $request->merge([
                                "tipe_ujian" => $i,
                                "user_id" => "00",
                                "jml_peserta" => 0,
                                "status_prodi" => 1
                            ]);
                        } else {
                            $request->merge([
                                "tipe_ujian" => $i,
                                "user_id" => "00",
                                "jml_peserta" => 0,
                                "status_prodi" => 2
                            ]);
                        }

                        mst_pendaftaran::create($request->all());
                    }
                } else {
                    if (Auth::user()->name == "akademikfakultasfh") {
                        $request->merge([
                            "user_id" => "00",
                            "jml_peserta" => 0,
                            'status_prodi' => 1
                        ]);
                    } else {
                        $request->merge([
                            "user_id" => "00",
                            "jml_peserta" => 0,
                            'status_prodi' => 2
                        ]);
                    }
                    mst_pendaftaran::create($request->all());
                }
            }
            return redirect()->back()->with((['status' => "berhasil", 'message' => "berhasil menambahkan data jadwal"]));
        } catch (\Throwable $th) {
            return redirect()->back()->with((['status' => "gagal", 'message' => "gagal menambahkan data jadwal"]));
        }
    }

    public function jadwalUjianPost(Request $request)
    {
        try {
            if (count($request->all()) == 4) {
                $namaperiode = mst_pendaftaran::find($request->pendaftaran_id)->nama_periode;
                $countname = mst_pendaftaran::where("nama_periode", $namaperiode)->count();
                mst_pendaftaran::where([
                    "nama_periode" => $namaperiode,
                ])->update([
                    'status_ujian' => 1,
                ]);
                $request->merge(["status" => $request->tipe_ujian]);
                if ($countname == 3) {
                    $pendaftaran = mst_pendaftaran::where("nama_periode", $namaperiode)->get();
                    foreach ($pendaftaran as $p) {
                        $request->merge([
                            "pendaftaran_id" => $p->pendaftaran_id
                        ]);
                        TrtJadwalUjian::create($request->all());
                    }
                } else {
                    TrtJadwalUjian::create($request->all());
                }
            }
            return redirect()->back()->with((['status' => "berhasil", 'message' => "berhasil menambahkan data jadwal"]));
        } catch (\Throwable $th) {
            return redirect()->back()->with((['status' => "gagal", 'message' => "gagal menambahkan data jadwal"]));
        }
    }

    public function pendaftarandel($id)
    {
        try {
            $namaperiode = mst_pendaftaran::find($id)->nama_periode;
            $countname = mst_pendaftaran::where('nama_periode', $namaperiode)->count();
            if ($countname == 3) {
                mst_pendaftaran::where('nama_periode', $namaperiode)->delete();
            } else {
                mst_pendaftaran::where('pendaftaran_id', $id)->delete();
            }
            return redirect()->back()->with((['status' => "berhasil", 'message' => "berhasil menghapus data jadwal"]));
        } catch (\Throwable $th) {
            return redirect()->back()->with((['status' => "gagal", 'message' => "gagal menghapus data jadwal"]));
        }
    }

    public function temp_daftar_peserta($id)
    {
        $info = DB::select("SELECT * FROM mst_pendaftaran WHERE mst_pendaftaran.pendaftaran_id = ?", [$id]);

        $data = DB::select("SELECT * FROM mst_pendaftaran,trt_reg, trt_bimbingan, t_mst_mahasiswa WHERE mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_reg.pendaftaran_id = ? AND trt_reg.status = ?", [$id, $info[0]->tipe_ujian]);

        return view('tugasakhir.fakultas.temp_daftar_peserta', compact("data", "info"));
    }

    public function ubah_periode_pendaftaran(Request $request)
    {

        try {
            for ($i = 0; $i < count($request->C_NPM); $i++) {
                DB::table('trt_reg')->where('C_NPM', $request->C_NPM[$i])->update([
                    "pendaftaran_id" => $request->pindah_periode[$i],
                ]);
            }


            foreach (helper::getPeriodePendaftaranByStatusUjian($request->status_ujian, $request->tipe_ujian) as $item) {
                $data_pendaftar = DB::table('trt_reg')
                    ->select('*')
                    ->where('pendaftaran_id', $item->pendaftaran_id)
                    ->get();

                DB::table('mst_pendaftaran')->where('pendaftaran_id', $item->pendaftaran_id)->update([
                    "jml_peserta" => count($data_pendaftar),
                ]);
            }

            return redirect()->back();
        } catch (Exception $e) {
            return $e;
        }
        return $request;
    }

    public function hapusJadwalUjianPerMahasiswa($C_NPM, $pendaftaran_id)
    {
        try {
            trt_reg::where('C_NPM', $C_NPM)->where('pendaftaran_id', $pendaftaran_id)->delete();
            $data_pendaftaran = mst_pendaftaran::where('pendaftaran_id', $pendaftaran_id)->first();
            mst_pendaftaran::where('pendaftaran_id', $pendaftaran_id)->update(
                [
                    "jml_peserta" => $data_pendaftaran->jml_peserta - 1,
                ]
            );
            TrtPenguji::where('C_NPM', $C_NPM)->where('tipe_ujian', $data_pendaftaran->tipe_ujian)->delete();
            return redirect()->back()->with(['status' => "berhasil_hapus"]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => "gagal_hapus"]);
        }
    }

    public function daftar_peserta($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();
        $data = DB::select("SELECT * FROM mst_pendaftaran,trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa WHERE mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND trt_reg.pendaftaran_id = ? AND trt_reg.status = ?", [$id, $info->tipe_ujian]);

        return view('tugasakhir.fakultas.daftar_peserta', compact("data", "info"));
    }

    public function peserta_proposal()
    {
        if (Auth::user()->name == 'akademikfakultasfh') {
            $pendaftaran = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', 0)
                ->where('mst_pendaftaran.status_prodi', 1)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        } else {
            $pendaftaran = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', 0)
                ->where('mst_pendaftaran.status_prodi', 2)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        }
        return view('tugasakhir.prodi.peserta_proposal', compact('pendaftaran'));
    }

    public function peserta_ujianmeja()
    {
        if (Auth::user()->name == 'akademikfakultasfh') {
            $pendaftaran = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', 2)
                ->where('mst_pendaftaran.status_prodi', 1)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        } else {
            $pendaftaran = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', 2)
                ->where('mst_pendaftaran.status_prodi', 2)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        }
        return view('tugasakhir.prodi.peserta_ujianmeja', compact('pendaftaran'));
    }

    public function jadwalPerMhs($tipe_ujian)
    {
        switch ($tipe_ujian):
            case "proposal":
                $type = 0;
                break;
            case "seminarhasil":
                $type = 1;
                break;
            case "ujianmeja":
                $type = 2;
                break;
        endswitch;

        if (Auth::user()->name == 'akademikfakultasfh') {
            $data = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', $type)
                ->where('mst_pendaftaran.status_prodi', 1)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        } else {
            $data = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', $type)
                ->where('mst_pendaftaran.status_prodi', 2)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        }
        return view('tugasakhir.fakultas.jadwalpermhs', compact('data'));
    }

    public function detailJadwalPermhs($pendaftaran_id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $pendaftaran_id)->first();
        $data = DB::select("SELECT * FROM mst_pendaftaran,trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa WHERE mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND trt_reg.pendaftaran_id = ? AND trt_reg.status = ?", [$pendaftaran_id, $info->tipe_ujian]);

        return view('tugasakhir.fakultas.detail_jadwalpermhs', compact("data", "info"));
    }

    public function set_jadwalujianpermhs($pendaftaran_id, $nim)
    {
        $xinfo = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $pendaftaran_id)->first();
        $info = trt_reg::join("trt_bimbingan", "trt_bimbingan.bimbingan_id", "=", "trt_reg.bimbingan_id")
            ->join("t_mst_mahasiswa", "t_mst_mahasiswa.C_NPM", "=", "trt_bimbingan.C_NPM")
            ->join("trt_penguji", "trt_penguji.C_NPM", "=", "t_mst_mahasiswa.C_NPM")
            ->where([
                "trt_reg.pendaftaran_id" => $pendaftaran_id,
                "trt_reg.status" => $xinfo->tipe_ujian,
                "trt_penguji.tipe_ujian" => $xinfo->tipe_ujian,
                "t_mst_mahasiswa.C_NPM" => $nim
            ])->first();

        $jadwal = TrtJadwalUjianPerMhs::where([
            "C_NPM" => $nim,
            "jadwal_ujian" => $xinfo->id
        ])->first();


        return view('tugasakhir.fakultas.set_jadwalpermhs', compact("info", "pendaftaran_id", "jadwal"));
    }

    public function set_jadwalujianpermhspost($pendaftaran_id, Request $request)
    {
        $trtjadwalujian = TrtJadwalUjian::where("pendaftaran_id", $pendaftaran_id)->first();
        $trtjadwalujianpermhs = TrtJadwalUjianPerMhs::where(["C_NPM" => $request->C_NPM, "jadwal_ujian" => $trtjadwalujian->id])->first();
        $request->merge(["jadwal_ujian" => $trtjadwalujian->id]);
        $request->merge(["jam_ujian" => $request->jam_ujian]);
        if (empty($trtjadwalujianpermhs)) {
            TrtJadwalUjianPerMhs::create($request->all());
        } else {
            TrtJadwalUjianPerMhs::where(["C_NPM" => $request->C_NPM, "jadwal_ujian" => $trtjadwalujian->id])
                ->update($request->except([
                    "C_NPM", "jadwal_ujian", "_token"
                ]));
        }

        return redirect()->to("/fakultas/detail_jadwalpermhs/$pendaftaran_id")->with((['status' => "berhasil", 'message' => "Berhasil menetapkan jadwal ujian"]));
    }

    public function approve_hasilujian_proposal()
    {
        if (Auth::user()->name == "akademikfakultasfh") {
            $data = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', 0)
                ->where('mst_pendaftaran.status_prodi', 1)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        } else {
            $data = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', 0)
                ->where('mst_pendaftaran.status_prodi', 2)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        }
        return view('tugasakhir.fakultas.approve_hasilujian_proposal', compact('data'));
    }

    public function detail_hasilujian_proposal($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();
        $data = DB::select("SELECT * FROM mst_pendaftaran,trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa WHERE mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND trt_reg.pendaftaran_id = ? AND trt_reg.status = ?", [$id, $info->tipe_ujian]);

        return view('tugasakhir.fakultas.detail_hasilujian_proposal', compact("data", "info"));
    }

    public function approve_hasilujian_proposal_post($id, $nim, $pendaftaran_id)
    {
        try {
            DB::table('trt_bimbingan')
                ->where([
                    "bimbingan_id" => $id,
                    "C_NPM" => $nim
                ])
                ->update(['status_bimbingan' => 1]);
            return redirect('fakultas/detail_hasilujian_proposal/' . $pendaftaran_id)->with((['status' => "berhasil", 'message' => "berhasil menyetujui hasil ujian"]));
        } catch (\Throwable $th) {
            return redirect('fakultas/detail_hasilujian_proposal/' . $pendaftaran_id)->with((['status' => "gagal", 'message' => "gagal menyetujui hasil ujian"]));
        }
    }

    public function tolak_hasilujian_proposal_post($id, $nim, $pendaftaran_id)
    {
        DB::table('trt_bimbingan')
            ->where([
                "bimbingan_id" => $id,
                "C_NPM" => $nim
            ])
            ->update([
                'status_tolak_proposal' => 1,
            ]);

        DB::table('trt_reg')
            ->where([
                "bimbingan_id" => $id,
                "status" => 0
            ])
            ->delete();

        return redirect('fakultas/detail_hasilujian_proposal/' . $pendaftaran_id);
    }

    public function approve_hasilujian_proposal_all_post()
    {
        $data = DB::table('trt_bimbingan')
            ->join("trt_reg", "trt_reg.bimbingan_id", "=", "trt_bimbingan.bimbingan_id")
            ->select("trt_reg.reg_id", "trt_bimbingan.bimbingan_id")
            ->where("trt_bimbingan.status_bimbingan", 0)
            ->get();
        $data_bimbingan_id = array();
        foreach ($data as $key => $value) {
            if (Helper::getJumlahTrtHasil($value->reg_id) == 5) {
                array_push($data_bimbingan_id, $value->bimbingan_id);
            }
        }

        try {
            DB::table("trt_bimbingan")
                ->whereIn("bimbingan_id", $data_bimbingan_id)
                ->update(["status_bimbingan" => 1]);

            return redirect()->back()->with(['status' => 'success', 'total' => count($data_bimbingan_id)]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => 'error', 'total' => count($data_bimbingan_id)]);
        }
    }

    public function approve_hasilujian_ta_all_post()
    {
        $data = DB::table('trt_bimbingan')
            ->join("trt_reg", "trt_reg.bimbingan_id", "=", "trt_bimbingan.bimbingan_id")
            ->select("trt_reg.reg_id", "trt_bimbingan.bimbingan_id")
            ->where("trt_bimbingan.status_bimbingan", 2)
            ->get();
        $data_bimbingan_id = array();
        foreach ($data as $key => $value) {
            if (Helper::getJumlahTrtHasil($value->reg_id) == 6) {
                array_push($data_bimbingan_id, $value->bimbingan_id);
            }
        }

        try {
            DB::table("trt_bimbingan")
                ->whereIn("bimbingan_id", $data_bimbingan_id)
                ->update(["status_bimbingan" => 3]);

            return redirect()->back()->with(['status' => 'success', 'total' => count($data_bimbingan_id)]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => 'error', 'total' => count($data_bimbingan_id)]);
        }
    }

    public function approve_hasilujian_ta()
    {
        if (Auth::user()->name == "akademikfakultasfh") {
            $data = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', 2)
                ->where('mst_pendaftaran.status_prodi', 1)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        } else {
            $data = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
                ->where('tipe_ujian', 2)
                ->where('mst_pendaftaran.status_prodi', 2)
                ->orwhere('tipe_ujian', 3)
                ->orderBy('mst_pendaftaran.created_at', 'desc')
                ->get();
        }
        return view('tugasakhir.fakultas.approve_hasilujian_ta', compact('data'));
    }

    public function detail_hasilujian_ta($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();
        $data = DB::select("SELECT * FROM mst_pendaftaran,trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa WHERE mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND trt_reg.pendaftaran_id = ? AND trt_reg.status = ?", [$id, $info->tipe_ujian]);

        return view('tugasakhir.fakultas.detail_hasilujian_ta', compact("data", "info"));
    }

    public function approve_hasilujian_ta_post($id, $nim, $pendaftaran_id)
    {
        DB::table('trt_bimbingan')
            ->where([
                "bimbingan_id" => $id,
                "C_NPM" => $nim
            ])
            ->update(['status_bimbingan' => 3]);
        return redirect('fakultas/detail_hasilujian_ta/' . $pendaftaran_id);
    }

    public function tolak_hasilujian_ta_post($id, $nim, $pendaftaran_id)
    {
        DB::table('trt_bimbingan')
            ->where([
                "bimbingan_id" => $id,
                "C_NPM" => $nim
            ])
            ->update([
                'status_tolak_meja' => 1,
            ]);

        DB::table('trt_reg')
            ->where([
                "bimbingan_id" => $id,
                "status" => 2
            ])
            ->delete();
        return redirect('fakultas/detail_hasilujian_ta/' . $pendaftaran_id);
    }

    public function lembaran_hasilujian_ta($pendaftaran_id, $nim, $reg_id)
    {
        $trtjadwalujian = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("trt_jadwal_ujian.pendaftaran_id", $pendaftaran_id)->first();
        $trtjadwalujianpermhs = TrtJadwalUjianPerMhs::join("mst_ruangan", "mst_ruangan.id", "trt_jadwal_ujian_per_mhs.ruangan")
            ->where([
                "C_NPM" => $nim,
                "jadwal_ujian" => $trtjadwalujian->id
            ])->first();
        $trt_bimbingan = trt_bimbingan::where("C_NPM", $nim)->first();
        $mst_pendaftaran = mst_pendaftaran::find($pendaftaran_id);
        $trt_penguji = TrtPenguji::where([
            "C_NPM" => $nim,
            "tipe_ujian" => $mst_pendaftaran->tipe_ujian
        ])->first();

        $ruangan = MstRuangan::find($trtjadwalujianpermhs->ruangan)->nama_ruangan;
        $tgl_ujian = Carbon::parse($trtjadwalujian->tgl_ujian)->formatLocalized("%A, %d %B %Y");
        $tanggal = Carbon::parse($trtjadwalujian->tgl_ujian)->formatLocalized("%d");
        $bulan = Carbon::parse($trtjadwalujian->tgl_ujian)->formatLocalized("%m");
        $tahun = Carbon::parse($trtjadwalujian->tgl_ujian)->formatLocalized("%Y");
        switch ($mst_pendaftaran->tipe_ujian) {
            case "0":
                $tipe_ujian = "Proposal";
                break;
            case "2":
                $tipe_ujian = "Meja";
                break;
        }

        $reg_id = $reg_id;

        $data_hasil = trt_hasil::where('reg_id', $reg_id)->get();
        $data_dosen_selesai = DB::table('trt_penguji')
            ->select('*')
            ->where('trt_penguji.C_NPM', $nim)
            ->where('trt_penguji.tipe_ujian', 2)
            ->first();

        $data_dosen_pembimbing = DB::table('trt_bimbingan')
            ->select("*")
            ->where("trt_bimbingan.C_NPM", $nim)
            ->first();

        return view("tugasakhir.fakultas.lembaran_hasilujian_ta", compact(
            "nim",
            "trt_bimbingan",
            "trt_penguji",
            "tipe_ujian",
            "ruangan",
            "tgl_ujian",
            "data_hasil",
            "reg_id",
            "data_dosen_selesai",
            "data_dosen_pembimbing",
            "tanggal",
            "bulan",
            "tahun"
        ));
    }

    public function syarat_ujian()
    {
        $data0 = DB::table('mst_syarat_ujian')
            ->select('*')
            ->where('tipe_ujian', 0)
            ->get();
        $data1 = DB::table('mst_syarat_ujian')
            ->select('*')
            ->where('tipe_ujian', 1)
            ->get();
        $data2 = DB::table('mst_syarat_ujian')
            ->select('*')
            ->where('tipe_ujian', 2)
            ->get();
        return view('tugasakhir.fakultas.syarat_ujian', compact('data0', 'data1', 'data2'));
    }

    public function syaratadd(Request $request)
    {
        try {
            $datapost = $request->all();
            mst_syarat_ujian::create($datapost);
            return redirect::to('fakultas/syarat_ujian')->with((['status' => "berhasil", 'message' => "berhasil menambahkan data syarat"]));
        } catch (\Throwable $th) {
            return redirect::to('fakultas/syarat_ujian')->with((['status' => "gagal", 'message' => "gagal menambahkan data syarat"]));
        }
    }

    public function syaratdel($id)
    {
        try {
            DB::table('mst_syarat_ujian')
                ->where('syarat_ujian_id', $id)
                ->delete();
            return redirect::to('fakultas/syarat_ujian')->with((['status' => "berhasil", 'message' => "berhasil menghapus data syarat"]));
        } catch (\Throwable $th) {
            return redirect::to('fakultas/syarat_ujian')->with((['status' => "gagal", 'message' => "gagal menghapus data syarat"]));
        }
    }

    public function persyaratan_seminarhasil()
    {
        $data = TrtPengajuanDokumen::join("t_mst_mahasiswa", "trt_pengajuan_dokumen.C_NPM", "=", "t_mst_mahasiswa.C_NPM")->where("type", 1)->get(["NAMA_MAHASISWA", "t_mst_mahasiswa.C_NPM"]);
        return view("tugasakhir.fakultas.persyaratan_seminarhasil", compact("data"));
    }

    public function detail_persyaratan_seminarhasil($id)
    {
        $mhs = t_mst_mahasiswa::where("C_NPM", $id)->first();
        $data = TrtSyaratUjian::join("mst_syarat_ujian", "trt_syarat_ujian.syarat_ujian_id", "=", "mst_syarat_ujian.syarat_ujian_id")->where(["tipe_ujian" => 1, "C_NPM" => $id])->get();
        return view("tugasakhir.fakultas.detail_persyaratan_seminarhasil", compact("data", "mhs"));
    }

    public function detail_persyaratan_seminarhasil_catatan($id, $nim)
    {
        $data = DB::table('trt_syarat_ujian')
            ->select("*")
            ->where("id", $id)
            ->where("C_NPM", $nim)
            ->get();
        return view('tugasakhir.fakultas.detail_persyaratan_seminarhasil_catatan', compact('data', 'nim'));
    }

    public function detail_persyaratan_seminarhasil_catatan_post(Request $request)
    {
        try {
            TrtSyaratUjian::where("id", $request->id)
                ->where('C_NPM', $request->C_NPM)
                ->update([
                    "catatan" => $request->catatan
                ]);
            return redirect::to('fakultas/detail_persyaratan_seminarhasil/' . $request->C_NPM)->with('status', 'success');
        } catch (Exception $exception) {
            return redirect::to('fakultas/detail_persyaratan_seminarhasil/' . $request->C_NPM)->with('status', 'error');
        }
    }

    public function surat_keputusan_pembimbing()
    {
        if (Auth::user()->name == "akademikfakultasfh") {
            $data = DB::table('t_mst_mahasiswa')
                ->join('trt_bimbingan', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
                ->join('t_mst_dosen', 'C_KODE_DOSEN', '=', 'trt_bimbingan.pembimbing_I_id')
                ->select('t_mst_mahasiswa.NAMA_MAHASISWA', 't_mst_dosen.NAMA_DOSEN')
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '040%')
                ->get();

            $penetapan_pengusulan = DB::table('trt_bimbingan')
                ->join('t_mst_mahasiswa', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
                ->select('*')
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '040%')
                ->where('status_sk', '<>', 1)
                ->get();

            $riwayat_usulan = DB::table('trt_sk')
                ->select('nomor', 'tgl_surat')
                ->distinct('nomor')
                ->orderBy('trt_sk.sk_id', 'DESC')
                ->get();

            $data_sk = DB::table('mst_sk_pembimbing')
                ->join('trt_bimbingan', 'mst_sk_pembimbing.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
                ->select('*')
                ->where('trt_bimbingan.C_NPM', 'LIKE', '040%')
                ->orderBy('mst_sk_pembimbing.sk_pembimbing_id', 'DESC')
                ->get();
        } else {
            $data = DB::table('t_mst_mahasiswa')
                ->join('trt_bimbingan', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
                ->join('t_mst_dosen', 'C_KODE_DOSEN', '=', 'trt_bimbingan.pembimbing_I_id')
                ->select('t_mst_mahasiswa.NAMA_MAHASISWA', 't_mst_dosen.NAMA_DOSEN')
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '131%')
                ->get();

            $penetapan_pengusulan = DB::table('trt_bimbingan')
                ->join('t_mst_mahasiswa', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
                ->select('*')
                ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '131%')
                ->where('status_sk', '<>', 1)
                ->get();

            $riwayat_usulan = DB::table('trt_sk')
                ->select('nomor', 'tgl_surat')
                ->distinct('nomor')
                ->orderBy('trt_sk.sk_id', 'DESC')
                ->get();

            $data_sk = DB::table('mst_sk_pembimbing')
                ->join('trt_bimbingan', 'mst_sk_pembimbing.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
                ->select('*')
                ->where('trt_bimbingan.C_NPM', 'LIKE', '131%')
                ->orderBy('mst_sk_pembimbing.sk_pembimbing_id', 'DESC')
                ->get();
        }

        return view('tugasakhir.fakultas.surat_keputusan_pembimbing', compact('riwayat_usulan', 'penetapan_pengusulan', 'data', 'data_sk'));
    }

    public function set_sk($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();
        $data = trt_reg::join("trt_bimbingan", "trt_bimbingan.bimbingan_id", "=", "trt_reg.bimbingan_id")
            ->join("t_mst_mahasiswa", "t_mst_mahasiswa.C_NPM", "=", "trt_reg.C_NPM")
            ->join("trt_penguji", "trt_penguji.C_NPM", "=", "t_mst_mahasiswa.C_NPM")
            ->where([
                "trt_reg.pendaftaran_id" => $id,
                "trt_penguji.tipe_ujian" => $info->tipe_ujian
            ])->get();


        return view('tugasakhir.fakultas.set_sk', compact('data'));
    }

    public function add_sk_pembimbing(Request $request)
    {
        $datapost = $request->all();
        try {
            $status = TrtPenguji::where('C_NPM', $request->c_npm)->where('tipe_ujian', 0)->update([
                'nomor_sk' => $request->nomor_sk
            ]);
            return redirect::to('fakultas/set_sk/' . $datapost['pendaftaran_id'] . '')->with('status', 'success');
        } catch (Exception $exception) {
            return redirect::to('fakultas/set_sk/' . $datapost['pendaftaran_id'] . '')->with('status', 'error');
        }
    }
}
