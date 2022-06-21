<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $usergroupComments->user_id }}</p>
</div>

<!-- Comment Field -->
<div class="col-sm-12">
    {!! Form::label('comment', 'Comment:') !!}
    <p>{{ $usergroupComments->comment }}</p>
</div>

<!-- Theme Id Field -->
<div class="col-sm-12">
    {!! Form::label('theme_id', 'Theme Id:') !!}
    <p>{{ $usergroupComments->theme_id }}</p>
</div>

