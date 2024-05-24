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
                <li class="active">Pengajuan Topik</li>
            </ol>
            <!-- End breadcrumb -->

            <!-- BEGIN DATA TABLE -->
            <h3 class="page-heading">Form Pengajuan Topik</h3>
            @if (Session::get('status') == 'berhasil')
                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
            @elseif(Session::get('status') == 'gagal')
                <div class="alert alert-danger" role="alert">{{ Session::get('message') }}</div>
            @endif

            <!-- BEGIN DATA TABLE -->
            <h3 class="page-heading">Daftar Riwayat Usulan Lokasi Penelitian</h3>
            <div class="the-box">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="datatable-example">
                        <thead class="the-box dark full">
                            <tr>
                                <th>No</th>
                                <th>Nama Pemohon</th>
                                <th>NIM Pemohon</th>
                                <th>Program Studi</th>
                                <th>Judul Penelitian</th>
                                <th>Lokasi Penelitian</th>
                                <th>Nomor Surat</th>
                                <th>Tanggal Surat</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_lokasi_penelitian as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->nama_pemohon }}</td>
                                    <td>{{ $item->nim_pemohon }}</td>
                                    <td>{{ $item->program_studi }}</td>
                                    <td>{{ $item->judul_penelitian }}</td>
                                    <td>{{ $item->lokasi_penelitian }}</td>
                                    <td>
                                        @if ($item->nomor_surat == null)
                                            <span class="label label-warning">Menunggu Set SK dan Tanggal oleh
                                                Fakultas</span>
                                        @else
                                            {{ $item->nomor_surat }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tanggal == null)
                                            <span class="label label-warning">Menunggu Set SK dan Tanggal oleh
                                                Fakultas</span>
                                        @else
                                            {{ $item->tanggal }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == '0')
                                            <span class="label label-warning">Menunggu Set SK dan Tanggal oleh
                                                Fakultas</span>
                                        @elseif($item->status == '1')
                                            <span class="label label-info">Menunggu Approve</span>
                                        @elseif($item->status == '2')
                                            <span class="label label-success">Approve</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == '1')
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#requestModal"
                                                data-tanggal="{{ $item->tanggal }}"
                                                data-sk="{{ $item->nomor_surat }}"
                                                data-id="{{ $item->id }}"
                                                data-nama="{{ $item->nama_pemohon }}"
                                                data-nim="{{ $item->nim_pemohon }}">
                                                Approve
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-primary" disabled>
                                                Approve
                                            </button>
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

    <!-- Modal -->
    <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('update_wakildekan_request_surat_lokasi_penelitian') }}">

                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="requestModalLabel">Approve Surat Lokasi Penelitian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="modal-id">
                        <div class="form-group">
                            <label for="modal-nama">Nama Pemohon</label>
                            <input type="text" class="form-control" id="modal-nama" disabled>
                        </div>
                        <div class="form-group">
                            <label for="modal-nim">NIM Pemohon</label>
                            <input type="text" class="form-control" id="modal-nim" disabled>
                        </div>
                        <div class="form-group">
                            <label for="modal-sk">Nomor SK</label>
                            <input type="text" class="form-control" name="nomor_sk" id="modal-sk" required disabled>
                        </div>
                        <div class="form-group">
                            <label for="modal-tanggal">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="modal-tanggal" required disabled>
                        </div>
                        <small class="text-danger">*Data yang sudah diinput tidak dapat diubah dan pastikan data yang
                            diinputkan benar</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#requestModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var nim = button.data('nim');
            var sk = button.data('sk');
            var tanggal = button.data('tanggal');

            console.log(id, nama, nim);

            var modal = $(this);
            modal.find('#modal-id').val(id);
            modal.find('#modal-nama').val(nama);
            modal.find('#modal-nim').val(nim);
            modal.find('#modal-sk').val(sk);
            modal.find('#modal-tanggal').val(tanggal);
        });
    </script>
@endsection
