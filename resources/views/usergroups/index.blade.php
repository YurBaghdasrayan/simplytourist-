@extends('layouts.app')

@section('content')

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade active show mt-4" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                <div class="row">
                    <section class="content-header col-12">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="mx-auto">
                                    {{ $usergroups->links() }}
                                </div>
                                <div class="col">
                                    <a class="btn btn-basic float-right" href="{{ route('usergroups.create') }}"><i class="mdi mdi-plus-circle"></i> {{__('Add usergroup')}}</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    @include('usergroups.filter',['filter_url'=>'/usergroups'])

                    @include('usergroups.table')

            </div>
            </div>
        </div>
    </div>

@endsection

