<li class="nav-item">
    <a href="{{ route('home',['filter[tour_status]'=>'open']) }}"
       class="nav-link {{ Request::is('home*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>

        <p>{{__('My tours')}}</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('profile.index') }}"
       class="nav-link {{ Request::is('profile*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>

        <p>{{__('Profile')}}</p>
    </a>
</li>
<li class="nav-item">
    <a href="/tours?filter[tour_status]=open"
       class="nav-link {{ Request::is('tours*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-route"></i>

        <p>{{__('Public tours')}}</p>
    </a>
</li>



<li class="nav-item">
    <a href="{{ route('usergroups.index') }}"
       class="nav-link {{ Request::is('usergroup*') ? 'active' : '' }}">
        <i class="nav-icon fa fa-comment"></i>
        <p>{{__('Usergroups')}}</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ url('/invitations/tours') }}"
       class="nav-link {{ Request::is('invitations*') ? 'active' : '' }}">
        <i class="nav-icon mdi mdi-map-marker-check"></i>
        <p>{{__('Invitations')}}</p>
    </a>
</li>









