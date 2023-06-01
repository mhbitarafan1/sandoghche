<!DOCTYPE html>
<html lang="fa" dir="rtl" style="font-size: 100%;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="fontiran.com:license" content="Y68A9">
    <link rel="icon" href="/users/build/images/favicon.ico" type="image/ico"/>
    <title>صندوقچه | @yield('title')</title>
    <!-- Bootstrap -->
    <link href="/users/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/users/vendors/bootstrap-rtl/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/users/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/users/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="/users/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/users/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="/users/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/users/build/css/custom.min.css" rel="stylesheet">

    @if (auth()->user()->created_at < Carbon\Carbon::now()->subDays(45))
    <script type="text/javascript">
        (function(){
        var now = new Date();
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.async = true;
        var script_address = 'https://cdn.yektanet.com/js/sandoghche.mhbitarafan.ir/native-sandoghche.mhbitarafan.ir-26783.js';
        script.src = script_address + '?v=' + now.getFullYear().toString() + '0' + now.getMonth() + '0' + now.getDate() + '0' + now.getHours();
        head.appendChild(script);
        })();
    </script>
    <script type="text/javascript">
        const head = document.getElementsByTagName("head")[0];
        const script = document.createElement("script");
        script.type = "text/javascript";
        script.async = true;
        script.src = "https://s1.mediaad.org/serve/sandoghche.mhbitarafan.ir/loader.js";
        head.appendChild(script);
    </script>
    @endif

</head>
<!-- /header content -->
<body class="nav-md footer_fixed">

@include('sweetalert::alert')







<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col menu_fixed hidden-print">
            <div class="left_col  scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ route('home') }}" class="site_title">
                        <img width="35" src="/users/build/images/logo/sandoghche.png" alt="">
                        </i> <span>صندوقچه</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <a href="{{ route('profiles.edit',auth()->user()->id) }}" class="profile_pic">
                        <img

                        @if (auth()->user()->avatar_url)
                            src="{{auth()->user()->avatar_url}}"
                        @else
                            src="/users/build/images/profile/user.png"
                        @endif
                         alt="..." class="img-circle profile_img">
                    </a>
                    <div class="profile_info">


                        <h2>موجودی :</h2>
                        <span>{{auth()->user()->cash}} تومان</span>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" >
                    <div class="menu_section" >
                        <h3><span class="badge bg-green">کاربر عادی</span></h3>
                        <ul class="nav side-menu">
                            <li><a href="{{ route('profiles.index') }}"><i class="fa fa-edit"></i>پروفایل
                                {{-- <span class="fa fa-chevron-down"></span> --}}
                            </a>
                                {{-- <ul class="nav child_menu">
                                    <li><a href="{{ route('profiles.index') }}">مشاهده پروفایل</a></li>
                                    <li><a href="{{ route('profiles.edit',auth()->user()->id) }}">ویرایش پروفایل</a></li>
                                    <li><a href="form_advanced.html">عضویت ویژه</a></li>
                                </ul> --}}
                            </li>
                            <li><a href="{{ route('lotteries.index') }}"><i class="fa fa-flash"></i>صندوق ها</a>

                                <li><a href="{{ route('lotteries.create') }}"><i class="fa fa-plus"></i>ایجاد صندوق</a></li>

                            </li>
                            <li><a href="{{ route('payments.index') }}"><i class="fa fa-bar-chart-o"></i>امور مالی
                                {{-- <span class="fa fa-chevron-down"></span> --}}
                            </a>
                                {{-- <ul class="nav child_menu">
                                    <li><a href="{{ route('payments.index') }}">مشاهده لیست تراکنش ها</a></li>
                                    <li><a href="{{ route('checkout.request') }}">درخواست برداشت از حساب</a></li>
                                </ul> --}}
                            </li>
                            <li><a href="{{ route('tickets.index') }}"><i class="fa fa-support"></i>پشتیبانی</a>

                            </li>
                            <li><a href="{{ route('ducument') }}"><i class="fa fa-book"></i>مستندات</a>

                            </li>
                        </ul>
                    </div>


                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="تنظیمات">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="تمام صفحه" onclick="toggleFullScreen();">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="قفل" class="lock_btn">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" data-toggle="tooltip" data-placement="top" title="خروج" >
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>



        <!-- top navigation -->
        <div>
        <div class="top_nav hidden-print">
            <div class="nav_menu" >
                <nav>
                    <div class="nav toggle" >
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        @if (\Request::route()->getName() != "home")
                            <a onclick="history.back()" id="back_btn"><i class="fa fa-arrow-right"></i></a>
                        @endif

                    </div>





                    <ul class="nav navbar-nav navbar-right">
                        <div class="site_name">
                            {{-- <img width="20" src="/users/build/images/logo/sandoghche.png" alt=""> --}}
                            <a href="">@yield('title2')</a>
                        </div>
                        <li class="">
                               <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img
                                @if (auth()->user()->avatar_url)
                                    src="{{auth()->user()->avatar_url}}"
                                @else
                                    src="/users/build/images/profile/user.png"
                                @endif

                                 alt="">

                                 {{-- {{auth()->user()->name }} --}}
                                                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                {{-- <li><a href="{{ route('profiles.index') }}"> پروفایل</a></li> --}}
                                <li><a href="{{ route('profiles.edit',auth()->user()->id) }}"> ویرایش پروفایل</a></li>
                                {{-- <li><a href="{{  route('tickets.index') }}">پشتیبانی نرم افزار</a></li> --}}


                                <li><a href="{{ route('ducument') }}">درباره صندوقچه</a></li>




                                <li><a href="{{  route('donate') }}">حمایت مالی</a></li>
                                {{-- <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>تنظیمات</span>
                                    </a>
                                </li> --}}
                                {{-- <li><a href="{{ route('lotteries.create') }}">ایجاد صندوق</a></li> --}}













                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> خروج</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                </li>
                            </ul>
                        </li>

                        {{-- <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-red">6</span>
                            </a>

                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مهری صادقی راد</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a>
                                            <strong>مشاهده تمام اعلان ها</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li> --}}




                        {{-- <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="badge bg-red">9</span>
                            </a>

                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مهری صادقی راد</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a>
                                            <strong>مشاهده تمام اعلان ها</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li> --}}


                    </ul>
                </nav>
            </div>
        </div>

        <!-- /top navigation -->




        <!-- /header content -->

        @yield('content')

        <!-- footer content -->
        <footer class="hidden-print">
            <div class="pull-left">
                <ul class="nav_bottom" >
                    <li style="text-align: center">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i>
                        <br><span style="font-size: 10px">صندوقچه</span></a>
                    </li>
                    {{-- <a href="{{ route('payments.index') }}"><i class="fa fa-credit-card"></i></a> --}}

                    {{-- <li style="text-align: center">
                        <a href="{{ route('profiles.edit',auth()->user()->id) }}"><i class="fa fa-edit"></i>
                            <br><span style="font-size: 10px">پروفایل</span></a>
                    </li> --}}
                    {{-- <li>
                        <a href="{{ route('ducument') }}"><i class="fa fa-info-circle"></i>
                            <br><span style="font-size: 10px">راهنما</span></a>
                    </li> --}}



                    <li style="text-align: center">
                        <a href="{{ route('tickets.index') }}"><i class="fa fa-envelope"></i>
                        <br><span style="font-size: 10px">پشتیبانی</span></a>
                    </li>

                    <li style="text-align: center">
                        <a href="{{ route('lotteries.create') }}"><i class="fa fa-plus-circle"></i>
                        <br><span style="font-size: 10px">ایجاد</span></a>
                    </li>

                    <li style="text-align: center">
                        <a href="{{ route('payments.index') }}"><i class="fa fa-credit-card"></i>
                        <br><span style="font-size: 10px">مالی</span></a>
                    </li>
                    <li style="text-align: center">
                        <a href="{{ route('my.lotteries') }}"><i class="fa fa-user"></i>
                        <br><span style="font-size: 10px">وام من</span></a>
                    </li>

                </ul>
                {{-- صندوقچه - سیستم مدیریت و اچرای صندوق های وام قرعه کشی --}}
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>
<div id="lock_screen">
    <table>
        <tr>
            <td>
                <div class="clock"></div>
                <span class="unlock">
                    <span class="fa-stack fa-5x">
                      <i class="fa fa-square-o fa-stack-2x fa-inverse"></i>
                      <i id="icon_lock" class="fa fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                </span>
            </td>
        </tr>
    </table>
</div>



@yield('scripts')



<!-- jQuery -->
<script src="/users/vendors/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="/users/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/users/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/users/vendors/nprogress/nprogress.js"></script>
<!-- bootstrap-progressbar -->
<script src="/users/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="/users/vendors/iCheck/icheck.min.js"></script>

<!-- bootstrap-daterangepicker -->
<script src="/users/vendors/moment/min/moment.min.js"></script>

<script src="/users/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Chart.js -->
<script src="/users/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- jQuery Sparklines -->
<script src="/users/vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- gauge.js -->
<script src="/users/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- Skycons -->
<script src="/users/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="/users/vendors/Flot/jquery.flot.js"></script>
<script src="/users/vendors/Flot/jquery.flot.pie.js"></script>
<script src="/users/vendors/Flot/jquery.flot.time.js"></script>
<script src="/users/vendors/Flot/jquery.flot.stack.js"></script>
<script src="/users/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="/users/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="/users/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="/users/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="/users/vendors/DateJS/build/production/date.min.js"></script>
<!-- JQVMap -->
<script src="/users/vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="/users/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="/users/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>

<!-- Custom Theme Scripts -->
<script src="/users/build/js/custom.min.js"></script>

<script type="text/javascript">
if(performance.navigation.type == 2){
   location.reload(true);
}

</script>
<script type="text/javascript">
    $(".panel-heading").click(function ($e) {
        $(".panel-collapse").removeClass("in");
        $($(this).attr("data-href")).addClass("in");
    });
</script>



</body>
</html>
