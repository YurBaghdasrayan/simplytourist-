@extends('voyager::bread.edit-add')
@section('submit-buttons')
    @parent
    <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
@endsection
