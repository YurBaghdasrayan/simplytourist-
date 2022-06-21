<!-- Tour Type Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tour_type_id', 'Tour Type Id:') !!}
    {!! Form::number('tour_type_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Tour Type Rating Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('tour_type_rating', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('tour_type_rating', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('tour_type_rating', 'Tour Type Rating', ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Description De Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description_de', 'Description De:') !!}
    {!! Form::textarea('description_de', null, ['class' => 'form-control']) !!}
</div>

<!-- Description En Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description_en', 'Description En:') !!}
    {!! Form::textarea('description_en', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Ru Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description_ru', 'Description Ru:') !!}
    {!! Form::textarea('description_ru', null, ['class' => 'form-control']) !!}
</div>