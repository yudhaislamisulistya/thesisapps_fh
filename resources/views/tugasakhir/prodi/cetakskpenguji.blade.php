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
<div class="header" style="position: relative">
    <img src="{{asset('umi.png')}}" alt="Logo Institusi"/>
    <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
    <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
    <h4 class="textheader">Fakultas Ilmu Hukum</h4><br>
    <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
</div>
<span style="border: solid 0.5px; width: 100%; display: flex"></span>
<span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
<h6 class="headerAddress" style="text-align: center"> Jln. Urip Sumohardjo Km.05 Gedung Fakultas Ilmu Hukum Lt.I Kampus II UMI Tlp.(0411) 449775-453308-453818, Fax (0411) - 453009 Makassar 90231
website: fh.umi.ac.id, email:S1.ilmu.hukum@umi.ac.id
</h6>
<div class="title">
    <i><h4 style="display: inline;font-weight: 200">Bismillahir Rahmanir Rahiim</h4></i><br><br>
</div>

    <div class="title">
        <u>
            <h4 class="headingTitle">SURAT PENUNJUKAN</h4>
        </u><br>
        <h4 class="headingTitle">Nomor : {{helper::getNomorSkPerMhsFromTrtPenguji($nim)}}</h4></u>
    </div>
    <br>
    <p align="justify">
        Sesuai Peraturan akademik pada Program Studi {{helper::getProgramStudiByNim($nim)}} Fakultas Ilmu Hukum
        Universitas Muslim Indonesia dengan ini menetapkan tim penguji atau penanggap pada ujian
        {{strtolower($tipe_ujian)}}, maka
    </p>
    <b>
        <center>KETUA PROGRAM STUDI {{strtoupper(helper::getProgramStudiByNim($nim))}}</center>
    </b>
    <p>
        Menetapkan Tim Penguji Ujian {{$tipe_ujian}} sebagai berikut :
    </p>
    <div>
        <table>
            <tr>
                <td width="150px">Pembimbing Utama</td>
                <td>:</td>
                <td>{{\App\Dosen::where("C_KODE_DOSEN",$bimbingan->pembimbing_I_id)->first()->NAMA_DOSEN}}</td>
            </tr>
            <tr>
                <td>Pembimbing Pendamping</td>
                <td>:</td>
                <td>{{\App\Dosen::where("C_KODE_DOSEN",$bimbingan->pembimbing_II_id)->first()->NAMA_DOSEN}}</td>
            </tr>
        </table>
    </div>
    <div>
        <table>
            <tr>
                <td width="150px">Ketua Sidang</td>
                <td>:</td>
                <td>{{\App\Dosen::where("C_KODE_DOSEN",$penguji->ketua_sidang_id)->first()->NAMA_DOSEN}}</td>
            </tr>
        </table>
    </div>
    <div>
        <table>
            <tr>
                <td width="150px">Penguji</td>
                <td>:</td>
                <td>1. {{\App\Dosen::where("C_KODE_DOSEN",$penguji->penguji_I_id)->first()->NAMA_DOSEN}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>2. {{\App\Dosen::where("C_KODE_DOSEN",$penguji->penguji_II_id)->first()->NAMA_DOSEN}}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>3. {{\App\Dosen::where("C_KODE_DOSEN",$penguji->penguji_III_id)->first()->NAMA_DOSEN}}</td>
            </tr>
        </table>
    </div>
    <p align="justify">
        Bertugas melaksanakan ujian {{strtolower($tipe_ujian)}} bagi mahasiswa
    </p>
    <div align="center">
        <table border="1" width="550px" cellpadding="4" cellspacing="0">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Stambuk</th>
            </tr>
            <tr>
                <td style="text-align: center">1</td>
                <td>{{\App\Model\t_mst_mahasiswa::where("C_NPM",$nim)->first()->NAMA_MAHASISWA}}</td>
                <td style="text-align: center">{{$nim}}</td>
            </tr>
        </table>
    </div>
    <br>

    <div>
        <table>
            <tr>
                <td width="150px">Judul</td>
                <td>:</td>
                <td><b>{{$bimbingan->judul}}</b></td>
            </tr>
        </table>
    </div>
    <br>
    <div align="center">
        <table border="0" width="550px">
            @php
                $fix_tgl_ujian = explode(",", $tgl_ujian);
            @endphp
            <tr>
                <td>Hari / Tanggal</td>
                <td>:</td>
                <td>{{helper::getHari($tgl_ujian)}}, {{$tanggal}} {{helper::getBulan($bulan)}} {{$tahun}}</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>:</td>
                <td>{{$waktu}}</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>:</td>
                <td>{{$ruangan}}</td>
            </tr>
        </table>
    </div>
    <p align="justify">
        Demikian surat penunjukan ini diberikan untuk dilaksanakan dengan penuh tanggung jawab dan amanah. Waalahu
        Waliyyut Taufiq wal-Hidayah
    </p>

    <div class="legalitor">
        Makassar, {{Illuminate\Support\Carbon::parse(substr($penguji->created_at,0,10))->formatLocalized("%d %B %Y")}}
        <br>
        Ketua Program Studi
    </div>
    <br>
    @if (helper::getProgramStudiByNim($nim) == "Ilmu Hukum")
        <div style="text-align: center; position: relative">
            <img src="{{asset('gambar/stempelprodi.png')}}" alt="" height="100px" style="position: absolute; right: 140px">
            <br>
            <img src="{{asset('gambar/ttd_kaprodi.png')}}" alt="" height="70px" style="position: absolute; right: 90px">
        </div>
    @else
        <div style="text-align: center; position: relative">
            <img src="{{asset('gambar/stempelprodi_si.png')}}" alt="" height="100px" style="position: absolute; right: 140px">
            <br>
            <img src="{{asset('gambar/ttd_kaprodi_si.png')}}" alt="" height="120px" style="position: absolute; right: 20px; top: -10px">
        </div>
    @endif
    <br><br><br>
    <div class="legalitor">
        @if (helper::getProgramStudiByNim($nim) == "Ilmu Hukum")
        <b><u>Tasrif Hasanuddin, S.T., M.Cs.</u></b><br>
        <b>NIDN : 0910126901</b><br>
        @else
        <b><u>Ir. Herman, S.Kom.,M.Cs., MTA.</u></b><br>
        <b>NIDN : 0913038506</b><br>
        @endif
    </div>
    <br><br><br><br>
</body>

</html>