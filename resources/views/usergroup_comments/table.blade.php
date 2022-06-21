<div class="table-responsive">
    <table class="table" id="usergroupComments-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Comment</th>
        <th>Theme Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($usergroupComments as $usergroupComment)
            <tr>
                <td>{{ $usergroupComment->user_id }}</td>
            <td>{{ $usergroupComment->comment }}</td>
            <td>{{ $usergroupComment->theme_id }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['usergroupComments.destroy', $usergroupComment->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('usergroupComments.show', [$usergroupComment->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('usergroupComments.edit', [$usergroupComment->id]) }}" class='btn btn-default btn-xs'>
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
