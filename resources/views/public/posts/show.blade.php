@extends('layouts.landing')

@section('content')
    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="card-body p-0">
                <h1 class="h3">{{$post->title}}</h1>
{{--                <span class="post-time">{{$post->created_at}}</span>--}}
{{--                <div class="post-image"><img src="/storage/{{$post->image}}"></div>--}}
                <div class="post-content">{!! $post->body !!}</div>
{{--                {{var_dump($post->excerpt)}}--}}
{{--                {{var_dump($post->slug)}}--}}
{{--                {{var_dump($post->meta_description)}}--}}
{{--                {{var_dump($post->meta_keywords)}}--}}
{{--                {{var_dump($post->category_id)}}--}}
            </div>

        </div>
    </div>

@endsection

