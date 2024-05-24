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
                    <h4>Welcome, <br /><strong>Wakil Dekan</strong></h4>
                    <a style="display: inline-block; width: 30px; padding: 0px; height: 30px; color: white; line-height: 2.3; border-radius: 5px;"
                        href="{{ url('wakildekan/ubah_password') }}" class="btn btn-success btn-xs"><i
                            class="fa fa-cog"></i></a>
                    <a style="display: inline-block; width: 80px; padding: 0px; height: 30px; color: white; line-height: 2.3; border-radius: 5px;"
                        class="btn btn-danger btn-xs" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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
        <li class="static">MENU WAKIL DEKAN</li>
        <li>
            <a href="{{ url('wakildekan/topik') }}">
                <i class="fa fa-files-o icon-sidebar"></i>
                Topik Penelitian
            </a>
        </li>
        <li>
            <a href="{{ route('get_wakil_dekan_penetapan_pembimbing_dan_judul') }}">
                <i class="fa fa-flask icon-sidebar"></i>
                Penetapan Pembimbing dan Judul
            </a>
        </li>
        <li>
            <a href="{{ url('wakildekan/sk_pembimbing') }}">
                <i class="fa fa-stack-overflow icon-sidebar"></i>
                SK Pembimbing
            </a>
        </li>
        <li>
            <a href="{{ url('wakildekan/sk_ujian_ta') }}">
                <i class="fa fa-paperclip icon-sidebar"></i>
                SK Ujian TA
            </a>
        </li>
        <li>
            <a href="#fakelink">
                <i class="fa fa-users icon-sidebar"></i>
                <i class="fa fa-angle-right chevron-icon-sidebar"></i>
                Peserta Ujian
            </a>
            <ul class="submenu">
                <li><a href="{{ route('get_wakil_dekan_peserta_proposal') }}">Proposal</a></li>
                <li><a href="{{ route('get_wakil_dekan_peserta_seminar') }}">Seminar</a></li>
                <li><a href="{{ route('get_wakil_dekan_peserta_ujianmeja') }}">Ujian Meja</a></li>
            </ul>
        </li>


        <li>
            <a href="{{ url('wakildekan/request_surat_lokasi_penelitian') }}">
                <i class="fa fa-eye icon-sidebar"></i>
                Request Surat Lokasi Penelitian
            </a>
        </li>
    </ul>
</div><!-- /.sidebar-left -->
<!-- END SIDEBAR LEFT -->



<!-- BEGIN SIDEBAR RIGHT HEADING -->
<div class="sidebar-right-heading">
    <ul class="nav nav-tabs square nav-justified">
        <li class="active"><a href="#online-user-sidebar" data-toggle="tab"><i class="fa fa-comments"></i></a></li>
        <li><a href="#notification-sidebar" data-toggle="tab"><i class="fa fa-bell"></i></a></li>
        <li><a href="#task-sidebar" data-toggle="tab"><i class="fa fa-tasks"></i></a></li>
        <li><a href="#setting-sidebar" data-toggle="tab"><i class="fa fa-cogs"></i></a></li>
    </ul>
</div><!-- /.sidebar-right-heading -->
<!-- END SIDEBAR RIGHT HEADING -->



<!-- BEGIN SIDEBAR RIGHT -->
<div class="sidebar-right right-sidebar-nicescroller">
    <div class="tab-content">
        <div class="tab-pane fade in active" id="online-user-sidebar">
            <ul class="sidebar-menu online-user">
                <li class="static">ONLINE USERS</li>
                <li><a href="#fakelink">
                        <span class="user-status success"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-2.jpg') }}" class="ava-sidebar img-circle"
                            alt="Avatar">
                        <i class="fa fa-mobile-phone device-status"></i>
                        Thomas White
                        <span class="small-caps">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status success"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-3.jpg') }}" class="ava-sidebar img-circle"
                            alt="Avatar">
                        Doina Slaivici
                        <span class="small-caps">Duis autem vel eum iriure dolor in hendrerit in </span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status success"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-4.jpg') }}" class="ava-sidebar img-circle"
                            alt="Avatar">
                        <i class="fa fa-android device-status"></i>
                        Harry Nichols
                        <span class="small-caps">I think so</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status success"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-5.jpg') }}" class="ava-sidebar img-circle"
                            alt="Avatar">
                        <i class="fa fa-mobile-phone device-status"></i>
                        Mihaela Cihac
                        <span class="small-caps">Yes, I'll be waiting</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status success"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-6.jpg') }}" class="ava-sidebar img-circle"
                            alt="Avatar">
                        <i class="fa fa-apple device-status"></i>
                        Harold Chavez
                        <span class="small-caps">Thank you!</span>
                    </a></li>

                <li class="static">IDLE USERS</li>
                <li><a href="#fakelink">
                        <span class="user-status warning"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-7.jpg') }}" class="ava-sidebar img-circle"
                            alt="Avatar">
                        <i class="fa fa-windows device-status"></i>
                        Elizabeth Owens
                        <span class="small-caps">2 hours</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status warning"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-8.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <i class="fa fa-apple device-status"></i>
                        Frank Oliver
                        <span class="small-caps">4 hours</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status warning"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-9.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        Mya Weastell
                        <span class="small-caps">15 minutes</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status warning"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-10.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <i class="fa fa-mobile-phone device-status"></i>
                        Carl Rodriguez
                        <span class="small-caps">20 hours</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status warning"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-11.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <i class="fa fa-mobile-phone device-status"></i>
                        Nikita Carter
                        <span class="small-caps">2 minutes</span>
                    </a></li>

                <li class="static">OFFLINE USERS</li>
                <li><a href="#fakelink">
                        <span class="user-status danger"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-12.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        Craig Dixon
                        <span class="small-caps">Last seen 2 hours ago</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status danger"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-13.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        Mikayla King
                        <span class="small-caps">Last seen yesterday</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status danger"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-14.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        Richard Dixon
                        <span class="small-caps">Last seen Feb 20, 2014 05:45:50</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status danger"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-15.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        Brenda Fuller
                        <span class="small-caps">Last seen Feb 15, 2014 11:35:50</span>
                    </a></li>
                <li><a href="#fakelink">
                        <span class="user-status danger"></span>
                        <img src="{{ asset('master/assets/img/avatar/avatar-16.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        Ryan Ortega
                        <span class="small-caps">Last seen Jan 20, 2014 03:45:50</span>
                    </a></li>
            </ul>
        </div>
        <div class="tab-pane fade" id="notification-sidebar">
            <ul class="sidebar-menu sidebar-notification">
                <li class="static">TODAY</li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Karen Wallace" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-25.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Posted something on your profile page</span>
                        <span class="small-caps">17 seconds ago</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Phillip Lucas" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-24.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Uploaded a photo</span>
                        <span class="small-caps">2 hours ago</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Sandra Myers" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-23.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Commented on your post</span>
                        <span class="small-caps">5 hours ago</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Charles Guerrero" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-22.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Send you a message</span>
                        <span class="small-caps">17 hours ago</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Maria Simpson" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-21.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Change her avatar</span>
                        <span class="small-caps">20 hours ago</span>
                    </a></li>

                <li class="static">YESTERDAY</li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Jason Crawford" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-20.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Posted something on your profile page</span>
                        <span class="small-caps">Yesterday 10:45:12</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Cynthia Mendez" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-19.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Uploaded a photo</span>
                        <span class="small-caps">Yesterday 08:00:05</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Peter Ramirez" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-18.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Commented on your post</span>
                        <span class="small-caps">Yesterday 07:49:08</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Jessica Gutierrez" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-17.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Send you a message</span>
                        <span class="small-caps">Yesterday 07:35:19</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="Ryan Ortega" data-placement="left">
                        <img src="{{ asset('master/assets/img/avatar/avatar-16.jpg') }}"
                            class="ava-sidebar img-circle" alt="Avatar">
                        <span class="activity">Change her avatar</span>
                        <span class="small-caps">Yesterday 06:00:00</span>
                    </a></li>

                <li class="static text-center"><button class="btn btn-primary btn-sm">See all notifications</button>
                </li>
            </ul>
        </div>
        <div class="tab-pane fade" id="task-sidebar">
            <ul class="sidebar-menu sidebar-task">
                <li class="static">UNCOMPLETED</li>
                <li><a href="#fakelink" data-toggle="tooltip" title="in progress" data-placement="left">
                        <i class="fa fa-clock-o icon-task-sidebar progress"></i>
                        Creating documentation
                        <span class="small-caps">Deadline : Next week</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="uncompleted" data-placement="left">
                        <i class="fa fa-exclamation-circle icon-task-sidebar uncompleted"></i>
                        Eating sand
                        <span class="small-caps">Deadline : 2 hours ago</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="uncompleted" data-placement="left">
                        <i class="fa fa-exclamation-circle icon-task-sidebar uncompleted"></i>
                        Sending payment
                        <span class="small-caps">Deadline : 2 seconds ago</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="in progress" data-placement="left">
                        <i class="fa fa-clock-o icon-task-sidebar progress"></i>
                        Uploading new version
                        <span class="small-caps">Deadline : Tomorrow</span>
                    </a></li>

                <li class="static">COMPLETED</li>
                <li><a href="#fakelink" data-toggle="tooltip" title="completed" data-placement="left">
                        <i class="fa fa-check-circle-o icon-task-sidebar completed"></i>
                        Drinking coffee
                        <span class="small-caps">Completed : 10 hours ago</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="completed" data-placement="left">
                        <i class="fa fa-check-circle-o icon-task-sidebar completed"></i>
                        Walking to nowhere
                        <span class="small-caps">Completed : Yesterday</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="completed" data-placement="left">
                        <i class="fa fa-check-circle-o icon-task-sidebar completed"></i>
                        Sleeping under bridge
                        <span class="small-caps">Completed : Feb 10 2014</span>
                    </a></li>
                <li><a href="#fakelink" data-toggle="tooltip" title="completed" data-placement="left">
                        <i class="fa fa-check-circle-o icon-task-sidebar completed"></i>
                        Buying some cigarettes
                        <span class="small-caps">Completed : Jan 15 2014</span>
                    </a></li>

                <li class="static text-center"><button class="btn btn-success btn-sm">See all tasks</button></li>
            </ul>
        </div><!-- /#task-sidebar -->
        <div class="tab-pane fade" id="setting-sidebar">
            <ul class="sidebar-menu">
                <li class="static">ACCOUNT SETTING</li>
                <li class="text-content">
                    <div class="switch">
                        <div class="onoffswitch blank">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onlinestatus"
                                checked>
                            <label class="onoffswitch-label" for="onlinestatus">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                    Online status
                </li>
                <li class="text-content">
                    <div class="switch">
                        <div class="onoffswitch blank">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                id="offlinecontact" checked>
                            <label class="onoffswitch-label" for="offlinecontact">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                    Show offline contact
                </li>
                <li class="text-content">
                    <div class="switch">
                        <div class="onoffswitch blank">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                id="invisiblemode">
                            <label class="onoffswitch-label" for="invisiblemode">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                    Invisible mode
                </li>
                <li class="text-content">
                    <div class="switch">
                        <div class="onoffswitch blank">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                                id="personalstatus" checked>
                            <label class="onoffswitch-label" for="personalstatus">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                    Show my personal status
                </li>
                <li class="text-content">
                    <div class="switch">
                        <div class="onoffswitch blank">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="deviceicon">
                            <label class="onoffswitch-label" for="deviceicon">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                    Show my device icon
                </li>
                <li class="text-content">
                    <div class="switch">
                        <div class="onoffswitch blank">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="logmessages">
                            <label class="onoffswitch-label" for="logmessages">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                    Log all message
                </li>
            </ul>
        </div><!-- /#setting-sidebar -->
    </div><!-- /.tab-content -->
</div><!-- /.sidebar-right -->
<!-- END SIDEBAR RIGHT -->
