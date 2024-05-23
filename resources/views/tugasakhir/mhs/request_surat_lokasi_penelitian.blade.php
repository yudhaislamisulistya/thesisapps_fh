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
                <div class="alert alert-success" role="alert"><?php echo Session::get('message'); ?></div>
            @elseif(Session::get('status') == 'gagal')
                <div class="alert alert-danger" role="alert"><?php echo Session::get('message'); ?></div>
            @endif
            <div class="the-box">
                <form method="post" action="{{ url('mhs/request_surat_lokasi_penelitian') }}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if ($status_bimbingan == 1 || $status_bimbingan == 2)
                        <fieldset>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Nama Pemohon</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="nama_pemohon" required
                                        value="{{ $nama }}" readonly />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">NIM Pemohon</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="nim_pemohon" required
                                        value="{{ $C_NPM }}" readonly />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Program Studi</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="program_studi" required
                                        value="{{ $program_studi }}" readonly />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Judul Penelitian</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="judul_penelitian" required
                                        value="{{ $judul }}" readonly />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Lokasi Penelitian</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="lokasi_penelitian" required
                                        placeholder="Contoh: Desa/Kelurahan, Kecamatan, Kabupaten/Kota" />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Kota</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="kota" required
                                        placeholder="Contoh: Bandung" />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Provinsi</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="provinsi" required
                                        placeholder="Contoh: Jawa Barat" />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Tanggal Mulai</label>
                                <div class="col-lg-10">
                                    <input type="date" class="form-control bold-border" name="tanggal_mulai" required />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Tanggal Selesai</label>
                                <div class="col-lg-10">
                                    <input type="date" class="form-control bold-border" name="tanggal_selesai"
                                        required />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Dosen Pembimbing Ketua</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="dosen_pembimbing_ketua"
                                        required value="{{ $pembimbing_ketua }}" readonly />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Dosen Pembimbing Anggota</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="dosen_pembimbing_anggota"
                                        required value="{{ $pembimbing_anggota }}" readonly />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Kontak Pemohon</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control bold-border" name="kontak_pemohon" required
                                        placeholder="Contoh: 081234567890" />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Email Pemohon</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control bold-border" name="email_pemohon" required
                                        placeholder="Contoh: johndoe@umi.ac.id" />
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Note</label>
                                <div class="col-lg-10 mb-5">
                                    <textarea class="form-control bold-border" name="note">Assalamualaikum, </textarea>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <div class="col-lg-12" align="right" style="margin-top: 20px">
                                    <button class="btn btn-primary btn-perspective" type="submit">Simpan</button>
                                </div>
                            </div>
                        </fieldset>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Anda tidak dapat mengajukan usulan lokasi penelitian karena status bimbingan Anda saat ini masih
                            persiapan ujian proposal.
                        </div>
                    @endif
                </form>
            </div><!-- /.the-box -->

            {{-- Modal Note --}}
            <div class="modal fade" id="modalNote" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content modal-no-shadow modal-no-border bg-info">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Note</h4>
                        </div>
                        <div class="modal-body">
                            <textarea class="summernote-sm" name="note"></textarea>
                        </div>
                    </div><!-- /.modal-content .modal-no-shadow .modal-no-border .the-box .info .full -->
                </div><!-- /.modal-dialog -->
            </div><!-- /#InfoModalColor -->


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
                                <th>Status</th>
                                <th>Surat</th>
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
                                        @if ($item->status == 0)
                                            <span class="badge badge-warning">Menunggu Approve dari Fakultas</span>
                                        @elseif($item->status == 1)
                                            <span class="badge badge-primary">Diterima oleh Fakultas</span>
                                        @elseif($item->status == 2)
                                            <span class="badge badge-info">Diterima oleh Wakil Dekan</span>
                                        @elseif($item->status == 2)
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 2)
                                            <a href="{{ url('mhs/request_surat_lokasi_penelitian/download/' . $item->id) }}"
                                                class="btn btn-primary btn-xs">Download</a>
                                        @else
                                            <a href="#" class="btn btn-primary btn-xs" disabled>Download</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 0)
                                            <a href="#"
                                                onclick="showModal(this)"
                                                data-target="#modalDanger"
                                                data-toggle="modal"
                                                data-href="{{ url('mhs/request_surat_lokasi_penelitian/delete/' . $item->id) }}"
                                                class="btn btn-danger btn-xs">Hapus</a>
                                        @else
                                            <a href="#" class="btn btn-danger btn-xs" disabled>Hapus</a>
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

{{-- ModalTambah --}}
@section('modalPrimaryTitle')
    Tambah
@endsection
@section('modalPrimaryBody')
    Apakah Anda yakin ingin menambah data?
@endsection
@section('modalPrimaryFooter')
    <button onclick="submit(this)" class="btn btn-default">Tambah</button>
@endsection

{{-- ModalRequest --}}
@section('modalInfoTitle')
    Request Pembimbing
@endsection
@section('modalInfoBody')
    Apakah Anda yakin ingin me-request pembimbing?
    <br>
    <span id="status" class="badge badge-danger"></span>
@endsection
@section('modalInfoFooter')
    <button onclick="submit(this)" id="tombol_request_dua" class="btn btn-default">Request</button>
@endsection

{{-- ModalDownload --}}
@section('modalDefaultTitle')
    Download Kerangka Pikir
@endsection
@section('modalDefaultBody')
    Apakah Anda yakin ingin men-download kerangka pikir?
@endsection
@section('modalDefaultFooter')
    <button onclick="goOnNewTab(this)" class="btn btn-primary">Download</button>
@endsection

{{-- ModalHapus --}}
@section('modalDangerTitle')
    Hapus
@endsection
@section('modalDangerBody')
    Apakah Anda yakin ingin menghapus data?
@endsection
@section('modalDangerFooter')
    <button onclick="goOn(this)" class="btn btn-default">Hapus</button>
@endsection

@section('script')
    <script>
        $('#tombol_request_satu').on('click', function() {
            console.log("Selamat Datang di Bagian Satu");

            var p1 = $('select[name="pembimbing_I_id"]').val();
            var p2 = $('select[name="pembimbing_II_id"]').val();

            if (p1 == "--" && p2 == "--") {
                console.log("Ini Bagian Satu");
                $('#tombol_request_dua').attr("disabled", "disabled");
                $('#status').html("Data Pembimbing Belum Lengkap");
            } else {
                $('#status').html("");
                $("#tombol_request_dua").removeAttr("disabled");
            }
        });
        const initStatusPembimbing = e => {
            let id = e.value;
            let index = e.getAttribute("index");
            let status0 = document.getElementById("status0");
            let status1 = document.getElementById("status1");
            let status = [{
                    value: "0",
                    text: "Ditolak",
                    class: "text-danger"
                },
                {
                    value: "1",
                    text: "Diterima",
                    class: "text-primary"
                },
                {
                    value: "2",
                    text: "Menunggu...",
                    class: "text-warning"
                }
            ];
            console.log(index);
            console.log(id);
            axios.get(`https://thesis-dev.fikom.app/fh/mhs/usulan_tmp/pembimbing/getstatus/${index}/${id}`).then(
                res => {
                    if (index === "0") {
                        status.map(s => {
                            if (s.value === res.data) {
                                status0.classList = s.class;
                                status0.style.display = "initial";
                                status0.innerHTML = "<b>" + s.text + "</b>";
                            }
                        });
                    }
                    if (index === "1") {
                        status.map(s => {
                            if (s.value === res.data) {
                                status1.classList = s.class;
                                status1.style.display = "initial";
                                status1.innerHTML = "<b>" + s.text + "</b>";
                            }
                        });
                    }
                }).catch(() => {
                if (index === "0") {
                    status0.style.display = "none";
                }
                if (index === "1") {
                    status1.style.display = "none";
                }
            })
        };

        //Modal
        let modal, modalId, modalFooter, link, form, formaction;

        const showPostModal = e => {
            formaction = e.getAttribute("data-formaction");
            modalId = e.getAttribute("data-target");
            modal = document.querySelector(modalId);
            modalFooter = modal.querySelector(".modal-footer");
        };

        const showModal = e => {
            link = e.getAttribute("data-href");
            modalId = e.getAttribute("data-target");
            modal = document.querySelector(modalId);
            modalFooter = modal.querySelector(".modal-footer");
        };

        const goOn = () => {
            modal.querySelector(".modal-backdrop").click();
            window.location.href = link;
        };

        const submit = () => {
            form = document.querySelector(`form[action="${formaction}"]`);
            form.submit();
        };

        const goOnNewTab = () => {
            modal.querySelector(".modal-backdrop").click();
            window.open(link);
        };

        (function() {
            let selectPembimbingI = document.body.querySelector("[name=pembimbing_I_id]");
            let selectPembimbingII = document.body.querySelector("[name=pembimbing_II_id]");
            initStatusPembimbing(selectPembimbingI);
            initStatusPembimbing(selectPembimbingII);
        })();
    </script>
@endsection
