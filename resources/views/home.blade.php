@extends('layouts.app')

@section('content')
<div class="content px-3">
    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ (isset(request('filter')['tour_status'])&&request('filter')['tour_status']=='open') ? 'active' : '' }}" href="/home?filter[tour_status]=open">{{__('In planing')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (isset(request('filter')['tour_status'])&&request('filter')['tour_status']=='done') ? 'active' : '' }}" href="/home?filter[tour_status]=done">{{__('Done')}}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (isset(request('filter')['tour_status'])&&request('filter')['tour_status']=='canceled') ? 'active' : '' }}" href="/home?filter[tour_status]=canceled">{{__('Canceled')}}</a>
        </li>
    </ul>
    @include('flash::message')

    <div class="clearfix"></div>

    <div class="tab-content" id="custom-content-below-tabContent">
        <div class="card-body p-0">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="mx-auto">
                        </div>
                        <div>
                            <a class="btn btn-basic float-right" href="{{ route('tours.create') }}"><i class="mdi mdi-plus-circle"></i> {{__('Add tour')}}</a>
                        </div>
                    </div>
                </div>
            </section>
            @include('tours.filter',['filter_url'=>'/home'])
            @include('tours.table')
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
        </div>

    </div>
</div>
@endsection
