<form action="{{$filter_url}}" method="get" class="tour-filter mb-3">
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-6">
                    <label for="tour_type_id" class="d-flex">
                        {{__('Tour type')}}
                        <field-help class="ml-1" field-name="Tour type"></field-help>
                    </label>
                    <checkbox-select
                        class="tour_type_id"
                        input-name="filter[tour_type_id]"
                        legend="{{__('Choose tour type')}}"
                        :data="[
                        @foreach($tourTypes as $tt)
                        {{"{value:'"}}{{$tt->id}}{{"',label:'"}}{{$tt['name_'.App::getlocale()]}}{{"'},"}}
                        @endforeach
                            ]"
                        @if(isset(request('filter')['tour_type_id']))
                        :filter="{{json_encode(request('filter')['tour_type_id'])}}"
                        @endif
                    ></checkbox-select>
                </div>
                <div class="col-1"></div>
                <div class="col-5">
                    <label for="tour_condition_id" class="d-flex">
                        {{__('Tour conditions')}}
                        <field-help class="ml-1" field-name="Tour conditions"></field-help>
                    </label>
                    <checkbox-select
                        input-name="filter[tour_condition_id]"
                        class="tour_condition_id"
                        legend="{{__('Choose tour conditions')}}"
                        :data="[
                        @foreach($tourConditions as $tс)
                        {{"{value:'"}}{{$tс->id}}{{"',label:'"}}{{$tс['name_'.App::getlocale()]}}{{"'},"}}
                        @endforeach
                            ]"
                        @if(isset(request('filter')['tour_condition_id']))
                        :filter="{{json_encode(request('filter')['tour_condition_id'])}}"
                        @endif
                    ></checkbox-select>
                </div>


            </div>

        </div>
        <div class="col-md-3">
            <label for="tour_dificult" class="d-flex">
                {{__('Tour type complexity')}}
                <field-help class="ml-1" field-name="Tour type complexity"></field-help>
            </label>
            <checkbox-select
                input-name="filter[dificult][]"
                legend="{{__('Choose dificult level')}}"
                :data="[
                @foreach($tourDificults as $td)
                {{"{value:'"}}{{$td->id}}{{"',label:'"}}{{$td['name_'.App::getlocale()]}}{{"'},"}}
                @endforeach
                    ]"
                @if(isset(request('filter')['dificult']))
                :filter="{{json_encode(implode(',',request('filter')['dificult']))}}"
                @endif
            ></checkbox-select>


        </div>
        <div class="col-md-2">
            <label for="filter[more_open_places]" class="d-flex">
                {{__('Open spots')}}
                <field-help class="ml-1" field-name="Open places"></field-help>
            </label>
            <input type="number" class="form-control" name="filter[more_open_places]"
                   @if(isset(request('filter')['more_open_places'])) value="{{request('filter')['more_open_places']}}" @endif/>
        </div>

        <div class="col-md-2">
            <label for="country_iso" class="d-flex">
                {{__('Country')}}
                <field-help class="ml-1" field-name="Country"></field-help>
            </label>
            @include('layouts.partials.country',['showAllCountriesOption'=>true,'country_name'=>'filter[country_iso]','selected'=>(isset(request('filter')['country_iso']))?request('filter')['country_iso']:''])

        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3">
            <label for="filter[more_type_rating]" class="d-flex">
                {{__('Type rating')}}
                <rating-help
                    class="ml-1"
                    field-name="filter[tour_type_id]"
                    popup-name="type_description"
                    rating-name="filter[more_type_rating]"
                ></rating-help>
            </label>
            <star-input
                hidden-input-name="filter[more_type_rating]"
                :show-help="true"
                depended-field="filter[tour_type_id]"
                depended-class-selector="tour_type_id"
                @if(isset(request('filter')['more_type_rating'])) :grade="{{request('filter')['more_type_rating']}}" @endif
            ></star-input>
        </div>
        <div class="col-md-3">
            <label for="filter[more_condition_rating]" class="d-flex">
                {{__('Condition rating')}}
                <rating-help
                    class="ml-1"
                    field-name="filter[tour_condition_id]"
                    popup-name="condition_description"
                    rating-name="filter[more_condition_rating]"
                ></rating-help>
            </label>
            <star-input
                hidden-input-name="filter[more_condition_rating]"
                depended-class-selector="tour_condition_id"
                depended-field="filter[tour_condition_id]"
                @if(isset(request('filter')['more_condition_rating'])) :grade="{{request('filter')['more_condition_rating']}}" @endif
            ></star-input>

        </div>
        <div class="col-md-3">
            <label for="guide" class="d-flex">
                {{__('Guide')}}
                <field-help class="ml-1" field-name="Guide"></field-help>
            </label>
{{--            <checkbox-select--}}
{{--                input-name="filter[guide]"--}}
{{--                legend=""--}}
{{--                :data="[{value:'guided',label:'В сопровождении гида'},{value: 'guide_needed',label: 'Требуется гид'}]"--}}
{{--                @if(isset(request('filter')['guid']))--}}
{{--                :filter="{{json_encode(request('filter')['guide'])}}"--}}
{{--                @endif--}}
{{--            ></checkbox-select>--}}
            <select name="filter[guide]" class="form-control">
                <option selected value>{{__('Choose an option')}}</option>
                <option value="guided"
                        @if(isset(request('filter')['guide'])&&request('filter')['guide']=='guided') selected="selected" @endif>
                    {{__('Guided')}}
                </option>
                <option value="guide_needed"
                        @if(isset(request('filter')['guide'])&&request('filter')['guide']=='guide_needed') selected="selected" @endif>
                    {{__('Guide needed')}}

                </option>
            </select>
            <input type="hidden" name="filter[tour_status]" @if(isset(request('filter')['tour_status']))value="{{request('filter')['tour_status']}}"@endif>
        </div>
        <div class="col-md-3">
            <label for="submit"></label>
            <button class="btn btn-basic col-12 p-3 mt-2"><i class="mdi mdi-magnify"></i>{{__('Find tour')}}</button>
        </div>
    </div>
</form>
{{--<style>--}}
{{--    label {--}}
{{--        font-weight: 500 !important;--}}
{{--        font-size: 14px !important;--}}
{{--        padding-left: 20px;--}}
{{--    }--}}
{{--</style>--}}
