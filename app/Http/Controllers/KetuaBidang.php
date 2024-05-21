<?php

namespace App\Http\Controllers;

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
}
