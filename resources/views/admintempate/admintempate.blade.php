<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سهل - لوحة تحكم التطبيق </title>
    <link href={{asset("css/bootstrap.min.css")}} rel="stylesheet">
    <meta name="google-site-verification" content="hYgsIi14Fac8-Pvr4_rt7oshb94W4dfW2tDaZmtiv4c"/>
    <!-- MetisMenu CSS -->
    <link href={{asset("css/plugins/metisMenu/metisMenu.min.css")}} rel="stylesheet">

    <!-- Timeline CSS -->
    <link href={{asset("css/plugins/timeline.css")}} rel="stylesheet">

    <!-- Custom CSS -->
    <link href={{asset(("css/sb-admin-2.css"))}} rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href={{asset("css/plugins/morris.css")}} rel="stylesheet">

    <!-- Custom Fonts -->
    <link href={{asset("vendor/font-awesome-4.7.0/css/font-awesome.min.css")}} rel="stylesheet" type="text/css">

    {{--vue element--}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    {{--<link rel="stylesheet" href="//unpkg.com/element-ui/lib/theme-chalk/index.css">--}}
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="//unpkg.com/element-ui@2.3.9/lib/theme-chalk/index.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    @yield('page-style-level')
</head>

<body>


{{--side bar and header start--}}

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" id="template" role="navigation" style="margin-bottom: 0">

        <ul class="nav navbar-top-links navbar-right">
            <img width="30" height="30" src="http://www.shl-app.com/wp-content/uploads/Group-1663.png"
                 class="img-responsive" alt="تطبيق سهل "/>
        </ul>

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:;">لوحة تحكم التطبيق </a>
        </div>
        <div class="navbar-header">

            <a style="margin-top:7px ; " class="btn btn-warning" href="{{ route('logout') }}"><i class="fa fa-sign-out">
                    &nbsp;خروج</i> </a>
        </div>
        <!-- /.navbar-header -->


        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">

                    {{--<li>--}}
                    {{--<a href="#"><i class="fa fa-mobile fa-fw"></i> <span class="fa arrow"></span>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-second-level">--}}

                    {{--</ul>--}}
                    {{--<!-- /.nav-second-level -->--}}
                    {{--</li>--}}

                    @can('manager.view',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/manager')}}><i class="fa fa-product-hunt"></i>اداره حسابات المسئولين</a></li>
                        <li><a href={{url('/role')}}><i class="fa fa-product-hunt"></i>اداره الوظائف </a></li>
                    @endcan


                    @can('services.view',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/services')}}><i class="fa fa-product-hunt"></i> الخدمات</a></li>
                    @endcan

                    @can('clients.create',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/clients')}}><i class="fa fa-product-hunt"></i>اداره حسابات الاعضاء</a></li>
                    @endcan

                    @can('providers.create',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/providers')}}><i class="fa fa-product-hunt"></i>اداره حسابات الموظفين</a></li>
                    @endcan


                    <li><a href={{url('/requests')}}><i class="fa fa-product-hunt"></i>طلبات الانضمام للفريق</a></li>

                    @can('services.price',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/services_prices')}}><i class="fa fa-product-hunt"></i> اسعار الخدمات</a></li>
                    @endcan

                    @can('polls.view',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/polls')}}><i class="fa fa-product-hunt"></i>صفحه الاستبيان</a></li>
                    @endcan


                    <li><a href={{url('/zones')}}><i class="fa fa-product-hunt"></i>اضافه مناطق</a></li>

                    @can('reports.services',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/reports')}}><i class="fa fa-product-hunt"></i>لوحة تقارير الخدمات</a></li>
                    @endcan
                    @can('reports.providers',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/providerReports')}}><i class="fa fa-product-hunt"></i>لوحة تقارير مزودي الخدمه</a></li>
                    @endcan
                    @can('reports.followproviders',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/followProviders')}}><i class="fa fa-product-hunt"></i>تتبع نظام الرحلات  </a></li>
                    @endcan

                    @can('other.contact',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/contact_us')}}><i class="fa fa-product-hunt"></i> التواصل مع الادارة </a></li>
                    @endcan
                    @can('other.condition',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/social_media')}}><i class="fa fa-product-hunt"></i> مواقع التواصل الاجتماعى </a>
                    </li>
                    @endcan
                    @can('other.social',\Illuminate\Support\Facades\Auth::user())
                    <li><a href={{url('/services_terms')}}><i class="fa fa-product-hunt"></i> احكام وشروط الخدمات </a>
                    </li>
                        @endcan
                </ul>
                <center>
                    Powered by <a href="http://alexforprog.com" target="_blank">AlexApps</a>
                </center>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    {{--side bar and header end--}}
    <div id="page-wrapper">
        @yield('content')
    </div>
</div>


<!-- jQuery Version 1.11.0 -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src={{asset("js/jquery-1.11.0.js")}}></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

{{--<!-- Bootstrap Core JavaScript -->--}}
<script src={{asset("js/bootstrap.min.js")}}></script>

{{--<!-- Metis Menu Plugin JavaScript -->--}}
<script src={{asset("js/metisMenu/metisMenu.min.js")}}></script>

{{--<!-- Morris Charts JavaScript -->--}}
<script src={{asset("js/raphael/raphael.min.js")}}></script>
<script src={{asset("js/morris/morris.min.js")}}></script>
<script src={{asset("js/julien-maurel-jQuery-Storage-API-f435d2c/jquery.storageapi.min.js")}}></script>

{{--<!-- Custom Theme JavaScript -->--}}


{{--<script src={{asset("js/sb-admin-2.js")}}></script>--}}


{{--<!-- Custom scripts for this page-->--}}
<script src="{{asset("vendor/underscore-1.8.3/underscore-min.js")}}"></script>
<script src={{asset("vendor/vue/vue.js")}}></script>
{{--vue element js--}}
{{--<script src="//unpkg.com/element-ui/lib/index.js"></script>--}}
<script src="https://unpkg.com/element-ui/lib/index.js"></script>

<script src="//unpkg.com/element-ui/lib/umd/locale/en.js"></script>
<script src="//unpkg.com/vue-data-tables@3.0.1/dist/data-tables.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
{{--<script src={{asset("AdminScript/.js")}}></script>--}}
@yield('page-script-level')


</body>
</html>
