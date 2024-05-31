<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Model\mst_pendaftaran;
use App\Model\mst_tmp_usulan;
use App\Model\t_mst_mahasiswa;
use App\Model\trt_bimbingan;
use App\Model\trt_topik;
use App\TrtJadwalUjian;
use App\TrtPenguji;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class WakilDekan extends Controller
{
    // Menampilkan SK Pembimbing
    public function sk_pembimbing()
    {
        $data_sk = DB::table('mst_sk_pembimbing')
            ->join('trt_bimbingan', 'mst_sk_pembimbing.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->select('*')
            ->where("mst_sk_pembimbing.status", 0)
            ->orderBy('mst_sk_pembimbing.sk_pembimbing_id', 'DESC')
            ->get();
        return view('tugasakhir.wakildekan.sk_pembimbing', compact('data_sk'));
    }

    // Menampilkan Status Bimbingan Mahasiswa
    public function detail_status_bimbingan_mahasiswa($status)
    {
        $data = DB::table('trt_bimbingan')
            ->select("*")
            ->where('trt_bimbingan.status_bimbingan', $status)
            ->get();

        return view('tugasakhir.wakildekan.detail_status_bimbingan_mahasiswa', compact('data', 'status'));
    }
    // Akhir Menampilkan Status Bimbingan Mahasiswa


    // Approve SK Pembimbing
    public function approve_sk_pembimbing($id)
    {
        try {
            DB::update('update mst_sk_pembimbing set status = 2 where sk_pembimbing_id = ?', [$id]);
            return redirect::to('wakildekan/sk_pembimbing')->with('status', 'success');
        } catch (Exception $exception) {
            return redirect::to('wakildekan/sk_pembimbing')->with('status', 'error');
        }
    }

    // Menampilkan SK Pembimbing
    public function sk_ujian_ta()
    {
        $data_sk = DB::table('mst_sk_penugasan')
            ->join('trt_bimbingan', 'mst_sk_penugasan.bimbingan_id', '=', 'trt_bimbingan.bimbingan_id')
            ->select('*')
            ->where("mst_sk_penugasan.status", 0)
            ->orderBy('mst_sk_penugasan.sk_penugasan_id', 'DESC')
            ->get();
        return view('tugasakhir.wakildekan.sk_ujian_ta', compact('data_sk'));
    }

    // Approve SK Pembimbing
    public function approve_sk_ujian_ta($id)
    {
        try {
            DB::update('update mst_sk_penugasan set status = 2 where sk_penugasan_id = ?', [$id]);
            return redirect::to('wakildekan/sk_ujian_ta')->with('status', 'success');
        } catch (Exception $exception) {
            return redirect::to('wakildekan/sk_ujian_ta')->with('status', 'error');
        }
    }

    public function topik()
    {
        $data_pengusul = DB::table('trt_topik')
            ->join('t_mst_mahasiswa', 'trt_topik.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->select('t_mst_mahasiswa.C_NPM', 't_mst_mahasiswa.C_NPM', 't_mst_mahasiswa.NAMA_MAHASISWA')
            ->where('trt_topik.status', 0)
            ->distinct()
            ->get();

        $data_riwayat_usulan = DB::table('trt_topik')
            ->join('t_mst_mahasiswa', 'trt_topik.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->select('t_mst_mahasiswa.C_NPM', 't_mst_mahasiswa.NAMA_MAHASISWA', 'trt_topik.topik', 'trt_topik.kerangka', 'trt_topik.status')
            ->get();
        return view('tugasakhir.wakildekan.topik', compact('data_riwayat_usulan', 'data_pengusul'));
    }

    public function topikpost(Request $request)
    {
        $datapost = $request->all();

        DB::table('trt_topik')
            ->where('topik_id', $datapost['topik_id'])
            ->update(['status' => '1']);

        DB::table('trt_topik')
            ->where('C_NPM', $datapost['C_NPM'])
            ->where('status', 0)
            ->update(['status' => '2']);
        return redirect::to('wakildekan/topik');
    }

    public function detail_topikusulan($id)
    {
        $data = DB::table('t_mst_mahasiswa')
            ->select('*')
            ->where('C_NPM', $id)
            ->first();
        $data_usulan = DB::table('trt_topik')
            ->where('trt_topik.C_NPM', $id)
            ->join('t_mst_mahasiswa', 'trt_topik.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->select('*')
            ->get();
        return view('tugasakhir.wakildekan.detail_topikusulan', compact('data', 'data_usulan'));
    }

    // Ubah Note Pada Prodi
    public function detail_note($id)
    {
        $data = DB::table("trt_topik")
            ->select("*")
            ->where("topik_id", $id)
            ->get();
        return view("tugasakhir.wakildekan.detail_note", compact('data'));
    }
    // Ubah Note Pada Prodi

    // Proses Ubah Note Pada Prodi
    public function note_update(Request $request, $id)
    {
        trt_topik::where("topik_id", $id)
            ->update([
                'note' => $request->note,
            ]);
        return redirect::to('wakildekan/topik');
    }
    // Akhir Proses Ubah Note Pada Prodi

    public function tolak_topik_penelitian($id)
    {
        try {

            DB::table('trt_topik')
                ->where('topik_id', $id)
                ->update([
                    'status' => 2
                ]);

            return redirect()->back()->with(['status' => "berhasil"]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => "gagal"]);
        }
    }

    public function penetapan_pembimbing_dan_judul()
    {
        try {
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
                ->where('trt_topik.status_penetapan', '=', 2)
                ->orWhere('trt_topik.status_penetapan', '=', 3)
                ->get();

            $listdosen = DB::table('t_mst_dosen')
                ->leftJoin("trt_level_pembimbing", "trt_level_pembimbing.C_KODE_DOSEN", "=", "t_mst_dosen.C_KODE_DOSEN")
                ->select('t_mst_dosen.*', 'trt_level_pembimbing.level')
                ->get();

            return view('tugasakhir.wakildekan.penetapan_pembimbing_dan_judul', compact('data_riwayat_usulan', 'listdosen'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => "gagal", 'message' => $e->getMessage()]);
        }
    }

    public function penetapan_pembimbing_dan_judul_post()
    {
        try {
            $data = request()->all();
            $data['topik'] = $data['topik'] == '-' ? null : $data['topik'];
            $data['pembimbing_I_id'] = $data['pembimbing_ketua'] == '0' ? null : $data['pembimbing_ketua'];
            $data['pembimbing_II_id'] = $data['pembimbing_anggota'] == '0' ? null : $data['pembimbing_anggota'];

            DB::table('mst_tmp_usulan')
                ->where('C_NPM', $data['C_NPM'])
                ->update([
                    'pembimbing_I_id' => $data['pembimbing_I_id'],
                    'pembimbing_II_id' => $data['pembimbing_II_id'],
                    'pembimbing_I_status' => 1,
                    'pembimbing_II_status' => 1
                ]);

            DB::table('trt_topik')
                ->where([
                    ['C_NPM', '=', $data['C_NPM']],
                    ['topik_id', '=', $data['topik_id']]
                ])->update([
                    'topik' => $data['topik'],
                    'status_penetapan' => 3,
                    'status' => 1,
                ]);

            return redirect()->back()->with((['status' => "berhasil", 'message' => "Data berhasil disimpan"]));
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
        return view('tugasakhir.wakildekan.peserta_proposal', compact('pendaftaran'));
    }

    public function peserta_seminarhasil()
    {
        $pendaftaran = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
            ->where('tipe_ujian', 1)
            ->where('mst_pendaftaran.status_prodi', 1)
            ->orwhere('tipe_ujian', 3)
            ->orderBy('mst_pendaftaran.created_at', 'desc')
            ->get();
        return view('tugasakhir.wakildekan.peserta_seminarhasil', compact('pendaftaran'));
    }

    public function peserta_ujianmeja()
    {
        $pendaftaran = mst_pendaftaran::join("trt_jadwal_ujian", "trt_jadwal_ujian.pendaftaran_id", "=", "mst_pendaftaran.pendaftaran_id")
            ->where('tipe_ujian', 2)
            ->where('mst_pendaftaran.status_prodi', 1)
            ->orwhere('tipe_ujian', 3)
            ->orderBy('mst_pendaftaran.created_at', 'desc')
            ->get();
        return view('tugasakhir.wakildekan.peserta_ujianmeja', compact('pendaftaran'));
    }

    public function daftar_peserta($id)
    {
        $info = TrtJadwalUjian::join("mst_pendaftaran", "mst_pendaftaran.pendaftaran_id", "=", "trt_jadwal_ujian.pendaftaran_id")
            ->where("mst_pendaftaran.pendaftaran_id", $id)->first();
        $data = DB::select("SELECT * FROM mst_pendaftaran,trt_reg, trt_bimbingan, trt_penguji, t_mst_mahasiswa
                WHERE mst_pendaftaran.pendaftaran_id = trt_reg.pendaftaran_id
                AND trt_reg.bimbingan_id = trt_bimbingan.bimbingan_id
                AND trt_bimbingan.C_NPM = t_mst_mahasiswa.C_NPM
                AND trt_penguji.tipe_ujian = trt_reg.status
                AND trt_penguji.C_NPM = trt_bimbingan.C_NPM
                AND trt_reg.pendaftaran_id = ?
                AND trt_reg.status = ?", [$id, $info->tipe_ujian]);

        return view('tugasakhir.wakildekan.daftar_peserta', compact("data", "info"));
    }

    public function set_penguji($pendaftaran_id, $nim, $tipe_ujian)
    {
        $info = t_mst_mahasiswa::join("trt_bimbingan", "trt_bimbingan.C_NPM", "=", "t_mst_mahasiswa.C_NPM")
            ->join('trt_penguji', 'trt_penguji.C_NPM', '=', 'trt_bimbingan.C_NPM')
            ->where("t_mst_mahasiswa.C_NPM", $nim)
            ->where('trt_penguji.tipe_ujian', $tipe_ujian)
            ->first();
        $dosen = Dosen::whereNotIn("C_KODE_DOSEN", [$info->pembimbing_I_id, $info->pembimbing_II_id])->get();
        return view('tugasakhir.wakildekan.set_penguji', compact('dosen', "info", "pendaftaran_id"));
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
                    "tipe_ujian" => $request->tipe_ujian,
                ])->update($request->except(["C_NPM", "tipe_ujian", "_token"]));
            endif;
            return redirect()->to("/wakildekan/daftar_peserta/$pendaftaran_id")->with(["status" => "berhasil", "message" => "Data berhasil disimpan"]);
        } catch (\Throwable $th) {
            return redirect()->to("/wakildekan/daftar_peserta/$pendaftaran_id")->with(["status" => "gagal", "message" => "Data gagal disimpan"]);
        }
    }

    public function request_surat_lokasi_penelitian()
    {
        try {
            $data_lokasi_penelitian = DB::table('mst_lokasi_penelitian')
                ->select('*')
                ->get();

            return view('tugasakhir.wakildekan.request_surat_lokasi_penelitian', compact('data_lokasi_penelitian'));
        } catch (Exception $error) {
            return redirect()->back();
        }
    }

    public function request_surat_lokasi_penelitian_update(Request $request)
    {
        $datapost = $request->all();
        try {
            DB::table('mst_lokasi_penelitian')
                ->where('id', $datapost['id'])
                ->update([
                    'status' => 2
                ]);

            return redirect()->back()->with((['status' => "berhasil", 'message' => "Berhasil set sk"]));
        } catch (Exception $error) {
            return redirect()->back()->with((['status' => "gagal", 'message' => "Gagal set sk"]));
        }
    }
}
