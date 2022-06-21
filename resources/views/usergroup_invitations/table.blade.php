<div class="table-responsive">
    <table class="table" id="usergroups-table">
        <thead>
        <tr>
            @if(Request::is('usergroups*'))
                <th></th>
            @endif
            <th>{{__("Usergroup name")}}</th>
            <th>{{__("Usergroup description")}}</th>
            <th>{{__("Attendees count")}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($usergroups as $usergroups)
            <tr>
                @if(Request::is('usergroups*'))
                    <td>
                        @if($usergroups->CanEdit)
                            <a href="/usergroups/{{$usergroups->id}}/edit" class="color-base btn"><i class="mdi mdi-pencil"></i></a>
                        @endif
                    </td>
                @endif
                <td><a href="/usergroup/{{$usergroups->id}}/">{{ $usergroups->usergroup_name }}</a></td>
                <td>{{ $usergroups->usergroup_description }}</td>
                <td>{{ $usergroups->member_count }}</td>
                <td>
                    <a class="btn btn-success btn-sm" href="/usergroupInvitations/{{$usergroups->id}}/status/allow">{{__('Connect to group')}}</a>
                    <a class="btn btn-danger btn-sm mt-2" href="/usergroupInvitations/{{$usergroups->id}}/status/cancel">{{__('Cancel')}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

