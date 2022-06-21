<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="/profile">{{__('About me')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('profile/equipment') ? 'active' : '' }}" href="/profile/equipment">{{__('Equipment')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('profile/certification') ? 'active' : '' }}"  href="/profile/certification">{{__('My certification')}}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('profile/privacy') ? 'active' : '' }}" href="/profile/privacy">{{__('Privacy Settings')}}</a>
    </li>
</ul>
