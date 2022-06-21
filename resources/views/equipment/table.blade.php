<div class="table-responsive">
    <table class="table" id="equipment-table">
        <thead>
        <tr>

            <th>Action</th>
            <th>Name</th>
            <th>Equipment Type Id</th>
            <th>Packlist Hiking Daytour</th>
            <th>Packlist Skitour</th>
            <th>Packlist Via Ferrata</th>
            <th>Packlist Ice Climbing</th>
            <th>Packlist Bouldering On Rock</th>
            <th>Packlist Expedition</th>
            <th>Packlist Indoor Climbing</th>
            <th>Packlist Snowshoe Tour</th>
        </tr>
        </thead>
        <tbody>
        @foreach($equipment as $equipment)
            <tr>
                <td><a href="/equipment/{{$equipment->id}}/add">{{__('Add')}}</a> </td>
                <td>{{ $equipment['name_'.App::getLocale()] }}</td>
                <td>{{ $equipment->equipment_type_id }}</td>
                <td>{{ $equipment->packlist_hiking_daytour }}</td>
                <td>{{ $equipment->packlist_skitour }}</td>
                <td>{{ $equipment->packlist_via_ferrata }}</td>
                <td>{{ $equipment->packlist_ice_climbing }}</td>
                <td>{{ $equipment->packlist_bouldering_on_rock }}</td>
                <td>{{ $equipment->packlist_expedition }}</td>
                <td>{{ $equipment->packlist_indoor_climbing }}</td>
                <td>{{ $equipment->packlist_snowshoe_tour }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
