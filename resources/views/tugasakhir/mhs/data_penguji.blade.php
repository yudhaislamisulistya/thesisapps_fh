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
                                <th>Tipe Ujian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rowNumber = 1;
                            @endphp

                            @foreach ($dataDetailPenguji as $value)
                                @if ($value->status !== 'Ketua Sidang')
                                    <tr class="odd gradeX">
                                        <td width="1%" align="center">{{ $rowNumber++ }}</td>
                                        <td>{{ $value->C_KODE_DOSEN }}</td>
                                        <td>{{ $value->NAMA_DOSEN }}</td>
                                        <td>
                                            @if ($value->JENIS_KELAMIN == '')
                                                <span>Belum diisi</span>
                                            @else
                                                {{ $value->JENIS_KELAMIN }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->tipe_ujian == 'Proposal')
                                                <span class="label label-success">{{ $value->tipe_ujian }}</span>
                                            @elseif ($value->tipe_ujian == 'Seminar')
                                                <span class="label label-info">{{ $value->tipe_ujian }}</span>
                                            @elseif ($value->tipe_ujian == 'Ujian Meja')
                                                <span class="label label-warning">{{ $value->tipe_ujian }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->status == 'Penguji I')
                                                <span class="label label-primary">{{ $value->status }}</span>
                                            @elseif ($value->status == 'Penguji II')
                                                <span class="label label-danger">{{ $value->status }}</span>
                                            @elseif ($value->status == 'Penguji III')
                                                <span class="label label-warning">{{ $value->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.the-box .default -->
            <!-- END DATA TABLE -->
        </div><!-- /.container-fluid -->
    @endsection
