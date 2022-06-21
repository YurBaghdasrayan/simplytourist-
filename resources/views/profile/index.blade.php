@extends('layouts.app')
@section('css')
    <style>
        input#avatar {
            display: none;
        }
        span#file-chosen {
            position: relative;
        }
        textarea{
            min-height: 157px;
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
        @include('adminlte-templates::common.errors')
        @include('flash::message')

        <div class="clearfix"></div>
        @include('profile.menu')
        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade active show mt-4" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                <div class="row">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6 pr-0 float-right">
                        <button class="btn btn-basic float-right profile-save"><i class="mdi mdi-content-save"></i> {{__('Save changes')}}</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    @include('layouts.field_from_rows',['rows'=>$rows,'field'=>'name'])
                    @include('layouts.field_from_rows',['rows'=>$rows,'field'=>'about_surname'])
                    @include('layouts.field_from_rows',['rows'=>$rows,'field'=>'about_phone'])
                    <label class="form-label d-flex" for="">{{__('Language')}}
                        <field-help class="ml-1" field-name="Language"></field-help>
                    </label>
                        <select name="user_locale" class="form-control">
                            <option value="ru" @if($data[0]->user_locale=='ru') selected="selected"@endif>Русский</option>
                            <option value="en" @if($data[0]->user_locale=='en') selected="selected"@endif>English</option>
                            <option value="de" @if($data[0]->user_locale=='de') selected="selected"@endif>Deutsch</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label d-flex" for="">
                            {{__('Your country')}}
                            <field-help class="ml-1" field-name="Your country">

                            </field-help>
                        </label>
                        @include('layouts.partials.country',['country_name'=>'about_address_country','selected'=>$data[0]->about_address_country])<br/>
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"about_address_city"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"about_address_street"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"about_address_zip_code"])
                    </div>
                    <div class="col-md-4 mb-2">
                    @include('layouts.field_from_rows',['rows'=>$rows,'field'=>'avatar'])
                    </div>
                    <div class="col-md-12">
                        @include('layouts.field_from_rows',['rows'=>$rows,'field'=>'about_me'])
                    </div>
                </div>

            </div>
        </div>

    </div>

    {!! Form::close() !!}
    @include('layouts.partials.autoresize_textarea_script')
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', init, false);
        function init(){
            const actualBtn = document.getElementById('avatar');
            const fileChosen = document.getElementById('file-chosen');
            actualBtn.addEventListener("change", function(){
                fileChosen.textContent = this.files[0].name
            })
        };
    </script>
@endpush
