<!-- Tour Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tour_id', 'Tour Id:') !!}
    {!! Form::number('tour_id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Tour Admin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tour_admin', 'Tour Admin:') !!}
    {!! Form::text('tour_admin', null, ['class' => 'form-control','maxlength' => 3,'maxlength' => 3]) !!}
</div>