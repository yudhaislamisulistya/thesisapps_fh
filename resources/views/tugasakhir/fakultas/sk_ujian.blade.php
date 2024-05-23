@extends('tugasakhir.index')
@section('isi')
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="container-fluid">
            <!-- Begin page heading -->
            <h1 class="page-heading">Sistem Informasi Program Studi <small>Tugas Akhir</small></h1>
            <!-- End page heading -->

            <!-- Begin breadcrumb -->
            <ol class="breadcrumb default square rsaquo sm">
                <li><a href="index.html"><i class="fa fa-home"></i></a></li>
                <li><a href="#fakelink">Home</a></li>
                <li class="active">SK Ujian Proposal</li>
            </ol>

            <h3 class="page-heading">Daftar Jadwal Ujian</h3>
            <!-- BEGIN DATA TABLE -->
            <div class="the-box">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable-example">
                        <thead class="the-box dark full">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Ujian</th>
                                <th>Nama Periode</th>
                                <th>Tipe Ujian</th>
                                <th>Jumlah Peserta</th>
                                <th>SK</th>
                                {{-- <th>Status Ujian</th> --}}
                                <th>Detail Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalujian as $i => $d)
                                <tr class="odd gradeX">
                                    <td width="1%" align="center">{{ ++$i }}</td>
                                    <td>{{ $d->tgl_ujian }}</td>
                                    <td>{{ $d->nama_periode }}</td>
                                    @php
                                        if ($d->tipe_ujian == 0):
                                            $tipe = 'Proposal';
                                        elseif ($d->tipe_ujian == 1):
                                            $tipe = 'Seminar';
                                        elseif ($d->tipe_ujian == 2):
                                            $tipe = 'Ujian Meja';
                                        endif;

                                    @endphp
                                    <td>{{ $tipe }}</td>
                                    <td>{{ $d->jml_peserta }}</td>
                                    {{-- <td>{{$d->status == 0 ? "<td>{{$value->status == 0 ? "<td>{{$d->status == 0 ? "Belum terlaksana" : "Terlaksana"}}</td>" : "Terlaksana"}}</td>" : "Terlaksana"}}</td> --}}
                                    <td>
                                        <a href="{{ url("fakultas/set_sk/$d->pendaftaran_id") }}" class="btn btn-success"><i
                                                class="fa fa-file-text"></i>Set SK</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('fakultas/detail_skujian/' . $d->pendaftaran_id) }}">
                                            <i class="fa fa-copy icon-square icon-xs icon-primary"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.the-box .default -->
            <!-- END DATA TABLE -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
