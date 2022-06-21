<!-- Usergroup name Field -->
<div class="col-sm-12">
    {!! Form::label('usergroup_name', 'Usergroup name:') !!}
    <p>{{ $usergroups->usergroup_name }}</p>
</div>

<!-- Usergroup description Field -->
<div class="col-sm-12">
    {!! Form::label('usergroup_description', 'Usergroup description:') !!}
    <p>{{ $usergroups->usergroup_description }}</p>
</div>

<!-- Usergroup Privat Field -->
<div class="col-sm-12">
    {!! Form::label('usergroup_privat', 'Usergroup Privat:') !!}
    <p>{{ $usergroups->usergroup_privat }}</p>
</div>

<!-- Language Iso Field -->
<div class="col-sm-12">
    {!! Form::label('language_iso', 'Language Iso:') !!}
    <p>{{ $usergroups->language_iso }}</p>
</div>

<!-- Country Iso Field -->
<div class="col-sm-12">
    {!! Form::label('country_iso', 'Country Iso:') !!}
    <p>{{ $usergroups->country_iso }}</p>
</div>

<!-- Attendees count Field -->
<div class="col-sm-12">
    {!! Form::label('member_count', 'Attendees count:') !!}
    <p>{{ $usergroups->member_count }}</p>
</div>

<!-- Edit Lock Field -->
<div class="col-sm-12">
    {!! Form::label('edit_lock', 'Edit Lock:') !!}
    <p>{{ $usergroups->edit_lock }}</p>
</div>

