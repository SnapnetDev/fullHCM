<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HCMatrix Time & Attendance') }}</title>
  <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-touch-icon.png') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{ asset('global/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('global/css/bootstrap-extend.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/site.css') }}">
  <!-- Plugins -->
  <link rel="stylesheet" href="{{ asset('global/vendor/animsition/animsition.css') }}">
  <link rel="stylesheet" href="{{ asset('global/vendor/asscrollable/asScrollable.css') }}">
  <link rel="stylesheet" href="{{ asset('global/vendor/switchery/switchery.css') }}">
  <link rel="stylesheet" href="{{ asset('global/vendor/intro-js/introjs.css') }}">
  <link rel="stylesheet" href="{{ asset('global/vendor/slidepanel/slidePanel.css') }}">
  <link rel="stylesheet" href="{{ asset('global/vendor/flag-icon-css/flag-icon.css') }}">
  <link rel="stylesheet" href="{{ asset('global/vendor/waves/waves.css') }}">

  <link rel="stylesheet" href="{{ asset('global/vendor/toastr/toastr.css') }}">
  @yield('stylesheets')
  
  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('global/fonts/font-awesome/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('global/fonts/material-design/material-design.min.css') }}">
  <link rel="stylesheet" href="{{ asset('global/fonts/brand-icons/brand-icons.min.css') }}">
  
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  <!--[if lt IE 9]>
    <script src="{{ asset('global/vendor/html5shiv/html5shiv.min.js') }}"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <script src="{{ asset('global/vendor/media-match/media.match.min.js') }}"></script>
    <script src="{{ asset('global/vendor/respond/respond.min.js') }}"></script>
    <![endif]-->
  <!-- Scripts -->
  <style type="text/css">
     .select2-container--open{
        z-index:9999999;        
    }
  </style>
  <script src="{{ asset('global/vendor/breakpoints/breakpoints.js') }}"></script>
  <script>
  Breakpoints();
  </script>
</head>
<body class="animsition site-navbar-small app-contacts page-aside-left">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  <nav class="site-navbar navbar navbar-inverse bg-light-blue-500 navbar-fixed-top navbar-mega" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
      data-toggle="menubar">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger-bar"></span>
      </button>
      <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
      data-toggle="collapse">
        <i class="icon md-more" aria-hidden="true"></i>
      </button>
      <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
        <a href="{{ route('home') }}" style="color: #fff;text-decoration: none">
        <img class="navbar-brand-logo" src="{{ asset('assets/images/logo.png') }}" title="HCMatrix Time & Attendance">
        <span class="navbar-brand-text hidden-xs-down"> HCMatrix</span>
        </a>
      </div>
      <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search"
      data-toggle="collapse">
        <span class="sr-only">Toggle Search</span>
        <i class="icon md-search" aria-hidden="true"></i>
      </button>
    </div>
    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <!-- Navbar Toolbar -->
        <ul class="nav navbar-toolbar">
          <li class="nav-item hidden-float" id="toggleMenubar">
            <a class="nav-link" data-toggle="menubar" href="#" role="button">
              <i class="icon hamburger hamburger-arrow-left">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
            </a>
          </li>
          <li class="nav-item hidden-sm-down" id="toggleFullscreen">
            <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
              <span class="sr-only">Toggle fullscreen</span>
            </a>
          </li>
          <li class="nav-item hidden-float">
            <a class="nav-link icon md-search" data-toggle="collapse" href="#" data-target="#site-navbar-search"
            role="button">
              <span class="sr-only">Toggle Search</span>
            </a>
          </li>
          
        </ul>
        <!-- End Navbar Toolbar -->
        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
          <li class="nav-item hidden-sm-down" id="toggleFullscreen">
            <a class="nav-link "  href="#" role="button" style="font-size: 16px;">
              {{parentCompany()}}
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" data-animation="scale-up"
            aria-expanded="false" role="button">
              <span class="flag-icon flag-icon-us"></span>
            </a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                <span class="flag-icon flag-icon-gb"></span> English</a>
              <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                <span class="flag-icon flag-icon-fr"></span> French</a>
              <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                <span class="flag-icon flag-icon-cn"></span> Chinese</a>
              <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                <span class="flag-icon flag-icon-de"></span> German</a>
              <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                <span class="flag-icon flag-icon-nl"></span> Dutch</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
            data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
                <img src="../../../../global/portraits/5.jpg" alt="...">
                <i></i>
              </span>
            </a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" href="{{ route('users.edit',['id'=>Auth::user()->id]) }}" role="menuitem"><i class="icon md-account" aria-hidden="true"></i> Profile</a>
              <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon md-settings" aria-hidden="true"></i> Settings</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}"  role="menuitem" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="icon md-power" aria-hidden="true"></i> {{ __('Logout') }}</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Notifications"
            aria-expanded="false" data-animation="scale-up" role="button">
              <i class="icon md-notifications" aria-hidden="true"></i>
              <span class="tag tag-pill tag-danger up">5</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
              <div class="dropdown-menu-header">
                <h5>NOTIFICATIONS</h5>
                <span class="tag tag-round tag-danger">New 5</span>
              </div>
              <div class="list-group">
                <div data-role="container">
                  <div data-role="content">
                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left p-r-10">
                          <i class="icon md-receipt bg-red-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">A new order has been placed</h6>
                          <time class="media-meta" datetime="2016-06-12T20:50:48+08:00">5 hours ago</time>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left p-r-10">
                          <i class="icon md-account bg-green-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Completed the task</h6>
                          <time class="media-meta" datetime="2016-06-11T18:29:20+08:00">2 days ago</time>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left p-r-10">
                          <i class="icon md-settings bg-red-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Settings updated</h6>
                          <time class="media-meta" datetime="2016-06-11T14:05:00+08:00">2 days ago</time>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left p-r-10">
                          <i class="icon md-calendar bg-blue-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Event started</h6>
                          <time class="media-meta" datetime="2016-06-10T13:50:18+08:00">3 days ago</time>
                        </div>
                      </div>
                    </a>
                    <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                      <div class="media">
                        <div class="media-left p-r-10">
                          <i class="icon md-comment bg-orange-600 white icon-circle" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Message received</h6>
                          <time class="media-meta" datetime="2016-06-10T12:34:48+08:00">3 days ago</time>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <div class="dropdown-menu-footer">
                <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                  <i class="icon md-settings" aria-hidden="true"></i>
                </a>
                <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                    All notifications
                  </a>
              </div>
            </div>
          </li>
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->
      <!-- Site Navbar Seach -->
      <div class="collapse navbar-search-overlap" id="site-navbar-search">
        <form role="search">
          <div class="form-group">
            <div class="input-search">
              <i class="input-search-icon md-search" aria-hidden="true"></i>
              <input type="text" class="form-control" name="site-search" placeholder="Search...">
              <button type="button" class="input-search-close icon md-close" data-target="#site-navbar-search"
              data-toggle="collapse" aria-label="Close"></button>
            </div>
          </div>
        </form>
      </div>
      <!-- End Site Navbar Seach -->
    </div>
  </nav>
  @include('layouts.nav')
  @yield('content')
  
  <!-- Footer -->
  <footer class="site-footer">
    <div class="site-footer-legal">© {{date('Y')}}<a href=""> Snapnet</a></div>
    
  </footer>
  <!-- Core  -->
  <script src="{{ asset('global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
  <script src="{{ asset('global/vendor/jquery/jquery.js') }}"></script>
  <script src="{{ asset('global/vendor/tether/tether.js') }}"></script>
  <script src="{{ asset('global/vendor/bootstrap/bootstrap.js') }}"></script>
  <script src="{{ asset('global/vendor/animsition/animsition.js') }}"></script>
  <script src="{{ asset('global/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
  <script src="{{ asset('global/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
  <script src="{{ asset('global/vendor/asscrollable/jquery-asScrollable.js') }}"></script>
  <script src="{{ asset('global/vendor/waves/waves.js') }}"></script>
  <!-- Plugins -->
  <script src="{{ asset('global/vendor/switchery/switchery.min.js') }}"></script>
  <script src="{{ asset('global/vendor/intro-js/intro.js') }}"></script>
  <script src="{{ asset('global/vendor/screenfull/screenfull.js') }}"></script>
  <script src="{{ asset('global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
  <script src="{{ asset('global/vendor/tablesaw/tablesaw.jquery.js') }}"></script>
  <script src="{{ asset('global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
  <script src="{{ asset('global/vendor/aspaginator/jquery.asPaginator.min.js') }}"></script>
  <script src="{{ asset('global/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
  <script src="{{ asset('global/vendor/bootbox/bootbox.js') }}"></script>
  <!-- Scripts -->
  <script src="{{ asset('global/js/State.js') }}"></script>
  <script src="{{ asset('global/js/Component.js') }}"></script>
  <script src="{{ asset('global/js/Plugin.js') }}"></script>
  <script src="{{ asset('global/js/Base.js') }}"></script>
  <script src="{{ asset('global/js/Config.js') }}"></script>
  <script src="{{ asset('assets/js/Section/Menubar.js') }}"></script>
  <script src="{{ asset('assets/js/Section/Sidebar.js') }}"></script>
  <script src="{{ asset('assets/js/Section/PageAside.js') }}"></script>
  <script src="{{ asset('assets/js/Plugin/menu.js') }}"></script>
  <script src="{{ asset('global/js/config/colors.js') }}"></script>
  <script src="{{ asset('assets/js/config/tour.js') }}"></script>
  <script>
  Config.set('assets', '{{ asset('assets') }}');
  </script>
  <script src="{{ asset('assets/js/Site.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/asscrollable.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/slidepanel.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/switchery.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/tablesaw.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/sticky-header.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/action-btn.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/asselectable.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/editlist.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/aspaginator.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/animate-list.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/jquery-placeholder.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/material.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/selectable.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/bootbox.js') }}"></script>
  <script src="{{ asset('assets/js/BaseApp.js') }}"></script>
  <script src="{{ asset('assets/js/App/Contacts.js') }}"></script>
  <script src="{{ asset('assets/examples/js/apps/contacts.js') }}"></script>

  <script src="{{ asset('global/vendor/toastr/toastr.js') }}"></script>
  <script src="{{ asset('global/js/Plugin/toastr.js') }}"></script>
  @yield('scripts')
   <script type="text/javascript" src="{{ asset('assets/js/jquery.thooClock.js') }}"></script>
    <script type="text/javascript">
        $(function(){
                
         
      $('#clockin').thooClock();
        
      setInterval(function(){
       
         $('#time').html(new Date(new Date().getTime()).toLocaleTimeString());

         
     },1000);
    });
    </script>
  <script type="text/javascript">
         $(function () {
      
        $('.site-menu-item a[href*="{{Request::url()}}"]').parent().addClass('active');
        $('.site-menu-item a[href*="{{Request::url()}}"]').parent().parent().parent().addClass('active').addClass('open');
       }); 
    </script> 
 

</body>
</html>