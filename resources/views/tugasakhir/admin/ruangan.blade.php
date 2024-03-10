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
                <li class="active">Ruangan</li>
            </ol>

            <!-- End breadcrumb -->
            <h3 class="page-heading">Daftar Ruangan </h3>
            @if (Session::get('status') == 'berhasil')
                <div class="alert alert-success" role="alert"><strong>Berhasil! </strong><?= Session::get('message') ?>
                </div>
            @elseif(Session::get('status') == 'gagal')
                <div class="alert alert-danger" role="alert"><strong>Gagal! </strong><?= Session::get('message') ?></div>
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
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr class="odd gradeX">
                                    <td width="1%" align="center">{{ ++$key }}</td>
                                    <td>{{ $value->nama_ruangan }}</td>
                                    <td>
                                        <a href="#" id="update-data-btn" data-id="{{ $value->id }}"
                                            data-nama="{{ $value->nama_ruangan }}"><i
                                                class="fa fa-pencil icon-square icon-xs icon-dark"></i>
                                        </a>
                                        {{-- Delete Button --}}
                                        <a href="{{ route('delete_master_ruangan', ['id' => $value->id]) }}"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i
                                                class="fa fa-times icon-square icon-xs icon-danger"></i>
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
                    <form id="add-data-form" action="{{ route('create_master_ruangan') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title" id="add-data-modal-label">Tambah Data Ruangan</h4>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
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

        {{-- Edit Modal --}}
        <div class="modal fade" id="update-data-modal" tabindex="-1" role="dialog"
            aria-labelledby="update-data-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="update-data-form" action="{{ route('update_master_ruangan') }}" method="POST">
                        <input type="hidden" name="id" id="id">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title" id="update-data-modal-label">Update Data Ruangan</h4>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nameEdit">Nama</label>
                                <input type="text" class="form-control" id="nameEdit" name="nameEdit" required>
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
        {{-- End Edit Modal --}}
    @endsection


    @section('script')
        <script>
            $(document).ready(function() {
                $('body').on('click', '#update-data-btn', function() {
                    var id = $(this).data('id');
                    var nama = $(this).data('nama');
                    console.log(id);
                    console.log(nama);
                    $('#id').val(id);
                    $('#nameEdit').val(nama);
                    $('#update-data-modal').modal('show');
                });
            });
        </script>
    @endsection
