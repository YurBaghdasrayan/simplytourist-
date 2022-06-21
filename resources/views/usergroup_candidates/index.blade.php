@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$group->usergroup_name}}</h1>
                    <span class="d-flex pr-2">
                        <a href="/usergroup/{{$group->id}}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> {{__('Back')}}
                        </a>
                    </span>
                </div>
                <div class="col-sm-6">
                    {{--                    <a class="btn btn-primary float-right"--}}
                    {{--                       href="{{ route('tourCandidates.create') }}">--}}
                    {{--                        Add New--}}
                    {{--                    </a>--}}
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        @if(!$group->canEdit)
            <div class="card">
                <div class="card-body p-4">
                    <form action="/usergroupCandidates" method="POST">
                        @csrf
                        <button class="btn btn-basic float-right mb-2">
                            <i class="mdi mdi-content-save"></i>
                            {{__("Add")}}
                        </button>
                        <input type="hidden" name="group_id" value="{{$group->id}}"/>
                        <textarea name="comment" id="" cols="30" rows="10" class="form-control" placeholder="{{__('Description')}}"></textarea>
                    </form>

                </div>

            </div>
        @endif
        <div class="card">
            <div class="card-body p-0">
                @include('usergroup_candidates.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

