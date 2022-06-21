<div class="card mb-4">

    <div class="card-body">
        <div class="row mb-2">
            <div class="col-2">
                @if($tour['CanEdit'])
                <a class="btn btn-base float-left profile-save ml-2" href="/tours/{{$tour['id']}}/status/done"  onclick="return confirm('{{__('Are you sure you want to run this action?')}}')">
                    <i class="mdi mdi-check-all"></i> {{__('Mark tour as done')}}
                </a>
                @endif
            </div>
            <div class="col-10">
                @if($tour['CanEdit'])
                    @include('tours.partials.buttons')
                @else
                    @if(!\App\Models\Tours::isTourMember($tour['id']))
                        <a class="btn btn-base float-right profile-save ml-2" href="/tours/{{$tour['id']}}/candidate"><i
                                class="mdi mdi-account-plus"></i> {{__('Connect to tour')}}</a>
                    @endif
                @endif
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <h5>{{$tour->tour_name}}</h5>
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
                <label for="" class="pt-1 mr-4">{{__('Type rating')}}</label>
                <star-input
                    hidden-input-name="tour_type_rating"
                    :grade="{{$tour->tour_type_rating}}"
                    :is-disabled="true"
                ></star-input>
            </div>
            <div class="col-md-6 rating-create">
                <label for="" class="pt-1 mr-4">{{__('Condition rating')}}</label>
                <star-input
                    hidden-input-name="tour_condition_rating"
                    :grade="{{$tour->tour_condition_rating}}"
                    :is-disabled="true"
                ></star-input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="d-flex" for="">{{__('Type description')}}</label>
                <div>
                    {{$tour->tour_type_description}}
                </div>
            </div>
            <div class="col-md-12">
                <label class="d-flex" for="">{{__('Conditions description')}}</label>
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
