<form action="{{$filter_url}}" method="get" class="tour-filter mb-3 col-12">
    <div class="row">
        <div class="col-md-3">
            <label for="country_iso" class="d-flex">
                {{__('Name of usergroup')}}
                <field-help class="ml-1" field-name="Usergroup name"></field-help>
            </label>
            <input type="text"
                   value="{{(isset(request('filter')['usergroup_name']))?request('filter')['usergroup_name']:''}}"
                   name="filter[usergroup_name]"
                   class="form-control" placeholder="{{__('Name of usergroup')}}">
        </div>
        <div class="col-md-3">
            <label for="country_iso" class="d-flex">
                {{__('Usergroup description')}}
                <field-help class="ml-1" field-name="Usergroup description"></field-help>
            </label>
            <input type="text"
                   name="filter[usergroup_description]"
                   value="{{(isset(request('filter')['usergroup_description']))?request('filter')['usergroup_description']:''}}"
                   class="form-control"
                   placeholder="{{__('Usergroup description')}}">
        </div>
        <div class="col-md-3">
            <label for="country_iso" class="d-flex">
                {{__('Usergroup country')}}
                <field-help class="ml-1" field-name="Usergroup country"></field-help>
            </label>
            @include('layouts.partials.country',['showAllCountriesOption'=>true,'country_name'=>'filter[country_iso]','selected'=>(isset(request('filter')['country_iso']))?request('filter')['country_iso']:''])

        </div>
        <div class="col-md-3">
            <label for="submit"></label>
            <button class="btn btn-basic col-12 p-3 mt-2"><i class="mdi mdi-magnify"></i>{{__('Search')}}</button>
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
