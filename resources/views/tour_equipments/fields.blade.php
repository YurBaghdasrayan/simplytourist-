<!-- Tour Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tour_id', 'Tour Id:') !!}
    {!! Form::number('tour_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Equipment Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('equipment_id', 'Equipment Id:') !!}
    {!! Form::number('equipment_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Equipment Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('equipment_type_id', 'Equipment Type Id:') !!}
    {!! Form::number('equipment_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Equipment Note Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('equipment_note', 'Equipment Note:') !!}
    {!! Form::textarea('equipment_note', null, ['class' => 'form-control']) !!}
</div>