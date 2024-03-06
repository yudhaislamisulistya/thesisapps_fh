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
    <h4 class="textheader">Fakultas Ilmu Hukum</h4>
</div>
<span style="border: solid 0.5px; width: 100%; display: flex"></span>
<span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
<h6 class="headerAddress" style="text-align: center"> Jln. Urip Sumohardjo Km.05 Gedung Fakultas Ilmu Hukum Lt.I Kampus II UMI Tlp.(0411) 449775-453308-453818, Fax (0411) - 453009 Makassar 90231
website: fh.umi.ac.id, email:S1.ilmu.hukum@umi.ac.id
</h6>

    <h5 style="text-align: center"><i>Bismillahir Rahmanir Rahiim</i></h5>
    
    <div class="title">
        <u><h4><b>LEMBAR PENILAIAN <br>UJIAN {{strtoupper($tipe_ujian)}} TUGAS AKHIR</b></h4></u>
    </div>
    <div>
        <table>
            <tr>
                <td style="padding-right: 100px;">STAMBUK</td>
                <td style="padding-right: 10px">:</td>
                <td colspan="2">{{ucwords($nim)}}</td>
            </tr>
            <tr>
                <td >NAMA MAHASISWA</td>
                <td >:</td>
                <td style="" colspan="2">
                    {{ucwords(strtolower(\App\Model\t_mst_mahasiswa::where("C_NPM", $nim)->first()->NAMA_MAHASISWA))}}</td>
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
                <span style="font-size: 14px">1.1	 Penguasaan isi skripsi</span><br>
                <span style="font-size: 14px">1.2	 Kemampuan berargumentasi</span><br>
                <span style="font-size: 14px">1.3	 Percaya diri dalam menyampaikan</span><br>
                <span style="font-size: 14px">1.4	 Penguasaan isi skripsi</span><br>
                </td>
                <td align="center">10%</td>
                <td align="center">6 - 10</td>
                <td align="center">{{$data_hasil[0]->nilai_1}}</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td><b>Sistematika Penelitian</b><br> 
                <span style="font-size: 14px">2.1 Kelengkapan/Kesesuaian Penulisan</span><br>
                <span style="font-size: 14px">2.2 Format Penulisan</span><br>
                </td>
                <td align="center">15%</td>
                <td align="center">10 - 15</td>
                <td align="center">{{$data_hasil[0]->nilai_2}}</td>
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
                <td align="center">{{$data_hasil[0]->nilai_3}}</td>
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
                <td align="center">20 - 30</td>
                <td align="center">{{$data_hasil[0]->nilai_4}}</td>
            </tr>
            <tr>
                <td align="center">5</td>
                <td><b>Penguasaan Program/Aplikasi</b><br> 
                <span style="font-size: 14px">(Penggunaan Data, Fungsi/Procedure, dll)</span><br>
                </td>
                <td align="center">25%</td>
                <td align="center">20 - 25</td>
                <td align="center">{{$data_hasil[0]->nilai_4}}</td>
            </tr>
            <tr>
                <td align="center" colspan="2" style="font-weight: bold">TOTAL NILAI</td>
                <td align="center" style="font-weight: bold">100%</td>
                <td align="center" style="font-weight: bold">71 - 100</td>
                <td align="center" style="font-weight: bold">{{($data_hasil[0]->nilai_5) + ($data_hasil[0]->nilai_4) + ($data_hasil[0]->nilai_3) + ($data_hasil[0]->nilai_2) + ($data_hasil[0]->nilai_1)}}</td>
            </tr>
        </table>
    </div>
    <br>
    <div class="legalitor">
        Makassar, {{$tgl_ujian}}
        <br>
            <b>{{$status_dosen}}</b>
    </div>
    <br><br><br><br>
    <br>
    <div class="legalitor">
        <b><u>{{\App\Dosen::where("C_KODE_DOSEN",$data_hasil[0]->nidn)->first()->NAMA_DOSEN}}</u></b><br>
        <b>NIDN : {{$data_hasil[0]->nidn}}</b><br>
    </div>
    <br><br>
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
                <td>71 - 75</td>
                <td>B</td>
                <td>3.00</td>
            </tr>
        </table>
            <span style="font-size: 12px"><i>Sumber: Peraturan No. 1 Tahun 2014 UMI Tentang Ketentuan Pokok Akademik Pasal 43 Predikat Kelulusan</i></span>
    </div>
    <br><br>
    <br><br>
</body>

</html>
