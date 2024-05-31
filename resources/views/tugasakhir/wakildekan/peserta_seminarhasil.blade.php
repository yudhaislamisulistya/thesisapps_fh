@extends('tugasakhir.index')
@section('isi')
    <!-- BEGIN PAGE CONTENT -->
    <div class="page-content">
        <div class="container-fluid">
            <!-- Begin page heading -->
            <h1 class="page-heading">Sistem Informasi Program Studi <small> TUGAS AKHIR</small></h1>
            <!-- End page heading -->

            <!-- Begin breadcrumb -->
            <ol class="breadcrumb default square rsaquo sm">
                <li><a href="index.html"><i class="fa fa-home"></i></a></li>
                <li><a href="#fakelink">Home</a></li>
                <li class="active">Peserta Seminar</li>
            </ol>
            <!-- End breadcrumb -->

            <!-- BEGIN DATA TABLE -->
            <h3 class="page-heading">Daftar Jadwal Pendaftaran Seminar</h3>
            @if (Session::get('status') == 'berhasil')
                <div class="alert alert-success" role="alert"><strong>Berhasil! </strong><?= Session::get('message') ?>
                </div>
            @elseif(Session::get('status') == 'gagal')
                <div class="alert alert-danger" role="alert"><strong>Gagal! </strong><?= Session::get('message') ?></div>
            @endif
            <div class="the-box">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable-example">
                        <thead class="the-box dark full">
                            <tr>
                                <th>No</th>
                                <th>Tanggal pendaftaran</th>
                                <th>Kuota</th>
                                <th>Jumlah Peserta</th>
                                <th>Nama Periode</th>
                                {{-- <th>Status Ujian</th> --}}
                                <th>Detail Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendaftaran as $key => $value)
                                <tr class="odd gradeX">
                                    <td width="1%" align="center">{{ ++$key }}</td>
                                    <td>{{ $value->tgl_start }}-{{ $value->tgl_end }}</td>
                                    <td>{{ $value->kuota }}</td>
                                    <td>{{ $value->jml_peserta }}</td>
                                    <td>{{ $value->nama_periode }}</td>
                                    {{-- <<td>{{$value->status == 0 ? "td>{{$value->status == 0 ? "<td>{{$d->status == 0 ? "Belum terlaksana" : "Terlaksana"}}</td>" : "Terlaksana"}}</td>" : "Terlaksana"}}</td> --}}
                                    <td><a href="{{ url('wakildekan/daftar_peserta/' . $value->pendaftaran_id) }}"><i
                                                class="fa fa-copy icon-square icon-xs icon-primary"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.the-box .default -->
            <!-- END DATA TABLE -->
        </div><!-- /.container-fluid -->
    @endsection
