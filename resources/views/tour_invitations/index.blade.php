@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            @include('invitations.menu')
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('tour_invitations.table')

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

