<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Model\mst_bidangilmu;
use App\Model\mst_pendaftaran;
use App\Model\mst_pengumuman;
use App\Model\mst_syarat_ujian;
use App\Model\mst_tmp_usulan;
use App\Model\t_mst_mahasiswa;
use App\Model\trt_bimbingan;
use App\Model\trt_sk;
use App\Model\users;
use App\TrtLevelPembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class prodi extends Controller
{
    public function dosen_pembimbing()
    {
        $data = DB::table('t_mst_dosen')
            ->leftJoin("trt_level_pembimbing", "trt_level_pembimbing.C_KODE_DOSEN", "=", "t_mst_dosen.C_KODE_DOSEN")
            ->select('t_mst_dosen.*', 'trt_level_pembimbing.level')
            ->get();
        return view('tugasakhir.prodi.dosen_pembimbing', compact('data'));
    }

    public function detail_pembimbing($id)
    {
        $data = DB::table('t_mst_dosen')
            ->select('*')
            ->where('C_KODE_DOSEN', $id)
            ->first();

        $data_bimbingan1 = DB::table('trt_bimbingan')
            ->join('t_mst_mahasiswa', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->join('mst_sk_pembimbing', 'trt_bimbingan.bimbingan_id', '=', 'mst_sk_pembimbing.bimbingan_id')
            ->where('pembimbing_I_id', $id)
            ->get();

        $data_bimbingan2 = DB::table('trt_bimbingan')
            ->join('t_mst_mahasiswa', 'trt_bimbingan.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->where('pembimbing_II_id', $id)
            ->get();
        $total = count($data_bimbingan1) + count($data_bimbingan2);

        $ppropI = DB::table('trt_bimbingan')
            ->where('pembimbing_I_id', $id)
            ->where('status_bimbingan', 0)
            ->get();
        $ppropII = DB::table('trt_bimbingan')
            ->where('pembimbing_II_id', $id)
            ->where('status_bimbingan', 0)
            ->get();
        $phasilI = DB::table('trt_bimbingan')
            ->where('pembimbing_I_id', $id)
            ->where('status_bimbingan', 1)
            ->get();
        $phasilII = DB::table('trt_bimbingan')
            ->where('pembimbing_II_id', $id)
            ->where('status_bimbingan', 1)
            ->get();
        $pmejaI = DB::table('trt_bimbingan')
            ->where('pembimbing_I_id', $id)
            ->where('status_bimbingan', 2)
            ->get();
        $pmejaII = DB::table('trt_bimbingan')
            ->where('pembimbing_II_id', $id)
            ->where('status_bimbingan', 2)
            ->get();
        $alumniI = DB::table('trt_bimbingan')
            ->where('pembimbing_I_id', $id)
            ->where('status_bimbingan', 3)
            ->get();
        $alumniII = DB::table('trt_bimbingan')
            ->where('pembimbing_II_id', $id)
            ->where('status_bimbingan', 3)
            ->get();
        return view('tugasakhir.prodi.detail_pembimbing', compact(
            'data',
            'total',
            'data_bimbingan1',
            'data_bimbingan2',
            'ppropI',
            'ppropII',
            'phasilI',
            'phasilII',
            'pmejaI',
            'pmejaII',
            'alumniI',
            'alumniII'
        ));
    }

    public function mahasiswa()
    {
        $data = DB::table('t_mst_mahasiswa')
            ->select('*')
            ->get();
        return view('tugasakhir.prodi.mahasiswa', compact('data'));
    }

    public function detail_mahasiswa($id)
    {

        $datax = t_mst_mahasiswa::find($id);
        //$data = DB::table('t_mst_mahasiswa')->where('C_NPM',$id)->get();

        //dd($datax->C_NPM,$datax->NAMA_MAHASISWA);

        return view('tugasakhir.prodi.detail_mahasiswa', compact('datax'));
    }

    public function make_user($id)
    {
        $cek = DB::table('users')
            ->select('*')
            ->where('name', $id)
            ->get();
        if ($cek->isEmpty()) {
            $datapost['name'] = $id;
            $datapost['email'] = $id;
            $datapost['password'] = '$2y$10$r.fqTwSMxeulBuEVYVGjP.onKuLoSVVPBN.ZSyV4ext75kSp8RE0S';
            $datapost['remeber_password'] = 'MEDGZU9Xzuq84ejg5awqIJxFYbaJ9YxFXJ05fx9MeZdAyjcHA94rIS19wcOF';
            $datapost['level'] = 8;
            users::create($datapost);
        }
        //        $data = DB::table('t_mst_mahasiswa')
        //                  ->select('*')
        //                  ->get();
        return redirect()->back();
    }

    public function reset_user($id)
    {
        $cek = DB::table('users')
            ->select('*')
            ->where('name', $id)
            ->get();
        if ($cek->isNotEmpty()) {
            DB::table('users')
                ->where('name', $id)
                ->update(['password' => '$2y$10$r.fqTwSMxeulBuEVYVGjP.onKuLoSVVPBN.ZSyV4ext75kSp8RE0S']);
        }

        //        $data = DB::table('t_mst_mahasiswa')
        //                  ->select('*')
        //                  ->get();
        return redirect()->back();
    }

    public function make_userx($id)
    {
        $cek = DB::table('users')
            ->select('*')
            ->where('name', $id)
            ->get();
        if ($cek->isEmpty()) {
            $datapost['name'] = $id;
            $datapost['email'] = $id;
            $datapost['password'] = '$2y$10$hfjF7eEk1buEJjOBGP1ununuy19tXPnJjJFvvNrq8cRH1rlKEfNhC';
            //            $datapost['password'] =  Hash::make("dosenfikom");
            $datapost['remeber_password'] = 'MEDGZU9Xzuq84ejg5awqIJxFYbaJ9YxFXJ05fx9MeZdAyjcHA94rIS19wcOF';
            $datapost['level'] = 7;
            users::create($datapost);
        }
        //        $data = DB::table('t_mst_dosen')
        //                  ->select('*')
        //                  ->get();
        return redirect()->back();
    }

    public function reset_userx($id)
    {
        $cek = DB::table('users')
            ->select('*')
            ->where('name', $id)
            ->get();
        if ($cek->isNotEmpty()) {
            DB::table('users')
                ->where('name', $id)
                ->update(['password' => '$2y$10$hfjF7eEk1buEJjOBGP1ununuy19tXPnJjJFvvNrq8cRH1rlKEfNhC']);
            //              ->update(['password' => Hash::make("dosenfikom")]);
        }

        //        $data = DB::table('t_mst_mahasiswa')
        //                  ->select('*')
        //                  ->get();
        return redirect()->back();
    }


    public function surat_pengusulanujianta()
    {
        return view('tugasakhir.prodi.surat_usulantimujian');
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
        return view('tugasakhir.prodi.topik', compact('data_riwayat_usulan', 'data_pengusul'));
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
        return redirect::to('prodi/topik');
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
        return $data_usulan;
        return view('tugasakhir.prodi.detail_topikusulan', compact('data', 'data_usulan'));
    }

    public function usulan_pembimbing()
    {
        $data = DB::table('trt_topik')
            ->join('t_mst_mahasiswa', 'trt_topik.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->select('t_mst_mahasiswa.*', 'trt_topik.*')
            ->where('trt_topik.status', 1)
            ->whereNotIn(
                't_mst_mahasiswa.C_NPM',
                function ($q) {
                    $q
                        ->select('C_NPM')
                        ->from('trt_bimbingan');
                }
            )
            ->get();
        return view('tugasakhir.prodi.usulan_pembimbing', compact('data'));
    }

    public function usulan_timujianta()
    {
        $data = DB::table('trt_topik')
            ->join('t_mst_mahasiswa', 'trt_topik.C_NPM', '=', 't_mst_mahasiswa.C_NPM')
            ->select('t_mst_mahasiswa.*', 'trt_topik.*')
            ->where('trt_topik.status', 1)
            ->whereNotIn(
                't_mst_mahasiswa.C_NPM',
                function ($q) {
                    $q
                        ->select('C_NPM')
                        ->from('trt_bimbingan');
                }
            )
            ->get();
        return view('tugasakhir.prodi.surat_usulantimujian', compact('data'));
    }

    public function usulan_pembimbingpostadd(Request $request)
    {
        $datapost = $request->all();
        $datapost['status_I'] = '0';
        $datapost['status_II'] = '0';
        $datapost['status_bimbingan'] = '0';
        $datapost['status_sk'] = '0';
        $datapost['user_id'] = '1';
        trt_bimbingan::create($datapost);
        mst_tmp_usulan::where("C_NPM", $request->C_NPM)->delete();

        return redirect::to('prodi/usulan_pembimbing');
    }

    public function set_pembimbing($id)
    {
        $cek = DB::table('mst_tmp_usulan')
            ->select('*')
            ->where('C_NPM', $id)
            ->get();
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
        return view('tugasakhir.prodi.set_pembimbing', compact('data', 'data_mahasiswa', 'data_topik', 'cek'));
    }

    public function set_penguji()
    {
        $data = DB::table('t_mst_dosen')
            ->select('*')
            ->get();
        return view('tugasakhir.prodi.set_penguji', compact('data'));
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
            ->get();
        return view('tugasakhir.prodi.sk_pembimbing', compact('riwayat_usulan', 'penetapan_pengusulan', 'data'));
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

            return view('tugasakhir.prodi.sk_pengusulan', compact('datax', 'data'));
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
        return view('tugasakhir.prodi.suratpengusulan', compact('nomor', 'perihal', 'tgl', 'datax'));
    }

    public function cetakskpenguji()
    {
        return view('tugasakhir.prodi.cetakskpenguji');
    }


    public function surat_pengusulanold(Request $request)
    {
        $datapost = $request->all();

        $datask = DB::table('trt_sk')
            ->select('*')
            ->where('nomor', $datapost['nomor'])
            ->get();

        foreach ($datask as $key => $value) {
            $tes[++$key] = $value->bimbingan_id;
        }


        $datax = DB::table('trt_bimbingan')
            ->select('*')
            ->whereIn('trt_bimbingan.bimbingan_id', $tes)
            ->get();

        return view('tugasakhir.prodi.suratpengusulanold', compact('datask', 'datax'));
    }


    public function peserta_proposal()
    {
        $pendaftaran = DB::table('mst_pendaftaran')
            ->select('*')
            ->where('tipe_ujian', 0)
            ->orwhere('tipe_ujian', 3)
            ->get();
        return view('tugasakhir.prodi.peserta_proposal', compact('pendaftaran'));
    }

    public function peserta_seminarhasil()
    {
        $pendaftaran = DB::table('mst_pendaftaran')
            ->select('*')
            ->where('tipe_ujian', 1)
            ->orwhere('tipe_ujian', 3)
            ->get();
        return view('tugasakhir.prodi.peserta_seminarhasil', compact('pendaftaran'));
    }

    public function peserta_ujianmeja()
    {
        $pendaftaran = DB::table('mst_pendaftaran')
            ->select('*')
            ->where('tipe_ujian', 2)
            ->orwhere('tipe_ujian', 3)
            ->get();
        return view('tugasakhir.prodi.peserta_ujianmeja', compact('pendaftaran'));
    }

    public function daftar_peserta($id)
    {

        return view('tugasakhir.prodi.daftar_peserta');
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
        return view('tugasakhir.prodi.syarat_ujian', compact('data0', 'data1', 'data2'));
    }

    public function jadwal()
    {
        $pendaftaran = DB::table('mst_pendaftaran')
            ->select('*')
            ->get();
        return view('tugasakhir.prodi.jadwal', compact('pendaftaran'));
    }

    public function scope_ta()
    {
        $data = DB::table('mst_bidangilmu')
            ->select('*')
            ->get();
        return view('tugasakhir.prodi.scope_ta', compact('data'));
    }

    public function jadwalpostadd(Request $request)
    {
        // $datapost = $request->all();
        // $datapost['user_id'] = '00';
        // $datapost['jml_peserta'] = 0;
        // mst_pendaftaran::create($datapost);
        // return redirect::to('prodi/jadwal');
    }

    public function syaratadd(Request $request)
    {
        $datapost = $request->all();
        mst_syarat_ujian::create($datapost);
        return redirect::to('prodi/syarat_ujian');
    }

    public function scope_add(Request $request)
    {
        $datapost = $request->all();
        mst_bidangilmu::create($datapost);
        return redirect::to('prodi/scope_ta');
    }

    public function scope_del($id)
    {
        DB::table('mst_bidangilmu')
            ->where('bidangilmu_id', $id)
            ->delete();
        return redirect::to('prodi/scope_ta');
    }

    public function syaratdel($id)
    {
        DB::table('mst_syarat_ujian')
            ->where('syarat_ujian_id', $id)
            ->delete();
        return redirect::to('prodi/syarat_ujian');
    }

    public function pendaftarandel($id)
    {
        DB::table('mst_pendaftaran')
            ->where('pendaftaran_id', $id)
            ->delete();
        return redirect::to('prodi/jadwal');
    }


    public function sk_ujian()
    {
        return view('tugasakhir.prodi.sk_ujian');
    }

    public function pengumuman()
    {
        $data = mst_pengumuman::all();
        return view('tugasakhir.prodi.pengumuman', compact('data'));
    }

    public function pengumumanpost(Request $request)
    {
        $datapost = $request->all();
        $gambar = isset($datapost['gambar']) ? $datapost['gambar'] : '';
        $datapost['gambar'] = Helper::uploadImage($gambar, 'gambar/', '');
        $datapost['last_update'] = Helper::tgl($datapost['last_update']);
        $datapost['user_id'] = '1';
        mst_pengumuman::create($datapost);
        return redirect::to('prodi/pengumuman');
    }

    public function pengumumandel($id)
    {
        DB::table('mst_pengumuman')
            ->where('pengumuman_id', $id)
            ->delete();
        return redirect::to('prodi/pengumuman');
    }

    public function setlevelpembimbing($dosen, $level)
    {
        $cek = TrtLevelPembimbing::where("C_KODE_DOSEN", $dosen)->get();
        if ($cek->isNotEmpty()) {
            TrtLevelPembimbing::where("C_KODE_DOSEN", $dosen)->update([
                "level" => $level
            ]);
        } else {
            TrtLevelPembimbing::create([
                "C_KODE_DOSEN" => $dosen,
                "level" => $level
            ]);
        }
        return redirect()->back();
    }

    public function getPembimbingStatus($index, $id, $mahasiswa)
    {
        if ($index == "0") {
            $pembimbing = mst_tmp_usulan::where(["pembimbing_I_id" => $id, "C_NPM" => $mahasiswa])->firstOrFail();
            return response()->json($pembimbing->pembimbing_I_status);
        } elseif ($index == "1") {
            $pembimbing = mst_tmp_usulan::where(["pembimbing_II_id" => $id, "C_NPM" => $mahasiswa])->firstOrFail();
            return response()->json($pembimbing->pembimbing_II_status);
        }
        return abort(404);
    }

    public function statusBimbingan()
    {
        $data = (object) [
            "y" => "",
            "PP" => trt_bimbingan::where("status_bimbingan", 0)->count(),
            "PSH" => trt_bimbingan::where("status_bimbingan", 1)->count(),
            "PUM" => trt_bimbingan::where("status_bimbingan", 2)->count(),
            "L" => trt_bimbingan::where("status_bimbingan", 3)->count()
        ];

        return response()->json($data);
    }
}
