<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print Surat Pengusulan</title>
    <style>
        body {
            height: 842px;
            width: 595px;
            /* to centre page on screen*/
            margin-left: auto;
            margin-right: auto;
        }

        .header img {
            width: 75px;
            display: inline;
            float: left;
        }

        .header {
            text-align: center;
            margin-top: 10px;
            position: relative;
        }

        .textheader {
            display: inline;
            margin-top: 100px;
            text-align: center;
        }

        .headerAddress {
            display: inline-block;
            margin-bottom: 0px;
            margin-top: 0px;
            text-align: left;
        }

        .headingTitle {
            display: inline;
        }

        .title {
            text-align: center;
        }

        .legalitor {
            float: right;
        }

        .button {
            background-color: #4CAF50;
            /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            position: relative;
        }

        .tg {
        }

        .tg td {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 10px 5px;
            overflow: hidden;
            word-break: normal;
        }

        .tg th {
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            padding: 10px 5px;
            word-break: normal;
        }

        .tg .tg-baqh {
            text-align: center;
            vertical-align: top
        }

        .tg .tg-lqy6 {
            text-align: right;
            vertical-align: top
        }

        .tg .tg-0lax {
            text-align: left;
            vertical-align: top
        }
    </style>
    <script>
        function prints() {

            document.getElementById('btnPrint').style.display = "none";
            window.print();
            window.onafterprint = show();
        }

        function back() {
            window.location = 'report';
        }

        function show() {
            document.getElementById('btnBack').style.display = "inline";
            document.getElementById('btnPrint').style.display = "inline";
        }
    </script>
</head>
{{-- <button id="btnBack" onclick="back()" class="button">Kembali</button> --}}
<button id="btnPrint" onclick="prints()" class="button">Print</button>

<body>
    <div class="header" style="page-break-before: always">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" style="position:absolute; left: 80px " />
        <br>
        <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
        <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
        <h4 class="textheader">Fakultas Hukum</h4><br>
        <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
    </div>
    <span style="border: solid 0.5px; width: 100%; display: flex"></span>
    <span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
    <h6 class="headerAddress" style="text-align: center"><i>Jln. Urip Sumohardjo Km.05 Gedung Fakultas Hukum
            Lt.1, Kampus II UMI Tlp.(0411) 453009/082195858768, Makassar 90231
            website: fh.umi.ac.id, email: fh.umi.ac.id / S1.ilmu.hukum@umi.ac.id</i>
    </h6>

    <h5 style="text-align: center"><i>Bismillahir Rahmanir Rahiim</i></h5>

    <div class="title">
        <u>
            <h4><b>REKAPITULASI NILAI <br>UJIAN {{strtoupper($tipe_ujian)}} TUGAS AKHIR</b></h4>
        </u>
    </div>
    <div>
        <table>
            <tr>
                <td style="padding-right: 100px;">STAMBUK</td>
                <td style="padding-right: 10px">:</td>
                <td colspan="2">{{ucwords($nim)}}</td>
            </tr>
            <tr>
                <td>NAMA MAHASISWA</td>
                <td>:</td>
                <td style="" colspan="2">
                    {{ucwords(strtolower(\App\Model\t_mst_mahasiswa::where("C_NPM", $nim)->first()->NAMA_MAHASISWA))}}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">JUDUL SKRIPSI</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top;" colspan="2">{{$trt_bimbingan->judul}}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div style="position: relative">
        <table class="tg" border="1" width="550px" cellpadding="4" cellspacing="0">
            <tr>
                <th class="tg-baqh">No</th>
                <th class="tg-baqh" colspan="2">Tim Penguji</th>
                <th class="tg-baqh">Nilai</th>
                <th class="tg-baqh">Paraf</th>
            </tr>
            <tr>
                <td class="tg-baqh">1.</td>
                <td class="tg-0lax">Ketua Sidang</td>
                <td class="tg-0lax">{{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_selesai->ketua_sidang_id)->first()->NAMA_DOSEN}}</td>
                <td class="tg-baqh">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_5}}</td>
                <td class="tg-baqh"></td>
            </tr>
            <tr>
                <td class="tg-baqh">2.</td>
                <td class="tg-0lax">Pembimbing Ketua</td>
                <td class="tg-0lax">{{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_pembimbing->pembimbing_I_id)->first()->NAMA_DOSEN}}</td>
                <td class="tg-baqh">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_5}}</td>
                <td class="tg-baqh"></td>
            </tr>
            <tr>
                <td class="tg-baqh">3.</td>
                <td class="tg-0lax">Pembimbing Anggota</td>
                <td class="tg-0lax">{{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_pembimbing->pembimbing_II_id)->first()->NAMA_DOSEN}}</td>
                <td class="tg-baqh">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_5}}</td>
                <td class="tg-baqh"></td>
            </tr>
            <tr>
                <td class="tg-baqh">4.</td>
                <td class="tg-0lax">Penguji I</td>
                <td class="tg-0lax">{{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_selesai->penguji_I_id)->first()->NAMA_DOSEN}}</td>
                <td class="tg-baqh">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_5}}</td>
                <td class="tg-baqh"></td>
            </tr>
            <tr>
                <td class="tg-baqh">5.</td>
                <td class="tg-0lax">Penguji II</td>
                <td class="tg-0lax">{{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_selesai->penguji_II_id)->first()->NAMA_DOSEN}}</td>
                <td class="tg-baqh">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_5}}</td>
                <td class="tg-baqh"></td>
            </tr>
            <tr>
                <td class="tg-baqh">6.</td>
                <td class="tg-0lax">Penguji III</td>
                <td class="tg-0lax">{{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_selesai->penguji_III_id)->first()->NAMA_DOSEN}}</td>
                <td class="tg-baqh">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_5}}</td>
                <td class="tg-baqh"></td>
            </tr>
            <tr>
                <td class="tg-lqy6" colspan="3">Total : </td>
                <td class="tg-baqh">{{(helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_5)}}</td>
                <td class="tg-baqh"></td>
            </tr>
            <tr>
                <td class="tg-lqy6" colspan="3">Nilai Ujian Rata - Rata (Total/6) :</td>
                <td class="tg-baqh">{{((helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_5)) / 6}}</td>
                <td class="tg-baqh"></td>
            </tr>
            <tr>
                @php
                    $nilai_huruf = ((helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_5) + (helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_5)) / 6;
                    $status_huruf = '';
                    if ($nilai_huruf > 85){
                        $status_huruf = "A";
                    }else if($nilai_huruf >= 81 && $nilai_huruf <= 85){
                        $status_huruf = "A-";
                    }else if($nilai_huruf >= 76 && $nilai_huruf <= 80){
                        $status_huruf = "B+";
                    }else if($nilai_huruf >= 71 && $nilai_huruf <= 75){
                        $status_huruf = "B";
                    }else{

                    }
                @endphp
                <td class="tg-lqy6" colspan="3">Nilai Huruf :</td>
                <td class="tg-baqh">{{$status_huruf}}</td>
                <td class="tg-baqh"></td>
            </tr>
        </table>
    </div>
    <br>
    <div class="legalitor">
        Makassar,
        {{Illuminate\Support\Carbon::parse(substr($data_dosen_selesai->created_at,0,10))->formatLocalized("%d %B %Y")}}


        <br>
        <b>Ketua Sidang</b>
    </div>
    <br><br><br><br>
    <br>
    <div class="legalitor">
        {{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_selesai->ketua_sidang_id)->first()->NAMA_DOSEN}}
        <b><u></u></b><br>
        <b>NIDN : {{$data_dosen_selesai->ketua_sidang_id}}<br>
    </div>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br><br>
    <br>
    <div>

        <table border="1" width="320px" cellpadding="1" cellspacing="0">
            <tr align="center">
                <th width="100px">Nilai Angka</th>
                <th width="100px">Nilai Mutu</th>
                <th width="120px">Nilai Konversi</th>
            </tr>
            <tr align="center">
                <td> > 85</td>
                <td>A</td>
                <td>4.00</td>
            </tr>
            <tr align="center">
                <td>81 - 85</td>
                <td>A-</td>
                <td>3.75</td>
            </tr>
            <tr align="center">
                <td>76 - 80</td>
                <td>B+</td>
                <td>3.50</td>
            </tr>
            <tr align="center">
                <td>71 - 75</td>
                <td>B</td>
                <td>3.00</td>
            </tr>
        </table>
        <span style="font-size: 12px"><i>Sumber: Peraturan No. 1 Tahun 2014 UMI Tentang Ketentuan Pokok Akademik Pasal
                43 Predikat Kelulusan</i></span>

    </div>
    <br><br>
    <br><br>
    {{-- Satu --}}
    <div class="header" style="page-break-before: always">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" style="position:absolute; left: 80px " />
        <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
        <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
        <h4 class="textheader">Fakultas Hukum</h4><br>
        <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
    </div>
    <h6 class="headerAddress"> Alamat : Jalan Urip Sumoharjo Km. 05
        gedung Fakultas Hukum Lt.1 Kampus II UMI Tlp (0411)453009 Makassar 90231
    </h6>
    <span style="border: solid 0.5px; width: 100%; display: flex"></span>
    <span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
    <div class="title">
        <u>
            <h4><b>LEMBAR PENILAIAN UJIAN UJIAN TUTUP TUGAS AKHIR</b></h4>
        </u>
    </div>
    <div>
        <table>
            <tr>
                <td style="padding-right: 100px;">STAMBUK</td>
                <td style="padding-right: 10px">:</td>
                <td colspan="2">{{ucwords($nim)}}</td>
            </tr>
            <tr>
                <td>NAMA MAHASISWA</td>
                <td>:</td>
                <td style="" colspan="2">
                    {{ucwords(strtolower(\App\Model\t_mst_mahasiswa::where("C_NPM", $nim)->first()->NAMA_MAHASISWA))}}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">JUDUL SKRIPSI</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top;" colspan="2">{{$trt_bimbingan->judul}}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div style="position: relative">
        <table style=" margin: 0 auto" border="1" width="550px" cellpadding="4" cellspacing="0">
            <tr>
                <th width="10px">NO.</th>
                <th>ASPEK PENILAIAN</th>
                <th>BOBOT</th>
                <th width="60px">RANGE NILAI</th>
                <th>NILAI</th>
            </tr>
            <tr>
                <td align="center">1</td>
                <td><b>Sikap/Presentasi</b><br>
                    <span style="font-size: 14px">1.1 Penguasaan isi proposal</span><br>
                    <span style="font-size: 14px">1.2 Kemampuan berargumentasi</span><br>
                    <span style="font-size: 14px">1.3 Percaya diri dalam menyampaikan</span><br>
                    <span style="font-size: 14px">1.4 Penguasaan isi proposal</span><br>
                </td>
                <td align="center">10%</td>
                <td align="center">6 - 10</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_1}}</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td><b>Sistematika Penelitian</b><br>
                    <span style="font-size: 14px">2.1 Kelengkapan/Kesesuaian Penulisan</span><br>
                    <span style="font-size: 14px">2.2 Format Penulisan</span><br>
                </td>
                <td align="center">15%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_2}}</td>
            </tr>
            <tr>
                <td align="center">3</td>
                <td><b>Hasil Penelitian</b><br>
                    <span style="font-size: 14px">3.1 Kesesuaian dengan Tujuan</span><br>
                    <span style="font-size: 14px">3.2 Penyajian Hasil Penelitian</span><br>
                    <span style="font-size: 14px">3.3 Kualitas Hasil Penelitian</span><br>
                </td>
                <td align="center">20%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_3}}</td>
            </tr>
            <tr>
                <td align="center">4</td>
                <td><b>Penguasan Materi</b><br>
                    <span style="font-size: 14px">4.1 Pemahaman Konsep</span><br>
                    <span style="font-size: 12px">(Konsep Teori Riset, dan Materi yang relevan)</span><br>
                    <span style="font-size: 14px">4.2 Kemampuan Teknis</span><br>
                    <span style="font-size: 12px">(Pengoperasian OS dan Running Program)</span><br>
                </td>
                <td align="center">30%</td>
                <td align="center">15 - 30</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_4}}</td>
            </tr>
            <tr>
                <td align="center">5</td>
                <td><b>Penguasaan Program/Aplikasi</b><br>
                    <span style="font-size: 14px">(Penggunaan Data, Fungsi/Procedure, dll)</span><br>
                </td>
                <td align="center">25%</td>
                <td align="center">15 - 25</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_5}}</td>
            </tr>
            <tr>
                <td align="center" colspan="2" style="font-weight: bold">TOTAL NILAI</td>
                <td align="center" style="font-weight: bold">100%</td>
                <td align="center" style="font-weight: bold">71 - 100</td>
                <td align="center" style="font-weight: bold">
{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->ketua_sidang_id, $reg_id)->nilai_5}}
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="legalitor">
        Makassar, {{Illuminate\Support\Carbon::parse(substr($data_dosen_selesai->created_at,0,10))->formatLocalized("%d %B %Y")}}
        <br>
        <b>Ketua Sidang</b>
    </div>
    <br><br><br><br>
    <div class="legalitor">
        {{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_selesai->ketua_sidang_id)->first()->NAMA_DOSEN}}
        <b><u></u></b><br>
        <b>NIDN : {{$data_dosen_selesai->ketua_sidang_id}}<br>
    </div>
    <br><br>
    <div>

        <table border="1" width="320px" cellpadding="1" cellspacing="0">
            <tr align="center">
                <th width="100px">Nilai Angka</th>
                <th width="100px">Nilai Mutu</th>
                <th width="120px">Nilai Konversi</th>
            </tr>
            <tr align="center">
                <td> > 85</td>
                <td>A</td>
                <td>4.00</td>
            </tr>
            <tr align="center">
                <td>81 - 85</td>
                <td>A-</td>
                <td>3.75</td>
            </tr>
            <tr align="center">
                <td>76 - 80</td>
                <td>B+</td>
                <td>3.50</td>
            </tr>
            <tr align="center">
                <td>71 - 85</td>
                <td>B</td>
                <td>3.00</td>
            </tr>
        </table>
        <span style="font-size: 12px"><i>Sumber: Peraturan No. 1 Tahun 2014 UMI Tentang Ketentuan Pokok Akademik Pasal
                43 Predikat Kelulusan</i></span>
    </div>
    <br><br>
    <br><br>
    {{-- Dua --}}
    <div class="header" style="page-break-before: always">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" style="position:absolute; left: 80px " />
        <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
        <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
        <h4 class="textheader">Fakultas Hukum</h4><br>
        <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
    </div>
    <h6 class="headerAddress"> Alamat : Jalan Urip Sumoharjo Km. 05
        gedung Fakultas Hukum Lt.1 Kampus II UMI Tlp (0411)453009 Makassar 90231
    </h6>
    <span style="border: solid 0.5px; width: 100%; display: flex"></span>
    <span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
    <div class="title">
        <u>
            <h4><b>LEMBAR PENILAIAN UJIAN UJIAN TUTUP TUGAS AKHIR</b></h4>
        </u>
    </div>
    <div>
        <table>
            <tr>
                <td style="padding-right: 100px;">STAMBUK</td>
                <td style="padding-right: 10px">:</td>
                <td colspan="2">{{ucwords($nim)}}</td>
            </tr>
            <tr>
                <td>NAMA MAHASISWA</td>
                <td>:</td>
                <td style="" colspan="2">
                    {{ucwords(strtolower(\App\Model\t_mst_mahasiswa::where("C_NPM", $nim)->first()->NAMA_MAHASISWA))}}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">JUDUL SKRIPSI</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top;" colspan="2">{{$trt_bimbingan->judul}}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div style="position: relative">
        <table style=" margin: 0 auto" border="1" width="550px" cellpadding="4" cellspacing="0">
            <tr>
                <th width="10px">NO.</th>
                <th>ASPEK PENILAIAN</th>
                <th>BOBOT</th>
                <th width="60px">RANGE NILAI</th>
                <th>NILAI</th>
            </tr>
            <tr>
                <td align="center">1</td>
                <td><b>Sikap/Presentasi</b><br>
                    <span style="font-size: 14px">1.1 Penguasaan isi proposal</span><br>
                    <span style="font-size: 14px">1.2 Kemampuan berargumentasi</span><br>
                    <span style="font-size: 14px">1.3 Percaya diri dalam menyampaikan</span><br>
                    <span style="font-size: 14px">1.4 Penguasaan isi proposal</span><br>
                </td>
                <td align="center">10%</td>
                <td align="center">6 - 10</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_1}}</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td><b>Sistematika Penelitian</b><br>
                    <span style="font-size: 14px">2.1 Kelengkapan/Kesesuaian Penulisan</span><br>
                    <span style="font-size: 14px">2.2 Format Penulisan</span><br>
                </td>
                <td align="center">15%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_2}}</td>
            </tr>
            <tr>
                <td align="center">3</td>
                <td><b>Hasil Penelitian</b><br>
                    <span style="font-size: 14px">3.1 Kesesuaian dengan Tujuan</span><br>
                    <span style="font-size: 14px">3.2 Penyajian Hasil Penelitian</span><br>
                    <span style="font-size: 14px">3.3 Kualitas Hasil Penelitian</span><br>
                </td>
                <td align="center">20%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_3}}</td>
            </tr>
            <tr>
                <td align="center">4</td>
                <td><b>Penguasan Materi</b><br>
                    <span style="font-size: 14px">4.1 Pemahaman Konsep</span><br>
                    <span style="font-size: 12px">(Konsep Teori Riset, dan Materi yang relevan)</span><br>
                    <span style="font-size: 14px">4.2 Kemampuan Teknis</span><br>
                    <span style="font-size: 12px">(Pengoperasian OS dan Running Program)</span><br>
                </td>
                <td align="center">30%</td>
                <td align="center">15 - 30</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_4}}</td>
            </tr>
            <tr>
                <td align="center">5</td>
                <td><b>Penguasaan Program/Aplikasi</b><br>
                    <span style="font-size: 14px">(Penggunaan Data, Fungsi/Procedure, dll)</span><br>
                </td>
                <td align="center">25%</td>
                <td align="center">15 - 25</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_5}}</td>
            </tr>
            <tr>
                <td align="center" colspan="2" style="font-weight: bold">TOTAL NILAI</td>
                <td align="center" style="font-weight: bold">100%</td>
                <td align="center" style="font-weight: bold">71 - 100</td>
                <td align="center" style="font-weight: bold">
{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_I_id, $reg_id)->nilai_5}}
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="legalitor">
        Makassar, {{Illuminate\Support\Carbon::parse(substr($data_dosen_selesai->created_at,0,10))->formatLocalized("%d %B %Y")}}
        <br>
        <b>Penguji I</b>
    </div>
    <br><br><br><br>
    <div class="legalitor">
        {{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_selesai->penguji_I_id)->first()->NAMA_DOSEN}}
        <b><u></u></b><br>
        <b>NIDN : {{$data_dosen_selesai->penguji_I_id}}<br>
    </div>
    <br><br>
    <div>

        <table border="1" width="320px" cellpadding="1" cellspacing="0">
            <tr align="center">
                <th width="100px">Nilai Angka</th>
                <th width="100px">Nilai Mutu</th>
                <th width="120px">Nilai Konversi</th>
            </tr>
            <tr align="center">
                <td> > 85</td>
                <td>A</td>
                <td>4.00</td>
            </tr>
            <tr align="center">
                <td>81 - 85</td>
                <td>A-</td>
                <td>3.75</td>
            </tr>
            <tr align="center">
                <td>76 - 80</td>
                <td>B+</td>
                <td>3.50</td>
            </tr>
            <tr align="center">
                <td>71 - 85</td>
                <td>B</td>
                <td>3.00</td>
            </tr>
        </table>
        <span style="font-size: 12px"><i>Sumber: Peraturan No. 1 Tahun 2014 UMI Tentang Ketentuan Pokok Akademik Pasal
                43 Predikat Kelulusan</i></span>
    </div>
    <br><br>
    <br><br>
    {{-- Tiga --}}
    <div class="header" style="page-break-before: always">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" style="position:absolute; left: 80px " />
        <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
        <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
        <h4 class="textheader">Fakultas Hukum</h4><br>
        <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
    </div>
    <h6 class="headerAddress"> Alamat : Jalan Urip Sumoharjo Km. 05
        gedung Fakultas Hukum Lt.1 Kampus II UMI Tlp (0411)453009 Makassar 90231
    </h6>
    <span style="border: solid 0.5px; width: 100%; display: flex"></span>
    <span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
    <div class="title">
        <u>
            <h4><b>LEMBAR PENILAIAN UJIAN UJIAN TUTUP TUGAS AKHIR</b></h4>
        </u>
    </div>
    <div>
        <table>
            <tr>
                <td style="padding-right: 100px;">STAMBUK</td>
                <td style="padding-right: 10px">:</td>
                <td colspan="2">{{ucwords($nim)}}</td>
            </tr>
            <tr>
                <td>NAMA MAHASISWA</td>
                <td>:</td>
                <td style="" colspan="2">
                    {{ucwords(strtolower(\App\Model\t_mst_mahasiswa::where("C_NPM", $nim)->first()->NAMA_MAHASISWA))}}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">JUDUL SKRIPSI</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top;" colspan="2">{{$trt_bimbingan->judul}}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div style="position: relative">
        <table style=" margin: 0 auto" border="1" width="550px" cellpadding="4" cellspacing="0">
            <tr>
                <th width="10px">NO.</th>
                <th>ASPEK PENILAIAN</th>
                <th>BOBOT</th>
                <th width="60px">RANGE NILAI</th>
                <th>NILAI</th>
            </tr>
            <tr>
                <td align="center">1</td>
                <td><b>Sikap/Presentasi</b><br>
                    <span style="font-size: 14px">1.1 Penguasaan isi proposal</span><br>
                    <span style="font-size: 14px">1.2 Kemampuan berargumentasi</span><br>
                    <span style="font-size: 14px">1.3 Percaya diri dalam menyampaikan</span><br>
                    <span style="font-size: 14px">1.4 Penguasaan isi proposal</span><br>
                </td>
                <td align="center">10%</td>
                <td align="center">6 - 10</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_1}}</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td><b>Sistematika Penelitian</b><br>
                    <span style="font-size: 14px">2.1 Kelengkapan/Kesesuaian Penulisan</span><br>
                    <span style="font-size: 14px">2.2 Format Penulisan</span><br>
                </td>
                <td align="center">15%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_2}}</td>
            </tr>
            <tr>
                <td align="center">3</td>
                <td><b>Hasil Penelitian</b><br>
                    <span style="font-size: 14px">3.1 Kesesuaian dengan Tujuan</span><br>
                    <span style="font-size: 14px">3.2 Penyajian Hasil Penelitian</span><br>
                    <span style="font-size: 14px">3.3 Kualitas Hasil Penelitian</span><br>
                </td>
                <td align="center">20%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_3}}</td>
            </tr>
            <tr>
                <td align="center">4</td>
                <td><b>Penguasan Materi</b><br>
                    <span style="font-size: 14px">4.1 Pemahaman Konsep</span><br>
                    <span style="font-size: 12px">(Konsep Teori Riset, dan Materi yang relevan)</span><br>
                    <span style="font-size: 14px">4.2 Kemampuan Teknis</span><br>
                    <span style="font-size: 12px">(Pengoperasian OS dan Running Program)</span><br>
                </td>
                <td align="center">30%</td>
                <td align="center">15 - 30</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_4}}</td>
            </tr>
            <tr>
                <td align="center">5</td>
                <td><b>Penguasaan Program/Aplikasi</b><br>
                    <span style="font-size: 14px">(Penggunaan Data, Fungsi/Procedure, dll)</span><br>
                </td>
                <td align="center">25%</td>
                <td align="center">15 - 25</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_5}}</td>
            </tr>
            <tr>
                <td align="center" colspan="2" style="font-weight: bold">TOTAL NILAI</td>
                <td align="center" style="font-weight: bold">100%</td>
                <td align="center" style="font-weight: bold">71 - 100</td>
                <td align="center" style="font-weight: bold">
{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_II_id, $reg_id)->nilai_5}}
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="legalitor">
        Makassar, {{Illuminate\Support\Carbon::parse(substr($data_dosen_selesai->created_at,0,10))->formatLocalized("%d %B %Y")}}
        <br>
        <b>Penguji II</b>
    </div>
    <br><br><br><br>
    <div class="legalitor">
        {{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_selesai->penguji_II_id)->first()->NAMA_DOSEN}}
        <b><u></u></b><br>
        <b>NIDN : {{$data_dosen_selesai->penguji_II_id}}<br>
    </div>
    <br><br>
    <div>

        <table border="1" width="320px" cellpadding="1" cellspacing="0">
            <tr align="center">
                <th width="100px">Nilai Angka</th>
                <th width="100px">Nilai Mutu</th>
                <th width="120px">Nilai Konversi</th>
            </tr>
            <tr align="center">
                <td> > 85</td>
                <td>A</td>
                <td>4.00</td>
            </tr>
            <tr align="center">
                <td>81 - 85</td>
                <td>A-</td>
                <td>3.75</td>
            </tr>
            <tr align="center">
                <td>76 - 80</td>
                <td>B+</td>
                <td>3.50</td>
            </tr>
            <tr align="center">
                <td>71 - 85</td>
                <td>B</td>
                <td>3.00</td>
            </tr>
        </table>
        <span style="font-size: 12px"><i>Sumber: Peraturan No. 1 Tahun 2014 UMI Tentang Ketentuan Pokok Akademik Pasal
                43 Predikat Kelulusan</i></span>
    </div>
    <br><br>
    <br><br>
    {{-- Empat --}}
    <div class="header" style="page-break-before: always">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" style="position:absolute; left: 80px " />
        <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
        <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
        <h4 class="textheader">Fakultas Hukum</h4><br>
        <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
    </div>
    <h6 class="headerAddress"> Alamat : Jalan Urip Sumoharjo Km. 05
        gedung Fakultas Hukum Lt.1 Kampus II UMI Tlp (0411)453009 Makassar 90231
    </h6>
    <span style="border: solid 0.5px; width: 100%; display: flex"></span>
    <span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
    <div class="title">
        <u>
            <h4><b>LEMBAR PENILAIAN UJIAN UJIAN TUTUP TUGAS AKHIR</b></h4>
        </u>
    </div>
    <div>
        <table>
            <tr>
                <td style="padding-right: 100px;">STAMBUK</td>
                <td style="padding-right: 10px">:</td>
                <td colspan="2">{{ucwords($nim)}}</td>
            </tr>
            <tr>
                <td>NAMA MAHASISWA</td>
                <td>:</td>
                <td style="" colspan="2">
                    {{ucwords(strtolower(\App\Model\t_mst_mahasiswa::where("C_NPM", $nim)->first()->NAMA_MAHASISWA))}}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">JUDUL SKRIPSI</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top;" colspan="2">{{$trt_bimbingan->judul}}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div style="position: relative">
        <table style=" margin: 0 auto" border="1" width="550px" cellpadding="4" cellspacing="0">
            <tr>
                <th width="10px">NO.</th>
                <th>ASPEK PENILAIAN</th>
                <th>BOBOT</th>
                <th width="60px">RANGE NILAI</th>
                <th>NILAI</th>
            </tr>
            <tr>
                <td align="center">1</td>
                <td><b>Sikap/Presentasi</b><br>
                    <span style="font-size: 14px">1.1 Penguasaan isi proposal</span><br>
                    <span style="font-size: 14px">1.2 Kemampuan berargumentasi</span><br>
                    <span style="font-size: 14px">1.3 Percaya diri dalam menyampaikan</span><br>
                    <span style="font-size: 14px">1.4 Penguasaan isi proposal</span><br>
                </td>
                <td align="center">10%</td>
                <td align="center">6 - 10</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_1}}</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td><b>Sistematika Penelitian</b><br>
                    <span style="font-size: 14px">2.1 Kelengkapan/Kesesuaian Penulisan</span><br>
                    <span style="font-size: 14px">2.2 Format Penulisan</span><br>
                </td>
                <td align="center">15%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_2}}</td>
            </tr>
            <tr>
                <td align="center">3</td>
                <td><b>Hasil Penelitian</b><br>
                    <span style="font-size: 14px">3.1 Kesesuaian dengan Tujuan</span><br>
                    <span style="font-size: 14px">3.2 Penyajian Hasil Penelitian</span><br>
                    <span style="font-size: 14px">3.3 Kualitas Hasil Penelitian</span><br>
                </td>
                <td align="center">20%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_3}}</td>
            </tr>
            <tr>
                <td align="center">4</td>
                <td><b>Penguasan Materi</b><br>
                    <span style="font-size: 14px">4.1 Pemahaman Konsep</span><br>
                    <span style="font-size: 12px">(Konsep Teori Riset, dan Materi yang relevan)</span><br>
                    <span style="font-size: 14px">4.2 Kemampuan Teknis</span><br>
                    <span style="font-size: 12px">(Pengoperasian OS dan Running Program)</span><br>
                </td>
                <td align="center">30%</td>
                <td align="center">15 - 30</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_4}}</td>
            </tr>
            <tr>
                <td align="center">5</td>
                <td><b>Penguasaan Program/Aplikasi</b><br>
                    <span style="font-size: 14px">(Penggunaan Data, Fungsi/Procedure, dll)</span><br>
                </td>
                <td align="center">25%</td>
                <td align="center">15 - 25</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_5}}</td>
            </tr>
            <tr>
                <td align="center" colspan="2" style="font-weight: bold">TOTAL NILAI</td>
                <td align="center" style="font-weight: bold">100%</td>
                <td align="center" style="font-weight: bold">71 - 100</td>
                <td align="center" style="font-weight: bold">
{{helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_selesai->penguji_III_id, $reg_id)->nilai_5}}
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="legalitor">
        Makassar, {{Illuminate\Support\Carbon::parse(substr($data_dosen_selesai->created_at,0,10))->formatLocalized("%d %B %Y")}}
        <br>
        <b>Penguji III</b>
    </div>
    <br><br><br><br>
    <div class="legalitor">
        {{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_selesai->penguji_III_id)->first()->NAMA_DOSEN}}
        <b><u></u></b><br>
        <b>NIDN : {{$data_dosen_selesai->penguji_III_id}}<br>
    </div>
    <br><br>
    <div>

        <table border="1" width="320px" cellpadding="1" cellspacing="0">
            <tr align="center">
                <th width="100px">Nilai Angka</th>
                <th width="100px">Nilai Mutu</th>
                <th width="120px">Nilai Konversi</th>
            </tr>
            <tr align="center">
                <td> > 85</td>
                <td>A</td>
                <td>4.00</td>
            </tr>
            <tr align="center">
                <td>81 - 85</td>
                <td>A-</td>
                <td>3.75</td>
            </tr>
            <tr align="center">
                <td>76 - 80</td>
                <td>B+</td>
                <td>3.50</td>
            </tr>
            <tr align="center">
                <td>71 - 85</td>
                <td>B</td>
                <td>3.00</td>
            </tr>
        </table>
        <span style="font-size: 12px"><i>Sumber: Peraturan No. 1 Tahun 2014 UMI Tentang Ketentuan Pokok Akademik Pasal
                43 Predikat Kelulusan</i></span>
    </div>
    <br><br>
    <br><br>
    {{-- Lima --}}
    <div class="header" style="page-break-before: always">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" style="position:absolute; left: 80px " />
        <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
        <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
        <h4 class="textheader">Fakultas Hukum</h4><br>
        <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
    </div>
    <h6 class="headerAddress"> Alamat : Jalan Urip Sumoharjo Km. 05
        gedung Fakultas Hukum Lt.1 Kampus II UMI Tlp (0411)453009 Makassar 90231
    </h6>
    <span style="border: solid 0.5px; width: 100%; display: flex"></span>
    <span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
    <div class="title">
        <u>
            <h4><b>LEMBAR PENILAIAN UJIAN UJIAN TUTUP TUGAS AKHIR</b></h4>
        </u>
    </div>
    <div>
        <table>
            <tr>
                <td style="padding-right: 100px;">STAMBUK</td>
                <td style="padding-right: 10px">:</td>
                <td colspan="2">{{ucwords($nim)}}</td>
            </tr>
            <tr>
                <td>NAMA MAHASISWA</td>
                <td>:</td>
                <td style="" colspan="2">
                    {{ucwords(strtolower(\App\Model\t_mst_mahasiswa::where("C_NPM", $nim)->first()->NAMA_MAHASISWA))}}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">JUDUL SKRIPSI</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top;" colspan="2">{{$trt_bimbingan->judul}}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div style="position: relative">
        <table style=" margin: 0 auto" border="1" width="550px" cellpadding="4" cellspacing="0">
            <tr>
                <th width="10px">NO.</th>
                <th>ASPEK PENILAIAN</th>
                <th>BOBOT</th>
                <th width="60px">RANGE NILAI</th>
                <th>NILAI</th>
            </tr>
            <tr>
                <td align="center">1</td>
                <td><b>Sikap/Presentasi</b><br>
                    <span style="font-size: 14px">1.1 Penguasaan isi proposal</span><br>
                    <span style="font-size: 14px">1.2 Kemampuan berargumentasi</span><br>
                    <span style="font-size: 14px">1.3 Percaya diri dalam menyampaikan</span><br>
                    <span style="font-size: 14px">1.4 Penguasaan isi proposal</span><br>
                </td>
                <td align="center">10%</td>
                <td align="center">6 - 10</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_1}}</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td><b>Sistematika Penelitian</b><br>
                    <span style="font-size: 14px">2.1 Kelengkapan/Kesesuaian Penulisan</span><br>
                    <span style="font-size: 14px">2.2 Format Penulisan</span><br>
                </td>
                <td align="center">15%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_2}}</td>
            </tr>
            <tr>
                <td align="center">3</td>
                <td><b>Hasil Penelitian</b><br>
                    <span style="font-size: 14px">3.1 Kesesuaian dengan Tujuan</span><br>
                    <span style="font-size: 14px">3.2 Penyajian Hasil Penelitian</span><br>
                    <span style="font-size: 14px">3.3 Kualitas Hasil Penelitian</span><br>
                </td>
                <td align="center">20%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_3}}</td>
            </tr>
            <tr>
                <td align="center">4</td>
                <td><b>Penguasan Materi</b><br>
                    <span style="font-size: 14px">4.1 Pemahaman Konsep</span><br>
                    <span style="font-size: 12px">(Konsep Teori Riset, dan Materi yang relevan)</span><br>
                    <span style="font-size: 14px">4.2 Kemampuan Teknis</span><br>
                    <span style="font-size: 12px">(Pengoperasian OS dan Running Program)</span><br>
                </td>
                <td align="center">30%</td>
                <td align="center">15 - 30</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_4}}</td>
            </tr>
            <tr>
                <td align="center">5</td>
                <td><b>Penguasaan Program/Aplikasi</b><br>
                    <span style="font-size: 14px">(Penggunaan Data, Fungsi/Procedure, dll)</span><br>
                </td>
                <td align="center">25%</td>
                <td align="center">15 - 25</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_5}}</td>
            </tr>
            <tr>
                <td align="center" colspan="2" style="font-weight: bold">TOTAL NILAI</td>
                <td align="center" style="font-weight: bold">100%</td>
                <td align="center" style="font-weight: bold">71 - 100</td>
                <td align="center" style="font-weight: bold">
{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_I_id, $reg_id)->nilai_5}}
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="legalitor">
        Makassar, {{Illuminate\Support\Carbon::parse(substr($data_dosen_selesai->created_at,0,10))->formatLocalized("%d %B %Y")}}
        <br>
        <b>Pembimbing Ketua</b>
    </div>
    <br><br><br><br>
    <div class="legalitor">
        {{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_pembimbing->pembimbing_I_id)->first()->NAMA_DOSEN}}
        <b><u></u></b><br>
        <b>NIDN : {{$data_dosen_pembimbing->pembimbing_I_id}}<br>
    </div>
    <br><br>
    <div>

        <table border="1" width="320px" cellpadding="1" cellspacing="0">
            <tr align="center">
                <th width="100px">Nilai Angka</th>
                <th width="100px">Nilai Mutu</th>
                <th width="120px">Nilai Konversi</th>
            </tr>
            <tr align="center">
                <td> > 85</td>
                <td>A</td>
                <td>4.00</td>
            </tr>
            <tr align="center">
                <td>81 - 85</td>
                <td>A-</td>
                <td>3.75</td>
            </tr>
            <tr align="center">
                <td>76 - 80</td>
                <td>B+</td>
                <td>3.50</td>
            </tr>
            <tr align="center">
                <td>71 - 85</td>
                <td>B</td>
                <td>3.00</td>
            </tr>
        </table>
        <span style="font-size: 12px"><i>Sumber: Peraturan No. 1 Tahun 2014 UMI Tentang Ketentuan Pokok Akademik Pasal
                43 Predikat Kelulusan</i></span>
    </div>
    <br><br>
    <br><br>
    {{-- Enam --}}
    <div class="header" style="page-break-before: always">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" style="position:absolute; left: 80px " />
        <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
        <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
        <h4 class="textheader">Fakultas Hukum</h4><br>
        <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
    </div>
    <h6 class="headerAddress"> Alamat : Jalan Urip Sumoharjo Km. 05
        gedung Fakultas Hukum Lt.1 Kampus II UMI Tlp (0411)453009 Makassar 90231
    </h6>
    <span style="border: solid 0.5px; width: 100%; display: flex"></span>
    <span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
    <div class="title">
        <u>
            <h4><b>LEMBAR PENILAIAN UJIAN UJIAN TUTUP TUGAS AKHIR</b></h4>
        </u>
    </div>
    <div>
        <table>
            <tr>
                <td style="padding-right: 100px;">STAMBUK</td>
                <td style="padding-right: 10px">:</td>
                <td colspan="2">{{ucwords($nim)}}</td>
            </tr>
            <tr>
                <td>NAMA MAHASISWA</td>
                <td>:</td>
                <td style="" colspan="2">
                    {{ucwords(strtolower(\App\Model\t_mst_mahasiswa::where("C_NPM", $nim)->first()->NAMA_MAHASISWA))}}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">JUDUL SKRIPSI</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top;" colspan="2">{{$trt_bimbingan->judul}}</td>
            </tr>
        </table>
    </div>
    <br>
    <br>
    <div style="position: relative">
        <table style=" margin: 0 auto" border="1" width="550px" cellpadding="4" cellspacing="0">
            <tr>
                <th width="10px">NO.</th>
                <th>ASPEK PENILAIAN</th>
                <th>BOBOT</th>
                <th width="60px">RANGE NILAI</th>
                <th>NILAI</th>
            </tr>
            <tr>
                <td align="center">1</td>
                <td><b>Sikap/Presentasi</b><br>
                    <span style="font-size: 14px">1.1 Penguasaan isi proposal</span><br>
                    <span style="font-size: 14px">1.2 Kemampuan berargumentasi</span><br>
                    <span style="font-size: 14px">1.3 Percaya diri dalam menyampaikan</span><br>
                    <span style="font-size: 14px">1.4 Penguasaan isi proposal</span><br>
                </td>
                <td align="center">10%</td>
                <td align="center">6 - 10</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_1}}</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td><b>Sistematika Penelitian</b><br>
                    <span style="font-size: 14px">2.1 Kelengkapan/Kesesuaian Penulisan</span><br>
                    <span style="font-size: 14px">2.2 Format Penulisan</span><br>
                </td>
                <td align="center">15%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_2}}</td>
            </tr>
            <tr>
                <td align="center">3</td>
                <td><b>Hasil Penelitian</b><br>
                    <span style="font-size: 14px">3.1 Kesesuaian dengan Tujuan</span><br>
                    <span style="font-size: 14px">3.2 Penyajian Hasil Penelitian</span><br>
                    <span style="font-size: 14px">3.3 Kualitas Hasil Penelitian</span><br>
                </td>
                <td align="center">20%</td>
                <td align="center">15 - 20</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_3}}</td>
            </tr>
            <tr>
                <td align="center">4</td>
                <td><b>Penguasan Materi</b><br>
                    <span style="font-size: 14px">4.1 Pemahaman Konsep</span><br>
                    <span style="font-size: 12px">(Konsep Teori Riset, dan Materi yang relevan)</span><br>
                    <span style="font-size: 14px">4.2 Kemampuan Teknis</span><br>
                    <span style="font-size: 12px">(Pengoperasian OS dan Running Program)</span><br>
                </td>
                <td align="center">30%</td>
                <td align="center">15 - 30</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_4}}</td>
            </tr>
            <tr>
                <td align="center">5</td>
                <td><b>Penguasaan Program/Aplikasi</b><br>
                    <span style="font-size: 14px">(Penggunaan Data, Fungsi/Procedure, dll)</span><br>
                </td>
                <td align="center">25%</td>
                <td align="center">15 - 25</td>
                <td align="center">{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_5}}</td>
            </tr>
            <tr>
                <td align="center" colspan="2" style="font-weight: bold">TOTAL NILAI</td>
                <td align="center" style="font-weight: bold">100%</td>
                <td align="center" style="font-weight: bold">71 - 100</td>
                <td align="center" style="font-weight: bold">
{{helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_1 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_2 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_3 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_4 + helper::getNilaiKetuaSidangByDosen($data_dosen_pembimbing->pembimbing_II_id, $reg_id)->nilai_5}}
                </td>
            </tr>
        </table>
    </div>
    <br>
    <div class="legalitor">
        Makassar, {{Illuminate\Support\Carbon::parse(substr($data_dosen_selesai->created_at,0,10))->formatLocalized("%d %B %Y")}}
        <br>
        <b>Pembimbig Pendamping</b>
    </div>
    <br><br><br><br>
    <div class="legalitor">
        {{\App\Dosen::where("C_KODE_DOSEN",$data_dosen_pembimbing->pembimbing_II_id)->first()->NAMA_DOSEN}}
        <b><u></u></b><br>
        <b>NIDN : {{$data_dosen_pembimbing->pembimbing_II_id}}<br>
    </div>
    <br><br>
    <div>

        <table border="1" width="320px" cellpadding="1" cellspacing="0">
            <tr align="center">
                <th width="100px">Nilai Angka</th>
                <th width="100px">Nilai Mutu</th>
                <th width="120px">Nilai Konversi</th>
            </tr>
            <tr align="center">
                <td> > 85</td>
                <td>A</td>
                <td>4.00</td>
            </tr>
            <tr align="center">
                <td>81 - 85</td>
                <td>A-</td>
                <td>3.75</td>
            </tr>
            <tr align="center">
                <td>76 - 80</td>
                <td>B+</td>
                <td>3.50</td>
            </tr>
            <tr align="center">
                <td>71 - 85</td>
                <td>B</td>
                <td>3.00</td>
            </tr>
        </table>
        <span style="font-size: 12px"><i>Sumber: Peraturan No. 1 Tahun 2014 UMI Tentang Ketentuan Pokok Akademik Pasal
                43 Predikat Kelulusan</i></span>
    </div>
    <br><br>
    <br><br>
</body>

</html>
