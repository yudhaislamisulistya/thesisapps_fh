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
    <div class="header">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" />
        <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
        <h4 class="textheader">Universitas Muslim Indonesia</h4><br>

        <h4 class="textheader">Fakultas Hukum</h4><br>
        @if (auth()->user()->name == "prodifh")
        <h4 class="textheader">Program Studi Ilmu Hukum</h4>
        @else
        <h4 class="textheader">Program Studi Sistem Informasi</h4>
        @endif

    </div>
    <h6 class="headerAddress"> Alamat : Jalan Urip Sumoharjo Km. 05
        gedung Fakultas Hukum Lt.1 Kampus II UMI Tlp (0411)453009 Makassar 90231
    </h6>
    <hr>
    <div class="title">
        <h4 class="headingTitle">Bismillahirrahmaanirrahiim</h4><br>
    </div>
    <br>
    <div>

        <table>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>{{$nomor}}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>
                    @if(count($datax) < 10)
                        1 Lembar
                    @elseif (count($datax) >= 10 && count($datax) <= 20)
                        2 Lembar
                    @elseif(count($datax) > 20 && count($datax) <= 30)
                        3 Lembar
                    @elseif(count($datax) > 30 && count($datax) <= 40)
                        4 Lembar
                    @elseif(count($datax) > 40 && count($datax) <= 50)
                        5 Lembar
                    @elseif(count($datax) > 50 && count($datax) <= 60)
                        6 Lembar
                    @endif
                </td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td>{{$perihal}}</td>
            </tr>
        </table>
    </div>
    <br>
    <p align="justify">
        Kpd. Yth.,<br>
        <b>Bapak Dekan Fakultas Hukum</b><br>
        Di, - <br>
        Makassar <br><br>
        Assalamualaikum Wr. Wb.<br>
        Dengan Rahmat Allah S.W.T, Saya yang bertanda tangan dibawah ini sesuai peraturan Akademik Universitas Muslim
        Indonesia
        tentang penyesuain Tugas Akhir Mahasiswa, Ketua Program Studi Ilmu Hukum mengusulkan Calon Pembimbing
        Tugas Akhir.
        <br><br>
        Menunjuk saudara yang tercantum namanya untuk membimbing atau membina mahasiswa dalam penyusunan tugas akhir
        atas nama
        mahasiswa yang namanya terlampir dalam lampiran surat penunjukan.
        <br><br>
        Demikian surat penunjukan ini diuusulkan untuk dibuatkan surat penugasan kepada yang bersangkutan untuk
        dilaksanakan
        dengan penuh rasa amanah.
        <br><br>
    </p>
    <div class="legalitor">
        Makassar, {{Illuminate\Support\Carbon::parse(substr($datax[0]->created_at,0,10))->formatLocalized("%d %B %Y")}}
    </div>
    <br>
        @if (Auth::user()->name == "prodifh")
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
    <br><br><br><br>
    <div class="legalitor">
        @if (Auth::user()->name == "prodifh")
        Tasrif Hasanuddin, S.T., M.Cs
        @else
        Ir. Herman, S.Kom.,M.Cs., MTA.
        @endif
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br
    <h4>Lampiran Surat Penunjukan No {{$nomor}}</h4>
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
            <td>{{$value->C_NPM}}/ {{$value->NAMA_MAHASISWA}}</td>
            <td>{{helper::getDeskripsi($value->pembimbing_I_id)}}</td>
            <td>{{helper::getDeskripsi($value->pembimbing_II_id)}}</td>
            <td>{{$value->judul}}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>