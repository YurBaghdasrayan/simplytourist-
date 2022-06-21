<div class="table-responsive">
    <table class="table" id="toursTypesRatings-table">
        <thead>
            <tr>
                <th>Tour Type Id</th>
        <th>Tour Type Rating</th>
        <th>Description De</th>
        <th>Description En</th>
        <th>Description Ru</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($toursTypesRatings as $toursTypesRatings)
            <tr>
                <td>{{ $toursTypesRatings->tour_type_id }}</td>
            <td>{{ $toursTypesRatings->tour_type_rating }}</td>
            <td>{{ $toursTypesRatings->description_de }}</td>
            <td>{{ $toursTypesRatings->description_en }}</td>
            <td>{{ $toursTypesRatings->description_ru }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['toursTypesRatings.destroy', $toursTypesRatings->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('toursTypesRatings.show', [$toursTypesRatings->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('toursTypesRatings.edit', [$toursTypesRatings->id]) }}" class='btn btn-default btn-xs'>
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
