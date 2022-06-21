@extends('layouts.landing')

@section('content')


    <div class="pt-2"  id="app">
            <h1 class="h3">{{__('Usergroups')}}</h1>
{{--        <div class="tab-content" id="custom-content-below-tabContent">--}}
            <div class="tab-pane fade active show mt-4" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                <div class="row">
                    @php
                        $index=1;
                    @endphp
                    @foreach($usergroups as $usergroup)
                        @include('public.usergroups.group-card')
                        @php
                            $index++;
                        @endphp
                        @if($index>3)
                            @php
                                $index=1;
                            @endphp
                        @endif
                    @endforeach
{{--                    @include('usergroups.table')--}}

                </div>
            </div>
{{--        </div>--}}
    </div>

@endsection

