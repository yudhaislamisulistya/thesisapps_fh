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
                <li class="active">Ketua Bidang</li>
            </ol>

            <!-- End breadcrumb -->
            <h3 class="page-heading">Daftar Ketua Bidang </h3>
            @if (Session::get('status') == 'berhasil')
                <div class="alert alert-success" role="alert"><?php echo Session::get('message'); ?></div>
            @elseif(Session::get('status') == 'gagal')
                <div class="alert alert-danger" role="alert"><?php echo Session::get('message'); ?></div>
            @endif
            <!-- BEGIN DATA TABLE -->
            <div class="the-box">
                <div style="float: right;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-data-modal">
                        Tambah Data
                    </button>
                </div>
                <br><br>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable-example">
                        <thead class="the-box dark full">
                            <tr>
                                <th>No</th>
                                <th>Bidang Ilmu</th>
                                <th>Nama Dosen Ketua Bidang</th>
                                <th>NIP</th>
                                <th>Username</th>
                                <th>Default Password</th>
                                <th>TTD</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr class="odd gradeX">
                                    <td width="1%" align="center">{{ ++$key }}</td>
                                    <td>{{ helper::getBidangIlmuById($value->id_bidang_ilmu)->bidang_ilmu }}</td>
                                    <td>{{ helper::getDosenByKodeDosen($value->C_KODE_DOSEN)->NAMA_DOSEN }}</td>
                                    <td>{{ $value->C_KODE_DOSEN }}</td>
                                    <td>{{ helper::getUserByEmail($value->C_KODE_DOSEN . "@umi.ac.id")->name }}</td>
                                    <td>
                                        <span class="label label-primary">Sesuai NIP</span>
                                    </td>
                                    @if ($value->ttd == '')
                                        <td>
                                            <img src="{{ asset('gambar/no_image.jpg') }}" height="50" width="50">
                                        </td>
                                    @else
                                        <td>
                                            <img src="{{ asset('gambar/' . $value->ttd) }}" height="50" width="50">
                                        </td>
                                    @endif
                                    <td>
                                        <a href="#" id="update-data-btn" data-id="{{ $value->id_ketua_bidang }}"
                                            data-id-bidang-ilmu="{{ $value->id_bidang_ilmu }}"
                                            data-c-kode-dosen="{{ $value->C_KODE_DOSEN }}" data-ttd="{{ $value->ttd }}">
                                            <i class="fa fa-pencil icon-square icon-xs icon-dark"></i>
                                        </a>
                                        {{-- Delete By ID --}}
                                        <a href="{{ route('delete_master_ketua_bidang', ['id' => $value->id_ketua_bidang]) }}"
                                            onclick="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?')">
                                            <i class="fa fa-times icon-square icon-xs icon-danger"></i>
                                        </a>
                                        {{-- Reset Password --}}
                                        <a href="{{ route('reset_password_ketua_bidang', ['id' => $value->id_ketua_bidang]) }}"
                                            onclick="return confirm('Apakah Anda Yakin Ingin Mereset Password Ketua Bidang Ini?')">
                                            <i class="fa fa-refresh icon-square icon-xs icon-primary"></i>
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

        {{-- Add Modal --}}
        <div class="modal fade" id="add-data-modal" tabindex="-1" role="dialog" aria-labelledby="add-data-modal-label"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="add-data-form" action="{{ route('create_master_ketua_bidang') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title" id="add-data-modal-label">Tambah Data Ketua Bidang</h4>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id_bidang_ilmu">Bidang Ilmu</label>
                                <select class="form-control" name="id_bidang_ilmu" required>
                                    <option value="">Pilih Bidang Ilmu</option>
                                    @foreach ($bidang_ilmu as $value)
                                        <option value="{{ $value->bidangilmu_id }}">{{ $value->bidang_ilmu }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="C_KODE_DOSEN">Dosen Bidang</label>
                                <select class="selectpicker form-control" name="C_KODE_DOSEN" data-live-search="true"
                                    required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($data_dosen as $value)
                                        <option value="{{ $value->C_KODE_DOSEN }}">{{ $value->NAMA_DOSEN }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="ttd">TTD</label>
                                <input type="file" class="form-control" id="ttd" name="ttd" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Add Modal --}}

        {{-- Update Modal --}}
        <div class="modal fade" id="update-data-modal" tabindex="-1" role="dialog"
            aria-labelledby="update-data-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="update-data-form" action="{{ route('update_master_ketua_bidang') }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id_ketua_bidang" id="id_ketua_bidang">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title" id="update-data-modal-label">Update Data Ketua Bidang</h4>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="id_bidang_ilmuEdit">Bidang Ilmu</label>
                                <select class="form-control" name="id_bidang_ilmuEdit" id="id_bidang_ilmuEdit" required>
                                    <option value="">Pilih Bidang Ilmu</option>
                                    @foreach ($bidang_ilmu as $value)
                                        <option value="{{ $value->bidangilmu_id }}">{{ $value->bidang_ilmu }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="C_KODE_DOSENEdit">Dosen Bidang</label>
                                <select class="selectpicker form-control" name="C_KODE_DOSENEdit" id="C_KODE_DOSENEdit"
                                    data-live-search="true" required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach ($data_dosen as $value)
                                        <option value="{{ $value->C_KODE_DOSEN }}">{{ $value->NAMA_DOSEN }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ttdEdit">TTD</label>
                                <input type="file" class="form-control" id="ttdEdit" name="ttdEdit">
                            </div>
                            <div class="form-group">
                                <img src="" id="ttd-img-tag" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Update Modal --}}
    @endsection


    @section('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.selectpicker').selectpicker();

                $('body').on('click', '#update-data-btn', function() {
                    var id_ketua_bidang = $(this).data('id');
                    var id_bidang_ilmu = $(this).data('id-bidang-ilmu');
                    var C_KODE_DOSEN = $(this).data('c-kode-dosen');
                    var ttd = $(this).data('ttd');
                    $('#id_ketua_bidang').val(id_ketua_bidang);
                    $('#id_bidang_ilmuEdit').val(id_bidang_ilmu);
                    $('#C_KODE_DOSENEdit').val(C_KODE_DOSEN).selectpicker('refresh');
                    if (ttd == '') {
                        $('#ttd-img-tag').attr('src', '{{ asset('gambar/no_image.jpg') }}');
                        $('#ttd-img-tag').css('border-radius', '10%');
                        $('#ttd-img-tag').css('margin-left', 'auto');
                        $('#ttd-img-tag').css('margin-right', 'auto');
                        $('#ttd-img-tag').css('display', 'block');
                        $('#ttd-img-tag').css('width', '400px');
                    } else {
                        $('#ttd-img-tag').attr('src', '{{ asset('gambar/') }}/' + ttd);
                        $('#ttd-img-tag').css('border-radius', '10%');
                        $('#ttd-img-tag').css('border-radius', '10%');
                        $('#ttd-img-tag').css('margin-left', 'auto');
                        $('#ttd-img-tag').css('margin-right', 'auto');
                        $('#ttd-img-tag').css('display', 'block');
                        $('#ttd-img-tag').css('width', '400px');
                    }
                    $('#update-data-modal').modal('show');
                });
            });
        </script>
    @endsection
