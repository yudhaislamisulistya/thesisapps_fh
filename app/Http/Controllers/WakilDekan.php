<?php

namespace App\Http\Controllers;

use App\Model\mst_tmp_usulan;
use App\Model\trt_bimbingan;
use App\Model\trt_topik;
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
            DB::update('update mst_sk_penugasan set status = 1 where sk_penugasan_id = ?', [$id]);
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
                ->where('C_NPM', $data['C_NPM'])
                ->update([
                    'topik' => $data['topik'],
                    'status_penetapan' => 3,
                    'status' => 1,
                ]);

            return redirect()->back()->with((['status' => "berhasil", 'message' => "Data berhasil disimpan"]));
        } catch (\Exception $e) {
            return redirect()->back()->with((['status' => "gagal", 'message' => "Data gagal disimpan"]));
        }
    }
}
