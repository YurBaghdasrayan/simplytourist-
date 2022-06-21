@extends('layouts.app')

@section('content')


    <div class="content px-3">

            @include('adminlte-templates::common.errors')
        @include('flash::message')

        @include('tours.partials.main_tour_info')
            <div class="mb-4">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if(!str_contains(url()->full(), 'custom-tabs-one-discussion'))active @endif" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">{{__('Description')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">{{__('Equipment')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">{{__('Attendees')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(str_contains(url()->full(), 'custom-tabs-one-discussion'))active @endif" href="?tab=custom-tabs-one-discussion">
                            {{__('Discussion')}}
                        </a>
                    </li>
                    @if(count($tour->tourReports)>0)
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-report-tab" data-toggle="pill" href="#custom-tabs-one-report" role="tab" aria-controls="custom-tabs-one-report" aria-selected="false">
                                {{__('Report')}}
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade @if(!str_contains(url()->full(), 'custom-tabs-one-discussion')) show active @endif" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-12">
                                        <label class="d-flex" for="">
                                            {{__('Tour link')}}
                                            <field-help class="ml-1" field-name="Tour link"></field-help>
                                        </label>
                                        <div>
                                            <a href="{{$tour->tour_link}}" target="_blank">{{$tour->tour_link}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="d-flex" for="">
                                    {{__('Description')}}
                                    <field-help class="ml-1" field-name="Description"></field-help>
                                </label>
                                <div>
                                    <pre>{{$tour->tour_description}}</pre>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                @if($tour['CanEdit'])
                                    <a class="btn btn-base float-right profile-save ml-2" href="/tours/{{$tour['id']}}/status/canceled"   onclick="return confirm('{{__('Are you sure you want to run this action?')}}')">
                                        <i class="mdi mdi-close"></i> {{__('Cancel tour')}}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        <tour-equipment
                            :categories="{{\App\Models\EquipmentType::getEquipmentsType(App::getLocale())}}"
                            :translations="[
                                {'Back':'{{__('Back')}}'},
                                {'Add':'{{__('Add')}}'},
                                {'Category':'{{__('Category')}}'},
                                {'Add equipment':'{{__('Add equipment')}}'},
                                {'Equipment':'{{__('Equipment')}}'},
                                {'Description':'{{__('Description')}}'},
                                {'Shop':'{{__('Shop')}}'},
                                {'My equipment':'{{__('My equipment')}}'},
                                {'Delete':'{{__('Delete')}}'},
                                {'Quantity':'{{__('Quantity')}}'},
                                {'Yes':'{{__('Yes')}}'},
                                {'No':'{{__('No')}}'},
                                ]"
                            locale-lang="{{App::getLocale()}}"
                            :preselected="{{json_encode($tourEquipment)}}"
                            :selected-qty="{{json_encode($tourEquipmentQTY)}}"
                            :editable="false"
                        ></tour-equipment>

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
                            @foreach($tourAttend as $attend)
                                <tr>
                                    @if(isset($attend->user))
                                        <td>{{$attend->user->name}}</td>
                                        <td>
                                            <user-contacts
                                                :user-id="{{$attend->user_id}}"
                                                :translations="[
                                                    {'Contacts':'{{__('Contacts')}}'},
                                                    ]"
                                                type="tour"
                                                :ext-id="{{$tour->id}}"
                                            ></user-contacts>
                                        </td>
                                        <td>
                                            @if($attend->user->user_locale=='ru')<span>Русский</span>@endif
                                            @if($attend->user->user_locale=='en')<span>English</span>@endif
                                            @if($attend->user->user_locale=='de')<span>Deutsch</span>@endif
                                        </td>
                                        <td>
                                            @if($attend->tour_admin >0)
                                                {{__('Yes')}}
                                            @else
                                                {{__('No')}}
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade @if(str_contains(url()->full(), 'custom-tabs-one-discussion')) show active @endif" id="custom-tabs-one-discussion" role="tabpanel" aria-labelledby="custom-tabs-one-discussion-tab">
                        <section class="content-header">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="mx-auto">
                                    </div>
                                    <div>
                                        @if(\App\Models\Tours::isTourMember($tour->id))
                                            <a class="btn btn-basic float-right" href="/tours/{{$tour->id}}/theme/create"><i class="mdi mdi-plus-circle"></i> {{__('Add discussion')}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </section>
                        @if(count($tour->tourDiscussion)>0)
                            <table class="table" id="equipment-table">
                                <thead>
                                <tr>
                                    <th>{{__('Topic')}}</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tour->tourDiscussion as $discussion)
                                    <tr>
                                        <td><a href="/tours/themes/{{$discussion->id}}">{{$discussion->theme}}</a></td>
                                        <td>{{$discussion->user->name}}</td>
                                        <td>{{$discussion->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif

                    </div>
                    @if(count($tour->tourReports)>0)
                        <div class="tab-pane fade" id="custom-tabs-one-report" role="tabpanel" aria-labelledby="custom-tabs-one-report-tab">
                            @foreach($tour->tourReports as $report)
                                <h4>{{$report->title}}</h4>
                                {{$report->created_at}}
                                {!! $report->body !!}
                            @endforeach
                        </div>
                    @endif
        <!-- /.card -->
    </div>
    </div>
    </div>
@endsection

