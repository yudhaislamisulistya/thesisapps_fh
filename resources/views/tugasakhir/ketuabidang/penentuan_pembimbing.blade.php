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
                                <th>Pembimbing Ketua</th>
                                <th>Pembimbing Anggota</th>
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
                                            <span class="label label-success">Sudah Menentukan Pembimbing</span>
                                        @elseif($value->status_penetapan == 3)
                                            <span class="label label-info">Sudah Ditetapkan Pembimbing dan Judul</span>
                                        @elseif($value->status_penetapan == 4)
                                            <span class="label label-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($value->pembimbing_I_id == null)
                                            <span class="label label-danger">Belum Menentukan Pembimbing Ketua</span>
                                        @else
                                            <span
                                                class="label label-info">{{ helper::getDosenByKodeDosen($value->pembimbing_I_id)->NAMA_DOSEN }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($value->pembimbing_II_id == null)
                                            <span class="label label-danger">Belum Menentukan Pembimbing Anggota</span>
                                        @else
                                            <span
                                                class="label label-info">{{ helper::getDosenByKodeDosen($value->pembimbing_II_id)->NAMA_DOSEN }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" onclick="showModalBidang(this)"
                                            data-c_npm="{{ $value->C_NPM }}"
                                            data-pembimbing-ketua="{{ $value->pembimbing_I_id }}"
                                            data-pembimbing-anggota="{{ $value->pembimbing_II_id }}"
                                            data-target="#modalBidang" data-toggle="modal">
                                            <i class="fa fa-pencil"> Pilih Pembimbing</i>
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
                    <form action="{{ route('update_ketua_bidang_penentuan_pembimbing') }}" method="POST">
                        @csrf
                        <input type="hidden" name="C_NPM" id="C_NPM">
                        <div class="form-group">
                            <label for="pembimbing_ketua">Pembimbing Ketua</label>
                            <select class="form-control selectpicker" name="pembimbing_ketua" data-live-search="true">
                                <option value="">--</option>
                                @foreach ($listdosen as $key => $value)
                                    @if ($value->level == '1' || !isset($value->level) || $value->level == '3')
                                        <option value="{{ $value->C_KODE_DOSEN }}">{{ $value->NAMA_DOSEN }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pembimbing_anggota">Pembimbing Anggota</label>
                            <select class="form-control selectpicker" name="pembimbing_anggota" data-live-search="true">
                                <option value="">--</option>
                                @foreach ($listdosen as $key => $value)
                                    @if ($value->level == '2' || !isset($value->level) || $value->level == '3')
                                        <option value="{{ $value->C_KODE_DOSEN }}">{{ $value->NAMA_DOSEN }}</option>
                                    @endif
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
        $(document).ready(function() {
            // Inisialisasi Bootstrap Select
            $('.selectpicker').selectpicker();
        });

        function showModalBidang(button) {
            var c_npm = button.getAttribute('data-c_npm');
            var pembimbing_ketua = button.getAttribute('data-pembimbing-ketua');
            var pembimbing_anggota = button.getAttribute('data-pembimbing-anggota');
            document.getElementById('C_NPM').value = c_npm;
            var selectKetua = document.querySelector('select[name="pembimbing_ketua"]');
            var selectAnggota = document.querySelector('select[name="pembimbing_anggota"]');
            selectKetua.value = pembimbing_ketua;
            selectAnggota.value = pembimbing_anggota;
            $('.selectpicker').selectpicker('refresh'); // Refresh the selectpicker
        }
    </script>
@endsection
