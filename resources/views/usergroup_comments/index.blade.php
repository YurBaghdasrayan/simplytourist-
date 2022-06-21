@extends('layouts.app')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if(isset($first->theme->tour_id)&&!(isset($first->theme->usergroup_id)))
                        <h1>{{$first->theme->tour->tour_name}}</h1>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="clearfix"></div>
        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade active show mt-4" id="custom-content-below-home" role="tabpanel"
                 aria-labelledby="custom-content-below-home-tab">
                @if(isset($first->theme->usergroup_id))
                    <span class="d-flex pr-2">
                                <a href="/usergroup/{{$first->theme->usergroup_id}}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left"></i> {{__('Back')}}
                                </a>
                            </span>
                @elseif(isset($first->theme->tour_id)&&!(isset($first->theme->usergroup_id)))
                    <span class="d-flex pr-2">
                                <a href="/tours/{{$first->theme->tour_id}}?tab=custom-tabs-one-discussion" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left"></i> {{__('Back')}}
                                </a>
                            </span>
                @endif
                <div class="row">
                    <div class="card-footer col-12">
                        <form action="{{route('usergroupComments.store')}}" method="POST">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="theme_id" value="{{$first->theme_id}}">
                            <wysiwig></wysiwig>
                            <button class="btn btn-basic mt-3  float-right"><i class="mdi mdi-chat-plus"></i> {{__('Add')}}</button>

                        {!! Form::close() !!}
                    </div>
                    <div class="card-header col-12 d-flex">

                        <span class="d-flex pl-4">{{$first->theme->theme}}</span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body  card-comments col-12 p-0">
                        @foreach($usergroupComments as $comment)
                            <div class="card-comment p-4">
                                <!-- User image -->
                                <img class="img-circle img-sm"
                                     src="@if((strpos($comment->user->avatar,'https://')) !== 0)/storage/@endif{{$comment->user->avatar}}"
                                     alt="User Image">

                                <div class="comment-text">
                                    <span class="username">
                                        {{$comment->user->name}}
                                      <span class="text-muted float-right">{{$comment->created_at}}</span>
                                    </span><!-- /.username -->
                                    {!! $comment->comment !!}
                                </div>
                                <!-- /.comment-text -->
                            </div>
                        @endforeach

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer card-comments col-12">

                        <!-- /.card-comment -->
                    </div>
                    <!-- /.card-footer -->

                    <!-- /.card-footer -->
                </div>
            </div>
        </div>

    @endsection

