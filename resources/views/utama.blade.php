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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-switch.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/rowgroup/1.1.3/css/rowGroup.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}">
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />



    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <!-- Bootstrap DateTimePicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

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
            <div class="page-logo" style="display: grid;place-items:start;align-items:center">
                <a href="/" style="display: flex; align-content:center;height:30px;width:30px;">
                    <img src="{{ asset('assets/img/logPOG.jpg') }}"
                        style="height:30px;width:auto; border-radius:2px;margin:0px" alt="logo" />
                </a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <img src="{{ asset('assets/img/menu-toggler.png') }}" alt="" />
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <ul class="nav navbar-nav pull-right">
                <li class="devider">
                    &nbsp;
                </li>
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <img alt="" src="{{ asset('assets/img/avatar3_small.jpg') }}" />
                        <span
                            class="username username-hide-on-mobile">{{ Auth::user()->name }}-{{ Auth::user()->jabatan->name }}-{{ Auth::user()->department->name }}
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
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
                    @if (Auth::user()->jabatan_id != 9)
                        <li id="dashboard" class="start">
                            <a href="/">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    @endif
                    {{-- GM  Keatas & super admin --}}
                    @if (Auth::user()->jabatan_id > 4 && Auth::user()->jabatan_id <= 7)
                        <li id="setting">
                            <a href="/">
                                <i class="fa fa-gear"></i>
                                <span class="title">Setting</span>
                                <span class="selected"></span>
                            </a>
                            <ul class="sub-menu">
                                <li id="hierarchy">
                                    <a href="/hierarchy">
                                        <i class="fa fa-sitemap"></i>
                                        Configure Hierarchy
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (Auth::user()->jabatan_id == 9)
                        <li id="admin">
                            <a href="/">
                                <i class="icon-home"></i>
                                <span class="title">Admin</span>
                                <span class="selected"></span>
                            </a>
                            <ul class="sub-menu">
                                <li id="admindashboard">
                                    <a href="/admindashboard">
                                        <i class="fa fa-sitemap"></i>
                                        Dashboard
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
                <!-- END SIDEBAR MENU -->
            </div>
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
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
                <h3 class="page-title all-content">
                    @yield('title')
                </h3>
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

    <script src="{{ asset('js/bootstrap-switch.min.js') }}" type="text/javascript"></script>

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
        });
    </script>
    @yield('javascript')
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>
