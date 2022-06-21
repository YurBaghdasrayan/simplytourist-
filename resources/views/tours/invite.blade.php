@extends('layouts.app')

@section('content')
    @push('breadcrumbs')
        <div class="d-flex breadcrumbs">
            <span class="breadcrumb-inactive mr-2">{{__('Tours')}}</span>/<span class="ml-2">{{$tour->tour_name}}</span>
        </div>
    @endpush
    <div class="content px-3" id="app">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="d-flex pr-2">
                        <a href="/tours/{{$tour_id}}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> {{__('Back')}}
                        </a>
                    </span>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div>
        @include('adminlte-templates::common.errors')

        <div class="clearfix"></div>

        <div class="tab-content" id="custom-content-below-tabContent">

            <div class="card-body p-0">
                <form action="/invitations/tours" onsubmit="return false;" method="POST" id="send-invitation">
                    @csrf
                    <input type="hidden" name="tour_id" value="{{$tour_id}}">
                    <dynamic-input
                        name="emails[]"
                        :placeholder="{{json_encode(__('Email'))}}"
                        :translations="[
                            {'Choose Type':'{{__('Choose Type')}}'},
                            {'Username':'{{__('Username')}}'},
                            {'Mailing list':'{{__('Mailing list')}}'},
                            {'Input':'{{__('Input')}}'},
                            {'Email must be specified':'{{__('Email must be specified')}}'},
                            ]"
                    ></dynamic-input>
                    <toggle-button value="on" name="send_attendees" :labels="false"></toggle-button>
                    <label class="form-check-label mt-2"> {{__('Notify tour members')}}</label>
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="mx-auto">
                                </div>
                                <div>
                                    <button class="btn btn-basic float-right" onclick="formSubmit(true)"><i class="mdi mdi-email-send"></i> {{__('Send invitations')}}</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
            <div>
                @include('tour_invitations.table_invite')
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        function formSubmit(fromButton=false){
            if(!fromButton){
                event.PreventDefault();
                return fromButton;
            }else{
                let form=document.getElementById('send-invitation');
                let chk_status = form.checkValidity();
                console.log(form.reportValidity())
                form.reportValidity();
                if (chk_status) {
                    form.submit();
                }
            }
        }
    </script>
@endpush

