@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{$usergroup->usergroup_name}}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'usergroupThemes.store']) !!}
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <span class="d-flex pr-2 card-footer">
                        <a href="/usergroup/{{$usergroup->id}}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> {{__('Back')}}
                        </a>
                    </span>
                    </div>
                    <div class="col-sm-6">
                        <div class="card-footer float-right">
                            {!! Form::submit(__('Save'), ['class' => 'btn btn-basic']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <input type="hidden" name="usergroup_id" value="{{$usergroup->id}}">
                    @include('layouts.field_from_rows',['rows'=>$rows,'field'=>'theme'])
                    <label for="" class="form-label d-flex">
                        {{__('Comment')}}
                        <field-help class="ml-1" field-name="Comment"></field-help>
                    </label>
                    <textarea name="comment" cols="5" class="form-control"></textarea>
                </div>

            </div>



            {!! Form::close() !!}

        </div>
    </div>
@endsection
