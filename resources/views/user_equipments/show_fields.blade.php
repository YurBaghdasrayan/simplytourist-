<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $userEquipment->user_id }}</p>
</div>

<!-- Equipment Id Field -->
<div class="col-sm-12">
    {!! Form::label('equipment_id', 'Equipment Id:') !!}
    <p>{{ $userEquipment->equipment_id }}</p>
</div>

<!-- Equipment Type Id Field -->
<div class="col-sm-12">
    {!! Form::label('equipment_type_id', 'Equipment Type Id:') !!}
    <p>{{ $userEquipment->equipment_type_id }}</p>
</div>

<!-- Note Field -->
<div class="col-sm-12">
    {!! Form::label('note', 'Note:') !!}
    <p>{{ $userEquipment->note }}</p>
</div>

