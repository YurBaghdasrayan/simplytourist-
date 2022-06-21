<div class="table-responsive">
    <table class="table" id="usergroups-table">
        <thead>
            <tr>
        <th>{{__('Topic')}}</th>
        <th>{{__('Author')}}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($usergroupThemes as $usergroupThemes)
            <tr>
            <td><a href="/usergroup/themes/{{$usergroupThemes->id}}/">{{ $usergroupThemes->theme }}</a></td>
            <td>{{ $usergroupThemes->user->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
