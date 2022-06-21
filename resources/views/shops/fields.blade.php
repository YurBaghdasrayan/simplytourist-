<!-- Name Ru Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name_ru', 'Name Ru:') !!}
    {!! Form::text('name_ru', null, ['class' => 'form-control','maxlength' => 256,'maxlength' => 256]) !!}
</div>

<!-- Name En Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name_en', 'Name En:') !!}
    {!! Form::text('name_en', null, ['class' => 'form-control','maxlength' => 256,'maxlength' => 256]) !!}
</div>

<!-- Name De Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name_de', 'Name De:') !!}
    {!! Form::number('name_de', null, ['class' => 'form-control']) !!}
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

<!-- Shop Url Ru Field -->
<div class="form-group col-sm-6">
    {!! Form::label('shop_url_ru', 'Shop Url Ru:') !!}
    {!! Form::number('shop_url_ru', null, ['class' => 'form-control']) !!}
</div>

<!-- Shop Url En Field -->
<div class="form-group col-sm-6">
    {!! Form::label('shop_url_en', 'Shop Url En:') !!}
    {!! Form::number('shop_url_en', null, ['class' => 'form-control']) !!}
</div>

<!-- Shop Url De Field -->
<div class="form-group col-sm-6">
    {!! Form::label('shop_url_de', 'Shop Url De:') !!}
    {!! Form::number('shop_url_de', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Default Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_default', 'Is Default:') !!}
    {!! Form::text('is_default', null, ['class' => 'form-control','maxlength' => 3,'maxlength' => 3]) !!}
</div>