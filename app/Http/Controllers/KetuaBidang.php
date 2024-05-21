<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Model\mst_pendaftaran;
use App\Model\t_mst_mahasiswa;
use App\TrtJadwalUjian;
use App\TrtPenguji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class KetuaBidang extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('/tugasakhir/layouts/content');
    }

    public function penentuan_pembimbing()
    {
        $sessionBidang = strtolower(str_replace(' ', '', Auth::user()->name));
        $data_riwayat_usulan = DB::table('trt_topik')
            ->join('t_mst_mahasiswa', 'trt_topik.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->join('mst_tmp_usulan', 'trt_topik.C_NPM', '=', 'mst_tmp_usulan.C_NPM')
            ->select(
                't_mst_mahasiswa.C_NPM',
                't_mst_mahasiswa.NAMA_MAHASISWA',
                'trt_topik.topik',
                'trt_topik.kerangka',
                'trt_topik.status',
                'trt_topik.status_penetapan',
                'trt_topik.bidang_ilmu_peminatan',
                'mst_tmp_usulan.pembimbing_I_id',
                'mst_tmp_usulan.pembimbing_II_id',
                'mst_tmp_usulan.pembimbing_I_status',
                'mst_tmp_usulan.pembimbing_II_status'
            )
            ->orderBy('trt_topik.topik_id', 'desc')
            ->where('t_mst_mahasiswa.C_NPM', 'LIKE', '040%')
            ->whereRaw("LOWER(REPLACE(trt_topik.bidang_ilmu_peminatan, ' ', '')) = ?", [$sessionBidang])
            ->get();

        $listdosen = DB::table('t_mst_dosen')
            ->leftJoin("trt_level_pembimbing", "trt_level_pembimbing.C_KODE_DOSEN", "=", "t_mst_dosen.C_KODE_DOSEN")
            ->select('t_mst_dosen.*', 'trt_level_pembimbing.level')
            ->get();


        return view('tugasakhir.ketuabidang.penentuan_pembimbing', compact('data_riwayat_usulan', 'listdosen'));
    }

    public function penentuan_pembimbing_update()
    {
        try {
            $data = request()->all();
            $data['pembimbing_I_id'] = $data['pembimbing_ketua'] == '0' ? null : $data['pembimbing_ketua'];
            $data['pembimbing_II_id'] = $data['pembimbing_anggota'] == '0' ? null : $data['pembimbing_anggota'];

            $queryMstTmpUsulan = DB::table('mst_tmp_usulan')
                ->where('C_NPM', $data['C_NPM'])
                ->update([
                    'pembimbing_I_id' => $data['pembimbing_I_id'],
                    'pembimbing_II_id' => $data['pembimbing_II_id'],
                    'pembimbing_I_status' => 2,
                    'pembimbing_II_status' => 2
                ]);

            $queryTrtTopik = DB::table('trt_topik')
                ->where('C_NPM', $data['C_NPM'])
                ->update([
                    'status_penetapan' => 2
                ]);

            if ($queryMstTmpUsulan && $queryTrtTopik) {
                return redirect()->back()->with((['status' => "berhasil", 'message' => "Data berhasil disimpan"]));
            } else {
                return redirect()->back()->with((['status' => "gagal", 'message' => "Data gagal disimpan"]));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with((['status' => "gagal", 'message' => "Data gagal disimpan"]));
        }
    }

    public function peserta_proposal()
    {
        $pendaftaran = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
            ->where('tipe_ujian', 0)
            ->where('mst_pendaftaran.status_prodi', 1)
            ->orwhere('tipe_ujian', 3)
            ->orderBy('mst_pendaftaran.created_at', 'desc')
            ->get();
        return view('tugasakhir.ketuabidang.peserta_proposal', compact('pendaftaran'));
    }

    public function peserta_ujianmeja()
    {
        $pendaftaran = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
            ->where('tipe_ujian', 2)
            ->where('mst_pendaftaran.status_prodi', 1)
            ->orwhere('tipe_ujian', 3)
            ->orderBy('mst_pendaftaran.created_at', 'desc')
            ->get();
        return view('tugasakhir.ketuabidang.peserta_ujianmeja', compact('pendaftaran'));
    }

    public function daftar_peserta($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();

        // Asumsikan bahwa $sessionBidang sudah didefinisikan sebelumnya
        $sessionBidang = strtolower(str_replace(' ', '', auth()->user()->name));

        $data = DB::select("
        SELECT *
        FROM mst_pendaftaran
        JOIN trt_reg ON mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id
        JOIN trt_bimbingan ON trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id
        JOIN trt_penguji ON trt_penguji.C_NPM = trt_bimbingan.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status
        JOIN t_mst_mahasiswa ON trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM
        JOIN trt_topik ON trt_topik.C_NPM = trt_bimbingan.C_NPM
        WHERE mst_pendaftaran.pendaftaran_id = ?
        AND trt_reg.status = ?
        AND LOWER(REPLACE(trt_topik.bidang_ilmu_peminatan, ' ', '')) = ?", [$id, $info->tipe_ujian, $sessionBidang]);

        return view('tugasakhir.ketuabidang.daftar_peserta', compact("data", "info"));
    }


    public function set_penguji($pendaftaran_id, $nim, $tipe_ujian)
    {
        $info = t_mst_mahasiswa::join("trt_bimbingan", "trt_bimbingan.C_NPM", "=", "t_mst_mahasiswa.C_NPM")
            ->join('trt_penguji', 'trt_penguji.C_NPM', '=', 'trt_bimbingan.C_NPM')
            ->where("t_mst_mahasiswa.C_NPM", $nim)
            ->where('trt_penguji.tipe_ujian', $tipe_ujian)
            ->first();
        $dosen = Dosen::whereNotIn("C_KODE_DOSEN", [$info->pembimbing_I_id, $info->pembimbing_II_id])->get();
        return view('tugasakhir.ketuabidang.set_penguji', compact('dosen', "info", "pendaftaran_id"));
    }

    public function set_pengujipost($pendaftaran_id, Request $request)
    {
        try {
            $mst_pendaftaran = mst_pendaftaran::where("pendaftaran_id", $pendaftaran_id)->first();
            $request->merge(["tipe_ujian" => $mst_pendaftaran->tipe_ujian]);
            $trtpenguji = TrtPenguji::where([
                "C_NPM" => $request->C_NPM,
                "tipe_ujian" => $request->tipe_ujian
            ])->count();
            if (empty($trtpenguji)) :
                TrtPenguji::create($request->all());
            elseif (!empty($trtpenguji)) :
                TrtPenguji::where([
                    "C_NPM" => $request->C_NPM,
                    "tipe_ujian" => $request->tipe_ujian
                ])->update($request->except(["C_NPM", "tipe_ujian", "_token"]));
            endif;
            return redirect()->to("/ketuabidang/daftar_peserta/$pendaftaran_id")->with(["status" => "berhasil", "message" => "Data berhasil disimpan"]);
        } catch (\Throwable $th) {
            return redirect()->to("/ketuabidang/daftar_peserta/$pendaftaran_id")->with(["status" => "gagal", "message" => "Data gagal disimpan"]);
        }
    }
}
