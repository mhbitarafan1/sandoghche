<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://www.sandoghche.mhbitarafan.ir/users/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://www.sandoghche.mhbitarafan.ir/users/vendors/bootstrap-rtl/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://www.sandoghche.mhbitarafan.ir/users/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="https://www.sandoghche.mhbitarafan.ir/users/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="https://www.sandoghche.mhbitarafan.ir/users/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center text-center">
                @yield('content')
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="https://www.sandoghche.mhbitarafan.ir/users/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://www.sandoghche.mhbitarafan.ir/users/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="https://www.sandoghche.mhbitarafan.ir/users/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="https://www.sandoghche.mhbitarafan.ir/users/vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="https://www.sandoghche.mhbitarafan.ir/users/build/js/custom.min.js"></script>
  </body>
</html>
