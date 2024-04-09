<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Model\mst_bidangilmu;
use App\Model\mst_ketua_bidang;
use App\Model\mst_periode_jabatan;
use App\Model\mst_ruangan;
use App\Model\t_mst_dosen;
use App\Model\trt_prodi;
use App\Model\users;

class Admin extends Controller
{
    public function periode_jabatan(){
        $data = mst_periode_jabatan::all();
        return view('tugasakhir.admin.periode_jabatan', compact('data'));
    }

    public function periode_jabatan_update(){
        try {
            $request = request()->all();
            $data = mst_periode_jabatan::find($request['id_jabatan']);
            $data->nama = $request['nama'];
            $data->status = $request['status'];
            $data->tanggal_menjabat = $request['tanggal_menjabat'];
            $data->tanggal_berakhir = $request['tanggal_berakhir'];
            $data->email = $request['email'];
            $data->no_telepon = $request['no_telepon'];
            $filename = 'ttd-' . time() . '.png';

            if (request()->hasFile('ttd')) {
                $file = request()->file('ttd');
                $file->move('gambar', $filename);
                $data->ttd = $filename;
            }

            $data->save();

            return redirect()->back()->with(['status' => "berhasil"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal"]);
        }
    }

    public function bidang_ilmu(){
        $data = mst_bidangilmu::orderBy('bidangilmu_id', 'desc')->get();
        return view('tugasakhir.admin.bidang_ilmu', compact('data'));
    }

    public function bidang_ilmu_create(){
        try {
            $request = request()->all();
            $data = new mst_bidangilmu();
            $data->bidang_ilmu = $request['nama'];
            $data->save();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil menambahkan bidang ilmu"]);
        } catch (\Exception $th) {
            var_dump($th->getMessage());
            die();
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal menambahkan bidang ilmu"]);
        }
    }

    public function bidang_ilmu_update(){
        try {
            $request = request()->all();
            $data = mst_bidangilmu::find($request['bidangilmu_id']);
            $data->bidang_ilmu = $request['nameEdit'];
            $data->save();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil mengubah bidang ilmu"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal mengubah bidang ilmu"]);
        }
    }

    public function bidang_ilmu_delete($id){
        try {
            $data = mst_bidangilmu::find($id);
            $data->delete();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil menghapus bidang ilmu"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal menghapus bidang ilmu"]);
        }
    }

    public function ruangan(){
        $data = mst_ruangan::orderBy('id', 'desc')->get();
        return view('tugasakhir.admin.ruangan', compact('data'));
    }

    public function ruangan_create(){
        try {
            $request = request()->all();
            $data = new mst_ruangan();
            $data->nama_ruangan = $request['nama'];
            $data->save();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil menambahkan ruangan"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal menambahkan ruangan"]);
        }
    }

    public function ruangan_update(){
        try {
            $request = request()->all();
            $data = mst_ruangan::find($request['id']);
            $data->nama_ruangan = $request['nameEdit'];
            $data->save();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil mengubah ruangan"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal mengubah ruangan"]);
        }
    }

    public function ruangan_delete($id){
        try {
            $data = mst_ruangan::find($id);
            $data->delete();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil menghapus ruangan"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal menghapus ruangan"]);
        }
    }

    public function prodi(){
        $data = trt_prodi::orderBy('prodi_id', 'desc')->get();
        return view('tugasakhir.admin.prodi', compact('data'));
    }

    public function prodi_create(){
        try {
            $request = request()->all();
            $data = new trt_prodi();
            $data->kode_prodi = $request['kode_prodi'];
            $data->nama = $request['nama'];
            $data->save();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil menambahkan prodi"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal menambahkan prodi"]);
        }
    }

    public function prodi_update(){
        try {
            $request = request()->all();
            $data = trt_prodi::find($request['prodi_id']);
            $data->kode_prodi = $request['kode_prodiEdit'];
            $data->nama = $request['nameEdit'];
            $data->save();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil mengubah prodi"]);
        } catch (\Exception $th) {
            var_dump($th->getMessage());
            die();
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal mengubah prodi"]);
        }
    }

    public function prodi_delete($id){
        try {
            $data = trt_prodi::find($id);
            $data->delete();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil menghapus prodi"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal menghapus prodi"]);
        }
    }

    // CRUD Ketua Bidang
    public function ketua_bidang(){
        $data = mst_ketua_bidang::orderBy('id_bidang_ilmu', 'asc')->get();
        $bidang_ilmu = mst_bidangilmu::all();
        $data_dosen = t_mst_dosen::all();
        return view('tugasakhir.admin.ketua_bidang', compact('data', 'bidang_ilmu', 'data_dosen'));
    }

    public function ketua_bidang_create(){
        try {
            $request = request()->all();
            $data = new mst_ketua_bidang();
            $data->id_bidang_ilmu = $request['id_bidang_ilmu'];
            $data->C_KODE_DOSEN = $request['C_KODE_DOSEN'];
            $filename = 'ttd-' . time() . '.png';

            if (request()->hasFile('ttd')) {
                $file = request()->file('ttd');
                $file->move('gambar', $filename);
                $data->ttd = $filename;
            }

            $data->save();

            $dataUser = new users();
            $dataUser->name = strtolower(str_replace(' ', '', Helper::getBidangIlmuById($request['id_bidang_ilmu'])->bidang_ilmu));
            $dataUser->email = $request['C_KODE_DOSEN'] . '@umi.ac.id';
            $dataUser->password = bcrypt($data->C_KODE_DOSEN);
            $dataUser->level = 9;
            $dataUser->save();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil menambahkan ketua bidang"]);
        } catch (\Exception $th) {
            unlink(public_path('gambar/' . $filename));
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal menambahkan ketua bidang"]);
        }
    }

    public function ketua_bidang_update(){
        try {
            $request = request()->all();

            $dataKetuaBidangOld = mst_ketua_bidang::find($request['id_ketua_bidang']);
            $C_KODE_DOSEN_OLD = $dataKetuaBidangOld->C_KODE_DOSEN;
            $dataUserOld = users::where('email', $C_KODE_DOSEN_OLD . '@umi.ac.id')->first();

            $data = mst_ketua_bidang::find($request['id_ketua_bidang']);
            $data->id_bidang_ilmu = $request['id_bidang_ilmuEdit'];
            $data->C_KODE_DOSEN = $request['C_KODE_DOSENEdit'];
            $filename = 'ttd-' . time() . '.png';

            if (request()->hasFile('ttdEdit')) {
                $file = request()->file('ttdEdit');
                $file->move('gambar', $filename);
                $data->ttd = $filename;
            }


            $dataUser = new users();
            $dataUser->name = strtolower(str_replace(' ', '', Helper::getBidangIlmuById($request['id_bidang_ilmuEdit'])->bidang_ilmu));
            $dataUser->email = $request['C_KODE_DOSENEdit'] . '@umi.ac.id';
            $dataUser->password = bcrypt($data->C_KODE_DOSEN);
            $dataUser->level = 9;

            unlink(public_path('gambar/' . $dataKetuaBidangOld->ttd));
            $dataUserOld->delete();
            $data->save();
            $dataUser->save();
            

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil mengubah ketua bidang"]);
        } catch (\Exception $th) {
            $dataKetuaBidangOld = mst_ketua_bidang::find($request['id_ketua_bidang']);
            $dataKetuaBidangOld->delete();
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal mengubah ketua bidang"]);
        }
    }

    public function ketua_bidang_delete($id){
        try {
            $data = mst_ketua_bidang::find($id);
            unlink(public_path('gambar/' . $data->ttd));
            $data->delete();

            $dataUser = users::where('email', $data->C_KODE_DOSEN . '@umi.ac.id')->first();
            $dataUser->delete();



            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil menghapus ketua bidang"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal menghapus ketua bidang"]);
        }
    }

    public function reset_password_ketua_bidang($id){
        try {
            $data = mst_ketua_bidang::find($id);
            $dataUser = users::where('email', $data->C_KODE_DOSEN . '@umi.ac.id')->first();
            $dataUser->password = bcrypt($data->C_KODE_DOSEN);
            $dataUser->save();

            return redirect()->back()->with(['status' => "berhasil", 'message' => "Berhasil mereset password ketua bidang"]);
        } catch (\Exception $th) {
            return redirect()->back()->with(['status' => "gagal", 'message' => "Gagal mereset password ketua bidang"]);
        }
    }
}
