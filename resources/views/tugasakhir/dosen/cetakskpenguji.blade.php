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
                display:inline;
                float:left;
            }
            .header {
                text-align:center;
                margin-top : 10px;
            }
            .textheader {
                display:inline;
                margin-top : 100px;
                text-align: center;
            }
            .headerAddress {
                display : inline-block;
                margin-bottom: 0px;
                margin-top: 0px;
                text-align: left;
            }
            .headingTitle {
                display:inline;
            }
            .title{
                text-align: center;
            }
            .legalitor {
                float:right;
            }
            .button{
                background-color: #4CAF50; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
                position:relative;
            }
        </style>
        <script>
            function prints() {
              
                document.getElementById('btnPrint').style.display = "none";
                window.print();
                window.onafterprint = show();
            }
            function back() {
                window.location = ;
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
        <div class="header">
            <img src="{{asset('umi.png')}}" alt="Logo Institusi"/>
            <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
            <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
            <h4 class="textheader">Fakultas Ilmu Komputer</h4><br>
            <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
        </div>
        <h6 class="headerAddress"> Alamat : Jalan Urip Sumoharjo Km. 05
            gedung Fakultas Ilmu Komputer Lt.1 Kampus II UMI Tlp (0411)453009 Makassar 90231
        </h6>
        <hr>
        <div class="title">
            <h4 class="headingTitle">Bismillahirrahmaanirrahiim</h4><br><br>
        </div>

        <div class="title">
            <u><h4 class="headingTitle">SURAT PENUNJUKAN</h4></u><br>
            <h4 class="headingTitle">Nomor : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/H.22/TI/FIK-UMI/V/2019</h4></u>
        </div>
        <br>
        <p align="justify">
        Sesuai Peraturan akademik pada Program Studi {{helper::getProgramStudiByNim($nim)}} Fakultas Ilmu Komputer Universitas Muslim Indonesia dengan ini menetapkan tim penguji atau penanggap pada ujian {{strtolower($tipe_ujian)}}, maka
        </p>
        <b><center>KETUA PROGRAM STUDI {{strtoupper(helper::getProgramStudiByNim($nim))}}</center></b>
        <p>
        Menetapkan Tim Penguji Ujian Proposal  sebagai berikut :
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
        <br>
        <div>
            <table>
                <tr>
                    <td width="150px">Ketua Sidang</td>
                    <td>:</td>
                    <td>{{\App\Dosen::where("C_KODE_DOSEN",$penguji->ketua_sidang_id)->first()->NAMA_DOSEN}}</td>
                </tr>
            </table>
        </div>
        <br>
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
                <tr>
                    <td>Hari / Tanggal</td>
                    <td>:</td>
                    <td>{{$tgl_ujian}}</td>
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
        <br>
        <p align="justify">
        Demikian surat penunjukan ini diberikan untuk dilaksanakan dengan penuh tanggung jawab dan amanah. Waalahu Waliyyut Taufiq wal-Hidayah
        </p>

        <div class="legalitor">
            Makassar, {{$tgl_sekarang}}
            <br>
            Ketua Program Studi
        </div>
        <br><br><br><br>
        <div class="legalitor">
            @if (helper::getProgramStudiByNim($nim) == "Teknik Informatika")
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
