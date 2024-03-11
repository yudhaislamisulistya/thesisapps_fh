<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Print SK Pembimbing - {{$mahasiswa->nama}} - {{$mahasiswa->nim}}</title>
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
            <h5 class="textheader">Yayasan Wakaf UMI</h5><br>
            <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
            <h4 class="textheader">Fakultas Hukum</h4><br>
            <h3 class="textheader">Program Studi Ilmu Hukum</h3>
        </div>
        <hr>
        <div class="title">
            <h3 class="headingTitle"><u>SURAT PENUNJUKAN</u></h3><br>
            <h4 class="headingTitle">No. 0001/H.22/FIK-UMI/I/2019</h4>
        </div>
        <br>
        Dengan Rahmat Allah S.W.T, Sesuai Dengan Surat Ketua Program Studi Ilmu Hukum Nomor. 001/H.22/TI-FIK/UMI/I/2019
        Tentang Tugas Akhir Mahasiswa, Maka :
        <br>
        <p align="center">DEKAN Fakultas Hukum</p>
        <br>
        Menununjuk Saudara :
        <br>
        <table cellpadding="10" border="1" style="border-collapse: collapse;">
            <tr>
                <th>Nama</th>
                <th>Pangkat / Golongan</th>
                <th>Keterangan</th>
            </tr>
            <tr>
                <th>{{$pembimbing_1->nama}}</th>
                <th>{{$pembimbing_1->pangkat}} / {{$pembimbing_1->golongan}}</th>
                <th>Pembimbing Utama</th>
            </tr>
            <tr>
                <th>{{$pembimbing_2->nama}}</th>
                <th>{{$pembimbing_2->pangkat}} / {{$pembimbing_2->golongan}}</th>
                <th>Pembimbing Pendamping</th>
            </tr>
        </table>
        <br>
        Sebagai Pembimbing Untuk Tugas Akhir Mahasiswa<br>
        <table cellpadding="10">
            <tr>
                <td>Nama / Stambuk</td>
                <td>{{$mahasiswa->nama}} / {{$mahasiswa->nim}}</td>
            </tr>
            <tr>
                <td>Topik Penelitian</td>
                <td>{{$mahasiswa->topik}}</td>
            </tr>
        </table>
        <br>
        Demikian Surat Penunjukan Ini Disampaikan Kepada Yang Bersangkutan Untuk Dilaksanakan Dengan Penuh Tanggungjawab
        <br>
        <br>
        <div class="legalitor">
            Makassar, <?=date('d F Y');?>
        </div>
    </body>
</html>
