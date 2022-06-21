<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Tour Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tour_id', 'Tour Id:') !!}
    {!! Form::number('tour_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::textarea('status', null, ['class' => 'form-control']) !!}
</div>