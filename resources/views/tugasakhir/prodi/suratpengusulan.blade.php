<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print Surat Pengusulan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            height: 842px;
            width: 595px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
        }

        .header img {
            width: 75px;
            display: inline;
            float: left;
        }

        .header {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
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
            text-align: center;
        }

        .headingTitle {
            display: inline;
        }

        .title {
            text-align: center;
            margin-top: 20px;
        }

        .legalitor {
            float: right;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        table td {
            padding: 5px;
        }

        .table-bordered {
            border-collapse: collapse;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        .signature {
            margin-top: 40px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
        }

        .footer .signature {
            margin-top: 60px;
            position: relative;
        }

        .button {
            background-color: #4CAF50;
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

<button id="btnPrint" onclick="prints()" class="button">Print</button>

<body>
    <div class="header">
        <img src="{{ asset('umi.png') }}" alt="Logo Institusi" />
        <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
        <h4 class="textheader">Universitas Muslim Indonesia</h4><br>

        <h4 class="textheader">Fakultas Hukum</h4><br>
        <h4 class="textheader">Program Studi Ilmu Hukum</h4>

    </div>
    <h6 class="headerAddress"> Alamat : Jalan Urip Sumoharjo Km. 05
        gedung Fakultas Hukum Lt.1 Kampus II UMI Tlp (0411)453009 Makassar 90231
    </h6>
    <hr>
    <div class="title">
        <h4>Bismillahirrahmaanirrahiim</h4>
    </div>
    <br>
    <table>
        <tr>
            <td style="vertical-align: top; width: 80px;">Perihal</td>
            <td style="vertical-align: top; width: 10px;">:</td>
            <td style="vertical-align: top;">
                <b>Permohonan Persetujuan Judul Skripsi</b><br><br>
                Kepada Yth :<br>
                Dekan Fakultas Hukum Universitas Muslim Indonesia<br>
                Cq. Ketua Bagian Program Studi Sarjana Ilmu Hukum<br>
                di <br>
                Makassar
            </td>
        </tr>
    </table>
    <br>
    <p>
        Assalamualaikum Wr. Wb.<br>
        Dengan Rahmat Allah S.W.T, Saya yang bertanda tangan dibawah ini
    </p>

    <table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $dataPengajuanTopik[0]->NAMA_MAHASISWA }}</td>
        </tr>
        <tr>
            <td>NIM</td>
            <td>:</td>
            <td>{{ $dataPengajuanTopik[0]->C_NPM }}</td>
        </tr>
        <tr>
            <td>Jurusan/Konsentrasi</td>
            <td>:</td>
            <td>{{ $dataPengajuanTopik[0]->nama }}</td>
        </tr>
        <tr>
            <td>MK Minat yang Telah dilulusi</td>
            <td>:</td>
            <td>
                @php
                    $mk_lulus = explode(';', $dataPengajuanTopik[0]->mk_lulus);

                @endphp

                @foreach ($mk_lulus as $key => $value)
                    {{ $key + 1 }}. {{ $value }}<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Alamat Rumah</td>
            <td>:</td>
            <td>{{ $dataPengajuanTopik[0]->alamat }}</td>
        </tr>
        <tr>
            <td>No. HP/WA</td>
            <td>:</td>
            <td>{{ $dataPengajuanTopik[0]->whatsapp }}</td>
        </tr>
    </table>
    <br>
    <p>Dengan ini, saya mohon kiranya dapat disetujui salah satu rencana judul di bawah ini:</p>
    <table>
        @foreach ($dataPengajuanTopik as $value => $item)
            <tr>
                <td style="width: 10px;">{{ $value + 1 }}.</td>
                <td>
                    {{ $item->topik }}
                    @if ($item->status == 1)
                        <b>(Disetujui)</b>
                    @else
                        <b>(Ditolak)</b>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    <br>
    <p align="justify">
        Demikian permohonan ini saya ajukan, atas persetujuan Bapak/Ibu diucapkan terima kasih.
    </p>
    <div class="legalitor" style="text-align: right;">
        Makassar, ................................................<br>
        Mahasiswa yang Bermohon,
        <br><br><br><br><br>
        (................................................)
    </div>
    <br><br>
    <div class="signature" style="text-align: right;">
        <br><br><br>
        <p style="text-align: justify !important;">
            ......................................................................................................................................<br>Persetujuan
            Pembimbing Pada Bagian Hukum................................................</p>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: left; width: 150px;">Pembimbing Ketua</td>
                <td style="text-align: center; width: 10px;">:</td>
                <td style="text-align: left;">..................................................</td>
                <td style="text-align: right;">(Oleh Ketua Bagian)</td>
            </tr>
            <tr>
                <td style="text-align: left;">Pembimbing Anggota</td>
                <td style="text-align: center;">:</td>
                <td style="text-align: left;">..................................................</td>
                <td style="text-align: right;">(Oleh Ketua Bagian)</td>
            </tr>
        </table>
        <p style="text-align: right;">
            Makassar, ...... / ................ / 20....<br>
            Ketua Bagian ..........................
            <br><br><br><br><br>
            ..........................
        </p>
    </div>
    <div class="footer" style="text-align: right;">
        <hr>
        <p style="text-align: left !important;">Dapat disetujui, dan selanjutnya untuk diproses.</p>
        <p>Makassar, ................................................ 20....</p>
        <p>Wakil Dekan I</p>
        <br><br><br><br>
        <p><strong>Dr. Andika Prawira Buana, SH., MH.</strong></p>
    </div>
</body>

</html>
