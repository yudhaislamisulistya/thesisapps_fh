<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index');


Route::group(['middleware' => 'admin'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    // Make a route group master data
    Route::group(['prefix' => 'data-master'], function () {
        Route::get('/periode-jabatan', 'Admin@periode_jabatan')->name('get_master_periode_jabatan');
        Route::post('/periode-jabatan', 'Admin@periode_jabatan_update')->name('update_master_periode_jabatan');

        // Bidang Ilmu
        Route::get('/bidang-ilmu', 'Admin@bidang_ilmu')->name('get_master_bidang_ilmu');
        Route::post('/bidang-ilmu', 'Admin@bidang_ilmu_create')->name('create_master_bidang_ilmu');
        Route::post('/bidang-ilmu/update', 'Admin@bidang_ilmu_update')->name('update_master_bidang_ilmu');
        Route::get('/bidang-ilmu/delete/{id}', 'Admin@bidang_ilmu_delete')->name('delete_master_bidang_ilmu');

        // Ruangan
        Route::get('/ruangan', 'Admin@ruangan')->name('get_master_ruangan');
        Route::post('/ruangan', 'Admin@ruangan_create')->name('create_master_ruangan');
        Route::post('/ruangan/update', 'Admin@ruangan_update')->name('update_master_ruangan');
        Route::get('/ruangan/delete/{id}', 'Admin@ruangan_delete')->name('delete_master_ruangan');

        // Prodi
        Route::get('/prodi', 'Admin@prodi')->name('get_master_prodi');
        Route::post('/prodi', 'Admin@prodi_create')->name('create_master_prodi');
        Route::post('/prodi/update', 'Admin@prodi_update')->name('update_master_prodi');
        Route::get('/prodi/delete/{id}', 'Admin@prodi_delete')->name('delete_master_prodi');

        // Ketua Bidang CRUD
        Route::get('/ketua-bidang', 'Admin@ketua_bidang')->name('get_master_ketua_bidang');
        Route::post('/ketua-bidang', 'Admin@ketua_bidang_create')->name('create_master_ketua_bidang');
        Route::post('/ketua-bidang/update', 'Admin@ketua_bidang_update')->name('update_master_ketua_bidang');
        Route::get('/ketua-bidang/delete/{id}', 'Admin@ketua_bidang_delete')->name('delete_master_ketua_bidang');
        Route::get('/reset-password-ketua-bidang/{id}', 'Admin@reset_password_ketua_bidang')->name('reset_password_ketua_bidang');
    });
    //AKADEMIK-PRODI
    /*
	Route::get('/prodi/dosen_pembimbing', 'Prodi@dosen_pembimbing');
	Route::get('/prodi/detail_pembimbing/{id}', 'Prodi@detail_pembimbing');
	Route::get('/prodi/mahasiswa', 'Prodi@mahasiswa');
	Route::get('/prodi/detail_mahasiswa/{id}', 'Prodi@detail_mahasiswa');
	Route::get('/prodi/topik', 'Prodi@topik');
	Route::get('/prodi/detail_topikusulan/{id}', 'Prodi@detail_topikusulan');
	Route::get('/prodi/usulan_pembimbing', 'Prodi@usulan_pembimbing');
    Route::get('/prodi/usulan_timujianta', 'Prodi@usulan_timujianta');
	Route::get('/prodi/set_pembimbing/{id}', 'Prodi@set_pembimbing');
	Route::get('/prodi/sk_pembimbing', 'Prodi@sk_pembimbing');
	Route::get('/prodi/peserta_proposal', 'Prodi@peserta_proposal');
	Route::get('/prodi/peserta_seminarhasil', 'Prodi@peserta_seminarhasil');
	Route::get('/prodi/peserta_ujianmeja', 'Prodi@peserta_ujianmeja');
	Route::get('/prodi/syarat_ujian', 'Prodi@syarat_ujian');
	Route::get('/prodi/jadwal', 'Prodi@jadwal');
	Route::get('/prodi/sk_ujian', 'Prodi@sk_ujian');
	Route::get('/prodi/pengumuman', 'Prodi@pengumuman');
	Route::get('/prodi/pengumumandel/{id}', 'Prodi@pengumumandel');
	Route::get('/prodi/pendaftarandel/{id}', 'Prodi@pendaftarandel');
    Route::get('/prodi/daftar_peserta/{id}', 'Prodi@daftar_peserta');
    Route::get('/prodi/set_penguji', 'Prodi@set_penguji');
    Route::get('/prodi/cetakskpenguji/', 'Prodi@cetakskpenguji');

	Route::post('/prodi/usulan_pembimbing', 'Prodi@usulan_pembimbingpostadd');
	Route::post('/prodi/sk_pengusulan', 'Prodi@sk_pengusulanpost');
	Route::post('/prodi/jadwal', 'Prodi@jadwalpostadd');
	Route::post('/prodi/pengumuman', 'Prodi@pengumumanpost');
	Route::post('/prodi/topik', 'Prodi@topikpost');
    Route::post('/prodi/surat_pengusulan', 'Prodi@surat_pengusulan');
    Route::post('/prodi/suratpengusulanold/', 'Prodi@surat_pengusulanold');
    Route::post('/prodi/surat_pengusulanujianta/', 'Prodi@surat_pengusulanujianta');
    */
    //MAHASISWA
    /*
	Route::get('/mhs/pengajuan_topik', 'mhs@pengajuan_topik');
    Route::get('/mhs/pengajuan_topikdel/{id}', 'mhs@pengajuan_topikdel');
	Route::get('/mhs/riwayat_ujian', 'mhs@riwayat_ujian');
	Route::get('/mhs/mail_inbox', 'mhs@mail_inbox');
	Route::get('/mhs/mail_sent', 'mhs@mail_sent');
	Route::get('/mhs/mail_new', 'mhs@mail_new');
	Route::get('/mhs/mail_read/{id}', 'mhs@mail_read');
	Route::get('/mhs/detail_ujian', 'mhs@detail_ujian');
	Route::get('/mhs/signup_proposal', 'mhs@signup_proposal');
	Route::get('/mhs/signup_seminarhasil', 'mhs@signup_seminarhasil');
	Route::get('/mhs/signup_ujianmeja', 'mhs@signup_ujianmeja');


	Route::post('/mhs/pengajuan_topik', 'mhs@pengajuan_topikpost');
    Route::post('/mhs/registrasi', 'mhs@registrasi');
    Route::post('/mhs/pesanpost', 'mhs@pesanpost');
    */

    //FAKULTAS
    /*
    Route::get('/fakultas/sk_pembimbing', 'fakultas@sk_pembimbing');

    Route::get('/fakultas/chart_morris', 'fakultas@chart_morris');
    Route::get('/fakultas/chart_c3', 'fakultas@chart_c3');
    Route::get('/fakultas/chart_flot', 'fakultas@chart_flot');
    Route::get('/fakultas/chart_easy_knob', 'fakultas@chart_easy_knob');

	Route::post('/fakultas/sk_penetapan/', 'fakultas@sk_penetapan');
 	Route::post('/fakultas/cetakskpembimbing/', 'fakultas@cetakskpembimbing');
    */
});

// Route Group For Ketua Bidang
Route::group(['middleware' => 'ketua_bidang'], function () {
    Route::group(['prefix' => 'ketuabidang'], function () {
        // Penentuan Bidang Prefix
        Route::group(['prefix' => 'penentuan_pembimbing'], function () {
            Route::get('/', 'KetuaBidang@penentuan_pembimbing')->name('get_ketua_bidang_penentuan_pembimbing');
            Route::post('/update', 'KetuaBidang@penentuan_pembimbing_update')->name('update_ketua_bidang_penentuan_pembimbing');
        });
        // Set Penguji
        Route::get('peserta_proposal', 'KetuaBidang@peserta_proposal')->name('get_ketua_bidang_peserta_proposal');
        Route::get('peserta_ujianmeja', 'KetuaBidang@peserta_ujianmeja')->name('get_ketua_bidang_peserta_ujianmeja');
        Route::get('daftar_peserta/{id}', 'KetuaBidang@daftar_peserta')->name('get_ketua_bidang_daftar_peserta');
        Route::get('set_penguji/{pendaftaran_id}/{nim}/{tipe_ujian}', 'KetuaBidang@set_penguji')->name('set_penguji');
        Route::post('set_penguji/{pendaftaran_id}', 'KetuaBidang@set_pengujipost')->name('set_penguji_post');
    });
});





Route::group(['middleware' => 'kaprodi'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    //KA-PRODI
    Route::get('/prodi/dosen_pembimbing', 'Prodi@dosen_pembimbing');
    Route::get('/prodi/detail_pembimbing/{id}', 'Prodi@detail_pembimbing');
    Route::get('/prodi/mahasiswa', 'Prodi@mahasiswa');
    Route::get('/prodi/detail_mahasiswa/{id}', 'Prodi@detail_mahasiswa');
    Route::get('/prodi/make_user/{id}', 'Prodi@make_user');
    Route::get('/prodi/reset_user/{id}', 'Prodi@reset_user');
    Route::get('/prodi/make_userx/{id}', 'Prodi@make_userx');
    Route::get('/prodi/reset_userx/{id}', 'Prodi@reset_userx');
    Route::get('/prodi/scope_ta', 'Prodi@scope_ta');
    Route::get('/prodi/scope_del/{id}', 'Prodi@scope_del');
    Route::get('/prodi/topik', 'Prodi@topik');
    Route::get('/prodi/detail_topikusulan/{id}', 'Prodi@detail_topikusulan');
    Route::get('/prodi/usulan_pembimbing', 'Prodi@usulan_pembimbing');
    Route::get('/prodi/set_pembimbing_sementara/{nim}', 'Prodi@set_pembimbing_sementara');
    Route::get('/prodi/usulan_timujianta/{id}', 'Prodi@usulan_timujianta');
    Route::get('/prodi/set_pembimbing/{id}/{status}', 'Prodi@set_pembimbing');
    Route::get('/prodi/sk_pembimbing', 'Prodi@sk_pembimbing');
    Route::get('/prodi/peserta_proposal', 'Prodi@peserta_proposal');
    Route::get('/prodi/peserta_seminarhasil', 'Prodi@peserta_seminarhasil');
    Route::get('/prodi/peserta_ujianmeja', 'Prodi@peserta_ujianmeja');
    Route::get('/prodi/syarat_ujian', 'Prodi@syarat_ujian');
    Route::get('/prodi/jadwal', 'Prodi@jadwal');
    Route::get('/prodi/sk_ujian', 'Prodi@sk_ujian');
    Route::get('/prodi/sk_ujian_ta', 'Prodi@sk_ujian_ta');
    Route::get('/prodi/detail_skujian/{id}', 'Prodi@detail_skujian');
    Route::get('/prodi/pengumuman', 'Prodi@pengumuman');
    Route::get('/prodi/pengumuman/{id}', 'Prodi@edit_pengumuman');
    Route::post('/prodi/edit_pengumuman_post/', 'Prodi@edit_pengumuman_post');


    Route::get('/prodi/pengumumandel/{id}', 'Prodi@pengumumandel');
    Route::get('/prodi/pendaftarandel/{id}', 'Prodi@pendaftarandel');
    Route::get('/prodi/syaratdel/{id}', 'Prodi@syaratdel');
    Route::get('/prodi/daftar_peserta/{id}', 'Prodi@daftar_peserta');
    Route::get('/prodi/set_penguji/{pendaftaran_id}/{nim}/{tipe_ujian}', 'Prodi@set_penguji');
    Route::get('/prodi/cetakskpenguji/{pendaftaran_id}/{nim}', 'Prodi@cetakskpenguji');
    Route::get('/prodi/setlevelpembimbing/{dosen}/{level}', 'Prodi@setlevelpembimbing');
    Route::get("/prodi/usulan_tmp/pembimbing/getstatus/{index}/{id}/{mahasiswa}", "Prodi@getPembimbingStatus");
    Route::get("/prodi/persyaratan_proposal", "Prodi@persyaratan_proposal");
    Route::get("/prodi/persyaratan_seminarhasil", "Prodi@persyaratan_seminarhasil");
    Route::get("/prodi/persyaratan_ujianmeja", "Prodi@persyaratan_ujianmeja");
    Route::get("/prodi/detail_persyaratan_proposal/{id}", "Prodi@detail_persyaratan_proposal");
    Route::get("/prodi/detail_persyaratan_ujianmeja/{id}", "Prodi@detail_persyaratan_ujianmeja");
    Route::get("/prodi/konfirmasi_persyaratan_ujian/{status}/{id}/{nim}", "Prodi@konfirmasi_persyaratan_ujian");
    Route::get('/prodi/jadwalujiandel/{id}', 'Prodi@jadwalUjianDel');
    Route::get('/prodi/jadwalpermhs/{tipe_ujian}', 'Prodi@jadwalPerMhs');
    Route::get('/prodi/detail_jadwalpermhs/{pendaftaran_id}', 'Prodi@detailJadwalPermhs');
    Route::get('/prodi/set_jadwalpermhs/{pendaftaran_id}/{nim}', 'Prodi@set_jadwalujianpermhs');
    Route::get('/prodi/cetak_berita_acara/{pendaftaran_id}/{nim}', 'Prodi@cetakBeritaAcara');
    Route::get('/prodi/selesai_konfirmasi/{nim}/{type}', 'Prodi@selesaiKonfirmasi');


    Route::post('/prodi/dosen_pembimbing', 'Prodi@dosen_pembimbingpost');
    Route::post('/prodi/usulan_pembimbing', 'Prodi@usulan_pembimbingpostadd');
    Route::post('/prodi/sk_pengusulan', 'Prodi@sk_pengusulanpost');
    Route::post('/prodi/sk_pengusulan_tim_ujian_ta', 'Prodi@sk_pengusulan_tim_ujian_tapost');
    Route::post('/prodi/jadwal', 'Prodi@jadwalpostadd');
    Route::post('/prodi/scope_add', 'Prodi@scope_add');
    Route::post('/prodi/pengumuman', 'Prodi@pengumumanpost');
    Route::post('/prodi/topik', 'Prodi@topikpost');
    Route::post('/prodi/surat_pengusulan', 'Prodi@surat_pengusulan');
    Route::get('/prodi/surat_pengusulan/{nomor}', 'Prodi@get_surat_pengusulan');
    Route::get('/prodi/cetak_riwayat_sk_pengusulan_tim_ujian_ta/{nomor}', 'Prodi@cetak_riwayat_sk_pengusulan_tim_ujian_ta');
    Route::post('/prodi/surat_pengusulan_ujian_ta', 'Prodi@surat_pengusulan_ujian_ta');
    Route::post('/prodi/suratpengusulanold/', 'Prodi@surat_pengusulanold');
    Route::post('/prodi/surat_pengusulanujianta/', 'Prodi@surat_pengusulanujianta');
    Route::post('/prodi/syaratadd', 'Prodi@syaratadd');
    Route::post('/prodi/set_penguji/{pendaftaran_id}', 'Prodi@set_pengujipost');
    Route::post('/prodi/jadwalujian', 'Prodi@jadwalUjianPost');
    Route::post('/prodi/set_jadwalpermhs/{pendaftaran_id}', 'Prodi@set_jadwalujianpermhspost');
    Route::get("/prodi/konfirmasi_persyaratan_ujian_by_nim/{status}/{nim}", "Prodi@konfirmasi_persyaratan_ujian_by_nim");
    Route::get("/prodi/ubah_password/", "Prodi@ubah_password");

    Route::post("/prodi/ubah_password/", "Prodi@ubah_password_post");

    // Hasil Ujian Proposal
    Route::get("/prodi/approve_hasilujian_proposal/", "Prodi@approve_hasilujian_proposal");
    Route::get("/prodi/detail_hasilujian_proposal/{id}", "Prodi@detail_hasilujian_proposal");
    Route::get("/prodi/approve_hasilujian_proposal_post/{id}/{nim}/{pendaftaran_id}", "Prodi@approve_hasilujian_proposal_post");
    Route::get("/prodi/tolak_hasilujian_proposal_post/{id}/{nim}/{pendaftaran_id}", "Prodi@tolak_hasilujian_proposal_post");
    Route::get("/prodi/lembaran_hasilujian_proposal/{id}/{nim}/{regid}", "Prodi@lembaran_hasilujian_proposal");

    // Hasil Ujian Seminar
    Route::get("/prodi/approve_hasilujian_seminar/", "Prodi@approve_hasilujian_seminar");
    Route::get("/prodi/detail_hasilujian_seminar/{id}", "Prodi@detail_hasilujian_seminar");
    Route::get("/prodi/approve_hasilujian_seminar_post/{id}/{nim}/{pendaftaran_id}", "Prodi@approve_hasilujian_seminar_post");
    Route::get("/prodi/tolak_hasilujian_seminar_post/{id}/{nim}/{pendaftaran_id}", "Prodi@tolak_hasilujian_seminar_post");
    Route::get("/prodi/lembaran_hasilujian_seminar/{id}/{nim}/{regid}", "Prodi@lembaran_hasilujian_seminar");


    // Hasil Ujian TA
    Route::get("/prodi/approve_hasilujian_ta/", "Prodi@approve_hasilujian_ta");
    Route::get("/prodi/detail_hasilujian_ta/{id}", "Prodi@detail_hasilujian_ta");
    Route::get("/prodi/approve_hasilujian_ta_post/{id}/{nim}/{pendaftaran_id}", "Prodi@approve_hasilujian_ta_post");
    Route::get("/prodi/tolak_hasilujian_ta_post/{id}/{nim}/{pendaftaran_id}", "Prodi@tolak_hasilujian_ta_post");
    Route::get("/prodi/lembaran_hasilujian_ta/{id}/{nim}/{regid}", "Prodi@lembaran_hasilujian_ta");

    // Approve Semua Hasil Ujian
    Route::get("/prodi/approve_hasilujian_proposal_all_post", "Prodi@approve_hasilujian_proposal_all_post");
    Route::get("/prodi/approve_hasilujian_ta_all_post", "Prodi@approve_hasilujian_ta_all_post");

    Route::get("/prodi/make_user_all", "Prodi@make_user_all");

    Route::get('/prodi/detail_note/{id}', 'Prodi@detail_note');
    Route::post('/prodi/detail_note/{id}', 'Prodi@note_update');

    Route::get('/prodi/tolak_topik_penelitian/{id}', 'Prodi@tolak_topik_penelitian');

    Route::get('/prodi/detail_status_bimbingan_mahasiswa/{status}', 'Prodi@detail_status_bimbingan_mahasiswa');

    Route::get('/prodi/set_sk/{id}', 'Prodi@set_sk');
    Route::post('/prodi/add_sk_pembimbing', 'Prodi@add_sk_pembimbing');

    // Catatan
    Route::get('/prodi/detail_persyaratan_proposal/catatan/{id}/{nim}', 'Prodi@detail_persyaratan_proposal_catatan');
    Route::post('/prodi/detail_persyaratan_proposal_catatan_post/', 'Prodi@detail_persyaratan_proposal_catatan_post');

    // Catatan
    Route::get('/prodi/detail_persyaratan_ujianmeja/catatan/{id}/{nim}', 'Prodi@detail_persyaratan_ujianmeja_catatan');
    Route::post('/prodi/detail_persyaratan_ujianmeja_catatan_post/', 'Prodi@detail_persyaratan_ujianmeja_catatan_post');

    Route::get('/prodi/batal_set_pembimbing/{nim}', 'Prodi@batal_set_pembimbing');

    Route::get('/prodi/temp_daftar_peserta/{id}', 'Prodi@temp_daftar_peserta');

    Route::get('/prodi/edit_judul_detail_mahasiswa/{nim}', 'Prodi@edit_judul_detail_mahasiswa');
    Route::post('/prodi/ubah_judul/{nim}', 'Prodi@ubah_judul');

    Route::get('/prodi/ubah_pembimbing_per_mahasiswa/{nim}', 'Prodi@ubah_pembimbing_per_mahasiswa');
    Route::post('/prodi/ubah_pembimbing_per_mahasiswa/', 'Prodi@ubah_pembimbing_per_mahasiswa_post');


    Route::post('/prodi/ubah_periode_pendaftaran/', 'Prodi@ubah_periode_pendaftaran');

    Route::get('/prodi/riwayat_sk_pengusulan/', 'Prodi@riwayat_sk_pengusulan');
    Route::get('/prodi/riwayat_sk_pengusulan_tim_ujian_ta/', 'Prodi@riwayat_sk_pengusulan_tim_ujian_ta');

    Route::get('/prodi/detail_riwayat_sk_pengusulan/{nomor}', 'Prodi@detail_riwayat_sk_pengusulan');
    Route::get('/prodi/detail_riwayat_sk_pengusulan_tim_ujian_ta/{nomor}', 'Prodi@detail_riwayat_sk_pengusulan_tim_ujian_ta');

    // Flter By Tanggal Detail Status Bimbimngan
    Route::get('/detail_status_bimbingan_mahasiswa', 'Prodi@tampilDetailStatusBimbinganDenganFilterTanggal')->name('tampilDetailStatusBimbinganDenganFilterTanggal');
    // Menu Download
    Route::get('/prodi/download', "Prodi@tampilDownload")->name('tampilDownload');
    Route::post('/prodi/download', "Prodi@kirimDownload")->name('kirimDownload');
    Route::get('/prodi/download/hapus/{id}', "Prodi@hapusDownload")->name('hapusDownload');
    // Menu Jadwal Ujian
    Route::get('/prodi/hapus-jadwal-ujian-per-mahasiswa/{C_NPM}/{pendaftaran_id}', "Prodi@hapusJadwalUjianPerMahasiswa")->name('hapusJadwalUjianPerMahasiswa');
    // Surat Keputusan
    Route::get('/prodi/surat_keputusan_pembimbing', "Prodi@surat_keputusan_pembimbing")->name("surat_keputusan_pembimbing");
    Route::get('/prodi/surat_penugasan_ujian_tugas_akhir', "Prodi@surat_penugasan_ujian_tugas_akhir")->name('surat_penugasan_ujian_tugas_akhir');
});

Route::group(['middleware' => 'akademik_prodi'], function () {

    Route::get('/akademikprodi/make_user/{id}', 'AkademikProdi@make_user');
    Route::get('/akademikprodi/reset_user/{id}', 'AkademikProdi@reset_user');
    Route::get('/akademikprodi/make_userx/{id}', 'AkademikProdi@make_userx');
    Route::get('/akademikprodi/reset_userx/{id}', 'AkademikProdi@reset_userx');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get("/akademikprodi/persyaratan_proposal", "AkademikProdi@persyaratan_proposal");
    Route::get("/akademikprodi/persyaratan_ujianmeja", "AkademikProdi@persyaratan_ujianmeja");
    Route::get("/akademikprodi/detail_persyaratan_proposal/{id}", "AkademikProdi@detail_persyaratan_proposal");
    Route::get("/akademikprodi/detail_persyaratan_ujianmeja/{id}", "AkademikProdi@detail_persyaratan_ujianmeja");
    Route::get("/akademikprodi/konfirmasi_persyaratan_ujian_by_nim/{status}/{nim}", "AkademikProdi@konfirmasi_persyaratan_ujian_by_nim");
    Route::get("/akademikprodi/konfirmasi_persyaratan_ujian/{status}/{id}/{nim}", "AkademikProdi@konfirmasi_persyaratan_ujian");
    Route::get('/akademikprodi/dosen_pembimbing', 'AkademikProdi@dosen_pembimbing');
    Route::get('/akademikprodi/detail_pembimbing/{id}', 'AkademikProdi@detail_pembimbing');
    Route::get('/akademikprodi/mahasiswa', 'AkademikProdi@mahasiswa');
    Route::get('/akademikprodi/selesai_konfirmasi/{nim}/{type}', 'AkademikProdi@selesaiKonfirmasi');

    Route::get('/akademikprodi/detail_status_bimbingan_mahasiswa/{status}/', 'AkademikProdi@detail_status_bimbingan_mahasiswa');

    // Catatan
    Route::get('/akademikprodi/detail_persyaratan_proposal/catatan/{id}/{nim}', 'AkademikProdi@detail_persyaratan_proposal_catatan');
    Route::post('/akademikprodi/detail_persyaratan_proposal_catatan_post/', 'AkademikProdi@detail_persyaratan_proposal_catatan_post');

    // Catatan
    Route::get('/akademikprodi/detail_persyaratan_ujianmeja/catatan/{id}/{nim}', 'AkademikProdi@detail_persyaratan_ujianmeja_catatan');
    Route::post('/akademikprodi/detail_persyaratan_ujianmeja_catatan_post/', 'AkademikProdi@detail_persyaratan_ujianmeja_catatan_post');

    // Rekap Nilai Hasil Proposal
    Route::get("/akademikprodi/rekap_nilai_proposal/", "AkademikProdi@rekap_nilai_proposal");
    Route::get("/akademikprodi/detail_rekap_nilai_proposal/{id}", "AkademikProdi@detail_rekap_nilai_proposal");
    Route::get("/akademikprodi/lembaran_hasilujian_proposal/{id}/{nim}/{regid}", "AkademikProdi@lembaran_hasilujian_proposal");

    // Rekap Nilai Ujian TA
    Route::get("/akademikprodi/rekap_nilai_ujian_ta/", "AkademikProdi@rekap_nilai_ujian_ta");
    Route::get("/akademikprodi/detail_rekap_nilai_ujian_ta/{id}", "AkademikProdi@detail_rekap_nilai_ujian_ta");
    Route::get("/akademikprodi/lembaran_hasilujian_ujian_ta/{id}/{nim}/{regid}", "AkademikProdi@lembaran_hasilujian_ujian_ta");

    Route::get('/akademikprodi/detail_ujian/{nim}/{tipe_ujian}', 'akademikprodi@detail_ujian');

    // Surat Keputusan
    Route::get('/akademikprodi/sk_ujian', 'Prodi@sk_ujian');
    Route::get('/akademikprodi/set_sk/{id}', 'Prodi@set_sk');
    Route::get('/akademikprodi/detail_skujian/{id}', 'Prodi@detail_skujian');
    Route::post('/akademikprodi/add_sk_pembimbing', 'Prodi@add_sk_pembimbing');
    Route::get('/akademikprodi/cetakskpenguji/{pendaftaran_id}/{nim}', 'Prodi@cetakskpenguji');
    Route::get('/akademikprodi/cetak_berita_acara/{pendaftaran_id}/{nim}', 'Prodi@cetakBeritaAcara');
});

Route::group(['middleware' => 'dekan'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    //DEKAN
    //WAKIL DEKAN
    Route::get('/dekan/sk_pembimbing', 'Dekan@sk_pembimbing');
    Route::get('/dekan/appove_sk_pembimbing/{id}', 'Dekan@approve_sk_pembimbing');

    Route::get('/dekan/sk_ujian_ta', 'Dekan@sk_ujian_ta');
    Route::get('/dekan/appove_sk_ujian_ta/{id}', 'Dekan@approve_sk_ujian_ta');

    Route::get('/dekan/detail_status_bimbingan_mahasiswa/{status}/', 'Dekan@detail_status_bimbingan_mahasiswa');
});

Route::group(['middleware' => 'wakil_dekan'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    //WAKIL DEKAN
    Route::get('/wakildekan/sk_pembimbing', 'WakilDekan@sk_pembimbing');
    Route::get('/wakildekan/appove_sk_pembimbing/{id}', 'WakilDekan@approve_sk_pembimbing');

    Route::get('/wakildekan/sk_ujian_ta', 'WakilDekan@sk_ujian_ta');
    Route::get('/wakildekan/appove_sk_ujian_ta/{id}', 'WakilDekan@approve_sk_ujian_ta');

    Route::get('/wakildekan/detail_status_bimbingan_mahasiswa/{status}/', 'WakilDekan@detail_status_bimbingan_mahasiswa');

    // Pengajuan Topik Penelitian
    Route::get('/wakildekan/topik', 'WakilDekan@topik');
    Route::post('/wakildekan/topik', 'WakilDekan@topikpost');
    Route::get('/wakildekan/detail_topikusulan/{id}', 'WakilDekan@detail_topikusulan');
    Route::get('/wakildekan/detail_note/{id}', 'WakilDekan@detail_note');
    Route::post('/wakildekan/detail_note/{id}', 'WakilDekan@note_update');
    Route::get('/wakildekan/tolak_topik_penelitian/{id}', 'WakilDekan@tolak_topik_penelitian');

    // Penetapan Pembimbing dan Judul
    Route::get('/wakildekan/penetapan_pembimbing_dan_judul', 'WakilDekan@penetapan_pembimbing_dan_judul')->name('get_wakil_dekan_penetapan_pembimbing_dan_judul');
    Route::post('/wakildekan/penetapan_pembimbing_dan_judul', 'WakilDekan@penetapan_pembimbing_dan_judul_post')->name('post_wakil_dekan_penetapan_pembimbing_dan_judul');

    // Menetapkan Penguji
    Route::get('/wakildekan/peserta_proposal', 'WakilDekan@peserta_proposal')->name('get_wakil_dekan_peserta_proposal');
    Route::get('/wakildekan/peserta_ujianmeja', 'WakilDekan@peserta_ujianmeja')->name('get_wakil_dekan_peserta_ujianmeja');
    Route::get('/wakildekan/daftar_peserta/{id}', 'WakilDekan@daftar_peserta')->name('get_wakil_dekan_daftar_peserta');
    Route::get('/wakildekan/set_penguji/{pendaftaran_id}/{nim}/{tipe_ujian}', 'WakilDekan@set_penguji')->name('set_penguji_by_wakil_dekan');
    Route::post('/wakildekan/set_penguji/{pendaftaran_id}', 'WakilDekan@set_pengujipost')->name('set_penguji_by_wakil_dekan_post');
});

Route::group(['middleware' => 'akademik_fakultas'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    //AKADEMIK FAKULTAS
    Route::get('/fakultas/sk_pembimbing', 'fakultas@sk_pembimbing');
    Route::get('/fakultas/surat_penugasan_ujian_ta', 'fakultas@surat_penugasan_ujian_ta');

    Route::post('/fakultas/sk_penetapan/', 'fakultas@sk_penetapan');
    Route::post('/fakultas/sk_penetapan_tim_ujian_ta/', 'fakultas@sk_penetapan_tim_ujian_ta');
    Route::post('/fakultas/addskpembimbing/', 'fakultas@addskpembimbing');
    Route::post('/fakultas/add_sk_penugasan_per_mahasiswa/', 'fakultas@add_sk_penugasan_per_mahasiswa');
    Route::post('/fakultas/cetakskpembimbing/', 'fakultas@cetakskpembimbing');
    Route::post('/fakultas/cetakskpenugasan/', 'fakultas@cetakskpenugasan');
    Route::get('/fakultas/usulan_timujianta/{id}', 'fakultas@usulan_timujianta');
    Route::get("/fakultas/ubah_password/", "fakultas@ubah_password");
    Route::post("/fakultas/ubah_password/", "fakultas@ubah_password_post");

    // Rekap Nilai Hasil Proposal
    Route::get("/fakultas/rekap_nilai_proposal/", "fakultas@rekap_nilai_proposal");
    Route::get("/fakultas/detail_rekap_nilai_proposal/{id}", "fakultas@detail_rekap_nilai_proposal");
    Route::get("/fakultas/lembaran_hasilujian_proposal/{id}/{nim}/{regid}", "fakultas@lembaran_hasilujian_proposal");

    // Rekap Nilai Hasil Seminar
    Route::get("/fakultas/rekap_nilai_seminar/", "fakultas@rekap_nilai_seminar");
    Route::get("/fakultas/detail_rekap_nilai_seminar/{id}", "fakultas@detail_rekap_nilai_seminar");
    Route::get("/fakultas/lembaran_hasilujian_seminar/{id}/{nim}/{regid}", "fakultas@lembaran_hasilujian_seminar");

    // Rekap Nilai Ujian TA
    Route::get("/fakultas/rekap_nilai_ujian_ta/", "fakultas@rekap_nilai_ujian_ta");
    Route::get("/fakultas/detail_rekap_nilai_ujian_ta/{id}", "fakultas@detail_rekap_nilai_ujian_ta");
    Route::get("/fakultas/lembaran_hasilujian_ujian_ta/{id}/{nim}/{regid}", "fakultas@lembaran_hasilujian_ujian_ta");

    Route::get('/fakultas/detail_ujian/{nim}/{tipe_ujian}', 'fakultas@detail_ujian');

    // Surat Keputusan
    Route::get('/fakultas/sk_ujian', "fakultas@sk_ujian")->name('tampilSKUjianFakultas');
    Route::get('/fakultas/detail_skujian/{id}', 'Prodi@detail_skujian');
    Route::get('/fakultas/cetakskpenguji/{pendaftaran_id}/{nim}', 'Prodi@cetakskpenguji');
    Route::get('/fakultas/cetak_berita_acara/{pendaftaran_id}/{nim}', 'Prodi@cetakBeritaAcara');
    Route::get('/fakultas/surat_keputusan_pembimbing', "fakultas@surat_keputusan_pembimbing")->name("surat_keputusan_pembimbing");
    Route::get('/fakultas/set_sk/{id}', 'fakultas@set_sk')->name('set_sk_by_fakultas');
    Route::post('/fakultas/add_sk_pembimbing', 'fakultas@add_sk_pembimbing')->name('add_sk_pembimbing_by_fakultas');
    Route::get('/fakultas/sk_ujian_seminar', "fakultas@sk_ujian_seminar")->name('get_fakultas_sk_ujian_seminar');
    Route::get('/fakultas/detail_skujian_seminar/{id}', 'fakultas@detail_skujian_seminar')->name('get_fakultas_detail_skujian_seminar');
    Route::get('/fakultas/cetakskpenguji_seminar/{pendaftaran_id}/{nim}', 'fakultas@cetakskpenguji_seminar')->name('get_fakultas_cetakskpenguji_seminar');
    Route::get('/fakultas/cetak_berita_acara_seminar/{pendaftaran_id}/{nim}', 'fakultas@cetakBeritaAcaraSeminar')->name('get_fakultas_cetakBeritaAcaraSeminar');
    Route::get('/fakultas/set_sk_seminar/{id}', 'fakultas@set_sk_seminar')->name('set_sk_seminar_by_fakultas');
    Route::post('/fakultas/add_sk_pembimbing_seminar', 'fakultas@add_sk_pembimbing_seminar')->name('add_sk_pembimbing_seminar_by_fakultas');



    // Penentuan Bidang
    Route::get('fakultas/penentuan_bidang', 'fakultas@penentuan_bidang')->name('get_fakultas_penentuan_bidang');
    Route::post('fakultas/penentuan_bidang', 'fakultas@post_penentuan_bidang')->name('post_fakultas_penentuan_bidang');

    // Usulan Pembimbing
    Route::get('/fakultas/usulan_pembimbing', 'fakultas@usulan_pembimbing')->name('get_fakultas_usulan_pembimbing');
    Route::post('/fakultas/usulan_pembimbing', 'fakultas@usulan_pembimbingpostadd')->name('post_fakultas_usulan_pembimbing');
    Route::get('/fakultas/set_pembimbing/{id}/{status}', 'fakultas@set_pembimbing')->name('get_fakultas_set_pembimbing');

    // Surat Usulan Pembimbing
    Route::get('/fakultas/surat_usulan_pembimbing', 'fakultas@surat_usulan_pembimbing')->name('get_fakultas_surat_usulan_pembimbing');
    Route::get('/fakultas/riwayat_sk_pengusulan', 'fakultas@riwayat_sk_pengusulan')->name('get_fakultas_riwayat_sk_pengusulan');
    Route::post('/fakultas/sk_pengusulan', 'fakultas@sk_pengusulanpost')->name('post_fakultas_sk_pengusulan');
    Route::post('/fakultas/surat_pengusulan', 'fakultas@surat_pengusulan')->name('post_fakultas_surat_pengusulan');
    Route::get('/fakultas/detail_riwayat_sk_pengusulan/{nomor}', 'fakultas@detail_riwayat_sk_pengusulan')->name('get_fakultas_detail_riwayat_sk_pengusulan');
    Route::get('/fakultas/surat_pengusulan/{nomor}', 'fakultas@get_surat_pengusulan')->name('get_fakultas_surat_pengusulan');

    // Pelaksanaan Ujian dan Konfirmasi Ujian
    Route::get("/fakultas/persyaratan_proposal", "fakultas@persyaratan_proposal")->name('get_fakultas_persyaratan_proposal');
    Route::get("/fakultas/persyaratan_ujianmeja", "fakultas@persyaratan_ujianmeja")->name('get_fakultas_persyaratan_ujianmeja');
    Route::get("/fakultas/detail_persyaratan_proposal/{id}", "fakultas@detail_persyaratan_proposal")->name('get_fakultas_detail_persyaratan_proposal');
    Route::get("/fakultas/detail_persyaratan_ujianmeja/{id}", "fakultas@detail_persyaratan_ujianmeja")->name('get_fakultas_detail_persyaratan_ujianmeja');
    Route::get("/fakultas/konfirmasi_persyaratan_ujian_by_nim/{status}/{nim}", "fakultas@konfirmasi_persyaratan_ujian_by_nim")->name('get_fakultas_konfirmasi_persyaratan_ujian_by_nim');
    Route::get("/fakultas/konfirmasi_persyaratan_ujian/{status}/{id}/{nim}", "fakultas@konfirmasi_persyaratan_ujian")->name('get_fakultas_konfirmasi_persyaratan_ujian');
    Route::get('/fakultas/detail_persyaratan_proposal/catatan/{id}/{nim}', 'fakultas@detail_persyaratan_proposal_catatan')->name('get_fakultas_detail_persyaratan_proposal_catatan');
    Route::post('/fakultas/detail_persyaratan_proposal_catatan_post/', 'fakultas@detail_persyaratan_proposal_catatan_post')->name('post_fakultas_detail_persyaratan_proposal_catatan_post');
    Route::get('/fakultas/detail_persyaratan_ujianmeja/catatan/{id}/{nim}', 'fakultas@detail_persyaratan_ujianmeja_catatan')->name('get_fakultas_detail_persyaratan_ujianmeja_catatan');
    Route::post('/fakultas/detail_persyaratan_ujianmeja_catatan_post/', 'fakultas@detail_persyaratan_ujianmeja_catatan_post')->name('post_fakultas_detail_persyaratan_ujianmeja_catatan_post');
    Route::get('/fakultas/selesai_konfirmasi/{nim}/{type}', 'fakultas@selesaiKonfirmasi')->name('get_fakultas_selesaiKonfirmasi');
    Route::get("/fakultas/persyaratan_seminarhasil", "fakultas@persyaratan_seminarhasil")->name('get_fakultas_persyaratan_seminarhasil');
    Route::get("fakultas/detail_persyaratan_seminarhasil/{id}", "fakultas@detail_persyaratan_seminarhasil")->name('get_fakultas_detail_persyaratan_seminarhasil');
    Route::get('/fakultas/detail_persyaratan_seminarhasil/catatan/{id}/{nim}', 'fakultas@detail_persyaratan_seminarhasil_catatan')->name('get_fakultas_detail_persyaratan_seminarhasil_catatan');
    Route::post('/fakultas/detail_persyaratan_seminarhasil_catatan_post/', 'fakultas@detail_persyaratan_seminarhasil_catatan_post')->name('post_fakultas_detail_persyaratan_seminarhasil_catatan_post');

    // Jadwal Ujian
    Route::get('/fakultas/jadwal', 'fakultas@jadwal')->name('get_fakultas_jadwal');
    Route::post('/fakultas/jadwalujian', 'fakultas@jadwalUjianPost')->name('post_fakultas_jadwalujian');
    Route::post('/fakultas/jadwal', 'fakultas@jadwalpostadd')->name('post_fakultas_jadwalpostadd');
    Route::get('/fakultas/pendaftarandel/{id}', 'fakultas@pendaftarandel')->name('get_fakultas_pendaftarandel');
    Route::get('/fakultas/temp_daftar_peserta/{id}', 'fakultas@temp_daftar_peserta')->name('get_fakultas_temp_daftar_peserta');
    Route::post('/fakultas/ubah_periode_pendaftaran/', 'fakultas@ubah_periode_pendaftaran')->name('post_fakultas_ubah_periode_pendaftaran');
    Route::get('/fakultas/hapus-jadwal-ujian-per-mahasiswa/{C_NPM}/{pendaftaran_id}', "fakultas@hapusJadwalUjianPerMahasiswa")->name('hapusJadwalUjianPerMahasiswa');
    Route::get('/fakultas/daftar_peserta/{id}', 'fakultas@daftar_peserta')->name('get_prodi_daftar_peserta');

    // Menetapkan Jadwal Ujian dan SK
    Route::get('/fakultas/jadwalpermhs/{tipe_ujian}', 'fakultas@jadwalPerMhs')->name('get_fakultas_jadwalPerMhs');
    Route::get('/fakultas/detail_jadwalpermhs/{pendaftaran_id}', 'fakultas@detailJadwalPermhs')->name('get_fakultas_detailJadwalPermhs');
    Route::get('/fakultas/set_jadwalpermhs/{pendaftaran_id}/{nim}', 'fakultas@set_jadwalujianpermhs');
    Route::post('/fakultas/set_jadwalpermhs/{pendaftaran_id}', 'fakultas@set_jadwalujianpermhspost');

    // Aprove Hasil Ujian
    Route::get("/fakultas/approve_hasilujian_proposal/", "fakultas@approve_hasilujian_proposal");
    Route::get("/fakultas/detail_hasilujian_proposal/{id}", "fakultas@detail_hasilujian_proposal");
    Route::get("/fakultas/approve_hasilujian_proposal_post/{id}/{nim}/{pendaftaran_id}", "fakultas@approve_hasilujian_proposal_post");
    Route::get("/fakultas/tolak_hasilujian_proposal_post/{id}/{nim}/{pendaftaran_id}", "fakultas@tolak_hasilujian_proposal_post");
    Route::get("/fakultas/lembaran_hasilujian_proposal/{id}/{nim}/{regid}", "fakultas@lembaran_hasilujian_proposal");
    Route::get("/fakultas/approve_hasilujian_proposal_all_post", "fakultas@approve_hasilujian_proposal_all_post");
    Route::get("/fakultas/approve_hasilujian_ta_all_post", "fakultas@approve_hasilujian_ta_all_post");
    Route::get("/fakultas/approve_hasilujian_ta/", "fakultas@approve_hasilujian_ta");
    Route::get("/fakultas/detail_hasilujian_ta/{id}", "fakultas@detail_hasilujian_ta");
    Route::get("/fakultas/approve_hasilujian_ta_post/{id}/{nim}/{pendaftaran_id}", "fakultas@approve_hasilujian_ta_post");
    Route::get("/fakultas/tolak_hasilujian_ta_post/{id}/{nim}/{pendaftaran_id}", "fakultas@tolak_hasilujian_ta_post");
    Route::get("/fakultas/lembaran_hasilujian_ta/{id}/{nim}/{regid}", "fakultas@lembaran_hasilujian_ta");
    Route::get("/fakultas/approve_hasilujian_seminar/", "fakultas@approve_hasilujian_seminar");
    Route::get("/fakultas/detail_hasilujian_seminar/{id}", "fakultas@detail_hasilujian_seminar");
    Route::get("/fakultas/approve_hasilujian_seminar_post/{id}/{nim}/{pendaftaran_id}", "fakultas@approve_hasilujian_seminar_post");
    Route::get("/fakultas/tolak_hasilujian_seminar_post/{id}/{nim}/{pendaftaran_id}", "fakultas@tolak_hasilujian_seminar_post");
    Route::get("/fakultas/lembaran_hasilujian_seminar/{id}/{nim}/{regid}", "fakultas@lembaran_hasilujian_seminar");

    // Persyaratan Ujian
    Route::get('/fakultas/syarat_ujian', 'fakultas@syarat_ujian')->name('get_fakultas_syarat_ujian');
    Route::post('/fakultas/syaratadd', 'fakultas@syaratadd')->name('post_fakultas_syaratadd');
    Route::get('/fakultas/syaratdel/{id}', 'fakultas@syaratdel')->name('get_fakultas_syaratdel');
});

Route::group(['middleware' => 'dosen'], function () {

    // New
    Route::get('/dsn/usul_judul/delete/{usulan_judul_id}', 'dosen@hapus_usulan_judul');

    Route::get('/home', 'HomeController@index')->name('home');
    //DOSEN
    Route::get('/dsn/mail_inbox', 'dosen@mail_inbox');
    Route::get('/dsn/mail_sent', 'dosen@mail_sent');
    Route::get('/dsn/mail_new', 'dosen@mail_new');
    Route::get('/dsn/mail_read/{id}/{status}', 'dosen@mail_read');
    Route::post('/dsn/mail_reply/', 'dosen@mail_reply');



    Route::get('/dsn/request_pembimbing', 'dosen@request_pembimbing');
    Route::get('/dsn/request_konfirmasi/{status}/{mahasiswa}', 'dosen@request_konfirmasi');
    Route::post('/dsn/pesanpost', 'dosen@pesanpost');
    Route::get('/dsn/detail_pembimbing/{id}', 'dosen@detail_pembimbing');
    Route::get('/dsn/detail_note/{id}', 'dosen@detail_note');
    Route::post('/dsn/detail_note/{id}', 'dosen@note_update');
    Route::get("/dsn/ubah_password/", "dosen@ubah_password");
    Route::post("/dsn/ubah_password/", "dosen@ubah_password_post");
    Route::get("/dsn/hasil_proposal/", "dosen@hasil_proposal");
    Route::get("/dsn/detailhasil_proposal/{regid}", "dosen@detailhasil_proposal");
    Route::post("/dsn/detailhasil_proposalpost/", "dosen@detailhasil_proposalpost");
    Route::get("/dsn/hasil_seminar/", "dosen@hasil_seminar");
    Route::get("/dsn/detailhasil_seminar/{regid}", "dosen@detailhasil_seminar");
    Route::post("/dsn/detailhasil_seminarpost/", "dosen@detailhasil_seminarpost");
    Route::get("/dsn/hasil_ujianmeja/", "dosen@hasil_ujianmeja");
    Route::get("/dsn/detailhasil_ujianmeja/{regid}", "dosen@detailhasil_ujianmeja");
    Route::post("/dsn/detailhasil_ujianmejapost/", "dosen@detailhasil_ujianmejapost");
    Route::get("/dsn/jadwal_proposal/", "dosen@jadwal_proposal");
    Route::get("/dsn/jadwal_seminar/", "dosen@jadwal_seminar");
    Route::get("/dsn/jadwal_ujianmeja/", "dosen@jadwal_ujianmeja");
    Route::get('/dsn/surat_sk_seminar/{pendaftaran_id}/{nim}', 'dosen@surat_sk_seminar');

    Route::get('/dsn/usul_judul', 'dosen@usul_judul');
    Route::get('/dsn/add_usul_judul', 'dosen@add_usul_judul');
    Route::post('/dsn/usul_judul_post', 'dosen@usul_judul_post');

    // Rekap Nilai Hasil Proposal
    Route::get("/dsn/rekap_nilai_proposal/", "dosen@rekap_nilai_proposal");
    Route::get("/dsn/detail_rekap_nilai_proposal/{id}", "dosen@detail_rekap_nilai_proposal");
    Route::get("/dsn/lembaran_hasilujian_proposal/{id}/{nim}/{regid}", "dosen@lembaran_hasilujian_proposal");

    // Rekap Nilai Ujian TA
    Route::get("/dsn/rekap_nilai_ujian_ta/", "dosen@rekap_nilai_ujian_ta");
    Route::get("/dsn/detail_rekap_nilai_ujian_ta/{id}", "dosen@detail_rekap_nilai_ujian_ta");
    Route::get("/dsn/lembaran_hasilujian_ujian_ta/{id}/{nim}/{regid}", "dosen@lembaran_hasilujian_ujian_ta");

    // Pengumuman
    Route::get('/dsn/pengumuman/show/{id}', 'dosen@show_pengumuman');
    Route::get('/dsn/pengumuman/', 'dosen@pengumuman');

    // Sk Pembimbing
    Route::post('/dsn/cetak_sk_pembimbing/', 'dosen@cetak_sk_pembimbing');

    Route::get('/dsn/surat_sk_proposal/{pendaftaran_id}/{nim}', 'dosen@surat_sk_proposal');
    Route::get('/dsn/surat_sk_ujian_meja/{nim}', 'dosen@surat_sk_ujian_meja');

    Route::get('/dsn/detail_ujian/{nim}/{tipe_ujian}', 'dosen@detail_ujian');

    Route::get('/dsn/detailhasil_proposal/{kode_dosen}/{reg_id}/{pendaftaran_id}/{nim}/{status}', 'mhs@detail_hasil_proposal');

    Route::get('/dsn/detailhasil_ujianmeja/{kode_dosen}/{reg_id}/{pendaftaran_id}/{nim}/{status}', 'mhs@detail_hasil_ujianmeja');

    // Surat Keputusan Pembimbing
    Route::get('/dsn/sk_pembimbing', 'dosen@sk_pembimbing')->name('get_dosen_sk_pembimbing');
    Route::post('/dsn/cetakskpembimbing/', 'dosen@cetakskpembimbing')->name('post_dosen_cetakskpembimbing');
});

Route::group(['middleware' => 'mhs'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    //MAHASISWA
    Route::get('/mhs/pengajuan_topik', 'mhs@pengajuan_topik');
    Route::get('/mhs/detail_note/{id}', 'mhs@detail_note');
    Route::post('/mhs/detail_note/{id}', 'mhs@note_update');
    Route::get('/mhs/ubah_judul/{id}', 'mhs@ubah_judul');
    Route::post('/mhs/ubah_judul/{id}', 'mhs@judul_update');
    Route::get('/mhs/pengajuan_topikdel/{id}', 'mhs@pengajuan_topikdel');
    Route::get('/mhs/riwayat_ujian/{nim}', 'mhs@riwayat_ujian');
    Route::get('/mhs/mail_inbox', 'mhs@mail_inbox');
    Route::get('/mhs/mail_sent', 'mhs@mail_sent');
    Route::get('/mhs/mail_new', 'mhs@mail_new');
    Route::get('/mhs/mail_read/{id}/{status}', 'mhs@mail_read');
    Route::get('/mhs/detail_ujian/{nim}/{tipe_uijan}', 'mhs@detail_ujian');
    Route::get('/mhs/signup_proposal', 'mhs@signup_proposal');
    Route::get('/mhs/signup_seminarhasil', 'mhs@signup_seminarhasil');
    Route::get('/mhs/signup_ujianmeja', 'mhs@signup_ujianmeja');
    Route::get('/mhs/download', 'mhs@download');
    Route::get("/mhs/usulan_tmp/pembimbing/getstatus/{index}/{id}", "mhs@getPembimbingStatus");
    Route::get('/mhs/syarat_ujiandel/{type}/{id}', 'mhs@syarat_ujiandel');
    Route::get('/mhs/ajukan_dokumen/{type}', 'mhs@ajukan_dokumen');
    Route::get('/mhs/beritaacara_proposal/{nim}', 'mhs@beritaacara_proposal');
    Route::get('/mhs/beritaacara_seminarhasil/{nim}', 'mhs@beritaacara_seminarhasil');
    Route::get('/mhs/beritaacara_ujian/{nim}', 'mhs@beritaacara_ujian');
    Route::get('/mhs/cetak_beritaacara_proposal/{pendaftaran_id}/{nim}', 'mhs@cetak_beritaacara_proposal');

    Route::post('/mhs/pengajuan_topik', 'mhs@pengajuan_topikpost');
    Route::post('/mhs/registrasi', 'mhs@registrasi');
    Route::post('/mhs/pesanpost', 'mhs@pesanpost');
    Route::post('/mhs/usulan_tmp', 'mhs@usulan_tmp');
    Route::post('/mhs/syarat_ujianpost', 'mhs@syarat_ujianpost');
    Route::post('/mhs/syarat_ujianpost_all', 'mhs@syarat_ujianpost_all');
    Route::get("/mhs/ubah_password/", "mhs@ubah_password");
    Route::post("/mhs/ubah_password/", "mhs@ubah_password_post");

    Route::get('/mhs/usulan_judul_calon_pembimbing', 'mhs@usulan_judul_calon_pembimbing');
    Route::get('/mhs/usulan_judul_calon_pembimbing/{kode_dosen}', 'mhs@detail_usulan_judul_calon_pembimbing');
    Route::get('/mhs/usulan_judul_anak_bimbingan', 'mhs@usulan_judul_anak_bimbingan');
    Route::get('/mhs/usulan_judul_semua_mahasiswa', 'mhs@usulan_judul_semua_mahasiswa');

    Route::get('/mhs/detailhasil_proposal/{kode_dosen}/{reg_id}/{pendaftaran_id}/{nim}/{status}', 'mhs@detail_hasil_proposal');

    Route::get('/mhs/detailhasil_ujianmeja/{kode_dosen}/{reg_id}/{pendaftaran_id}/{nim}/{status}', 'mhs@detail_hasil_ujianmeja');

    Route::get("/mhs/lembaran_hasilujian_proposal/{id}/{nim}/{regid}", "Prodi@lembaran_hasilujian_proposal");

    Route::get("/mhs/chat/", "Prodi@chat");

    Route::get('/mhs/pengumuman/show/{id}', 'mhs@show_pengumuman');
    Route::get('/mhs/pengumuman/', 'mhs@pengumuman');

    Route::post('/mhs/mail_reply/', 'mhs@mail_reply');

    // Catatan
    Route::get('/mhs/signup_proposal/catatan/{id}', 'mhs@signup_proposal_catatan');
    Route::post('/mhs/signup_proposal_catatan/', 'mhs@signup_proposal_catatan_post');

    // Catatan
    Route::get('/mhs/signup_ujianmeja/catatan/{id}', 'mhs@signup_ujianmeja_catatan');
    Route::post('/mhs/signup_ujianmeja_catatan/', 'mhs@signup_ujianmeja_catatan_post');

    // Catatan
    Route::get('/mhs/surat_sk_pembimbing/{nomor}', 'mhs@surat_sk_pembimbing');
    Route::get('/mhs/surat_sk_proposal/{pendaftaran_id}', 'mhs@surat_sk_proposal');
    Route::get('/mhs/surat_sk_seminar/{pendaftaran_id}', 'mhs@surat_sk_seminar');
    Route::get('/mhs/surat_sk_ujian_meja/{nomor}', 'mhs@surat_sk_ujian_meja');

    // Data Pembimbing
    Route::get('/mhs/data_pembimbing', 'mhs@data_pembimbing');

    // Data Penguji
    Route::get('/mhs/data_penguji', 'mhs@data_penguji');
});
