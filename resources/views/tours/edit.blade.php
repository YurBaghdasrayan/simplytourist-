@extends('layouts.app')

@section('content')

    <div class="content px-3">
        <div role="alert" class="alert alert-danger" id="errors" style="display: none">
        </div>
{{--        @include('adminlte-templates::common.errors')--}}
        @include('flash::message')
        <form id="add_tour" method="post" action="{{route('tours.update',$tours['id'])}}" enctype="multipart/form-data" onsubmit="event.preventDefault();return false;">
            @method('put')
            @csrf
            <div class="card mb-4">


                <div class="card-body">
                    <div class="row mb-2">
                        @php($tour=$tours)
                        <div class="col-2">
                            <a class="btn btn-base float-left profile-save ml-2" href="/tours/{{$tour['id']}}/status/done"  onclick="return confirm('{{__('Are you sure you want to run this action?')}}')">
                                <i class="mdi mdi-check-all"></i> {{__('Mark tour as done')}}
                            </a>
                        </div>
                        <div class="col-10">
                            <button class="btn btn-basic float-right profile-save ml-2"  onclick="formSubmit(true)"><i class="mdi mdi-content-save"></i> {{__('Save changes')}}</button>
                            @include('tours.partials.buttons')
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <label class="form-label d-flex" for="">
                                {{__('Tour name')}}
                                <field-help class="ml-1" field-name="Tour name"></field-help>
                            </label>
                            <input type="text" class="form-control" name="tour_name" value="{{$tours['tour_name']}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label d-flex" for="country_iso">
                                {{__('Country')}}
                                <field-help class="ml-1" field-name="Country"></field-help>
                            </label>
                            @include('layouts.partials.country',['country_name'=>'country_iso','selected'=>$tours['country_iso']])
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label d-flex" for="tour_type_id">
                                        {{__('Tour type')}}
                                        <field-help class="ml-1" field-name="Tour type"></field-help>
                                    </label>
                                    <select name="tour_type_id" class="form-control" id="">
                                        @foreach($tourTypes as $tt)
                                            <option value="{{$tt->id}}" @if($tours['tour_type_id']==$tt->id) selected="selected"@endif>{{$tt['name_'.App::getlocale()]}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label d-flex" class="form-label" for="tour_dificult">
                                        {{__('Tour type complexity')}}
                                        <field-help class="ml-1" field-name="Tour type complexity"></field-help>
                                    </label>
                                    <checkbox-select
                                        input-name="tour_dificult"
                                        legend="Выберите уровень сложности"
                                        :data="[
                                                @foreach($tourDificults as $td)
                                                {{"{value:'"}}{{$td->id}}{{"',label:'"}}{{$td['name_'.App::getlocale()]}}{{"'},"}}
                                                @endforeach
                                            ]"
                                        @if(isset($tourDificultList))
                                            :filter="{{json_encode($tourDificultList)}}"
                                        @endif
                                    ></checkbox-select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-flex" for="tour_condition_id">
                                {{__('Tour conditions')}}
                                <field-help class="ml-1" field-name="Tour conditions"></field-help>
                            </label>
                            <select name="tour_condition_id" class="form-control" id="">
                                @foreach($tourConditions as $tс)
                                    <option value="{{$tс->id}}" @if($tours['tour_condition_id']==$tс->id) selected="selected"@endif>{{$tс['name_'.App::getlocale()]}}</option>
                                @endforeach
                            </select>
                        </div>
{{--                        <div class="col-md-2">--}}
{{--                            <label class="form-label d-flex" for="status">--}}
{{--                                {{__('Status')}}--}}
{{--                                <field-help class="ml-1" field-name="Status"></field-help>--}}
{{--                            </label>--}}
{{--                            <select name="tour_status" class="form-control" id="">--}}
{{--                                <option value="open" @if($tours['tour_status']=='open') selected="selected"@endif>{{__('Open')}}</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                    </div>
                    <div class="row">
                        <div class="col-md-6 rating-create">
                            <label for="" class="form-label pt-1 mr-4">
                                {{__('Type rating')}}
                            </label>
                            <star-input
                                hidden-input-name="tour_type_rating"
                                :grade="{{$tours['tour_type_rating']}}"
                            ></star-input>
                        </div>
                        <div class="col-md-6 rating-create">
                            <label for="" class="form-label pt-1 mr-4">
                                {{__('Condition rating')}}
                            </label>
                            <star-input
                                hidden-input-name="tour_condition_rating"
                                :grade="{{$tours['tour_condition_rating']}}"
                            ></star-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label d-flex" for="">
                                {{__('Type description')}}
                            </label>
                            <rating-text
                                hidden-input-name="tour_type_rating"
                                depended-field="tour_type_id"
                                endpoint="/help/rating/type_description/"
                                result-input="tour_type_description"
                            ></rating-text>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label d-flex" for="">
                                {{__('Conditions description')}}
                            </label>
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
                                    <input type="date" class="date form-control" name="tour_date_start" value="{{date("Y-m-d", strtotime($tours['tour_date_start']) )}}"  onchange="changeStartDate()">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label d-flex" for="">
                                        {{__('End date')}}
                                        <field-help class="ml-1" field-name="Date end"></field-help>
                                    </label>
                                    <input type="date" class="date form-control" name="tour_date_end" value="{{date("Y-m-d", strtotime($tours['tour_date_end']))}}">
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
                                        <option value="no" @if($tours['tour_private']==0)selected="selected"@endif>{{__('No')}}</option>
                                        <option value="yes" @if($tours['tour_private']==1)selected="selected"@endif>{{__('Yes')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label d-flex pl-1" for="">
                                        {{__('Attendees min.')}}
                                        <field-help class="ml-1" field-name="Attendees min."></field-help>
                                    </label>
                                    <input type="number" name="attendees_min" class="form-control" value="{{$tours['attendees_min']}}">
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
                                    <input type="number" name="attendees_max" class="form-control" value="{{$tours['attendees_max']}}" id="attendees_max">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label d-flex" for="">
                                        {{__('Open spots')}}
                                        <field-help class="ml-1" field-name="Open places"></field-help>
                                    </label>
                                    <input type="number" name="open_places" disabled class="form-control" value="{{$tours['open_places']}}" id="open_places">
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
                                <option value="no" @if($tours['guide_needed']==0)selected="selected"@endif>{{__('No')}}</option>
                                <option value="yes" @if($tours['guide_needed']==1)selected="selected"@endif>{{__('Yes')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label d-flex" for="">
                                {{__('Guided')}}
                                <field-help class="ml-1" field-name="Guided"></field-help>
                            </label>
                            <select name="guided" id="" class="form-control">
                                <option value="no" @if($tours['guided']==0)selected="selected"@endif>{{__('No')}}</option>
                                <option value="yes" @if($tours['guided']==1)selected="selected"@endif>{{__('Yes')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label d-flex" for="">
                                        {{__('Estimated costs')}}
                                        <field-help class="ml-1" field-name="Estimated costs"></field-help>
                                    </label>
                                    <input type="text" class="form-control" name="estimated_costs" value="{{$tours['estimated_costs']}}">
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
                                        @if($geoObject)
                                        :preselected="{{json_encode(['id' => $geoObject->id, 'text' => $geoObject['name_'.\App::getLocale()].'('.\App\Models\Languages::getCountry($geoObject->country_iso).')'])}}"
                                        @endif
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
                                    @include('layouts.partials.country',['country_name'=>'geo_country_iso','selected'=>false])
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
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">{{__('Description')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">{{__('Equipment')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">{{__('Attendees')}}</a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link"  data-toggle="pill" href="#custom-tabs-one-discussion" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">--}}
{{--                            {{__('Discussion')}}--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4 mr-4">
                                        <label class="form-label" for="">{{__('Image')}}</label>
                                        @if(isset($data['image']))
                                            <img alt="{{Auth::user()->name}}"
                                                 src="/storage/{{$data['image']}}"
                                                 class="avatar"/>
                                        @endif
                                    </div>
                                    <div class="col-md-7 ">
                                        <div class="col-12 h-100">
                                            <span id="file-chosen" class="mt-4">{{__('No file chosen')}}</span>
                                            <label for="avatar" class="btn btn-basic avatar__upload mb-0"><i class="mdi mdi-image"></i>{{__('Upload photo')}}</label>
                                            <input id="avatar"  style="display:none;" type="file" name="image"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-12">
                                        <label class="form-label d-flex" for="">
                                            {{__('Tour link')}}
                                            <field-help class="ml-1" field-name="Tour link"></field-help>
                                        </label>
                                        <input type="text" class="form-control" name="tour_link" value="{{$tours['tour_link']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label d-flex" for="">
                                    {{__('Description')}}
                                    <field-help class="ml-1" field-name="Description"></field-help>
                                </label>
                                <textarea name="tour_description" class="form-control resize-ta"
                                          rows="5">{{$tours['tour_description']}}</textarea>
                            </div>
                            <div class="col-md-12 text-center">
                                @if($tour['CanEdit'])
                                    <a class="btn btn-base float-right profile-save mt-2" href="/tours/{{$tour['id']}}/status/canceled"   onclick="return confirm('{{__('Are you sure you want to run this action?')}}')">
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
                                {'Equipment is currently loading...':'{{__('Equipment is currently loading...')}}'},
                                {'Not found':'{{__('Not Found')}}'},
                                {'selected':'{{__('selected')}}'},
                                {'Note':'{{__('Note')}}'},
                                {'Save':'{{__('Save')}}'},
                                {'Add note':'{{__('Add note')}}'},
                                ]"
                            locale-lang="{{App::getLocale()}}"
                            :preselected="{{json_encode($tourEquipment)}}"
                            :selected-qty="{{json_encode($tourEquipmentQTY)}}"
                            :editable="true"
                        ></tour-equipment>

                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
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
                            :attends="{{$tourAttend}}"
                            locale-lang="{{App::getLocale()}}"
                        ></tour-invites>
                    </div>
{{--                    <div class="tab-pane fade" id="custom-tabs-one-discussion" role="tabpanel" aria-labelledby="custom-tabs-one-discussion-tab">--}}
{{--                        <section class="content-header">--}}
{{--                            <div class="container-fluid">--}}
{{--                                <div class="row mb-2">--}}
{{--                                    <div class="mx-auto">--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <a class="btn btn-basic float-right" href="/tours/{{$tour['id']}}/theme/create"><i class="mdi mdi-plus-circle"></i> {{__('Add discussion')}}</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </section>--}}
{{--                        @if(isset($tour['tourDiscussion'])&&count($tour['tourDiscussion'])>0)--}}
{{--                            <table class="table" id="equipment-table">--}}
{{--                                <thead>--}}
{{--                                <tr>--}}
{{--                                    <th>{{__('Topic')}}</th>--}}
{{--                                    <th></th>--}}
{{--                                    <th></th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @foreach($tour['tourDiscussion'] as $discussion)--}}
{{--                                    <tr>--}}
{{--                                        <td><a href="/tours/themes/{{$discussion->id}}">{{$discussion->theme}}</a></td>--}}
{{--                                        <td>{{$discussion->user->name}}</td>--}}
{{--                                        <td>{{$discussion->created_at}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}

{{--                        @endif--}}

{{--                    </div>--}}
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
        function updatePlaces(){
            const attendees = document.getElementById('attendees_max').value;
            let users = document.querySelector('input[name$="selected_users"]').value;
            if(users!=''){
                users=users.split(',').length;
            }else{
                users=0;
            }
            const openPlaces=document.getElementById('open_places');
            if(!attendees)
                openPlaces.value=0;
            else
                openPlaces.value=attendees;
            if(users>0){
                if(attendees>users){
                    openPlaces.value=attendees-users;
                }else{
                    openPlaces.value=0;
                }
            }
        }
        document.addEventListener('DOMContentLoaded', init, false);
        function init(){
            const actualBtn = document.getElementById('avatar');
            const fileChosen = document.getElementById('file-chosen');
            actualBtn.addEventListener("change", function(){
                fileChosen.textContent = this.files[0].name
            })
            //Динамический расчет open_places при изменении одного из input ниже
            const attendees = document.getElementById('attendees_max');
            const users = document.querySelector('input[name$="selected_users"]');
            attendees.addEventListener("change", function(){
                updatePlaces();
            });
            //Обновление значения скрытого поля
            users.addEventListener('change', updatePlaces);
            setInterval(function() {
                users.dispatchEvent(new Event('change', { 'changed': true }));
            }, 3000);
        };


    </script>
@endpush
