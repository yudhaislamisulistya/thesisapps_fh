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
                <li class="active">Penentuban Bidang</li>
            </ol>

            <h3 class="page-heading">Daftar Riwayat Usulan</h3>
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
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Topik</th>
                                <th>Kerangka Pikir</th>
                                <th>Nama Bidang</th>
                                <th>Status Penentuan Bidang</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_riwayat_usulan as $key => $value)
                                <tr class="odd gradeX">
                                    <td width="1%" align="center">{{ ++$key }}</td>
                                    <td>{{ $value->C_NPM }}</td>
                                    <td>{{ $value->NAMA_MAHASISWA }}</td>
                                    <th>{{ $value->topik }}</th>
                                    <td><button class="btn btn-primary" onclick="showModal(this)"
                                            data-href="{{ asset('dokumen/' . $value->kerangka) }}"
                                            data-target="#modalPrimary" data-toggle="modal"><i
                                                class="fa fa-paperclip"></i></button></td>
                                    <td>
                                        @if ($value->bidang_ilmu_peminatan == null)
                                            <span class="label label-danger">Belum Menentukan Bidang</span>
                                        @else
                                            <span class="label label-info">{{ $value->bidang_ilmu_peminatan }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($value->status_penetapan == 0)
                                            <span class="label label-danger">Belum Menentukan Bidang</span>
                                        @elseif($value->status_penetapan == 1)
                                            <span class="label label-warning">Belum Menentukan Pembimbing</span>
                                        @elseif($value->status_penetapan == 2)
                                            <span class="label label-secondary">Belum Ditetapkan Pembimbing dan Judul</span>
                                        @elseif($value->status_penetapan == 3)
                                            <span class="label label-info">Sudah Ditetapkan Pembimbing dan Judul</span>
                                        @elseif($value->status_penetapan == 4)
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" onclick="showModalBidang(this)"
                                            data-c_npm="{{ $value->C_NPM }}" data-target="#modalBidang" data-toggle="modal">
                                            <i class="fa fa-pencil"> Pilih Bidang</i>
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.the-box .default -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Modal untuk menampilkan pilih bidang ilmu peminatan -->
    <div class="modal fade" id="modalBidang" tabindex="-1" role="dialog" aria-labelledby="modalBidangLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalBidangLabel">Pilih Bidang Ilmu Peminatan</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('post_fakultas_penentuan_bidang') }}" method="POST">
                        @csrf
                        <input type="hidden" name="C_NPM" id="C_NPM">
                        <div class="form-group">
                            <label for="bidang_ilmu_peminatan">Bidang Ilmu Peminatan</label>
                            <select name="bidang_ilmu_peminatan" id="bidang_ilmu_peminatan" class="form-control">
                                <option value="0">Pilih Bidang Ilmu Peminatan</option>
                                @foreach ($data_bidang_ilmu as $bidang)
                                    <option value="{{ $bidang->bidang_ilmu }}">{{ $bidang->bidang_ilmu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('script')
    <script>
        function showModalBidang(button) {
            // Get the C_NPM value from the button's data attribute
            var c_npm = button.getAttribute('data-c_npm');

            // Set the value of the hidden input field in the modal form
            document.getElementById('C_NPM').value = c_npm;

            // Show the modal (Bootstrap modal)
        }
    </script>
@endsection
