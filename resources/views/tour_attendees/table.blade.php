<div class="table-responsive">
    <table class="table" id="tourAttendees-table">
        <thead>
            <tr>
                <th>Tour Id</th>
        <th>User Id</th>
        <th>Tour Admin</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tourAttendees as $tourAttendees)
            <tr>
                <td>{{ $tourAttendees->tour_id }}</td>
            <td>{{ $tourAttendees->user_id }}</td>
            <td>{{ $tourAttendees->tour_admin }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['tourAttendees.destroy', $tourAttendees->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('tourAttendees.show', [$tourAttendees->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('tourAttendees.edit', [$tourAttendees->id]) }}" class='btn btn-default btn-xs'>
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
