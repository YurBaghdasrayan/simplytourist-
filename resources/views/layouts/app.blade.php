<!DOCTYPE html>
<html>
<head>
    @include('layouts.head_backend')
</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">


            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">

                <!-- Sidebar toggle button-->
                <a class="nav-link d-sm-block d-md-block d-lg-none" data-widget="pushmenu" href="#"><i
                        class="fa fa-bars"></i></a>
                <span></span>
                <div class="navbar-custom-menu float-left d-none d-sm-flex">
                    <ul class="nav navbar-nav float-left ml-4">
                        @stack('breadcrumbs')
                    </ul>
                </div>
                <div class="mx-auto  d-none d-sm-flex"></div>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav d-flex">

                        <!-- User Account Menu -->
                        <li class="nav-link user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#">
                                <!-- The user image in the navbar-->
                                <img alt="{{Auth::user()->name}}" class="user-image m-0"
                                     src="@if((strpos(Auth::user()->avatar,'https://')) !== 0)/storage/@endif{{Auth::user()->avatar}}"
                                     style="max-width: 200px;"/>

                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs text-muted">{{ Auth::user()->name }}</span>

                            </a>

                            <a href="#" class="dropdown-toggle ml-3  text-muted" data-toggle="dropdown">
                                {{ App::getLocale() }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach (Config::get('app.locales') as $lang => $language)
                                    @if ($language != App::getLocale())
                                        <li>
                                            <a class="dropdown-item  text-muted"
                                               href="{{ route('lang.switch', $language) }}">{{$language}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>

                            <a href="{{ url('/profile') }}">
                                <i class="mdi mdi-cog text-muted"></i>
                            </a>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout-variant text-muted"></i>
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
    @include('layouts.sidebar')
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pt-2" id="app">
            @yield('content')
        </div>


    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper" class="mt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endif
@include('layouts.footer_backend')
@stack('scripts')
@include('cookieConsent::index')
</body>
</html>
