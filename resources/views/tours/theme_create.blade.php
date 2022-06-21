@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{__("Create tour topic")}}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'usergroupThemes.store']) !!}
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="float-left">
                            <a href="/tours/{{$tour_id}}?tab=custom-tabs-one-discussion" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> {{__('Back')}}
                            </a>
                        </div>
                        <div class="mx-auto"></div>
                        <div class="float-right">
                            <button  class="btn btn-basic float-right" ><i class="mdi mdi-plus-circle"></i> {{__('Add discussion')}}</button>
                        </div>
                    </div>
                </div>
            </section>
            <div class="card-body">

                <div class="row">
                    <input type="hidden" name="tour_id" value="{{$tour_id}}">
                    <input type="text" class="form-control" name="theme" placeholder="{{__('Topic')}}">
                    <textarea name="comment" cols="5" class="form-control" placeholder="{{__('Comment')}}"></textarea>
                </div>

            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
