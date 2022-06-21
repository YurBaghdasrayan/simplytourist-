<!-- Left Side Of Navbar -->
<ul class="navbar-nav mr-auto">
    <li class="nav-item mr-0 ml-3">
        @guest
            <a class="nav-link {{ route::is('tour*') ? 'active' : '' }}" href="{{route('toursPublic')}}">{{ __('Tours') }}</a>
        @else
            <a class="nav-link" href="/tours">{{ __('Tours') }}</a>
        @endguest
    </li>
    <li class="nav-item mr-0 ml-3">
        @guest
            <a class="nav-link {{ route::is('usergroup*') ? 'active' : '' }}" href="{{route('usergroupsPublic')}}">{{ __('Usergroups') }}</a>
        @else
            <a class="nav-link" href="/usergroups">{{ __('Usergroups') }}</a>
        @endguest
    </li>
    <li class="nav-item mr-0 ml-3">
        @switch(\App::getLocale())
            @case('en')
            <a class="nav-link d-flex how-to-btn {{ Request::segment(3)=='gallery' ? 'active' : '' }}" href="/public/post/gallery">
                {{--                        <i class="mdi mdi-cloud-question"></i>--}}
                {{ __('Gallery') }}
            </a>
            @break

            @case('de')
            <a class="nav-link d-flex how-to-btn {{ Request::segment(3)=='galerie' ? 'active' : '' }}" href="/public/post/galerie">
                {{--                        <i class="mdi mdi-cloud-question"></i>--}}
                {{ __('Gallery') }}
            </a>
            @break

            @case('ru')
            <a class="nav-link d-flex how-to-btn {{ Request::segment(3)=='galereya' ? 'active' : '' }}" href="/public/post/galereya">
                {{--                        <i class="mdi mdi-cloud-question"></i>--}}
                {{ __('Gallery') }}
            </a>
            @break

        @endswitch
    </li>
    <li class="nav-item mr-0 ml-3">
        <a class="nav-link {{ \Request::route()->getName()=='posts' ? 'active' : '' }}" href="{{route('posts')}}">{{ __('Articles') }}</a>
    </li>


    <li class="nav-item mr-0 ml-3">
            @switch(\App::getLocale())
                @case('en')
                    <a class="nav-link d-flex how-to-btn {{ Request::segment(3)=='en-platform-tutorials' ? 'active' : '' }}" href="/public/post/en-platform-tutorials">
{{--                        <i class="mdi mdi-cloud-question"></i>--}}
                         {{ __('HowTo') }}
                    </a>
                @break

                @case('de')
                    <a class="nav-link d-flex how-to-btn {{ Request::segment(3)=='de-platform-tutorials' ? 'active' : '' }}" href="/public/post/de-platform-tutorials">
{{--                        <i class="mdi mdi-cloud-question"></i>--}}
                         {{ __('HowTo') }}
                    </a>
                @break

                @case('ru')
                    <a class="nav-link d-flex how-to-btn {{ Request::segment(3)=='instrukcii-po-platforme' ? 'active' : '' }}" href="/public/post/instrukcii-po-platforme">
{{--                        <i class="mdi mdi-cloud-question"></i>--}}
                         {{ __('HowTo') }}
                    </a>
                @break

            @endswitch
    </li>
    <!-- Authentication Links -->
    @guest
        {{--        @if (Route::has('register'))--}}
        {{--            <li class="nav-item mr-0 ml-3">--}}
        {{--                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
        {{--            </li>--}}
        {{--        @endif--}}
        <li class="nav-item mr-0 ml-3">
            <a class="nav-link  login-btn d-flex" href="{{ route('login') }}">
                {{--                <i class="mdi mdi-login"></i>--}}
                {{ __('Login') }}
            </a>
        </li>
    @else
{{--        <li class="nav-item mr-0 ml-3">--}}
{{--            <a class="nav-link d-flex" href="/home">--}}
{{--                {{ __('Dashboard') }}--}}
{{--            </a>--}}
{{--        </li>--}}

        {{--        <li class="nav-item mr-0 ml-3">--}}
        {{--            <a class="nav-link login-btn d-flex" href="{{ route('logout') }}"--}}
        {{--               onclick="event.preventDefault();--}}
        {{--                                                     document.getElementById('logout-form').submit();">--}}
        {{--                <i class="mdi mdi-logout"></i>--}}
        {{--                {{ __('Logout') }}--}}
        {{--            </a>--}}

        {{--            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
        {{--                @csrf--}}
        {{--            </form>--}}
        {{--        </li>--}}
    @endguest
</ul>

<!-- Right Side Of Navbar -->
<ul class="navbar-nav ml-3 d-lg-block d-none">
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            {{ App::getLocale() }}
        </a>
        <ul class="dropdown-menu">
            @foreach (Config::get('app.locales') as $lang => $language)
                @if ($language != App::getLocale())
                    <li>
                        <a class="dropdown-item"
                           href="{{ route('lang.switch', $language) }}">{{$language}}</a>
                    </li>
                @endif
            @endforeach
        </ul>
    </li>

</ul>
