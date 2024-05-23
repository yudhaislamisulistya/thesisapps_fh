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
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('prodi/dosen_pembimbing') }}">Dosen Pembimbing</a></li>
                <li class="active">Detail Dosen Pembimbing</li>
            </ol>




            <h3 class="page-heading">Detail Dosen Pembimbing</h3>
            @if (Session::get('status') == 'berhasil')
                <div class="alert alert-success" role="alert"><strong>Berhasil! </strong>Data Berhasil Disimpan</div>
            @elseif(Session::get('status') == 'gagal')
                <div class="alert alert-danger" role="alert"><strong>Gagal! </strong>Data Gagal Disimpan</div>
            @endif
            <!-- BEGIN DATA TABLE -->
            <div class="the-box">
                <form action="{{ url('prodi/dosen_pembimbing') }}" method="post">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">NIDN</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control bold-border" name="nidn"
                                    value="{{ $data->C_KODE_DOSEN }}" readonly />
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control bold-border" name="nama"
                                    value="{{ $data->NAMA_DOSEN }}" disabled />
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Alamat</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control bold-border" name="alamat"
                                    value="{{ $data->ALAMAT }}" disabled />
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">No Handphone</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control bold-border" name="noHp"
                                    value="{{ $data->NO_HP }}" />
                            </div>
                        </div>
                        <br><br>
                        {{-- Jabatan Fungsional --}}
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jabatan Fungsional</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="jabatanFungsional">
                                    <option value="Asisten Ahli" @if ($data->jabatan_fungsional == 'Asisten Ahli') selected @endif>Asisten Ahli</option>
                                    <option value="Lektor" @if ($data->jabatan_fungsional == 'Lektor') selected @endif>Lektor</option>
                                    <option value="Lektor Kepala" @if ($data->jabatan_fungsional == 'Lektor Kepala') selected @endif>Lektor Kepala</option>
                                    <option value="Guru Besar" @if ($data->jabatan_fungsional == 'Guru Besar') selected @endif>Guru Besar</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        {{-- End Jabatan Fungsional --}}
                        {{-- Golongan --}}
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Golongan</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="golongan">
                                    <option value="III/a" @if ($data->website == 'III/a') selected @endif>III/a</option>
                                    <option value="III/b" @if ($data->website == 'III/b') selected @endif>III/b</option>
                                    <option value="III/c" @if ($data->website == 'III/c') selected @endif>III/c</option>
                                    <option value="III/d" @if ($data->website == 'III/d') selected @endif>III/d</option>
                                    <option value="IV/a" @if ($data->website == 'IV/a') selected @endif>IV/a</option>
                                    <option value="IV/b" @if ($data->website == 'IV/b') selected @endif>IV/b</option>
                                    <option value="IV/c" @if ($data->website == 'IV/c') selected @endif>IV/c</option>
                                    <option value="IV/d" @if ($data->website == 'IV/d') selected @endif>IV/d</option>
                                    <option value="IV/e" @if ($data->website == 'IV/e') selected @endif>IV/e</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        {{-- End Golongan --}}
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Jumlah Bimbingan</label>
                            <div class="col-lg-5">
                                <input type="text" class="form-control bold-border" name="jmlBimbingan"
                                    value="{{ $total }}" disabled />
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <div class="col-lg-5 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Detail Bimbingan</label>
                            <div class="table-responsive col-lg-10">
                                <table class="table table-th-block">
                                    <thead>
                                        <tr>
                                            <th>Tahapan Mahasiswa Bimbingan</th>
                                            <th>Pembimbing Ketua : Pembimbing Ketua</th>
                                            <th>Pembimbing Anggota : Pembimbing Anggota</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Persiapan Proposal</td>
                                            <td>{{ count($ppropI) }}</td>
                                            <td>{{ count($ppropII) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Persiapan Ujian Meja</td>
                                            <td>{{ count($pmejaI) }}</td>
                                            <td>{{ count($pmejaII) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Lulusan</td>
                                            <td>{{ count($alumniI) }}</td>
                                            <td>{{ count($alumniII) }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->
                        </div>

                    </fieldset>
                </form>
            </div><!-- /.the-box -->
            <!-- End breadcrumb -->
            <h3 class="page-heading">Daftar Mahasiswa Bimbingan</h3>
            <!-- BEGIN DATA TABLE -->
            <div class="the-box">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable-example">
                        <thead class="the-box dark full">
                            <tr>
                                <th>No</th>
                                <th>No SK Bimbingan</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Tahapan Bimbingan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $a = 0;
                            ?>
                            @foreach ($data_bimbingan1 as $key => $value)
                                <tr class="odd gradeX">
                                    <td width="1%" align="center">{{ ++$a }}</td>
                                    <td>
                                        <form action="{{ url('dsn/cetak_sk_pembimbing/') }}" method="post"
                                            target="_blank">
                                            @csrf
                                            <input type="hidden" name="nomor" value="{{ $value->nomor_sk }}">
                                            <button type="submit" class="btn btn-primary">{{ $value->nomor_sk }}</button>
                                        </form>
                                    </td>
                                    <td>{{ $value->C_NPM }}</td>
                                    <td>{{ $value->NAMA_MAHASISWA }}</td>
                                    <td>
                                        @if ($value->status_bimbingan == 0)
                                            Persiapan Proposal
                                        @elseif($value->status_bimbingan == 2)
                                            Persiapan Ujian Meja
                                        @elseif($value->status_bimbingan == 3)
                                            Persiapan Wisuda
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($data_bimbingan2 as $key => $value)
                                <tr class="odd gradeX">
                                    <td width="1%" align="center">{{ ++$a }}</td>
                                    <td>
                                        <form action="{{ url('dsn/cetak_sk_pembimbing/') }}" method="post"
                                            target="_blank">
                                            @csrf
                                            <input type="hidden" name="nomor" value="{{ $value->nomor_sk }}">
                                            <button type="submit"
                                                class="btn btn-primary">{{ $value->nomor_sk }}</button>
                                        </form>
                                    </td>
                                    <td>{{ $value->C_NPM }}</td>
                                    <td>{{ $value->NAMA_MAHASISWA }}</td>
                                    <td>
                                        @if ($value->status_bimbingan == 0)
                                            Persiapan Proposal
                                        @elseif($value->status_bimbingan == 2)
                                            Persiapan Ujian Meja
                                        @elseif($value->status_bimbingan == 3)
                                            Persiapan Wisuda
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
    </div>
@endsection
