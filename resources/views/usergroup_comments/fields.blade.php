<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Comment Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('comment', 'Comment:') !!}
    {!! Form::textarea('comment', null, ['class' => 'form-control']) !!}
</div>

<!-- Theme Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('theme_id', 'Theme Id:') !!}
    {!! Form::number('theme_id', null, ['class' => 'form-control']) !!}
</div>