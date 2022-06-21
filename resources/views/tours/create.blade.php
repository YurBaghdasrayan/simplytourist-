@extends('layouts.app')

@section('content')

    <div class="content px-3">
        <div role="alert" class="alert alert-danger" id="errors" style="display: none">
        </div>
        @include('adminlte-templates::common.errors')
        <form id="add_tour" method="post" action="{{route('tours.store')}}"
              onsubmit="event.preventDefault();return false;"
              enctype="multipart/form-data">
            @csrf
            <div class="card mb-4">

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-basic float-right profile-save" onclick="formSubmit(true)"><i
                                    class="mdi mdi-content-save"></i> {{__('Save changes')}}</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label d-flex" for="">
                                {{__('Tour name')}}
                                <field-help class="ml-1" field-name="Tour name"></field-help>
                            </label>
                            <input type="text" class="form-control col" name="tour_name"
                                   placeholder="{{__('Tour name')}}" value="{{old('tour_name')}}" required="required">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label d-flex" for="country_iso">
                                {{__('Country')}}
                                <field-help class="ml-1" field-name="Country"></field-help>
                            </label>
                            @include('layouts.partials.country',['country_name'=>'country_iso','selected'=>old('country_iso')])
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label d-flex" for="tour_type_id">
                                        {{__('Tour type')}}
                                        <field-help class="ml-1" field-name="Tour type"></field-help>
                                    </label>
                                    <select name="tour_type_id" class="form-control" id="" required>
                                        <option disabled selected>{{__('Choose an option')}}</option>
                                        @foreach($tourTypes as $tt)
                                            <option value="{{$tt->id}}"
                                                    @if($tt->id==old('tour_type_id')) selected="selected" @endif>{{$tt['name_'.App::getlocale()]}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label d-flex" for="tour_dificult">
                                        {{__('Tour type complexity')}}
                                        <field-help class="ml-1" field-name="Tour type complexity"></field-help>
                                    </label>
                                    <checkbox-select
                                        input-name="tour_dificult"
                                        legend="{{__('Choose dificult level')}}"
                                        :data="[
                                        @foreach($tourDificults as $td)
                                        {{"{value:'"}}{{$td->id}}{{"',label:'"}}{{$td['name_'.App::getlocale()]}}{{"'},"}}
                                        @endforeach
                                            ]"
                                    ></checkbox-select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label d-flex" for="tour_condition_id">
                                {{__('Tour conditions')}}
                                <field-help class="ml-1" field-name="Tour conditions"></field-help>
                            </label>
                            <select name="tour_condition_id" class="form-control" id="" required>
                                <option disabled selected>{{__('Choose an option')}}</option>
                                @foreach($tourConditions as $tс)
                                    <option value="{{$tс->id}}"
                                            @if($tс->id==old('tour_condition_id')) selected="selected" @endif>{{$tс['name_'.App::getlocale()]}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--                    <div class="col-md-3">--}}
                        <input type="hidden" name="tour_status" value="open">
                        {{--                        <label class="form-label d-flex" for="status">--}}
                        {{--                            {{__('Status')}}--}}
                        {{--                            <field-help class="ml-1" field-name="Status"></field-help>--}}
                        {{--                        </label>--}}
                        {{--                        <select name="tour_status" class="form-control" id="">--}}
                        {{--                            <option value="open">{{__('Open')}}</option>--}}
                        {{--                        </select>--}}
                        {{--                    </div>--}}
                    </div>
                    <div class="row">
                        <div class="col-md-6 rating-create">
                            <label for="" class="form-label pt-1 mr-4">{{__('Type rating')}}</label>
                            @if(old('tour_type_rating')>0)
                                <star-input
                                    hidden-input-name="tour_type_rating"
                                    :grade="{{old('tour_type_rating')}}"
                                ></star-input>
                            @else
                                <star-input
                                    hidden-input-name="tour_type_rating"
                                ></star-input>
                            @endif

                        </div>
                        <div class="col-md-6 rating-create">
                            <label for="" class="form-label pt-1 mr-4">{{__('Condition rating')}}</label>
                            @if(old('tour_condition_rating')>0)
                                <star-input
                                    hidden-input-name="tour_condition_rating"
                                    :grade="{{old('tour_condition_rating')}}"
                                ></star-input>
                            @else
                                <star-input
                                    hidden-input-name="tour_condition_rating"
                                ></star-input>
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label d-flex" for="">{{__('Type description')}}</label>
                            <rating-text
                                hidden-input-name="tour_type_rating"
                                depended-field="tour_type_id"
                                endpoint="/help/rating/type_description/"
                                result-input="tour_type_description"
                            ></rating-text>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label d-flex" for="">{{__('Conditions description')}}</label>
                            <rating-text
                                hidden-input-name="tour_condition_rating"
                                depended-field="tour_condition_id"
                                endpoint="/help/rating/condition_description/"
                                result-input="tour_condition_description"
                            ></rating-text>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">


                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">

                                <div class="col-md-6">
                                    <label class="form-label d-flex" for="">
                                        {{__('Start date')}}
                                        <field-help class="ml-1" field-name="Date start"></field-help>
                                    </label>
                                    <input type="date" class="date form-control" name="tour_date_start" value="{{date('Y-m-d')}}" onchange="changeStartDate()">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label d-flex" for="">
                                        {{__('End date')}}
                                        <field-help class="ml-1" field-name="Date end"></field-help>
                                    </label>
                                    <input type="date" class="date form-control" name="tour_date_end" value="{{date('Y-m-d')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label d-flex" for="">
                                        {{__('Private tour')}}
                                        <field-help class="ml-1" field-name="Private tour"></field-help>
                                    </label>
                                    <select name="tour_private" id="" class="form-control">
                                        <option value="no">{{__('No')}}</option>
                                        <option value="yes">{{__('Yes')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label d-flex pl-1" for="">
                                        {{__('Attendees min.')}}
                                        <field-help class="ml-1" field-name="Attendees min."></field-help>
                                    </label>
                                    <input type="number" name="attendees_min" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label d-flex pl-1" for="">
                                        {{__('Attendees max.')}}
                                        <field-help class="ml-1" field-name="Attendees max."></field-help>
                                    </label>
                                    <input type="number" name="attendees_max" class="form-control" id="attendees_max">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label d-flex pl-1" for="">
                                        {{__('Open spots')}}
                                        <field-help class="ml-1" field-name="Open places"></field-help>
                                    </label>
                                    <input type="number" name="open_places" class="form-control" disabled
                                           id="open_places">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <label class="form-label d-flex" for="">
                                {{__('Guide needed')}}
                                <field-help class="ml-1" field-name="Guide needed"></field-help>

                            </label>
                            <select name="guide_needed" id="" class="form-control">
                                <option value="no">{{__('No')}}</option>
                                <option value="yes">{{__('Yes')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-flex" for="">
                                {{__('Guided')}}
                                <field-help class="ml-1" field-name="Guided"></field-help>
                            </label>
                            <select name="guided" id="" class="form-control">
                                <option value="no">{{__('No')}}</option>
                                <option value="yes">{{__('Yes')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label d-flex" for="">
                                        {{__('Estimated costs')}}
                                        <field-help class="ml-1" field-name="Estimated costs"></field-help>
                                    </label>
                                    <input type="text" class="form-control" name="estimated_costs">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label d-flex" for="">
                                        {{__('Main destination')}}
                                        <field-help class="ml-1" field-name="Main destination"></field-help>
                                    </label>
                                    <coordinate-selector
                                        :translations="[
                                            {'Input destination name':'{{__('Input destination name')}}'},
                                            {'Not Found':'{{__('Not Found')}}'},
                                            ]"
                                    ></coordinate-selector>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label d-flex" for="">
                                        {{__('Main destination')}} - {{__('Country')}}
                                        <field-help class="ml-1" field-name="Main destination - Country"></field-help>
                                    </label>
                                    @include('layouts.partials.country',['country_name'=>'geo_country_iso','selected'=>old('geo_country_iso')])
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label d-flex" for="">
                                        {{__('Create main destination - coordinates')}}
                                        <field-help class="ml-1" field-name="Create main destination - coordinates"></field-help>
                                    </label>
                                    <input type="text" name="geo_object_coordinates" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label d-flex" for="">
                                        {{__('Create main destination - name')}}
                                        <field-help class="ml-1" field-name="Create main destination - name"></field-help>
                                    </label>
                                    <input type="text" name="geo_object_name" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="mb-4">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                           href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                           aria-selected="true">{{__('Description')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                           href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                           aria-selected="false">{{__('Equipment')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                           href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                           aria-selected="false">{{__('Attendees')}}</a>
                    </li>
                </ul>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                         aria-labelledby="custom-tabs-one-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                @include('layouts.field_from_rows',['rows'=>$rows,'field'=>'image'])
                            </div>
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-12">
                                        <label class="form-label d-flex" for="">
                                            {{__('Tour link')}}
                                            <field-help class="ml-1" field-name="Tour link"></field-help>

                                        </label>
                                        <input type="text" class="form-control" name="tour_link">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label d-flex" for="">
                                    {{__('Description')}}
                                    <field-help class="ml-1" field-name="Description"></field-help>
                                </label>
                                <textarea name="tour_description" class="form-control resize-ta"
                                          rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                         aria-labelledby="custom-tabs-one-profile-tab">
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
                                {'Equipment is currently loading...':'{{__('Equipment is currently loading...')}}'},
                                {'Not found':'{{__('Not Found')}}'},
                                {'selected':'{{__('selected')}}'},
                                {'Note':'{{__('Note')}}'},
                                {'Save':'{{__('Save')}}'},
                                {'Add note':'{{__('Add note')}}'},
                                ]"
                            locale-lang="{{App::getLocale()}}"
                            :editable="true"
                        ></tour-equipment>

                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                         aria-labelledby="custom-tabs-one-messages-tab">
                        <tour-invites
                            :categories="{{\App\Models\EquipmentType::getEquipmentsType(App::getLocale())}}"
                            :translations="[
                                {'Back':'{{__('Back')}}'},
                                {'Add':'{{__('Add')}}'},
                                {'Users':'{{__('Users')}}'},
                                {'Add users':'{{__('Add users')}}'},
                                {'Yes':'{{__('Yes')}}'},
                                {'No':'{{__('No')}}'},
                                {'User name':'{{__('User name')}}'},
                                {'Country':'{{__('Country')}}'},
                                {'Administrator':'{{__('Administrator')}}'},
                                {'Delete':'{{__('Delete')}}'},
                                {'Not found':'{{__('Not Found')}}'},
                                {'selected':'{{__('selected')}}'},
                                ]"
                            locale-lang="{{App::getLocale()}}"
                        ></tour-invites>
                    </div>
        </form>
        <!-- /.card -->
    </div>
    </div>
    </div>
    @include('layouts.partials.autoresize_textarea_script')
@endsection

@push('scripts')
    <script src="/js/endDateToStartDate.js"></script>
    <script>
        function formSubmit(fromButton = false) {
            let form = document.getElementById("add_tour");
            let fd = new FormData(form)

            //Валидируем форму до отправки на сервер
            $.ajax({
                url: "/tour/validate",
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (dataofconfirm) {
                    // do something with the result
                    let errors = Object.values(dataofconfirm)
                    if (errors.length > 0) {
                        $('#errors').show()
                        $('#errors').html('');
                        for (key in errors) {
                            $('#errors').append('<p>' + errors[key] + '</p>');
                        }
                    } else {
                        let chk_status = form.checkValidity();
                        console.log(form.reportValidity())
                        form.reportValidity();
                        if (chk_status) {
                            form.submit();
                        }
                    }

                }
            });

        }

        function updatePlaces() {
            const attendees = document.getElementById('attendees_max').value;
            let users = document.querySelector('input[name$="selected_users"]').value;
            if (users != '') {
                users = users.split(',').length;
            } else {
                users = 0;
            }
            const openPlaces = document.getElementById('open_places');
            if (!attendees)
                openPlaces.value = 0;
            else
                openPlaces.value = attendees;
            if (users > 0) {
                if (attendees > users) {
                    openPlaces.value = attendees - users;
                } else {
                    openPlaces.value = 0;
                }
            }
        }

        document.addEventListener('DOMContentLoaded', init, false);

        function init() {
            const actualBtn = document.getElementById('avatar');
            const fileChosen = document.getElementById('file-chosen');
            actualBtn.addEventListener("change", function () {
                fileChosen.textContent = this.files[0].name
            });
            //Динамический расчет open_places при изменении одного из input ниже
            const attendees = document.getElementById('attendees_max');
            const users = document.querySelector('input[name$="selected_users"]');
            attendees.addEventListener("change", function () {
                updatePlaces();
            });
            //Обновление значения скрытого поля
            users.addEventListener('change', updatePlaces);
            setInterval(function () {
                users.dispatchEvent(new Event('change', {'changed': true}));
            }, 3000);
        };
    </script>
@endpush
