@extends('tugasakhir.index')
@section('isi')

<div class="page-content">
    <div class="container-fluid">
        <h1 class="page-heading">Sistem Informasi Program Studi <small> TUGAS AKHIR</small></h1>
        <ol class="breadcrumb default square rsaquo sm">
            <li><a href="index.html"><i class="fa fa-home"></i></a></li>
            <li><a href="#fakelink">Home</a></li>
            <li class="active">Data Pembimbing</li>
        </ol>
        <h3 class="page-heading">Data Pembimbing</h3>
        <div class="the-box">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="datatable-example">
                    <thead class="the-box dark full">
                    <tr>
                        <th>No</th>
                        <th>NIDN</th>
                        <th>Nama Dosen</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($dataDetailPembimbing as $key => $value)
                        <tr class="odd gradeX">
                            <td width="1%" align="center">{{++$key}}</td>
                            <td>{{$value->C_KODE_DOSEN}}</td>
                            <td>{{$value->NAMA_DOSEN}}</td>
                            <td>{{$value->JENIS_KELAMIN}}</td>
                            <td>
                                @if($value->status == "Pembimbing Ketua")
                                    <span class="label label-success">{{$value->status}}</span>
                                @else
                                    <span class="label label-warning">{{$value->status}}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /.the-box .default -->
        <!-- END DATA TABLE -->
    </div><!-- /.container-fluid -->
@endsection


