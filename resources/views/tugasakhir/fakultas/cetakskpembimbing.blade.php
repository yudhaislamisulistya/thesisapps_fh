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
            document.getElementById('btnPrint').style.display = "inline";
        }
    </script>
</head>
<button id="btnPrint" onclick="prints()" class="button">Print</button>

<body>
    <div class="header">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" />
        <h3 class="textheader">Yayasan Wakaf UMI</h4><br>
            <h3 class="textheader">Universitas Muslim Indonesia</h4><br>
                <h3 class="textheader">Fakultas Hukum</h4><br>
    </div>
    <hr>
    <h6 class="headerAddress" style="text-align: center"> Jln. UripSumohardjo Km.05 GedungFakultasIlmuKomputerLt.1. Kampus II UMI Tlp.(0411) 449775-453308-453818, Fax (0411) - 453009 Makassar 90231
website: fh.umi.ac.id, email: fikom@umi.ac.id
    </h6>
    <br>
    <br>
    <div class="title">
        <i>
            <h4 class="headingTitle">Bismillahirrahmaanirrahiim</h4>
        </i><br><br>
    </div>

    <div class="title">
        <u>
            <h4 class="headingTitle">SURAT PENUNJUKAN</h4>
        </u><br>
        @foreach($data_sk as $key => $value)
        <h4 class="headingTitle">Nomor : {{$value->nomor_sk}} </h4></u>
        @endforeach
    </div>
    <br>
    <p align="justify">
        Dengan rahmat Allah SWT, sesuai dengan surat ketua Program Studi
        {{helper::getProgramStudiByNim(auth()->user()->name)}} nomor : <b>{{helper::getNomorSKWithBimbinganId($data_sk[0]->bimbingan_id)}}</b>
        tentang tugas akhir mahasiswa maka :
    </p>
    <center>DEKAN Fakultas Hukum</center>
    <p>
        Menunjuk Saudara :
    </p>
    <div>

        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <b>
                        @foreach($data_sk as $key => $value)
                        {{isset($value->pembimbing_I_id) ? helper::getDeskripsi($value->pembimbing_I_id) :'' }}
                        @endforeach
                    </b>
                </td>
            </tr>
            <tr>
                <td>Pangkat/Gol.</td>
                <td>:</td>
                <td>
                    <b>
                        @foreach($data_sk as $key => $value)
                        {{isset($value->pembimbing_I_id) ? helper::getJabatanFungsionalByNIDN($value->pembimbing_I_id) :'' }}
                        @endforeach
                    </b>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <p align="justify">
        Sebagai Pembimbing Utama untuk Tugas Akhir Mahasiswa :
    </p>
    <div>
        <table>
            <tr>
                <td>Nama / Stambuk</td>
                <td>:</td>
                <td>
                    <b>
                        @foreach($data_sk as $key => $value)
                        {{isset($value->C_NPM) ? helper::getNamaMhs($value->C_NPM) :'' }} / {{$value->C_NPM}}
                        @endforeach
                    </b>
                </td>
            </tr>
            <tr>
                <td>Topik Penelitian</td>
                <td>:</td>
                <td>
                    <b>
                        @foreach($data_sk as $key => $value)
                        {{$value->judul}}
                        @endforeach
                    </b>
                </td>
            </tr>
        </table>
    </div>
    <p align="justify">
        Demikian surat penunjukan ini disampaikan kepada yang bersangkutan untuk dilaksanakan dengan penuh tanggung
        jawab dan amanah.
        <br><br>
        Waalahu Waliyyut Taufiq wal-Hidayah
    </p>

    <div class="legalitor">
        Makassar, @foreach($data_sk as $key => $value)
                        {{Illuminate\Support\Carbon::parse(substr($value->created_at,0,10))->formatLocalized("%d %B %Y")}}
                        @endforeach
        <br>
        Dekan
    </div>
    <br>
    <br>
    <div style="text-align: center; position: relative">
        @if (helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 0)
        @elseif(helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 1)
        @elseif(helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 2)
        <img src="{{asset('gambar/stempelfakultas.png')}}" alt="" height="100px" style="position: absolute; right: 140px">
        <img src="{{asset('gambar/ttd_dekan.png')}}" alt="" height="70px" style="position: absolute; right: -20px">
        @endif
    </div>
    <br><br><br><br>
    <div class="legalitor">
        <b><u>Purnawansyah, M.Kom</u></b>
    </div>
    <div style="text-align: center; position: relative">
        @if (helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 0)
        @elseif(helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 1 || helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 2)
        <img src="{{asset('gambar/paraf_wd.png')}}" alt="" height="50px" style="position: absolute; right: -20px">
        @endif
    </div>
    <p align="justify">
        <i><u>Tembusan : </u>
            <br>
            1. Yayasan Wakaf UMI <br>
            2. Rektor UMI <br>
            3. Ketua Program Studi TI FH UMI</i>
    </p>


    </table>

    <br><br><br><br><br><br><br><br><br>



    <div class="header">
        <img src="{{asset('umi.png')}}" alt="Logo Institusi" />
        <h3 class="textheader">Yayasan Wakaf UMI</h4><br>
            <h3 class="textheader">Universitas Muslim Indonesia</h4><br>
                <h3 class="textheader">Fakultas Hukum</h4><br>
    </div>
    <hr>
    <h6 class="headerAddress" style="text-align: center"> Jln. UripSumohardjo Km.05 GedungFakultasIlmuKomputerLt.1. Kampus II UMI Tlp.(0411) 449775-453308-453818, Fax (0411) - 453009 Makassar 90231
website: fh.umi.ac.id, email: fikom@umi.ac.id
    </h6>
    <br>
    <br>
    <div class="title">
        <i>
            <h4 class="headingTitle">Bismillahirrahmaanirrahiim</h4>
        </i><br><br>
    </div>

    <div class="title">
        <u>
            <h4 class="headingTitle">SURAT PENUNJUKAN</h4>
        </u><br>
        @foreach($data_sk as $key => $value)
        <h4 class="headingTitle">Nomor : {{$value->nomor_sk}} </h4></u>
        @endforeach
    </div>
    <br>
    <p align="justify">
        Dengan rahmat Allah SWT, sesuai dengan surat ketua Program Studi
        {{helper::getProgramStudiByNim(auth()->user()->name)}} nomor : <b>{{helper::getNomorSKWithBimbinganId($data_sk[0]->bimbingan_id)}}</b> tentang tugas
        akhir mahasiswa maka :
    </p>
    <center>DEKAN Fakultas Hukum</center>
    <p>
        Menunjuk Saudara :
    </p>
    <div>

        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>
                    <b>
                        @foreach($data_sk as $key => $value)
                        {{isset($value->pembimbing_II_id) ? helper::getDeskripsi($value->pembimbing_II_id) :'' }}
                        @endforeach
                    </b>
                </td>
            </tr>
            <tr>
                <td>Pangkat/Gol.</td>
                <td>:</td>
                <td>
                    <b>
                        @foreach($data_sk as $key => $value)
                        {{isset($value->pembimbing_II_id) ? helper::getJabatanFungsionalByNIDN($value->pembimbing_II_id) :'' }}
                        @endforeach
                    </b>
                </td>
            </tr>
        </table>
    </div>
    <br>
    <p align="justify">
        Sebagai Pembimbing Pendamping untuk Tugas Akhir Mahasiswa :
    </p>
    <div>
        <table>
            <tr>
                <td>Nama / Stambuk</td>
                <td>:</td>
                <td>
                    <b>
                        @foreach($data_sk as $key => $value)
                        {{isset($value->C_NPM) ? helper::getNamaMhs($value->C_NPM) :'' }} / {{$value->C_NPM}}
                        @endforeach
                    </b>
                </td>
            </tr>
            <tr>
                <td>Topik Penelitian</td>
                <td>:</td>
                <td>
                    <b>
                        @foreach($data_sk as $key => $value)
                        {{$value->judul}}
                        @endforeach
                    </b>
                </td>
            </tr>
        </table>
    </div>
    <p align="justify">
        Demikian surat penunjukan ini disampaikan kepada yang bersangkutan untuk dilaksanakan dengan penuh tanggung
        jawab dan amanah.
        <br><br>
        Waalahu Waliyyut Taufiq wal-Hidayah
    </p>

    <div class="legalitor">
        Makassar, @foreach($data_sk as $key => $value)
                        {{Illuminate\Support\Carbon::parse(substr($value->created_at,0,10))->formatLocalized("%d %B %Y")}}
                        @endforeach
        <br>
        Dekan
    </div>
    <br>
        <div style="text-align: center; position: relative">
        @if (helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 0)
        @elseif(helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 1)
        @elseif(helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 2)
        <img src="{{asset('gambar/stempelfakultas.png')}}" alt="" height="100px" style="position: absolute; right: 140px">
        <img src="{{asset('gambar/ttd_dekan.png')}}" alt="" height="70px" style="position: absolute; right: -20px">
        @endif
    </div>
    <br><br><br><br>
    <div class="legalitor">
        <b><u>Purnawansyah, M.Kom</u></b>
    </div>
    <div style="text-align: center; position: relative">
        @if (helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 0)
        @elseif(helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 1 || helper::getStatusApproveWakilDekan($value->sk_pembimbing_id) == 2)
        <img src="{{asset('gambar/paraf_wd.png')}}" alt="" height="50px" style="position: absolute; right: -20px">
        @endif
    </div>
    <p align="justify">
        <i><u>Tembusan : </u>
            <br>
            1. Yayasan Wakaf UMI <br>
            2. Rektor UMI <br>
            3. Ketua Program Studi TI FH UMI</i>
    </p>


    </table>
</body>

</html>