<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $usergroupMembers->user_id }}</p>
</div>

<!-- Usergroup Id Field -->
<div class="col-sm-12">
    {!! Form::label('usergroup_id', 'Usergroup Id:') !!}
    <p>{{ $usergroupMembers->usergroup_id }}</p>
</div>

<!-- Admin Field -->
<div class="col-sm-12">
    {!! Form::label('admin', 'Admin:') !!}
    <p>{{ $usergroupMembers->admin }}</p>
</div>

