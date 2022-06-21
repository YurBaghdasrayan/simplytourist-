<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Usergroup Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usergroup_id', 'Usergroup Id:') !!}
    {!! Form::number('usergroup_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Admin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('admin', 'Admin:') !!}
    {!! Form::text('admin', null, ['class' => 'form-control','maxlength' => 3,'maxlength' => 3]) !!}
</div>