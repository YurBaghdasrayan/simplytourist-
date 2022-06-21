@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card mb-4">


            <div class="card-body">
{{--                <div class="row">--}}
{{--                    <div class="col-12">--}}
{{--                        <button class="btn btn-basic float-right profile-save"  onclick="formSubmit(true)"><i class="mdi mdi-content-save"></i> {{__('Save changes')}}</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <h4>{{$usergroup->usergroup_name}}</h4>
                        </div>
                        <div class="col-md-12">
                            <label class="d-flex">
                                {{__('Usergroup description')}}
                                <field-help class="ml-1" field-name="usergroup_description"></field-help>
                            </label>
                            {{$usergroup->usergroup_description}}
                        </div>
                        <div class="col-md-12">
                            <label  class="d-flex" for="">
                                {{__('Language')}}
                                <field-help class="ml-1" field-name="Language"></field-help>
                            </label>
                            {{\App\Models\Languages::getLang($usergroup->language_iso)}}
                        </div>
                        <div class="col-md-12">
                            <label  class="d-flex" for="country_iso">
                                {{__('Country')}}
                                <field-help class="ml-1" field-name="Country"></field-help>
                            </label>
                            {{\App\Models\Languages::getCountry($usergroup['country_iso'])}}
                        </div>
                        <div class="col-md-12">
                            <label  class="d-flex" for="country_iso">
                                {{__('Group type')}}
                                <field-help class="ml-1" field-name="Country"></field-help>
                            </label>
                            @if($usergroup->usergroup_privat==1)
                                {{__('Private')}}
                            @else
                                {{__('Public')}}
                            @endif
                        </div>

                    </div>
                    <div class="col-md-6">
                        <label class="d-flex">
                            {{__('Usergroup image')}}
                            <field-help class="ml-1" field-name="Usergroup image"></field-help>
                        </label>
                        <div class="col-md-12">
                            <img src="/storage/{{$usergroup->image}}" alt="" class="avatar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="/usergroup/{{$usergroup->id}}/">{{__('Topics')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/usergroup/{{$usergroup->id}}/members">{{__('Members')}}</a>
            </li>
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent">
            <div class="row mb-2">
                <div class="col">
                    <a class="btn btn-base  profile-save ml-2" href="/usergroups/{{$group_id}}/invitations/"><i class="mdi mdi-email-send"></i> {{__('Send invitations')}}</a>
                </div>
                <div class="col">
                    <a class="btn btn-basic" href="{{ route('usergroupThemes.create',$group_id) }}"><i class="mdi mdi-plus-circle"></i> {{__('Add topic')}}</a>
                </div>
            </div>
            <div class="tab-pane fade active show mt-4" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                <div class="row">
                    @include('usergroup_themes.table')
                </div>
            </div>
        </div>
    </div>

@endsection

