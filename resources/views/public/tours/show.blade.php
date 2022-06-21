@extends('layouts.landing')

@section('content')


    <div class="content px-3">

        @include('adminlte-templates::common.errors')
        @include('flash::message')

        @method('post')
            @csrf
            <div class="card mb-4">

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h1 class="h3">{{$tour->tour_name}}</h1>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="d-flex" for="country_iso">
                                {{__('Country')}}
                                <field-help class="ml-1" field-name="Country"></field-help>
                            </label>
                            <div>
                                {{\App\Models\Languages::getCountry($tour['country_iso'])}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <label class="d-flex" for="tour_type_id">
                                        {{__('Tour type')}}
                                        <field-help class="ml-1" field-name="Tour type"></field-help>
                                    </label>
                                    <div>{{$tour->tourType['name_'.App::getLocale()] }}</div>
                                </div>
                                <div class="col-6">
                                    <label class="d-flex" for="tour_dificult">
                                        {{__('Tour type complexity')}}
                                        <field-help class="ml-1" field-name="Tour type complexity"></field-help>
                                    </label>
                                    <div>
                                        @if(isset($tour->tourDificult)&&isset($tour->tourDificult[0]->diff))
                                            @foreach($tour->tourDificult as $diff)
                                                {{$diff->diff['name_'.\App::getLocale()]}}<br/>
                                            @endforeach
                                        @else
                                            {{__('Not specified')}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="d-flex" for="tour_condition_id">
                                {{__('Tour conditions')}}
                                <field-help class="ml-1" field-name="Tour conditions"></field-help>
                            </label>
                            <div>{{$tour->tourConditions['name_'.App::getLocale()]}}</div>

                        </div>
                        <div class="col-md-2">
                            <label class="d-flex" for="status">
                                {{__('Status')}}
                                <field-help class="ml-1" field-name="Status"></field-help>
                            </label>
                            <div>{{__($tour->tour_status)}}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 rating-create">
                            <label for="" class="pt-1 mr-4">
                                {{__('Type rating')}}
                            </label>
                            <star-input
                                hidden-input-name="tour_type_rating"
                                :grade="{{$tour->tour_type_rating}}"
                                :is-disabled="true"
                            ></star-input>
                        </div>
                        <div class="col-md-6 rating-create">
                            <label for="" class="pt-1 mr-4">
                                {{__('Condition rating')}}
                            </label>
                            <star-input
                                hidden-input-name="tour_condition_rating"
                                :grade="{{$tour->tour_condition_rating}}"
                                :is-disabled="true"
                            ></star-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="d-flex" for="">
                                {{__('Type description')}}
                                <field-help class="ml-1" field-name="Type description"></field-help>
                            </label>
                            <div>
                                {{$tour->tour_type_description}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="d-flex" for="">
                                {{__('Conditions description')}}
                                <field-help class="ml-1" field-name="Conditions description"></field-help>
                            </label>
                            <div>
                                {{$tour->tour_condition_description}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">

                                <div class="col-md-4">
                                    <label class="d-flex" for="">
                                        {{__('Start date')}}
                                        <field-help class="ml-1" field-name="Date start"></field-help>
                                    </label>
                                    <div>{{$tour->tour_date_start}}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="d-flex" for="">
                                        {{__('End date')}}
                                        <field-help class="ml-1" field-name="Date end"></field-help>
                                    </label>
                                    <div>{{$tour->tour_date_end}}</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="d-flex" for="">
                                        {{__('Private tour')}}
                                        <field-help class="ml-1" field-name="Private tour"></field-help>
                                    </label>
                                    <div>
                                        @if($tour->tour_private)
                                            {{__('Yes')}}
                                        @else
                                            {{__('No')}}
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row">


                                <div class="col-md-4">
                                    <label class="d-flex" for="">
                                        {{__('Guide needed')}}
                                        <field-help class="ml-1" field-name="Guide needed"></field-help>
                                    </label>
                                    <div>
                                        @if($tour->guide_needed==1)
                                            {{__('Yes')}}
                                        @else
                                            {{__('No')}}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="d-flex" for="">
                                        {{__('Guided')}}
                                        <field-help class="ml-1" field-name="Guided"></field-help>
                                    </label>
                                    <div>
                                        @if($tour->guided==1)
                                            {{__('Yes')}}
                                        @else
                                            {{__('No')}}
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="d-flex" for="">
                                                {{__('Estimated costs')}}
                                                <field-help class="ml-1" field-name="Estimated costs"></field-help>
                                            </label>
                                            <div>
                                                {{$tour->estimated_costs}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="d-flex" for="">
                                        {{__('Attendees min.')}}
                                        <field-help class="ml-1" field-name="Attendees min."></field-help>
                                    </label>
                                    <div>
                                        {{$tour->attendees_min}}
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <label class="d-flex" for="">
                                        {{__('Attendees max.')}}
                                        <field-help class="ml-1" field-name="Attendees max."></field-help>
                                    </label>
                                    <div>
                                        {{$tour->attendees_max}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="d-flex" for="">
                                        {{__('Open spots')}}
                                        <field-help class="ml-1" field-name="Open places"></field-help>
                                    </label>
                                    <div>
                                        {{$tour->open_places}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12">
                                <label class="d-flex" for="">
                                    {{__('Main destination')}}
                                    <field-help class="ml-1" field-name="Coordinates"></field-help>
                                </label>
                                <div>
                                    @include('map.single_point',['coordinate'=>$tour->target_coordinates])
                                    {{--                            {{$tour->target_coordinates}}--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">{{__('Description')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">{{__('Equipment')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">{{__('Attendees')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-discussion-tab" data-toggle="pill" href="#custom-tabs-one-discussion" role="tab" aria-controls="custom-tabs-one-discussion" aria-selected="false">
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
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
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
                                    {{$tour->tour_description}}

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                        @guest
                            @include('layouts.partials.authorized_content')
                        @else
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
                                    ]"
                                locale-lang="{{App::getLocale()}}"
                                :preselected="{{json_encode($tourEquipment)}}"
                                :selected-qty="{{json_encode($tourEquipmentQTY)}}"
                                :editable="false"
                            ></tour-equipment>
                        @endguest

                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                        @guest
                            @include('layouts.partials.authorized_content')
                        @else
                            <table class="table" id="equipment-table">
                            <thead>
                            <tr>
                                <th>{{__('User name')}}</th>
                                <th>{{__('Language')}}</th>
                                <th>{{__('Administrator')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tourAttend as $attend)
                                <tr>
                                    <td>{{$attend->user->name}}</td>
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
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endguest
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-discussion" role="tabpanel" aria-labelledby="custom-tabs-one-discussion-tab">
                        @guest
                            @include('layouts.partials.authorized_content')
                        @else
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
                        @endguest
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
@push('scripts')
    <script>
        function formSubmit(fromButton=false){
            if(!fromButton){
                event.PreventDefault();
                return fromButton;
            }else{
                let form=document.getElementById('add_tour');
                form.submit();
            }
        }
    </script>
@endpush
