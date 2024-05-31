<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Helper;
use App\Model\mst_pendaftaran;
use App\Model\t_mst_mahasiswa;
use App\Model\trt_bimbingan;
use App\Model\trt_hasil;
use App\MstRuangan;
use App\TrtJadwalUjian;
use App\TrtJadwalUjianPerMhs;
use App\TrtPenguji;
use Carbon\Carbon;
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
                'trt_topik.topik_id',
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
            ->where('trt_topik.status_penetapan', '!=', 99)
            ->orWhere('trt_topik.status_penetapan', 98)
            ->orWhere('trt_topik.status_penetapan', 97)
            ->whereRaw("LOWER(REPLACE(trt_topik.bidang_ilmu_peminatan, ' ', '')) = ?", [$sessionBidang])
            ->get();

        $listdosen = DB::table('t_mst_dosen')
            ->leftJoin("trt_level_pembimbing", "trt_level_pembimbing.C_KODE_DOSEN", "=", "t_mst_dosen.C_KODE_DOSEN")
            ->select('t_mst_dosen.*', 'trt_level_pembimbing.level')
            ->get();


        return view('tugasakhir.ketuabidang.penentuan_pembimbing', compact('data_riwayat_usulan', 'listdosen'));
    }

    public function tolak_bidang_penentuan_pembimbing(Request $request)
    {
        $data = $request->all();
        $query = DB::table('trt_topik')
            ->where([
                ['C_NPM', '=', $data['C_NPM']],
                ['topik_id', '=', $data['topik_id']]
            ])->update([
                'status_penetapan' => 98
            ]);

        if ($query) {
            return redirect()->back()->with((['status' => "berhasil", 'message' => "Data berhasil disimpan"]));
        } else {
            return redirect()->back()->with((['status' => "gagal", 'message' => "Data gagal disimpan"]));
        }
    }

    public function penentuan_pembimbing_update()
    {
        try {
            $data = request()->all();
            $data['pembimbing_I_id'] = $data['pembimbing_ketua'] == '0' ? null : $data['pembimbing_ketua'];
            $data['pembimbing_II_id'] = $data['pembimbing_anggota'] == '0' ? null : $data['pembimbing_anggota'];

            $queryMstTmpUsulan = DB::table('mst_tmp_usulan')
                ->where(
                    'C_NPM',
                    $data['C_NPM']
                )->update([
                    'pembimbing_I_id' => $data['pembimbing_I_id'],
                    'pembimbing_II_id' => $data['pembimbing_II_id'],
                    'pembimbing_I_status' => 2,
                    'pembimbing_II_status' => 2
                ]);

            $queryTrtTopik = DB::table('trt_topik')
                ->where([
                    ['C_NPM', '=', $data['C_NPM']],
                    ['topik_id', '=', $data['topik_id']]
                ])->update([
                    'status_penetapan' => 2
                ]);

            if ($queryMstTmpUsulan && $queryTrtTopik) {
                return redirect()->back()->with((['status' => "berhasil", 'message' => "Data berhasil disimpan"]));
            } else {
                return redirect()->back()->with((['status' => "gagal", 'message' => "Data gagal disimpan"]));
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die();
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

    public function peserta_seminarhasil()
    {
        $pendaftaran = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
            ->where('tipe_ujian', 1)
            ->where('mst_pendaftaran.status_prodi', 1)
            ->orwhere('tipe_ujian', 3)
            ->orderBy('mst_pendaftaran.created_at', 'desc')
            ->get();
        return view('tugasakhir.ketuabidang.peserta_seminarhasil', compact('pendaftaran'));
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

    public function approve_hasilujian_proposal()
    {
        $data = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
            ->where('tipe_ujian', 0)
            ->where('mst_pendaftaran.status_prodi', 1)
            ->orwhere('tipe_ujian', 3)
            ->orderBy('mst_pendaftaran.created_at', 'desc')
            ->get();
        return view('tugasakhir.ketuabidang.approve_hasilujian_proposal', compact('data'));
    }

    public function detail_hasilujian_proposal($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)
            ->first();

        $data = DB::select("
        SELECT *
        FROM mst_pendaftaran
        JOIN trt_reg ON mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id
        JOIN trt_bimbingan ON trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id
        JOIN t_mst_mahasiswa ON trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM
        JOIN trt_penguji ON trt_penguji.tipe_ujian = trt_reg.status AND trt_penguji.C_NPM = trt_bimbingan.C_NPM
        JOIN trt_topik ON trt_bimbingan.C_NPM = trt_topik.C_NPM
        WHERE trt_reg.pendaftaran_id = ?
        AND trt_reg.status = ?
        AND LOWER(REPLACE(trt_topik.bidang_ilmu_peminatan, ' ', '')) = ?
    ", [$id, $info->tipe_ujian, strtolower(str_replace(' ', '', auth()->user()->name))]);

        return view('tugasakhir.ketuabidang.detail_hasilujian_proposal', compact("data", "info"));
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
            return redirect('ketuabidang/detail_hasilujian_proposal/' . $pendaftaran_id)->with((['status' => "berhasil", 'message' => "berhasil menyetujui hasil ujian"]));
        } catch (\Throwable $th) {
            return redirect('ketuabidang/detail_hasilujian_proposal/' . $pendaftaran_id)->with((['status' => "gagal", 'message' => "gagal menyetujui hasil ujian"]));
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

        return redirect('ketuabidang/detail_hasilujian_proposal/' . $pendaftaran_id);
    }

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
            case "1":
                $tipe_ujian = "Seminar";
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

        return view("tugasakhir.ketuabidang.lembaran_hasilujian_proposal", compact(
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
        $data = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
            ->where('tipe_ujian', 2)
            ->where('mst_pendaftaran.status_prodi', 1)
            ->orwhere('tipe_ujian', 3)
            ->orderBy('mst_pendaftaran.created_at', 'desc')
            ->get();

        return view('tugasakhir.ketuabidang.approve_hasilujian_ta', compact('data'));
    }

    public function detail_hasilujian_ta($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)
            ->first();

        $data = DB::select("
        SELECT *
        FROM mst_pendaftaran
        JOIN trt_reg ON mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id
        JOIN trt_bimbingan ON trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id
        JOIN t_mst_mahasiswa ON trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM
        JOIN trt_penguji ON trt_penguji.tipe_ujian = trt_reg.status AND trt_penguji.C_NPM = trt_bimbingan.C_NPM
        JOIN trt_topik ON trt_bimbingan.C_NPM = trt_topik.C_NPM
        WHERE trt_reg.pendaftaran_id = ?
        AND trt_reg.status = ?
        AND LOWER(REPLACE(trt_topik.bidang_ilmu_peminatan, ' ', '')) = ?
        ", [$id, $info->tipe_ujian, strtolower(str_replace(' ', '', auth()->user()->name))]);

        return view('tugasakhir.ketuabidang.detail_hasilujian_ta', compact("data", "info"));
    }

    public function approve_hasilujian_ta_post($id, $nim, $pendaftaran_id)
    {
        DB::table('trt_bimbingan')
            ->where([
                "bimbingan_id" => $id,
                "C_NPM" => $nim
            ])
            ->update(['status_bimbingan' => 3]);
        return redirect('ketuabidang/detail_hasilujian_ta/' . $pendaftaran_id);
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
        return redirect('ketuabidang/detail_hasilujian_ta/' . $pendaftaran_id);
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
            case "1":
                $tipe_ujian = "Seminar";
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

        return view("tugasakhir.ketuabidang.lembaran_hasilujian_ta", compact(
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

    public function approve_hasilujian_seminar()
    {
        $data = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
            ->where('tipe_ujian', 1)
            ->where('mst_pendaftaran.status_prodi', 1)
            ->orwhere('tipe_ujian', 3)
            ->orderBy('mst_pendaftaran.created_at', 'desc')
            ->get();

        return view('tugasakhir.ketuabidang.approve_hasilujian_seminar', compact('data'));
    }

    public function detail_hasilujian_seminar($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)
            ->first();

        $data = DB::select("
        SELECT *
        FROM mst_pendaftaran
        JOIN trt_reg ON mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id
        JOIN trt_bimbingan ON trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id
        JOIN t_mst_mahasiswa ON trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM
        JOIN trt_penguji ON trt_penguji.tipe_ujian = trt_reg.status AND trt_penguji.C_NPM = trt_bimbingan.C_NPM
        JOIN trt_topik ON trt_bimbingan.C_NPM = trt_topik.C_NPM
        WHERE trt_reg.pendaftaran_id = ?
        AND trt_reg.status = ?
        AND LOWER(REPLACE(trt_topik.bidang_ilmu_peminatan, ' ', '')) = ?
        ", [$id, $info->tipe_ujian, strtolower(str_replace(' ', '', auth()->user()->name))]);

        return view('tugasakhir.ketuabidang.detail_hasilujian_seminar', compact("data", "info"));
    }

    public function approve_hasilujian_seminar_post($id, $nim, $pendaftaran_id)
    {
        try {
            DB::table('trt_bimbingan')
                ->where([
                    "bimbingan_id" => $id,
                    "C_NPM" => $nim
                ])
                ->update(['status_bimbingan' => 2]);
            return redirect('ketuabidang/detail_hasilujian_seminar/' . $pendaftaran_id)->with((['status' => "berhasil", 'message' => "berhasil menyetujui hasil ujian"]));
        } catch (\Throwable $th) {
            return redirect('ketuabidang/detail_hasilujian_seminar/' . $pendaftaran_id)->with((['status' => "gagal", 'message' => "gagal menyetujui hasil ujian"]));
        }
    }

    public function tolak_hasilujian_seminar_post($id, $nim, $pendaftaran_id)
    {
        DB::table('trt_bimbingan')
            ->where([
                "bimbingan_id" => $id,
                "C_NPM" => $nim
            ])
            ->update([
                'status_tolak_seminar' => 1,
            ]);

        DB::table('trt_reg')
            ->where([
                "bimbingan_id" => $id,
                "status" => 0
            ])
            ->delete();

        return redirect('ketuabidang/detail_hasilujian_seminar/' . $pendaftaran_id);
    }

    public function lembaran_hasilujian_seminar($pendaftaran_id, $nim, $reg_id)
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
            case "1":
                $tipe_ujian = "Seminar";
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
            ->where('trt_penguji.tipe_ujian', 1)
            ->first();

        $data_dosen_pembimbing = DB::table('trt_bimbingan')
            ->select("*")
            ->where("trt_bimbingan.C_NPM", $nim)
            ->first();

        return view("tugasakhir.ketuabidang.lembaran_hasilujian_seminar", compact(
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

    public function approve_hasilujian_seminar_all_post()
    {
        $data = DB::table('trt_bimbingan')
            ->join("trt_reg", "trt_reg.bimbingan_id", "=", "trt_bimbingan.bimbingan_id")
            ->select("trt_reg.reg_id", "trt_bimbingan.bimbingan_id")
            ->where("trt_bimbingan.status_bimbingan", 1)
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
                ->update(["status_bimbingan" => 2]);

            return redirect()->back()->with(['status' => 'success', 'total' => count($data_bimbingan_id)]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => 'error', 'total' => count($data_bimbingan_id)]);
        }
    }

    public function rekap_nilai_proposal()
    {
        $data = DB::select("SELECT DISTINCT mst_pendaftaran.pendaftaran_id, mst_pendaftaran.nama_periode, mst_pendaftaran.kuota, mst_pendaftaran.jml_peserta, trt_jadwal_ujian.tgl_ujian FROM mst_pendaftaran, trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa, trt_jadwal_ujian, trt_jadwal_ujian_per_mhs , mst_ruangan WHERE mst_pendaftaran.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND mst_ruangan.id =  trt_jadwal_ujian_per_mhs.ruangan AND trt_bimbingan.C_NPM = trt_jadwal_ujian_per_mhs.C_NPM AND trt_jadwal_ujian.id = trt_jadwal_ujian_per_mhs.jadwal_ujian AND trt_jadwal_ujian.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND mst_pendaftaran.tipe_ujian = ? AND  trt_penguji.tipe_ujian = ? AND trt_reg.status = ? ORDER BY trt_reg.pendaftaran_id", [0, 0, 0]);
        return view('tugasakhir.ketuabidang.rekap_nilai_proposal', compact('data'));
    }

    public function detail_rekap_nilai_proposal($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();

        $data = DB::select("
        SELECT *
        FROM mst_pendaftaran
        JOIN trt_reg ON mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id
        JOIN trt_bimbingan ON trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id
        JOIN t_mst_mahasiswa ON trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM
        JOIN trt_penguji ON trt_penguji.tipe_ujian = trt_reg.status AND trt_penguji.C_NPM = trt_bimbingan.C_NPM
        JOIN trt_topik ON trt_bimbingan.C_NPM = trt_topik.C_NPM
        WHERE trt_reg.pendaftaran_id = ?
        AND trt_reg.status = ?
        AND LOWER(REPLACE(trt_topik.bidang_ilmu_peminatan, ' ', '')) = ?
        ", [$id, $info->tipe_ujian, strtolower(str_replace(' ', '', auth()->user()->name))]);

        return view('tugasakhir.ketuabidang.detail_rekap_nilai_proposal', compact("data", "info"));
    }


    public function rekap_nilai_ujian_ta()
    {
        $data = DB::select("SELECT DISTINCT mst_pendaftaran.pendaftaran_id, mst_pendaftaran.nama_periode, mst_pendaftaran.kuota, mst_pendaftaran.jml_peserta, trt_jadwal_ujian.tgl_ujian FROM mst_pendaftaran, trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa, trt_jadwal_ujian, trt_jadwal_ujian_per_mhs , mst_ruangan WHERE mst_pendaftaran.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND mst_ruangan.id =  trt_jadwal_ujian_per_mhs.ruangan AND trt_bimbingan.C_NPM = trt_jadwal_ujian_per_mhs.C_NPM AND trt_jadwal_ujian.id = trt_jadwal_ujian_per_mhs.jadwal_ujian AND trt_jadwal_ujian.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM  AND mst_pendaftaran.tipe_ujian = ? AND  trt_penguji.tipe_ujian = ? AND trt_reg.status = ? ORDER BY trt_reg.pendaftaran_id", [2, 2, 2]);
        return view('tugasakhir.ketuabidang.rekap_nilai_ujian_ta', compact('data'));
    }

    public function detail_rekap_nilai_ujian_ta($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();

        $data = DB::select("
        SELECT *
        FROM mst_pendaftaran
        JOIN trt_reg ON mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id
        JOIN trt_bimbingan ON trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id
        JOIN t_mst_mahasiswa ON trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM
        JOIN trt_penguji ON trt_penguji.tipe_ujian = trt_reg.status AND trt_penguji.C_NPM = trt_bimbingan.C_NPM
        JOIN trt_topik ON trt_bimbingan.C_NPM = trt_topik.C_NPM
        WHERE trt_reg.pendaftaran_id = ?
        AND trt_reg.status = ?
        AND LOWER(REPLACE(trt_topik.bidang_ilmu_peminatan, ' ', '')) = ?
        ", [$id, $info->tipe_ujian, strtolower(str_replace(' ', '', auth()->user()->name))]);

        return view('tugasakhir.ketuabidang.detail_rekap_nilai_ujian_ta', compact("data", "info"));
    }

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
            case "1":
                $tipe_ujian = "Seminar";
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

        return view("tugasakhir.ketuabidang.lembaran_hasilujian_ujian_ta", compact(
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

    public function rekap_nilai_seminar()
    {
        $data = DB::select("SELECT DISTINCT mst_pendaftaran.pendaftaran_id, mst_pendaftaran.nama_periode, mst_pendaftaran.kuota, mst_pendaftaran.jml_peserta, trt_jadwal_ujian.tgl_ujian FROM mst_pendaftaran, trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa, trt_jadwal_ujian, trt_jadwal_ujian_per_mhs , mst_ruangan WHERE mst_pendaftaran.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND mst_ruangan.id =  trt_jadwal_ujian_per_mhs.ruangan AND trt_bimbingan.C_NPM = trt_jadwal_ujian_per_mhs.C_NPM AND trt_jadwal_ujian.id = trt_jadwal_ujian_per_mhs.jadwal_ujian AND trt_jadwal_ujian.pendaftaran_id = mst_pendaftaran.pendaftaran_id AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM AND trt_penguji.tipe_ujian = trt_reg.status AND  trt_penguji.C_NPM = trt_bimbingan.C_NPM AND mst_pendaftaran.tipe_ujian = ? AND  trt_penguji.tipe_ujian = ? AND trt_reg.status = ? ORDER BY trt_reg.pendaftaran_id", [1, 1, 1]);
        return view('tugasakhir.ketuabidang.rekap_nilai_seminar', compact('data'));
    }

    public function detail_rekap_nilai_seminar($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();

        $data = DB::select("
        SELECT *
        FROM mst_pendaftaran
        JOIN trt_reg ON mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id
        JOIN trt_bimbingan ON trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id
        JOIN t_mst_mahasiswa ON trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM
        JOIN trt_penguji ON trt_penguji.tipe_ujian = trt_reg.status AND trt_penguji.C_NPM = trt_bimbingan.C_NPM
        JOIN trt_topik ON trt_bimbingan.C_NPM = trt_topik.C_NPM
        WHERE trt_reg.pendaftaran_id = ?
        AND trt_reg.status = ?
        AND LOWER(REPLACE(trt_topik.bidang_ilmu_peminatan, ' ', '')) = ?
        ", [$id, $info->tipe_ujian, strtolower(str_replace(' ', '', auth()->user()->name))]);

        return view('tugasakhir.ketuabidang.detail_rekap_nilai_seminar', compact("data", "info"));
    }
}
