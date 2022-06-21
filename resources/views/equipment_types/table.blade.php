<div class="table-responsive">
    <table class="table" id="equipmentTypes-table">
        <thead>
            <tr>
                <th>Name En</th>
        <th>Name De</th>
        <th>Name Ru</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($equipmentTypes as $equipmentType)
            <tr>
                <td>{{ $equipmentType->name_en }}</td>
            <td>{{ $equipmentType->name_de }}</td>
            <td>{{ $equipmentType->name_ru }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['equipmentTypes.destroy', $equipmentType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('equipmentTypes.show', [$equipmentType->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('equipmentTypes.edit', [$equipmentType->id]) }}" class='btn btn-default btn-xs'>
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
