@extends('layouts.landing')

@section('content')


    <div class="pt-2"  id="app">
        <h1 class="h3">{{__('Articles')}}</h1>
        <div class="d-flex">
            <aside class="d-none d-md-block" id="sidebar-wrapper-posts">
            <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar mr-4">
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <b>{{__('Article categories')}}:</b>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                            @foreach($categories as $category)
                                <li class="nav-item m-0">
                                    <a class="nav-link  pr-0 pl-0" href="{{route('posts',$category->slug)}}">{{__($category->name)}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </section>
            </aside>
            <div class="">
                @include('flash::message')
                <div class="clearfix"></div>
                <div>
                        @foreach($posts as $post)
                            <div class="row mb-4">
                                <div class="col-5">
                                    <div class="post-image"><img src="/storage/{{$post->image}}"></div>
                                </div>
                                <div class="col-7">
                                    <div class="post-content ml-4">
                                        <h4><a href="{{route('posts.show',$post->slug)}}">{{$post->title}}</a></h4>
{{--                                        <span class="post-time">{{$post->created_at}}</span>--}}
                                        <div class="post-content">{!! $post->excerpt !!}</div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

