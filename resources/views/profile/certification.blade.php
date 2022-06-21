@extends('layouts.app')
@section('css')
    <style>

        textarea{
            min-height: 350px;
        }
        .form-check {
            padding-bottom: 20px;
        }
        .col-12.h-100{
            display: grid;
        }
        label.btn.btn-basic.avatar__upload {
            align-self: end;
        }
        label {
            font-weight: 500 !important;
            font-size: 14px;
            line-height: 140%;
            padding-left: 20px;
            color: #2D3748 !important;
        }
    </style>
@endsection
@section('content')
    {!! Form::model($data, ['route' => ['profile.update', $data[0]->id], 'method' => 'patch','files'=>true]) !!}

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        @include('profile.menu')
        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade mt-4 show active" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6 pr-0">
                                <button class="btn btn-basic float-right profile-save"><i class="mdi mdi-content-save"></i> {{__('Save changes')}}</button>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-md-6">
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"certification_mountain_guide"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"certification_hiking_guide"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"certification_note"])
                    </div>
                    <div class="col-md-6">
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"certification_mountain_guide_approved"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"certification_hiking_guide_approved"])
                        <label for="certification_note" class="form-label d-flex">
                            {{__('Simplytourit certification notes')}}
                        </label>
                        <textarea type="text" name="simplytourit_certification_note" disabled placeholder="{{__('Simplytourit certification notes')}}" class="form-control tourit_cert_note">{{$data[0]['simplytourit_certification_note']}}</textarea>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {!! Form::close() !!}
    @include('layouts.partials.autoresize_textarea_script')
    <script>
        let cert_textarea = document.querySelector(".tourit_cert_note");
        cert_textarea.style.height = calcHeight(cert_textarea.value) + "px";
    </script>

@endsection
