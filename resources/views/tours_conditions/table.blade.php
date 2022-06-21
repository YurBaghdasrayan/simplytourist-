<div class="table-responsive">
    <table class="table" id="toursConditions-table">
        <thead>
            <tr>
                <th>Name En</th>
        <th>Description En</th>
        <th>Name De</th>
        <th>Description De</th>
        <th>Name Ru</th>
        <th>Description Ru</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($toursConditions as $toursConditions)
            <tr>
                <td>{{ $toursConditions->name_en }}</td>
            <td>{{ $toursConditions->description_en }}</td>
            <td>{{ $toursConditions->name_de }}</td>
            <td>{{ $toursConditions->description_de }}</td>
            <td>{{ $toursConditions->name_ru }}</td>
            <td>{{ $toursConditions->description_ru }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['toursConditions.destroy', $toursConditions->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('toursConditions.show', [$toursConditions->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('toursConditions.edit', [$toursConditions->id]) }}" class='btn btn-default btn-xs'>
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
