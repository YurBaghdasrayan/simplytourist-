<div class="table-responsive">
    <table class="table" id="tourEquipments-table">
        <thead>
            <tr>
                <th>Tour Id</th>
        <th>Equipment Id</th>
        <th>Equipment Type Id</th>
        <th>Equipment Note</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tourEquipments as $tourEquipment)
            <tr>
                <td>{{ $tourEquipment->tour_id }}</td>
            <td>{{ $tourEquipment->equipment_id }}</td>
            <td>{{ $tourEquipment->equipment_type_id }}</td>
            <td>{{ $tourEquipment->equipment_note }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['tourEquipments.destroy', $tourEquipment->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('tourEquipments.show', [$tourEquipment->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('tourEquipments.edit', [$tourEquipment->id]) }}" class='btn btn-default btn-xs'>
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
