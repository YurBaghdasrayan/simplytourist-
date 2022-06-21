<div class="mb-4">
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if(Request::is('invitations/tours')) active @endif"
               id="custom-tabs-one-tours-tab" href="/invitations/tours">{{__('Tour invitations')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(Request::is('invitations/groups')) active @endif"
               id="custom-tabs-one-usergroup-tab" href="/invitations/groups">{{__('Group invitations')}}</a>
        </li>


    </ul>
</div>
