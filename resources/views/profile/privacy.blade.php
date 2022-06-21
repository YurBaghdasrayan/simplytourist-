@extends('layouts.app')
@section('css')
    <style>

        textarea{
            height: 42% !important;
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
        @media (min-width: 768px) {
            .row > .col-md-6{
                border-right: 1px solid #ECF2F8;

            }
            .row > .col-md-6  ~ .col-md-6 {
                border-right: none;

            }
        }


    </style>
@endsection
@section('content')
    {!! Form::model($data, ['route' => ['profile.update', $data[0]->id], 'method' => 'patch','files'=>true]) !!}

    <div class="content px-3">

        @include('flash::message')
        @if(!$isUserContactable)
            <div class="alert alert-danger">
                {{__("The current privacy settings do not allow contact with you, this may result in exclusion from the group or tour")}}
            </div>
        @endif
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
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_phone_visible_for_simplytourit_only"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_phone_visible_for_tour_admin_only"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_phone_visible_for_all_tour_members"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_phone_visible_for_group_admin_only"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_phone_visible_for_all_group_members"])
                    </div>
                    <div class="col-md-6">
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_email_visible_for_simplytourit_only"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_email_visible_for_tour_admin_only"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_email_visible_for_all_tour_members"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_email_visible_for_group_admin_only"])
                        @include("layouts.field_from_rows",["rows"=>$rows,"field"=>"settings_email_visible_for_all_group_members"])
                    </div>
                </div>
{{--                @foreach($rows as $row)--}}
{{--                    @if((strpos($row['field'],'settings'))===0)--}}
{{--                        {{'@'}}{{'include("layouts.field_from_rows",["rows"=>$rows,"field"=>"'.$row['field'].'"])'}}<br/>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--                @foreach($rows as $row)--}}
{{--                    @if((strpos($row['field'],'settings'))===0)--}}
{{--                        @include('layouts.form')--}}
{{--                    @endif--}}
{{--                @endforeach--}}

            </div>
        </div>

    </div>

    {!! Form::close() !!}

@endsection
@push('scripts')
    <script>
        /*
        * Автоматически переключаем зависимые свитчи
        * */
        let fields={};
        fields['settings_email_visible_for_all_tour_members']='settings_email_visible_for_tour_admin_only';
        fields['settings_phone_visible_for_all_tour_members']='settings_phone_visible_for_tour_admin_only';
        fields['settings_email_visible_for_all_group_members']='settings_email_visible_for_group_admin_only';
        fields['settings_phone_visible_for_all_group_members']='settings_phone_visible_for_group_admin_only';
        $( document ).ready(function() {
            for(const [user_field, admin_field] of Object.entries(fields)){
                $('[name='+user_field+']').on( "click", function() {
                    if(!$('[name='+user_field+']').parent().hasClass('toggled')){
                        if(!$('[name='+admin_field+']').parent().hasClass('toggled')){
                            $('[name='+admin_field+']').click();
                        }
                    }
                });
            }

        });

    </script>
@endpush
