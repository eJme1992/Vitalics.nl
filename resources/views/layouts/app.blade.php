<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <!-- Meta, title, CSS, favicons, etc. -->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="{{ asset('') }}panel/logo2.png" type="image/ico" />
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>{{ config('app.name', 'Laravel') }}</title>
      <!-- Bootstrap -->
      <link href="{{ asset('') }}panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="{{ asset('') }}panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('') }}plugins/iconos/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <!-- NProgress -->
      <link href="{{ asset('') }}panel/vendors/nprogress/nprogress.css" rel="stylesheet">
      <!-- iCheck -->
      <link href="{{ asset('') }}panel/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
      <!-- bootstrap-progressbar -->
      <link href="{{ asset('') }}panel/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
      <!-- JQVMap -->
      <link href="{{ asset('') }}panel/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
      <link href="{{ asset('') }}panel/vendors/starrr/dist/starrr.css" rel="stylesheet">
      <!-- bootstrap-daterangepicker -->
      <link href="{{ asset('') }}panel/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
      <link href="{{asset('')}}panel/vendors/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet">
      <link href="{{asset('')}}panel/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet">

      <!-- Datatables -->
      <link href="{{asset('')}}panel/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
      <link href="{{asset('')}}panel/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
      <link href="{{asset('')}}panel/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
      <link href="{{asset('')}}panel/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
      <link href="{{asset('')}}panel/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

      <!-- Custom Theme Style -->
      <link href="{{ asset('') }}panel/build/css/custom.min.css" rel="stylesheet">
      <link href="{{ asset('') }}panel/build/css/custom.css" rel="stylesheet">
      <style type="text/css">
         .img-circle.profile_img {
         width: 80%;
         height: 60px;
         }
         .main_menu .fas {
         width: 35px;
         opacity: .99;
         display: inline-block;
         font-family: FontAwesome;
         font-style: normal;
         font-weight: normal;
         font-size: 18px;
         -webkit-font-smoothing: antialiased;
         -moz-osx-font-smoothing: grayscale;
         }
         .logo{
            width: 100%;
            display: block;
         }
         .logo2{
            width: 85%;
            display: none;
         }
         @media only screen and (max-width: 600px) {
         .logo {
          display: none;
          }
          .logo2{
            display: block;
         }
          }
      </style>
      <script type="text/javascript">
      function myFunction() {
        var x = document.getElementById("logo");
        var y = document.getElementById("logo2");
       if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
       } else {
        x.style.display = "none";
        y.style.display = "block";
       }
}
      </script>
   </head>
   <body class="nav-md">
      <div class="container body">
         <div class="main_container">
            <div class="col-md-3 left_col">
               <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;">
                     <a href="{{ url('/') }}" class="site_title">
                     <img src="{{url('/')}}/panel/logo.png" class="logo" id="logo">
                     <img src="{{url('/')}}/panel/logo2.png" class="logo2" id="logo2">
                     </a>
                  </div>
                  <div class="clearfix"></div>
                  <!-- menu profile quick info -->
                  <div class="profile clearfix">
                     <div class="profile_pic">
                        <a href="{{route('usuarios.show', Auth::user()->id)}}">
                        @if(Auth::user()->profile == '')
                        <img src="{{url('/')}}/img/profile.png" class="img-circle profile_img" >
                        @else
                        <img src="{{url('/')}}{{Auth::user()->profile }}"   alt="{{ Auth::user()->name }}" class="img-circle profile_img">
                        @endif
                       </a>
                     </div>
                     <div class="profile_info">
                        @if(Auth::user()->model == 'juridico')
                        <span><b>User type:</b> Company</span>
                        @else
                        <span><b>User type:</b> employee</span>
                        @endif
                        <a href="{{route('usuarios.show', Auth::user()->id)}}">
                        <h2>{{ Auth::user()->name }}</h2>
                        </a>
                     </div>
                  </div>
                  <!-- /menu profile quick info -->
                  <hr/>
                  <!-- sidebar menu -->
                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                     <div class="menu_section">
                        <h3>Options</h3>
                        @if(Auth::user()->model == 'juridico')
                        <ul class="nav side-menu">
                           <li><a href="{{url('/home')}}"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;Home</span></a></li>
                           <li>
                              <a><i class="fas fa-user"></i> Employees <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="{{route('empresas.index')}}">Roster</a></li>
                                 <li><a href="{{route('usuarios.index')}}">Invite employees</a></li>
                              </ul>
                           </li>
                           <li>
                              <a><i class="fas fa-suitcase"></i> Services <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="{{route('servicios.index')}}">Mis servicios</a></li>
                                 <!-- <li><a href="#">Nuevo empleado</a></li> -->
                              </ul>
                           </li>

                           <li>
                              <a><i class="fas fa-shopping-bag"></i> Store points</span></a>
                               <ul class="nav child_menu">
                                 <li><a href="{{route('point.create')}}">Comprar Puntos</a></li>
                               </ul>
                           </li>
                        </ul>
                        @else
                        <ul class="nav side-menu">
                           <li><a href="{{url('/home')}}"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;&nbsp;Home</span></a></li>
                    
                            <li>
                              <a><i class="fas fa-suitcase"></i> Services <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                 <li><a href="{{route('servicios.index')}}">Mis servicios</a></li>
                                 <!-- <li><a href="#">Nuevo empleado</a></li> -->
                              </ul>
                           </li>
                             <li>
                              <a><i class="fas fa-shopping-bag"></i> Store points</span></a>
                               <ul class="nav child_menu">
                                 <li><a href="{{route('point.create')}}">Comprar Puntos</a></li>
                               </ul>
                           </li>
                        </ul>
                        @endif
                         <ul class="nav side-menu">
                           <li><a href="{{url('/')}}"><i class="fas fa-shopping-cart"></i> Shop</span></a></li>
                        </ul>
                     </div>
                  </div>
                  <!-- /sidebar menu -->
                  <!-- /menu footer buttons -->
                  <div class="sidebar-footer hidden-small">
                     <a data-toggle="tooltip" data-placement="top" title="Settings">
                     <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                     </a>
                     <!--  <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a> -->
                     <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                     </a>
                  </div>
                  <!-- /menu footer buttons -->
               </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
               <div class="nav_menu">
                  <nav>
                     <div class="nav toggle">
                        <a id="menu_toggle" onclick="myFunction()"><i class="fa fa-bars"></i></a>
                     </div>
                     <ul class="nav navbar-nav navbar-right">
                        <li class="">
                           @guest
                        <li class="nav-item">
                           <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                           <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->profile  == '')
                        <img src="{{url('/')}}/img/profile.png" >
                        @else
                        <img src="{{Auth::user()->profile }}"   alt="{{ Auth::user()->name }}">
                        @endif
                        {{ Auth::user()->name }}
                        <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                           <li><a href="{{route('usuarios.show', Auth::user()->id)}}"> Profile</a></li>
                           <li>
                              <a href="{{route('usuarios.edit', Auth::user()->id)}}">
                                 <span>Edit profile</span>
                              </a>
                           </li>
                           <!--<li><a href="javascript:;">Help</a></li>-->
                           <li>
                              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                              <i class="fa fa-sign-out pull-right"></i>Cerrar sesión</a>
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 @csrf
                              </form>
                           </li>
                        </ul>
                        @endguest
                        </li>
                        <li role="presentation" class="dropdown">
                           <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                           <i class="fa fa-envelope-o"></i>
                           @if(countNoti(Auth::user()->id) > 0 )
                           <span class="badge bg-green">{{ countNoti(Auth::user()->id) }}</span>
                           @endif
                           </a>
                           <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                              @if( $notificaciones = notificaciones(Auth::user()->id))

                                 @foreach($notificaciones as $notificacion)

                                    <li>
                                       <a href="{{url($notificacion->url)}}">
                                          <span class="message">
                                             {{$notificacion->mensaje}}
                                          </span>
                                       </a>
                                    </li>

                                 @endforeach
                              @else
                                 No hay notificaciones
                              @endif

                              <li>
                                 <a>
                                 <span class="image"><img src="{{ asset('') }}panel/production/images/img.jpg" alt="Profile Image" /></span>
                                 <span>
                                 <span>John Smith</span>
                                 <span class="time">3 mins ago</span>
                                 </span>
                                 <span class="message">
                                 Film festivals used to be do-or-die moments for movie makers. They were where...
                                 </span>
                                 </a>
                              </li>
                              <li>
                                 <a>
                                 <span class="image"><img src="{{ asset('') }}panel/production/images/img.jpg" alt="Profile Image" /></span>
                                 <span>
                                 <span>John Smith</span>
                                 <span class="time">3 mins ago</span>
                                 </span>
                                 <span class="message">
                                 Film festivals used to be do-or-die moments for movie makers. They were where...
                                 </span>
                                 </a>
                              </li>
                              <li>
                                 <a>
                                 <span class="image"><img src="{{ asset('') }}panel/production/images/img.jpg" alt="Profile Image" /></span>
                                 <span>
                                 <span>John Smith</span>
                                 <span class="time">3 mins ago</span>
                                 </span>
                                 <span class="message">
                                 Film festivals used to be do-or-die moments for movie makers. They were where...
                                 </span>
                                 </a>
                              </li>
                              <li>
                                 <a>
                                 <span class="image"><img src="{{ asset('') }}panel/production/images/img.jpg" alt="Profile Image" /></span>
                                 <span>
                                 <span>John Smith</span>
                                 <span class="time">3 mins ago</span>
                                 </span>
                                 <span class="message">
                                 Film festivals used to be do-or-die moments for movie makers. They were where...
                                 </span>
                                 </a>
                              </li>
                              <li>
                                 <div class="text-center">
                                    <a>
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                    </a>
                                 </div>
                              </li>
                           </ul>
                        </li>
                     </ul>
                  </nav>
               </div>
            </div>
            <!-- /top navigation -->
            <!-- page content -->
            <div class="right_col" role="main">
               @yield('content')
            </div>
            <!-- /page content -->
            <!-- footer content -->
            <footer>
               <div class="pull-right">
                  Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
               </div>
               <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
         </div>
      </div>
     
      <!-- jQuery -->
      <script src="{{ asset('') }}panel/vendors/jquery/dist/jquery.min.js"></script>
      <!-- Bootstrap -->
      <script src="{{ asset('') }}panel/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
      <!-- FastClick -->
      <script src="{{ asset('') }}panel/vendors/fastclick/lib/fastclick.js"></script>
      <!-- NProgress -->
      <script src="{{ asset('') }}panel/vendors/nprogress/nprogress.js"></script>
      <!-- Chart.js -->
      <script src="{{ asset('') }}panel/vendors/Chart.js/dist/Chart.min.js"></script>
      <!-- gauge.js -->
      <script src="{{ asset('') }}panel/vendors/gauge.js/dist/gauge.min.js"></script>
      <!-- bootstrap-progressbar -->
      <script src="{{ asset('') }}panel/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
      <!-- iCheck -->
      <script src="{{ asset('') }}panel/vendors/iCheck/icheck.min.js"></script>
      <!-- Skycons -->
      <script src="{{ asset('') }}panel/vendors/skycons/skycons.js"></script>
      <!-- Flot -->
      <script src="{{ asset('') }}panel/vendors/Flot/jquery.flot.js"></script>
      <script src="{{ asset('') }}panel/vendors/Flot/jquery.flot.pie.js"></script>
      <script src="{{ asset('') }}panel/vendors/Flot/jquery.flot.time.js"></script>
      <script src="{{ asset('') }}panel/vendors/Flot/jquery.flot.stack.js"></script>
      <script src="{{ asset('') }}panel/vendors/Flot/jquery.flot.resize.js"></script>
      <!-- Flot plugins -->
      <script src="{{ asset('') }}panel/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
      <script src="{{ asset('') }}panel/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
      <script src="{{ asset('') }}panel/vendors/flot.curvedlines/curvedLines.js"></script>
      <!-- DateJS -->
      <script src="{{ asset('') }}panel/vendors/DateJS/build/date.js"></script>
      <!-- JQVMap -->
      <script src="{{ asset('') }}panel/vendors/jqvmap/dist/jquery.vmap.js"></script>
      <script src="{{ asset('') }}panel/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
      <script src="{{ asset('') }}panel/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
      <!-- bootstrap-daterangepicker -->
      <script src="{{ asset('') }}panel/vendors/starrr/dist/starrr.js"></script>
      <script src="{{ asset('') }}panel/vendors/switchery/dist/switchery.min.js"></script>
      <script src="{{ asset('') }}panel/vendors/moment/min/moment.min.js"></script>
      <script src="{{ asset('') }}panel/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
      <script src="{{ asset('') }}panel/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
      <script src="{{asset('')}}panel/vendors/validator/validator.js"></script>
      <script src="{{asset('')}}panel/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
      <!-- Datatables -->
    <script src="{{ asset('') }}panel/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="{{ asset('') }}panel/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/jszip/dist/jszip.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset('') }}panel/vendors/pdfmake/build/vfs_fonts.js"></script>
      <!-- Custom Theme Scripts -->
      <script src="{{ asset('') }}panel/build/js/custom.min.js"></script>

      <script src="https://checkout.stripe.com/checkout.js"></script>

       @yield('footer')
   </body>
</html>
