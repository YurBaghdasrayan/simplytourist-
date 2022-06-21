<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $tourCandidates->user_id }}</p>
</div>

<!-- Tour Id Field -->
<div class="col-sm-12">
    {!! Form::label('tour_id', 'Tour Id:') !!}
    <p>{{ $tourCandidates->tour_id }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $tourCandidates->status }}</p>
</div>

