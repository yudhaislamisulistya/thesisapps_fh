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
                                    <td>
                                        <a href="{{ asset('dokumen/' . $value->kerangka) }}" target="_blank">
                                            <button class="btn btn-primary">
                                                <i class="fa fa-eye"></i> Lihat
                                            </button>
                                    </td>
                                    <td>
                                        @if ($value->bidang_ilmu_peminatan == null)
                                            <span class="label label-danger">Belum Menentukan Bidang</span>
                                        @else
                                            <span class="label label-primary">{{ $value->bidang_ilmu_peminatan }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($value->status_penetapan == 0)
                                            <span class="label label-danger">Belum Menentukan Bidang</span>
                                        @elseif($value->status_penetapan == 1)
                                            <span class="label label-warning">Belum Menentukan Pembimbing oleh Ketua
                                                Bidang</span>
                                        @elseif($value->status_penetapan == 2)
                                            <span class="label label-danger">Belum Ditetapkan Pembimbing dan Judul oleh
                                                Wakil Dekan</span>
                                        @elseif($value->status_penetapan == 3)
                                            <span class="label label-info">Sudah Ditetapkan Pembimbing dan Judul oleh Wakil
                                                Dekan</span>
                                        @elseif($value->status_penetapan == 99)
                                            <span class="label label-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>

                                        @if ($value->status_penetapan == 3 || $value->status_penetapan == 2)
                                            <button class="btn btn-primary" disabled>
                                                <i class="fa fa-pencil"> Pilih Bidang</i>
                                            </button>
                                        @else
                                            @if ($value->status_penetapan == 99)
                                                <button class="btn btn-primary" disabled>
                                                    <i class="fa fa-pencil"> Pilih Bidang</i>
                                                </button>
                                            @else
                                                <button class="btn btn-primary" onclick="showModalBidang(this)"
                                                    data-c_npm="{{ $value->C_NPM }}" data-topik-id="{{ $value->topik_id }}"
                                                    data-bidang-ilmu-peminatan="{{ $value->bidang_ilmu_peminatan }}"
                                                    data-target="#modalBidang" data-toggle="modal">
                                                    <i class="fa fa-pencil"> Pilih Bidang</i>
                                                </button>
                                                <button class="btn btn-danger" onclick="showModalTolak(this)"
                                                    data-c_npm="{{ $value->C_NPM }}" data-topik-id="{{ $value->topik_id }}"
                                                    data-target="#modalTolak" data-toggle="modal">
                                                    <i class="fa fa-times"> Tolak</i>
                                                </button>
                                            @endif
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div>
        </div>
    </div>


    {{-- Modal untuk menampilkan tolak --}}
    <div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modalTolakLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('post_fakultas_tolak_penentuan_bidang') }}" method="POST">
                    @csrf
                    <input type="hidden" name="topik_id" id="topik_id">
                    <input type="hidden" name="C_NPM" id="C_NPM">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modalTolakLabel">Tolak Penentuan Bidang</h4>
                    </div>
                    <div class="modal-body">
                        <small>*Judul yang ditolak tidak akan di lanjutkan ke tahap selanjutnya</small>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


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
                        <input type="hidden" name="topik_id" id="topik_id_add">
                        <input type="hidden" name="C_NPM" id="C_NPM_add">
                        <div class="form-group">
                            <label for="bidang_ilmu_peminatan">Bidang Ilmu Peminatan</label>
                            <select name="bidang_ilmu_peminatan" id="bidang_ilmu_peminatan_add" class="form-control">
                                <option value="0">Pilih Bidang Ilmu Peminatan</option>
                                @foreach ($data_bidang_ilmu as $bidang)
                                    <option value="{{ $bidang->bidang_ilmu }}">{{ $bidang->bidang_ilmu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small>*Bidang Ilmu Peminatan yang dipilih akan menjadi bidang ilmu peminatan mahasiswa dan pastikan
                            bidang ilmu peminatan yang dipilih sesuai dengan bidang ilmu peminatan mahasiswa</small>
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
            var c_npm = button.getAttribute('data-c_npm');
            var bidang_ilmu_peminatan = button.getAttribute('data-bidang-ilmu-peminatan');
            var topik_id = button.getAttribute('data-topik-id');
            document.getElementById('C_NPM_add').value = c_npm;
            document.getElementById('bidang_ilmu_peminatan_add').value = bidang_ilmu_peminatan;
            document.getElementById('topik_id_add').value = topik_id;
        }

        function showModalTolak(button) {
            var c_npm = button.getAttribute('data-c_npm');
            var topik_id = button.getAttribute('data-topik-id');
            document.getElementById('C_NPM').value = c_npm;
            document.getElementById('topik_id').value = topik_id;
        }
    </script>
@endsection
