<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Conquer | Admin Dashboard Template</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="MobileOptimized" content="320">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{-- <link href="{{ asset('css/font-google.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet"
        type="text/css" />
    {{-- <link href="{{ asset('assets/plugins/fullcalendar/fullcalendar/fullcalendar.css') }}" rel="stylesheet"
        type="text/css" /> --}}
    <link href="{{ asset('assets/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{ asset('assets/css/style-conquer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style-responsive.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/tasks.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/red.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/rowgroup/1.1.3/css/rowGroup.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/frappe-gantt.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}">
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />



    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <!-- Bootstrap DateTimePicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .card-background-color {
            background-color: rgb(215, 215, 215);
        }
    </style>
    @yield('css')
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="page-header-fixed">
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <div class="header-inner">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/">
                    <img src="{{ asset('assets/img/logPOG.jpg') }}" style="height:25px;width:auto" alt="logo" />
                </a>
            </div>
            {{-- <form class="search-form search-form-header" role="form" action="index.html">
                <div class="input-icon right">
                    <i class="icon-magnifier"></i>
                    <input type="text" class="form-control input-sm" name="query" placeholder="Search...">
                </div>
            </form> --}}
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <img src="{{ asset('assets/img/menu-toggler.png') }}" alt="" />
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                {{-- <li class="dropdown" id="header_notification_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-success">
                            6 </span>
                    </a>
                    <ul class="dropdown-menu extended notification">
                        <li>
                            <p>
                                You have 14 new notifications
                            </p>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;">
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-success">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                        New user registered. <span class="time">
                                            Just now </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-danger">
                                            <i class="fa fa-bolt"></i>
                                        </span>
                                        Server #12 overloaded. <span class="time">
                                            15 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-warning">
                                            <i class="fa fa-bell"></i>
                                        </span>
                                        Server #2 not responding. <span class="time">
                                            22 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-info">
                                            <i class="fa fa-bullhorn"></i>
                                        </span>
                                        Application error. <span class="time">
                                            40 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-danger">
                                            <i class="fa fa-bolt"></i>
                                        </span>
                                        Database overloaded 68%. <span class="time">
                                            2 hrs </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-danger">
                                            <i class="fa fa-bolt"></i>
                                        </span>
                                        2 user IP blocked. <span class="time">
                                            5 hrs </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-warning">
                                            <i class="fa fa-bell"></i>
                                        </span>
                                        Storage Server #4 not responding. <span class="time">
                                            45 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-info">
                                            <i class="fa fa-bullhorn"></i>
                                        </span>
                                        System Error. <span class="time">
                                            55 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-danger">
                                            <i class="fa fa-bolt"></i>
                                        </span>
                                        Database overloaded 68%. <span class="time">
                                            2 hrs </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="external">
                            <a href="#">See all notifications <i class="fa fa-angle-right"></i></a>
                        </li>
                    </ul>
                </li> --}}
                <!-- END NOTIFICATION DROPDOWN -->
                <!-- BEGIN INBOX DROPDOWN -->
                {{-- <li class="dropdown" id="header_inbox_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <i class="icon-envelope-open"></i>
                        <span class="badge badge-info">
                            5 </span>
                    </a>
                    <ul class="dropdown-menu extended inbox">
                        <li>
                            <p>
                                You have 12 new messages
                            </p>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;">
                                <li>
                                    <a href="inbox.html?a=view">
                                        <span class="photo">
                                            <img src="./assets/img/avatar2.jpg') }}" alt="" />
                                        </span>
                                        <span class="subject">
                                            <span class="from">
                                                Lisa Wong </span>
                                            <span class="time">
                                                Just Now </span>
                                        </span>
                                        <span class="message">
                                            Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="inbox.html?a=view">
                                        <span class="photo">
                                            <img src="./assets/img/avatar3.jpg') }}" alt="" />
                                        </span>
                                        <span class="subject">
                                            <span class="from">
                                                Richard Doe </span>
                                            <span class="time">
                                                16 mins </span>
                                        </span>
                                        <span class="message">
                                            Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh...
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="inbox.html?a=view">
                                        <span class="photo">
                                            <img src="./assets/img/avatar1.jpg') }}" alt="" />
                                        </span>
                                        <span class="subject">
                                            <span class="from">
                                                Bob Nilson </span>
                                            <span class="time">
                                                2 hrs </span>
                                        </span>
                                        <span class="message">
                                            Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="inbox.html?a=view">
                                        <span class="photo">
                                            <img src="./assets/img/avatar2.jpg') }}" alt="" />
                                        </span>
                                        <span class="subject">
                                            <span class="from">
                                                Lisa Wong </span>
                                            <span class="time">
                                                40 mins </span>
                                        </span>
                                        <span class="message">
                                            Vivamus sed auctor 40% nibh congue nibh... </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="inbox.html?a=view">
                                        <span class="photo">
                                            <img src="./assets/img/avatar3.jpg') }}" alt="" />
                                        </span>
                                        <span class="subject">
                                            <span class="from">
                                                Richard Doe </span>
                                            <span class="time">
                                                46 mins </span>
                                        </span>
                                        <span class="message">
                                            Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh...
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="external">
                            <a href="inbox.html">See all messages <i class="fa fa-angle-right"></i></a>
                        </li>
                    </ul>
                </li> --}}
                <!-- END INBOX DROPDOWN -->
                <!-- BEGIN TODO DROPDOWN -->
                {{-- <li class="dropdown" id="header_task_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <i class="icon-calendar"></i>
                        <span class="badge badge-warning">
                            5 </span>
                    </a>
                    <ul class="dropdown-menu extended tasks">
                        <li>
                            <p>
                                You have 12 pending tasks
                            </p>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;">
                                <li>
                                    <a href="#">
                                        <span class="task">
                                            <span class="desc">
                                                New release v1.2 </span>
                                            <span class="percent">
                                                30% </span>
                                        </span>
                                        <span class="progress">
                                            <span style="width: 40%;" class="progress-bar progress-bar-success"
                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">
                                                    40% Complete </span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="task">
                                            <span class="desc">
                                                Application deployment </span>
                                            <span class="percent">
                                                65% </span>
                                        </span>
                                        <span class="progress progress-striped">
                                            <span style="width: 65%;" class="progress-bar progress-bar-danger"
                                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">
                                                    65% Complete </span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="task">
                                            <span class="desc">
                                                Mobile app release </span>
                                            <span class="percent">
                                                98% </span>
                                        </span>
                                        <span class="progress">
                                            <span style="width: 98%;" class="progress-bar progress-bar-success"
                                                aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">
                                                    98% Complete </span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="task">
                                            <span class="desc">
                                                Database migration </span>
                                            <span class="percent">
                                                10% </span>
                                        </span>
                                        <span class="progress progress-striped">
                                            <span style="width: 10%;" class="progress-bar progress-bar-warning"
                                                aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">
                                                    10% Complete </span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="task">
                                            <span class="desc">
                                                Web server upgrade </span>
                                            <span class="percent">
                                                58% </span>
                                        </span>
                                        <span class="progress progress-striped">
                                            <span style="width: 58%;" class="progress-bar progress-bar-info"
                                                aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">
                                                    58% Complete </span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="task">
                                            <span class="desc">
                                                Mobile development </span>
                                            <span class="percent">
                                                85% </span>
                                        </span>
                                        <span class="progress progress-striped">
                                            <span style="width: 85%;" class="progress-bar progress-bar-success"
                                                aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">
                                                    85% Complete </span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="task">
                                            <span class="desc">
                                                New UI release </span>
                                            <span class="percent">
                                                18% </span>
                                        </span>
                                        <span class="progress progress-striped">
                                            <span style="width: 18%;" class="progress-bar progress-bar-important"
                                                aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">
                                                    18% Complete </span>
                                            </span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="external">
                            <a href="#">See all tasks <i class="fa fa-angle-right"></i></a>
                        </li>
                    </ul>
                </li> --}}
                <!-- END TODO DROPDOWN -->
                <li class="devider">
                    &nbsp;
                </li>
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                {{-- <li class="dropdown" id="header_notification_bar">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-success">
                            6 </span>
                    </a>
                    <ul class="dropdown-menu extended notification">
                        <li>
                            <p>
                                You have 14 new notifications
                            </p>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list scroller" style="height: 250px;">
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-success">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                        New user registered. <span class="time">
                                            Just now </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-danger">
                                            <i class="fa fa-bolt"></i>
                                        </span>
                                        Server #12 overloaded. <span class="time">
                                            15 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-warning">
                                            <i class="fa fa-bell"></i>
                                        </span>
                                        Server #2 not responding. <span class="time">
                                            22 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-info">
                                            <i class="fa fa-bullhorn"></i>
                                        </span>
                                        Application error. <span class="time">
                                            40 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-danger">
                                            <i class="fa fa-bolt"></i>
                                        </span>
                                        Database overloaded 68%. <span class="time">
                                            2 hrs </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-danger">
                                            <i class="fa fa-bolt"></i>
                                        </span>
                                        2 user IP blocked. <span class="time">
                                            5 hrs </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-warning">
                                            <i class="fa fa-bell"></i>
                                        </span>
                                        Storage Server #4 not responding. <span class="time">
                                            45 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-info">
                                            <i class="fa fa-bullhorn"></i>
                                        </span>
                                        System Error. <span class="time">
                                            55 mins </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="label label-sm label-icon label-danger">
                                            <i class="fa fa-bolt"></i>
                                        </span>
                                        Database overloaded 68%. <span class="time">
                                            2 hrs </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="external">
                            <a href="#">See all notifications <i class="fa fa-angle-right"></i></a>
                        </li>
                    </ul>
                </li> --}}
                <!-- END NOTIFICATION DROPDOWN -->
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <img alt="" src="{{ asset('assets/img/avatar3_small.jpg') }}" />
                        <span class="username username-hide-on-mobile">{{ Auth::user()->name }} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        {{-- <li>
                            <a href="extra_profile.html"><i class="fa fa-user"></i> My Profile</a>
                        </li> --}}
                        {{-- <li class="divider"></li> --}}
                        <li>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
                                <i class="fa fa-key"></i>{{ __('Logout') }}
                            </a>
                        </li>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <div class="clearfix">
    </div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: for circle icon style menu apply page-sidebar-menu-circle-icons class right after sidebar-toggler-wrapper -->
                <ul class="page-sidebar-menu">
                    <li class="sidebar-toggler-wrapper">
                        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                        <div class="sidebar-toggler">
                        </div>
                        <div class="clearfix">
                        </div>
                        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    </li>
                    <li class="sidebar-search-wrapper">
                        <form class="search-form" role="form" action="index.html" method="get">
                            <div class="input-icon right">
                                <i class="icon-magnifier"></i>
                                <input type="text" class="form-control" name="query" placeholder="Search...">
                            </div>
                        </form>
                    </li>
                    @if (Auth::user()->jabatan_id == 1)
                        <li id="dashboardTeknisi" class="start">
                            <a href="{{ URL('/user') }}">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    @else
                        <li id="dashboard" class="start">
                            <a href="/">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    @endif
                    {{-- Departement Teknikal --}}
                    @if (Auth::user()->departement_id == 4)
                        <li id="jadwal">
                            <a href="javascript:;">
                                <i class="icon-calendar"></i>
                                <span class="title">Jadwal</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                @if (Auth::user()->jabatan_id == 1 || Auth::user()->jabatan_id == 3)
                                    <li id="calendar-page">
                                        <a href="{{ URL('calendar') }}">
                                            <i class="icon-calendar"></i>
                                            Kalender</a>
                                    </li>
                                @endif
                                @if (Auth::user()->jabatan_id == 2 || Auth::user()->jabatan_id == 3)
                                    <li id="timeline-chart">
                                        <a href="{{ URL('timeline') }}">
                                            <i class="icon-bar-chart"></i>
                                            Project Timeline</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li id="vehicle">
                            <a href="javascript:;">
                                <i class="icon-magnifier"></i>
                                <span class="title">Kendaraan</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                @if (Auth::user()->jabatan_id == 2 || Auth::user()->jabatan_id == 3)
                                    <li id="dataKendaraan">
                                        <a href="{{ URL('/vehicle') }}">
                                            <i class="icon-book-open"></i>
                                            Data Kendaraan</a>
                                    </li>
                                    <li id="dataBengkel">
                                        <a href="{{ route('workshop.index') }}">
                                            <i class="icon-book-open"></i>
                                            Data Bengkel</a>
                                    </li>
                                    <li id="historyPeminjaman">
                                        <a href="{{ route('vehicle.historyRentAdmin') }}">
                                            <i class="icon-refresh"></i>
                                            Riwayat Peminjaman Kendaraan</a>
                                    </li>
                                    <li id="service">
                                        <a href="{{ route('vehicle.admService') }}">
                                            <i class="icon-refresh"></i>
                                            Riwayat Servis Kendaraan</a>
                                    </li>
                                @endif
                                <li id="peminjamanKendaraan">
                                    <a href="{{ route('vehicle.historyRent') }}">
                                        <i class="icon-clock"></i>
                                        Peminjaman Kendaraan</a>
                                </li>
                                <li id="serviceTeknisi">
                                    <a href="{{ route('vehicle.techService') }}">
                                        <i class="icon-wrench"></i>
                                        Servis Kendaraan</a>
                                </li>
                            </ul>
                        </li>
                        @if (Auth::user()->jabatan_id == 2 || Auth::user()->jabatan_id == 3)
                            <li id="project">
                                <a href="javascript:;">
                                    <i class="icon-briefcase"></i>
                                    <span class="title">Project</span>
                                    <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    <li id="dataProject">
                                        <a href="{{ URL('/project') }}">
                                            <i class="icon-book-open"></i>
                                            Data Project</a>
                                    </li>
                                    <li id="dataDevice">
                                        <a href="{{ URL('/device') }}">
                                            <i class="icon-book-open"></i>
                                            Data Barang</a>
                                    </li>
                                    <li id="dataCustomer">
                                        <a href="{{ URL('/customer') }}">
                                            <i class="icon-book-open"></i>
                                            Data Pelanggan</a>
                                    </li>
                                    <li id="projectAssign">
                                        <a href="{{ URL('/assign') }}">
                                            <i class="fa fa-users"></i>
                                            Assignment</a>
                                    </li>
                                    @if (Auth::user()->jabatan_id == 3)
                                        <li id="dashboardTeknisi">
                                            <a href="{{ URL('/user') }}">
                                                <i class="icon-home"></i>
                                                <span class="title">Dashboard Teknisi</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul>

                <!-- END SIDEBAR MENU -->
            </div>
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                {{-- <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true"></button>
                                <h4 class="modal-title">Modal title</h4>
                            </div>
                            <div class="modal-body">
                                Widget settings form goes here
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success">Save changes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div> --}}
                <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <!-- BEGIN STYLE CUSTOMIZER -->
                <div class="theme-panel hidden-xs hidden-sm">
                    <div class="toggler">
                        <i class="fa fa-gear"></i>
                    </div>
                    <div class="theme-options">
                        <div class="theme-option theme-colors clearfix">
                            <span>
                                Theme Color </span>
                            <ul>
                                <li class="color-black current color-default tooltips" data-style="default"
                                    data-original-title="Default">
                                </li>
                                <li class="color-grey tooltips" data-style="grey" data-original-title="Grey">
                                </li>
                                <li class="color-blue tooltips" data-style="blue" data-original-title="Blue">
                                </li>
                                <li class="color-red tooltips" data-style="red" data-original-title="Red">
                                </li>
                                <li class="color-light tooltips" data-style="light" data-original-title="Light">
                                </li>
                            </ul>
                        </div>
                        <div class="theme-option">
                            <span>
                                Layout </span>
                            <select class="layout-option form-control input-small">
                                <option value="fluid" selected="selected">Fluid</option>
                                <option value="boxed">Boxed</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span>
                                Header </span>
                            <select class="header-option form-control input-small">
                                <option value="fixed" selected="selected">Fixed</option>
                                <option value="default">Default</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span>
                                Sidebar </span>
                            <select class="sidebar-option form-control input-small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected="selected">Default</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span>
                                Sidebar Position </span>
                            <select class="sidebar-pos-option form-control input-small">
                                <option value="left" selected="selected">Left</option>
                                <option value="right">Right</option>
                            </select>
                        </div>
                        <div class="theme-option">
                            <span>
                                Footer </span>
                            <select class="footer-option form-control input-small">
                                <option value="fixed">Fixed</option>
                                <option value="default" selected="selected">Default</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- END BEGIN STYLE CUSTOMIZER -->
                <!-- BEGIN PAGE HEADER-->
                <h3 class="page-title">
                    @yield('title')
                </h3>
                <!-- <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="index.html">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="#" onclick="showInfo()">
                                <i class="icon-bulb"></a></i>
                        </li>
                    </ul>
                    <div class="page-toolbar">
                        <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height btn-primary"
                            data-container="body" data-placement="bottom"
                            data-original-title="Change dashboard date range">
                            <i class="icon-calendar"></i>&nbsp; <span
                                class="thin uppercase visible-lg-inline-block"></span>&nbsp; <i
                                class="fa fa-angle-down"></i>
                        </div>
                    </div>
                </div> -->
                <br>
                <div id='showinfo'></div>
                @yield('isi')
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="footer">
        <div class="footer-inner">
            2023 &copy; Conquer by Intern Boys.
        </div>
        <div class="footer-tools">
            <span class="go-top">
                <i class="fa fa-angle-up"></i>
            </span>
        </div>
    </div>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    {{-- <script src="{{ asset('assets/plugins/jquery-1.11.0.min.js') }} " type="text/javascript"></script> --}}
    {{-- <script src="{{ asset('assets/plugins/jquery-migrate-1.2.1.min.js') }} " type="text/javascript"></script> --}}
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-migrate-3.4.1.min.js') }} " type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }} "
        type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }} " type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/jquery.blockui.min.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/uniform/jquery.uniform.min.js') }} " type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('assets/plugins/jqvmap/jqvmap/jquery.vmap.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js') }} " type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/jquery.peity.min.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery.pulsate.min.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/jquery-knob/js/jquery.knob.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/flot/jquery.flot.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/flot/jquery.flot.resize.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/moment.min.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }} " type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/gritter/js/jquery.gritter.js') }} " type="text/javascript"></script>
    <!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
    {{-- <script src="{{ asset('assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js') }} " type="text/javascript">
    </script> --}}
    <script src="{{ asset('assets/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }} " type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins/jquery.sparkline.min.js') }} " type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    {{-- FUllCalendar --}}
    <script src="{{ asset('js/fullcalendarCore.global.min.js') }}" type="text/javascript"></script>
    {{-- End FullCalendar --}}
    {{-- Frappe Gantt Chart --}}
    <script src="{{ asset('js/frappe-gantt.min.js') }}" type="text/javascript"></script>
    {{-- End Frappe Gantt Chart --}}
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('assets/scripts/app.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/index.js') }} " type="text/javascript"></script>
    <script src="{{ asset('assets/scripts/tasks.js') }} " type="text/javascript"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }} " type="text/javascript"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.js"></script>
    <!-- Bootstrap DateTimePicker JS -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- <script src="{{ asset('js/yearpicker.js') }}" type="text/javascript"></script> --}}

    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            App.init(); // initlayout and core plugins
            Index.init();
            Index.initJQVMAP(); // init index page's custom scripts
            Index.initCalendar(); // init index page's custom scripts
            Index.initCharts(); // init index page's custom scripts
            Index.initChat();
            Index.initMiniCharts();
            Index.initPeityElements();
            Index.initKnowElements();
            Index.initDashboardDaterange();
            Tasks.initDashboardWidget();
            $('#myTable').DataTable();

        });
    </script>
    @yield('javascript')
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>
