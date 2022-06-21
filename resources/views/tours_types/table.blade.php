<div class="table-responsive">
    <table class="table" id="toursTypes-table">
        <thead>
            <tr>
                <th>Name De</th>
        <th>Name En</th>
        <th>Name Ru</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($toursTypes as $toursTypes)
            <tr>
                <td>{{ $toursTypes->name_de }}</td>
            <td>{{ $toursTypes->name_en }}</td>
            <td>{{ $toursTypes->name_ru }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['toursTypes.destroy', $toursTypes->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('toursTypes.show', [$toursTypes->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('toursTypes.edit', [$toursTypes->id]) }}" class='btn btn-default btn-xs'>
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
