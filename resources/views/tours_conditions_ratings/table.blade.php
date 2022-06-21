<div class="table-responsive">
    <table class="table" id="toursConditionsRatings-table">
        <thead>
            <tr>
                <th>Tour Condition Id</th>
        <th>Tour Condition Rating</th>
        <th>Description De</th>
        <th>Description En</th>
        <th>Description Ru</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($toursConditionsRatings as $toursConditionsRatings)
            <tr>
                <td>{{ $toursConditionsRatings->tour_condition_id }}</td>
            <td>{{ $toursConditionsRatings->tour_condition_rating }}</td>
            <td>{{ $toursConditionsRatings->description_de }}</td>
            <td>{{ $toursConditionsRatings->description_en }}</td>
            <td>{{ $toursConditionsRatings->description_ru }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['toursConditionsRatings.destroy', $toursConditionsRatings->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('toursConditionsRatings.show', [$toursConditionsRatings->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('toursConditionsRatings.edit', [$toursConditionsRatings->id]) }}" class='btn btn-default btn-xs'>
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
