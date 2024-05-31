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
                <li class="active">Penentuan Bidang</li>
            </ol>

            <h3 class="page-heading">Daftar Riwayat Usulan
                <?= helper::getBidangIlmubyBidangIlmu(Auth::user()->name)->bidang_ilmu ?></h3>
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
                                    <td>
                                        <a href="{{ asset('dokumen/' . $value->kerangka) }}" target="_blank">
                                            <button class="btn btn-primary">
                                                <i class="fa fa-eye"></i> Lihat
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        @if ($value->status_penetapan == 0)
                                            <span class="label label-danger">Belum Menentukan Bidang</span>
                                        @elseif($value->status_penetapan == 1)
                                            <span class="label label-warning">Belum Menentukan Pembimbing</span>
                                        @elseif($value->status_penetapan == 2)
                                            <span class="label label-success">Sudah Menentukan Pembimbing</span>
                                        @elseif($value->status_penetapan == 3)
                                            <span class="label label-primary">Sudah Ditetapkan Pembimbing dan Judul oleh
                                                Wakil Dekan</span>
                                        @elseif($value->status_penetapan == 4)
                                            <span class="label label-success">Selesai</span>
                                        @elseif($value->status_penetapan == 98)
                                            <span class="label label-danger">Dilolak oleh Ketua Bidang</span>
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
                                        @if ($value->status_penetapan != 2)
                                            @if ($value->status_penetapan == 97 ||$value->status_penetapan == 98 || $value->status_penetapan == 99 || $value->status_penetapan == 3)
                                                <button class="btn btn-primary" disabled>
                                                    <i class="fa fa-pencil"> Pilih Pembimbing</i>
                                                </button>
                                            @else
                                                <button class="btn btn-primary" onclick="showModalBidang(this)"
                                                    data-c_npm="{{ $value->C_NPM }}" data-topik-id="{{ $value->topik_id }}"
                                                    data-topik="{{ $value->topik }}"
                                                    data-pembimbing-ketua="{{ $value->pembimbing_I_id }}"
                                                    data-pembimbing-anggota="{{ $value->pembimbing_II_id }}"
                                                    data-target="#modalBidang" data-toggle="modal">
                                                    <i class="fa fa-pencil"> Pilih Pembimbing</i>
                                                </button>
                                                <button class="btn btn-danger" onclick="showModalTolak(this)"
                                                    data-c_npm="{{ $value->C_NPM }}"
                                                    data-topik-id="{{ $value->topik_id }}"
                                                    data-topik="{{ $value->topik }}" data-target="#modalTolak"
                                                    data-toggle="modal">
                                                    <i class="fa fa-times"> Tolak</i>
                                                </button>
                                            @endif
                                        @else
                                            <button class="btn btn-primary" disabled>
                                                <i class="fa fa-pencil"> Pilih Pembimbing</i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.the-box .default -->
        </div><!-- /.container-fluid -->
    </div>

    {{-- Modal untuk menampilkan tolak bidang ilmu pemintan --}}
    <div class="modal fade" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modalTolakLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('tolak_bidang_penentuan_pembimbing') }}" method="POST">
                    @csrf
                    <input type="hidden" name="C_NPM" id="C_NPM_TOLAK">
                    <input type="hidden" name="topik_id" id="topik_id_tolak">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modalTolakLabel">Tolak Bidang Ilmu Peminatan</h4>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menolak bidang ilmu peminatan mahasiswa dengan NIM <b
                                id="nim_tolak"></b>?</p>
                        </br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ya</button>
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
                    <form action="{{ route('update_ketua_bidang_penentuan_pembimbing') }}" method="POST">
                        @csrf
                        <input type="hidden" name="C_NPM" id="C_NPM">
                        <input type="hidden" name="topik_id" id="topik_id">
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
            var topik_id = button.getAttribute('data-topik-id');
            var pembimbing_ketua = button.getAttribute('data-pembimbing-ketua');
            var pembimbing_anggota = button.getAttribute('data-pembimbing-anggota');
            document.getElementById('C_NPM').value = c_npm;
            document.getElementById('topik_id').value = topik_id;
            var selectKetua = document.querySelector('select[name="pembimbing_ketua"]');
            var selectAnggota = document.querySelector('select[name="pembimbing_anggota"]');
            selectKetua.value = pembimbing_ketua;
            selectAnggota.value = pembimbing_anggota;
            $('.selectpicker').selectpicker('refresh'); // Refresh the selectpicker
        }

        function showModalTolak(button) {
            var c_npm = button.getAttribute('data-c_npm');
            var topik_id = button.getAttribute('data-topik-id');
            document.getElementById('C_NPM_TOLAK').value = c_npm;
            document.getElementById('topik_id_tolak').value = topik_id;
        }
    </script>
@endsection
