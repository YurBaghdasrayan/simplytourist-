@extends('layouts.app')

@section('content')


    <div class="pt-2"  id="app">
        <div class="d-flex">
            <div class="content px-3">
                @include('flash::message')
                <div class="clearfix"></div>
                <div>
                    @if(count($posts)>0)
                        @foreach($posts as $post)
                            <div class="row mb-4">
                                <div class="col-5">
                                    <div class="post-image"><a href="{{route('help.show',$post->slug)}}"><img src="/storage/{{$post->image}}"></a></div>
                                </div>
                                <div class="col-7">
                                    <div class="post-content ml-4">
                                        <h4><a href="{{route('help.show',$post->slug)}}">{{$post->title}}</a></h4>
{{--                                        <span class="post-time">{{$post->created_at}}</span>--}}
                                        <div class="post-content">{!! $post->excerpt !!}</div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <h4 class="p-4">Пока не добавлено инструкций</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

