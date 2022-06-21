<div class="table-responsive">
    <table class="table" id="userEquipments-table">
        <thead>
            <tr>
                <th>User Id</th>
        <th>Equipment Id</th>
        <th>Equipment Type Id</th>
        <th>Note</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($userEquipments as $userEquipment)
            <tr>
                <td>{{ $userEquipment->user->name }}</td>
            <td>{{ $userEquipment->equipment->name_ru }}</td>
            <td>{{ $userEquipment->equipmentType->name_ru }}</td>
            <td>{{ $userEquipment->note }}</td>
                <td width="120">
{{--                    {!! Form::open(['route' => ['userEquipments.destroy', $userEquipment->id], 'method' => 'delete']) !!}--}}
{{--                    <div class='btn-group'>--}}
{{--                        <a href="{{ route('userEquipments.show', [$userEquipment->id]) }}" class='btn btn-default btn-xs'>--}}
{{--                            <i class="far fa-eye"></i>--}}
{{--                        </a>--}}
{{--                        <a href="{{ route('userEquipments.edit', [$userEquipment->id]) }}" class='btn btn-default btn-xs'>--}}
{{--                            <i class="far fa-edit"></i>--}}
{{--                        </a>--}}
{{--                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
{{--                    </div>--}}
{{--                    {!! Form::close() !!}--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
