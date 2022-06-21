<div class="table-responsive">
    <table class="table" id="usergroupMembers-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Usergroup Id</th>
        <th>Admin</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($usergroupMembers as $usergroupMembers)
            <tr>
                <td>{{ $usergroupMembers->user_id }}</td>
            <td>{{ $usergroupMembers->usergroup_id }}</td>
            <td>{{ $usergroupMembers->admin }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['usergroupMembers.destroy', $usergroupMembers->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('usergroupMembers.show', [$usergroupMembers->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('usergroupMembers.edit', [$usergroupMembers->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
