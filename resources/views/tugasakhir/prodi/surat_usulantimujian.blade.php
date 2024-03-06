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
            window.location = 'http://localhost:8000';
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
    @foreach ($datax as $value_ta)
        <div class="header" style="position: relative">
            <img src="{{ asset('umi.png') }}" alt="Logo Institusi" />
            <h4 class="textheader">Yayasan Wakaf UMI</h4><br>
            <h4 class="textheader">Universitas Muslim Indonesia</h4><br>
            <h4 class="textheader">Fakultas Ilmu Komputer</h4><br>
            <h4 class="textheader">Program Studi Teknik Infromatika</h4><br>
        </div>
        <span style="border: solid 0.5px; width: 100%; display: flex"></span>
        <span style="border: solid 1.5px; width: 99.8%; display: flex; margin-top:2px"></span>
        <h6 class="headerAddress" style="text-align: center"> Jln. Urip Sumohardjo Km.05 Gedung Fakultas Ilmu Komputer
            Lt.I Kampus II UMI Tlp.(0411) 449775-453308-453818, Fax (0411) - 453009 Makassar 90231
            website: fikom.umi.ac.id, email:S1.teknik.informatika@umi.ac.id
        </h6>
        <div class="title">
            <i>
                <h4 style="display: inline;font-weight: 200">Bismillahir Rahmanir Rahiim</h4>
            </i><br><br>
        </div>
        <br>
        <div>

            <table>
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td>{{ $nomor }}</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>:</td>
                    <td>Usulan Tim Ujian Tugas Akhir S. Akhir TA. 2019/2020</td>
                </tr>
            </table>
        </div>
        <br>
        <p align="justify">
            Kpd. Yth.,<br>
            <b>Bapak Dekan Fakultas Ilmu Komputer</b><br>
            Di, - <br>
            Makassar <br><br>
            <b><i>Assalamu’alaikum Warahmatullahi Wabarakatuh</i></b>.<br>
            Dengan Rahmat Allah S.W.T, Sehubungan dengan penyelesaian studi Mahasiswa PRogram Studi Ilmu Hukum
            Fakultas Ilmu Komputer UMI Semester Akhir TA 2019/2020, maka dengan ini kami mengusulkan nama-nama tim Ujian
            Tugas Akhir untuk dibuatkan SK penunjukan dengan susunan sebagai berikut:
        </p>
        <center>
            <table border="1" style="border-collapse: collapse;">
                <tr>
                    <th>No</th>
                    <th width="50px">Stambuk/ Nama Mahasiswa</th>
                    <th width="100px">Judul Tugas Akhir</th>
                    <th>Tim Penguji</th>
                    <th width="100px">Waktu & Tempat</th>
                </tr>

                @foreach (helper::getDataSuratUsulanTa($value_ta->pendaftaran_id) as $key => $value)
                    <tr>

                        <td style="font-size: 12px">{{ ++$key }}</td>
                        <td style="font-size: 12px">{{ $value->NAMA_MAHASISWA }} / {{ $value->C_NPM }}</td>
                        <td style="font-size: 12px">{{ $value->judul }}</td>
                        @php
                            $pembimbing1 = \App\Dosen::where('C_KODE_DOSEN', $value->pembimbing_I_id)->first();
                            $pembimbing2 = \App\Dosen::where('C_KODE_DOSEN', $value->pembimbing_II_id)->first();
                            $penguji1 = \App\Dosen::where('C_KODE_DOSEN', $value->penguji_I_id)->first();
                            $penguji2 = \App\Dosen::where('C_KODE_DOSEN', $value->penguji_II_id)->first();
                            $penguji3 = \App\Dosen::where('C_KODE_DOSEN', $value->penguji_III_id)->first();
                            $ketua_sidang = \App\Dosen::where('C_KODE_DOSEN', $value->ketua_sidang_id)->first();
                        @endphp
                        <td style="font-size: 12px">
                            Ketua Sidang : {{ $ketua_sidang->NAMA_DOSEN }}<br>
                            <hr color="black">
                            Pembimbing Utama : {{ $pembimbing1->NAMA_DOSEN }}<br>
                            <hr color="black">
                            Pembimbing Pendamping : {{ $pembimbing2->NAMA_DOSEN }}<br>
                            <hr color="black">
                            Penguji I : {{ $penguji1->NAMA_DOSEN }}<br>
                            <hr color="black">
                            Penguji II : {{ $penguji2->NAMA_DOSEN }}<br>
                            <hr color="black">
                            Penguji III : {{ $penguji3->NAMA_DOSEN }}<br>
                        </td>
                        <td style="text-align: center; font-size: 12px">
                            {{-- @php
                        $count_jam_ujian = strlen($data_sk[0]->jam_ujian);
                        if($count_jam_ujian == 5){
                            $waktu = $data_sk[0]->jam_ujian. "-" . sprintf('%02d', substr($data_sk[0]->jam_ujian, 0, 2) + 2) . ":30";
                        }else{
                            $waktu = $data_sk[0]->jam_ujian;
                        }
                    @endphp --}}
                            {{ Illuminate\Support\Carbon::parse($value->tgl_ujian)->formatLocalized('%A, %d %B %Y') }}
                            <br>
                            {{ $value->jam_ujian }}
                            {{-- {{$waktu}} <br> --}}
                            {{ $value->nama_ruangan }} <br>
                            Prodi FIK
                        </td>
                    </tr>
                @endforeach
            </table>
        </center>
        <p align="justify">
            Demikian Surat Pengusulan ini untuk dibuatkan surat penugasan kepada yang bersangkutan untuk dilaksanakan
            dengan penuh rasa amanah.<br>
            <b><i>Wallahu Waliyut Taufik Walhidayah</i></b><br>
            <b><i>Wa’alaikumussalam Warahmatullahi Wabarakatuh</i></b><br>
        </p>
        <br><br>
        <div class="legalitor">
            Makassar, {{ $tgl_ujian }}
        </div>
        <br>
        @if (Auth::user()->name == 'prodifh')
            <div style="text-align: center; position: relative">
                <img src="{{ asset('gambar/stempelprodi.png') }}" alt="" height="100px"
                    style="position: absolute; right: 140px">
                <br>
                <img src="{{ asset('gambar/ttd_kaprodi.png') }}" alt="" height="70px"
                    style="position: absolute; right: 90px">
            </div>
        @else
            <div style="text-align: center; position: relative">
                <img src="{{ asset('gambar/stempelprodi_si.png') }}" alt="" height="100px"
                    style="position: absolute; right: 140px">
                <br>
                <img src="{{ asset('gambar/ttd_kaprodi_si.png') }}" alt="" height="120px"
                    style="position: absolute; right: 20px; top: -10px">
            </div>
        @endif
        <br><br><br><br>
        <div class="legalitor">
            @if (Auth::user()->name == 'prodifh')
                <b><u>Tasrif Hasanuddin, S.T., M.Cs</u></b><br>
                <b>NIDN : 0910126901</b>
            @else
                <b><u>Ir. Herman, S.Kom.,M.Cs., MTA.</u></b><br>
                <b>NIDN : 0913038506</b>
            @endif
        </div>
    @endforeach
</body>

</html>
