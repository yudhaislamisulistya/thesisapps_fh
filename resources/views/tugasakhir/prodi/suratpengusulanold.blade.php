<!DOCTYPE html>
<html>
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
<div class="header">
    <img src="{{asset('umi.png')}}" alt="Logo Institusi" style="position:absolute; left: 80px "/>
    <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
    <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
    <h4 class="textheader">Fakultas Ilmu Komputer</h4><br>
    <h4 class="textheader">Program Studi {{helper::getProgramStudiByNim($nim)}}</h4><br>
</div>
<span style="border: solid 0.5px; width: 100%; display: flex"></span>
<span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
<h6 class="headerAddress" style="text-align: center"> Jln. Urip Sumohardjo Km.05 Gedung Fakultas Ilmu Komputer Lt.I Kampus II UMI Tlp.(0411) 449775-453308-453818, Fax (0411) - 453009 Makassar 90231
website: fikom.umi.ac.id, email:S1.teknik.informatika@umi.ac.id
</h6>
<div class="title">
    <i><h4 style="display: inline;font-weight: 200">Bismillahir Rahmanir Rahiim</h4></i><br><br>
</div>
        <br>
        <div>

            <table>
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td>{{$datask[0]->nomor}}</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>1 Lembar</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>:</td>
                    <td>{{$datask[0]->perihal}}</td>
                </tr>
            </table>
        </div>
        <br>
        <p align="justify">
        Kpd. Yth.,<br>
        <b>Bapak Dekan Fakultas Ilmu Komputer</b><br>
        Di, - <br>
        Makassar <br><br>
        Assalamualaikum Wr. Wb.<br>
        Dengan Rahmat Allah S.W.T, Saya yang bertanda tangan dibawah ini sesuai peraturan Akademik Universitas Muslim Indonesia
        tentang penyesuain Tugas Akhir Mahasiswa, Ketua Program Studi Teknik Informatika mengusulkan Calon Pembimbing Tugas Akhir.
        <br><br>
        Menunjuk saudara yang tercantum namanya untuk membimbing atau membina mahasiswa dalam penyusunan tugas akhir atas nama
        mahasiswa yang namanya terlampir dalam lampiran surat penunjukan.
        <br><br>
        Demikian surat penunjukan ini diuusulkan untuk dibuatkan surat penugasan kepada yang bersangkutan untuk dilaksanakan
        dengan penuh rasa amanah.
        <br><br>
        </p>
        <div class="legalitor">
            Makassar, {{$datask[0]->tgl_surat}}
        </div>
        <br><br><br><br><br>
        <div class="legalitor">
            Tasrif Hasanuddin, S.T., M.Cs
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <h4>Lampiran Surat Penunjukan </h4>
    <table border="1" style="border-collapse: collapse;">
        <tr>
            <th>No</th>
            <th>Stambuk/ Nama Mahasiswa</th>
            <th>Pembimbing Utama</th>
            <th>Pembimbing Pendamping</th>
            <th>Judul Penelitian</th>
        </tr>
        @foreach($datax as $key => $value)
        <tr>
            <td>{{++$key}}</td>
            <td>{{$value->C_NPM}} / {{helper::getNamaMhs($value->C_NPM)}} </td>
            <td>{{helper::getDeskripsi($value->pembimbing_I_id)}}</td>
            <td>{{helper::getDeskripsi($value->pembimbing_II_id)}}</td>
            <td>{{$value->judul}}</td>
        </tr>
        @endforeach
    </table>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </body>
</html>
