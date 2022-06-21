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

                    <div class="col-md-12">
                        @if($usergroup->canEdit)
                            <div class="row mb-2">
                                <div class="col">
                                    <a class="btn btn-base float-right profile-save ml-2" href="/usergroups/{{$group_id}}/candidate/"><i class="mdi mdi-account-group"></i> {{__('Group applicants')}}</a>

                                    <a class="btn btn-base float-right profile-save ml-2" href="/usergroups/{{$group_id}}/invitations/"><i class="mdi mdi-email-send"></i> {{__('Send invitations')}}</a>

                                    <a class="btn btn-base float-right profile-save ml-2" href="/usergroups/{{$group_id}}/edit/"><i class="mdi mdi-pencil"></i> {{__('Edit usergroup')}}</a>

                                </div>
                            </div>
                        @endif
                        @if(!\App\Models\Usergroups::isGroupMember($usergroup->id)&&!$usergroup->canEdit)
                            <div class="row mb-2">
                                <div class="col">
                                    <a class="btn btn-base float-right profile-save ml-2" href="/usergroups/{{$group_id}}/candidate"><i class="mdi mdi-account-plus"></i> {{__('Connect to group')}}</a>
                                </div>
                            </div>
                        @endif
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <h4>{{$usergroup->usergroup_name}}</h4>
                                </div>



                            </div>
                        <label class="d-flex">
                            {{__('Usergroup image')}}
                            <field-help class="ml-1" field-name="Usergroup image"></field-help>
                        </label>
                        <div class="col-md-12">
                            <img src="/storage/{{$usergroup->image}}" alt="" class="avatar">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row col-md-12 p-3">
                        <div class="col-md-4">
                            <label  class="d-flex" for="">
                                {{__('Language')}}
                                <field-help class="ml-1" field-name="Language"></field-help>
                            </label>
                            {{\App\Models\Languages::getLang($usergroup->language_iso)}}
                        </div>
                        <div class="col-md-4">
                            <label  class="d-flex" for="country_iso">
                                {{__('Usergroup country')}}
                                <field-help class="ml-1" field-name="Usergroup country"></field-help>
                            </label>
                            {{\App\Models\Languages::getCountry($usergroup['country_iso'])}}
                        </div>
                        <div class="col-md-4">
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
                    <div class="col-md-12">
                        <div class="col-md-12">
                        <label class="d-flex">
                            {{__('Usergroup description')}}
                            <field-help class="ml-1" field-name="usergroup_description"></field-help>
                        </label>
                        <pre>{{$usergroup->usergroup_description}}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link  active" id="custom-tabs-one-themes-tab" data-toggle="pill" href="#custom-tabs-one-themes" role="tab" aria-controls="custom-tabs-one-themes" aria-selected="false">{{__('Discussion')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">{{__('Members')}}</a>
            </li>
        </ul>
        <div class="tab-content" id="custom-content-below-tabContent">

            <div class="tab-pane fade  show active" id="custom-tabs-one-themes" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                @if(\App\Models\Usergroups::isGroupMember($usergroup->id))
                    <div class="row mb-2">
                        <div class="col">
                            <a class="btn btn-base float-right profile-save ml-2" href="{{ route('usergroupThemes.create',$group_id) }}"><i class="mdi mdi-plus-circle"></i> {{__('Add topic')}}</a>
                        </div>
                    </div>

                @endif
                <div class="tab-pane fade active show mt-4" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                    <div class="row">
                        @include('usergroup_themes.table')
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                <table class="table" id="equipment-table">
                    <thead>
                    <tr>
                        <th>{{__('User name')}}</th>
                        <th>{{__('Contacts')}}</th>
                        <th>{{__('Language')}}</th>
                        <th>{{__('Administrator')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($usergroup->attend as $attend)
                        <tr>
                            <td>{{$attend->user->name}}</td>
                            <td>
                                <user-contacts
                                    :user-id="{{$attend->user_id}}"
                                    :translations="[
                                        {'Contacts':'{{__('Contacts')}}'},
                                        ]"
                                    type="group"
                                    :ext-id="{{$usergroup->id}}"
                                ></user-contacts>
                            </td>
                            <td>
                                @if($attend->user->user_locale=='ru')<span>Русский</span>@endif
                                @if($attend->user->user_locale=='en')<span>English</span>@endif
                                @if($attend->user->user_locale=='de')<span>Deutsch</span>@endif
                            </td>
                            <td>
                                @if($attend->admin >0)
                                    {{__('Yes')}}
                                @else
                                    {{__('No')}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection

