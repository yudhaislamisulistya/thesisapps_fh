@extends('tugasakhir.index')
@section('isi')
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">

    <div class="container-fluid">
        <!-- Begin page heading -->
        <h1 class="page-heading">SIMPRODI <small>Tugas Akhir</small></h1>
        <!-- End page heading -->
        @if (Auth::user()->level == 5)
        <div class="row">
            <div class="col-sm-4">
                <div class="the-box no-border bg-success tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Persiapan Proposal</p>
                        @if (Auth::user()->name == 'prodifh')
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatusTi(0))}}</h1>
                        @elseif (Auth::user()->name == 'prodisi')
                            <h1 class="bolded">{{count(helper::getStatusBimbinganByStatusSi(0))}}</h1>
                        @else
                            <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(0))}}</h1>
                        @endif
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-success -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("prodi/detail_status_bimbingan_mahasiswa/0")}}"
                            class="btn btn-success btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
            <div class="col-sm-4">
                <div class="the-box no-border bg-primary tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Persiapan Ujian TA</p>
                        @if (Auth::user()->name == 'prodifh')
                            <h1 class="bolded">{{count(helper::getStatusBimbinganByStatusTi(2))}}</h1>
                        @elseif (Auth::user()->name == 'prodisi')
                            <h1 class="bolded">{{count(helper::getStatusBimbinganByStatusSi(2))}}</h1>
                        @else
                            <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(2))}}</h1>
                        @endif
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-primary -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("prodi/detail_status_bimbingan_mahasiswa/2")}}"
                            class="btn btn-primary btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
            <div class="col-sm-4">
                <div class="the-box no-border bg-danger tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Lulusan</p>
                        @if (Auth::user()->name == 'prodifh')
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatusTi(3))}}</h1>
                        @elseif (Auth::user()->name == 'prodisi')
                            <h1 class="bolded">{{count(helper::getStatusBimbinganByStatusSi(3))}}</h1>
                        @else
                            <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(3))}}</h1>
                        @endif
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-danger -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("prodi/detail_status_bimbingan_mahasiswa/3")}}"
                            class="btn btn-danger btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
        </div><!-- /.row -->
        @elseif(Auth::user()->level == 6)
        <div class="row">
            <div class="col-sm-4">
                <div class="the-box no-border bg-success tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Persiapan Proposal</p>
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(0))}}</h1>
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-success -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("akademikprodi/detail_status_bimbingan_mahasiswa/0")}}"
                            class="btn btn-success btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
            <div class="col-sm-4">
                <div class="the-box no-border bg-primary tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Persiapan Ujian TA</p>
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(2))}}</h1>
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-primary -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("akademikprodi/detail_status_bimbingan_mahasiswa/2")}}"
                            class="btn btn-primary btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
            <div class="col-sm-4">
                <div class="the-box no-border bg-danger tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Lulusan</p>
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(3))}}</h1>
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-danger -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("akademikprodi/detail_status_bimbingan_mahasiswa/3")}}"
                            class="btn btn-danger btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
        </div><!-- /.row -->
        @elseif(Auth::user()->level == 3)
        <div class="row">
            <div class="col-sm-4">
                <div class="the-box no-border bg-success tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Persiapan Proposal</p>
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(0))}}</h1>
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-success -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("wakildekan/detail_status_bimbingan_mahasiswa/0")}}"
                            class="btn btn-success btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
            <div class="col-sm-4">
                <div class="the-box no-border bg-primary tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Persiapan Ujian TA</p>
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(2))}}</h1>
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-primary -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("wakildekan/detail_status_bimbingan_mahasiswa/2")}}"
                            class="btn btn-primary btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
            <div class="col-sm-4">
                <div class="the-box no-border bg-danger tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Lulusan</p>
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(3))}}</h1>
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-danger -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("wakildekan/detail_status_bimbingan_mahasiswa/3")}}"
                            class="btn btn-danger btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
        </div><!-- /.row -->
        @elseif(Auth::user()->level == 2)
        <div class="row">
            <div class="col-sm-4">
                <div class="the-box no-border bg-success tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Persiapan Proposal</p>
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(0))}}</h1>
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-success -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("dekan/detail_status_bimbingan_mahasiswa/0")}}"
                            class="btn btn-success btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
            <div class="col-sm-4">
                <div class="the-box no-border bg-primary tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Persiapan Ujian TA</p>
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(2))}}</h1>
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-primary -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("dekan/detail_status_bimbingan_mahasiswa/2")}}"
                            class="btn btn-primary btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
            <div class="col-sm-4">
                <div class="the-box no-border bg-danger tiles-information">
                    <i class="fa fa-users icon-bg"></i>
                    <div class="tiles-inner text-center">
                        <p>Lulusan</p>
                        <h1 class="bolded">{{count(helper::getStatusBimbinganByStatus(3))}}</h1>
                        <div class="progress no-rounded progress-xs">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div><!-- /.progress-bar .progress-bar-danger -->
                        </div><!-- /.progress .no-rounded -->
                        <a href="{{ url("dekan/detail_status_bimbingan_mahasiswa/3")}}"
                            class="btn btn-danger btn-perspective">Lihat Detail</a>
                    </div><!-- /.tiles-inner -->
                </div><!-- /.the-box no-border -->
            </div><!-- /.col-sm-3 -->
        </div><!-- /.row -->
        @endif
        @if(Auth::user()->level==7)
        <div class="the-box">
            <div class="row">
                <div class="col-md-6">
                    <h3>Pengumuman Terbaru</h3>
                </div>
                <div class="col-md-6 text-right">
                    <h3><a href="{{url('/dsn/pengumuman/')}}">Lainnya</a></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="the-box no-border full">
                        <?php
                        if(count(helper::get5Pengumuman()) == 0){
                            echo '<h3 class="text-center">Belum ada pengumuman</h3>';
                        }else{
                        ?>
                        <button class="btn btn-block btn-primary btn-square"></button>
                        <ul class="widget-newsticker media-list">
                            @foreach (helper::get5Pengumuman() as $value)
                            <li class="media">
                                <div class="media-left">
                                    @if ($value->gambar == '')
                                    <img class="media-object" src="{{asset('gambar/no_image.jpg')}}" alt="Image">
                                    @else
                                    <img class="media-object" src="{{asset('gambar/'.$value->gambar)}}" alt="Image">

                                    @endif
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><a
                                            href="{{url('mhs/pengumuman/show/'.$value->pengumuman_id)}}">{{$value->judul}}</a>
                                    </h4>
                                    <p class="text-muted"><small>Terbit : {{$value->last_update}}</small></p>
                                    <p>
                                        {{mb_strimwidth(strip_tags($value->isi), 0, 100, '...')}}
                                    </p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <button class="btn btn-block btn-primary btn-square"></button>
                        <?php
                        
                        }
                        
                        ?>
                    </div><!-- /.the-box no-border -->
                </div>
            </div>
        </div>
        @elseif( Auth::user()->level==8)'
        <!-- BEGIN EXAMPLE ALERT -->
        <div class="alert alert-warning alert-bold-border fade in alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p><strong>Welcome! {{helper::getNamaMhs(auth()->user()->name)}}</strong></p>
            
                @if (helper::getStatusBimbinganByNim(auth()->user()->name) == 0)
                <p class="text-mute visible-lg-inlined">Informasi bimbingan anda saat ini ialah <a class="alert-link"
                    href="#fakelink">
                    <h4 class="visible-lg-inline">Persiapan Ujian Proposal</h4>
                @elseif(helper::getStatusBimbinganByNim(auth()->user()->name) == 2)
                <p class="text-muted visible-lg-inline">Informasi bimbingan anda saat ini ialah <a class="alert-link"
                    href="#fakelink">
                    <h4 class="visible-lg-inline">Persiapan Ujian Meja</h4>
                @elseif(helper::getStatusBimbinganByNim(auth()->user()->name) == 3)
                <p class="text-muted visible-lg-inline">Selamat Anda Telah Menyelesaikan Bimbingan dan dinyatakan sebagai<a class="alert-link"
                    href="#fakelink"><h4 class="visible-lg-inline">Lulusan</h4>
                @else
                    <p class="text-muted visible-lg-inline">Anda belum sampai ke tahap bimbingan<a class="alert-link"
                    href="#fakelink">
                @endif
                </a><i
                    class="fa fa-smile-o"></i></p>
        </div>
        <!-- END EXAMPLE ALERT -->'
        <div class="the-box">
            <div class="row">
                <div class="col-md-6">
                    <h3>Pengumuman Terbaru</h3>
                </div>
                <div class="col-md-6 text-right">
                    <h3><a href="{{url('/mhs/pengumuman/')}}">Lainnya</a></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="the-box no-border full">
                        <?php
                        if(count(helper::get5Pengumuman()) == 0){
                            echo '<h3 class="text-center">Belum ada pengumuman</h3>';
                        }else{
                        ?>
                        <button class="btn btn-block btn-primary btn-square"></button>
                        <ul class="widget-newsticker media-list">
                            @foreach (helper::get5Pengumuman() as $value)
                            <li class="media">
                                <div class="media-left">
                                    @if ($value->gambar == '')
                                    <img class="media-object" src="{{asset('gambar/no_image.jpg')}}" alt="Image">
                                    @else
                                    <img class="media-object" src="{{asset('gambar/'.$value->gambar)}}" alt="Image">

                                    @endif
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><a
                                            href="{{url('mhs/pengumuman/show/'.$value->pengumuman_id)}}">{{$value->judul}}</a>
                                    </h4>
                                    <p class="text-muted"><small>Terbit : {{$value->last_update}}</small></p>
                                    <p>
                                        {{mb_strimwidth(strip_tags($value->isi), 0, 100, '...')}}
                                    </p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <button class="btn btn-block btn-primary btn-square"></button>
                        <?php
                        
                        }
                        
                        ?>
                    </div><!-- /.the-box no-border -->
                </div>
            </div>
        </div>
        @endif

        <div class="the-box">

            <div class="row">
                <div class="col-sm-12">
                    <div class="the-box">
                        <h4 class="small-title">STATUS BIMBINGAN</h4>
                        <div id="morris-bar" style="height: 500px;"></div>
                    </div><!-- .the-box -->
                </div><!-- /.col-sm-6 -->
            </div>
        </div>
    </div><!-- /.container-fluid -->
    @endsection
    @section("script")
    <script>
        axios.get(`https://thesis-dev.fikom.app/fh/api/status_bimbingan_all`).then(res => {
            console.log(res.data);
            Morris.Bar({
                element: 'morris-bar',
                // data: [
                //     {y: '', a: 100, b: 90, c: 89}
                // ],
                data: [res.data],
                xkey: 'y',
                ykeys: ['PP', 'PUM', 'L'],
                labels: ['Persiapan Proposal', 'Persiapan Ujian Meja', 'Lulusan'],
                barColors: ['#3BAFDA', '#8CC152', '#c1b755']
            });
        });
    </script>
    @endsection