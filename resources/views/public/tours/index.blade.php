@extends('layouts.landing')

@section('content')


    <div class="pt-2"  id="app">
            <div class="">
                <h1 class="h3">{{__('Public tours')}}</h1>
                @include('flash::message')
                <div class="clearfix"></div>
                <div>
                    @include('tours.filter',['filter_url'=>'/public/tours'])
                    <div class="row">
                        @php
                            $index=1;
                        @endphp
                        @foreach($tours as $tour)
                            @include('public.tours.tour-card')
                            @php
                                $index++;
                            @endphp
                            @if($index>3)
                                @php
                                    $index=1;
                                @endphp
                            @endif

                        @endforeach
                    </div>
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="mx-auto">
                                    {{ $tours->links() }}
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </section>
{{--                    @include('tours.table')--}}
                </div>
            </div>
    </div>

@endsection

