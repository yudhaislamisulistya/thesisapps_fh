<!-- BEGIN SIDEBAR LEFT -->
<div class="sidebar-left sidebar-nicescroller">
    <ul class="sidebar-menu">

        <li class="static left-profile-summary">
            <div class="media">
                <p class="pull-left">

                    <img src="{{ asset('master/assets/img/avatar/avatar-1.jpg') }}" class="avatar img-circle media-object"
                        alt="Avatar">
                </p>
                <div class="media-body">
                    <h4>Welcome,
                        <br>
                        <strong>{{ helper::getDeskripsi(helper::getCKodeDosenKetuaBidangIlmu(auth()->user()->name)) }}</strong>
                    </h4>
                    <a style="display: inline-block; width: 30px; padding: 0px; height: 30px; color: white; line-height: 2.3; border-radius: 5px;"
                        href="{{ url('dsn/ubah_password') }}" class="btn btn-success btn-xs"><i class="fa fa-cog"></i>
                    </a>
                    <a style="display: inline-block; width: 80px; padding: 0px; height: 30px; color: white; line-height: 2.3; border-radius: 5px;"
                        class="btn btn-danger btn-xs" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </li>

        <li>
            <a href="{{ url('/') }}">
                <i class="fa fa-home icon-sidebar"></i>
                Home
            </a>
        </li>
        <li class="static">MENU DOSEN</li>
        <li>
            <a href="{{ url('ketuabidang/penentuan_pembimbing') }}">
                <i class="fa fa-stack-overflow icon-sidebar"></i>
                Penentuan Pembimbing
            </a>
        </li>
        <li>
            <a href="#fakelink">
                <i class="fa fa-calendar icon-sidebar"></i>
                <i class="fa fa-angle-right chevron-icon-sidebar"></i>
                Jadwal Ujian Per Mahasiswa
            </a>
            <ul class="submenu">
                <li><a href="{{ url('ketuabidang/jadwalpermhs/proposal') }}">Proposal</a></li>
                <li><a href="{{ url('ketuabidang/jadwalpermhs/seminarhasil') }}">Proposal</a></li>
                <li><a href="{{ url('ketuabidang/jadwalpermhs/ujianmeja') }}">Ujian Meja</a></li>
            </ul>
        </li>
    </ul>
</div><!-- /.sidebar-left -->
<!-- END SIDEBAR LEFT -->
