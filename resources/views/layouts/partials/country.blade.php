{{--
 Пример использования
 @include('layouts.partials.country',['country_name'=>'about_address_country','selected'=>$data[0]->about_address_country])
--}}
@php
    $countries=\App\Models\Languages::getCountries();
    asort($countries);
@endphp
<select class="form-control" name="{{$country_name}}">

    @if($showAllCountriesOption ?? false)
        <option value="" selected>{{__('Select All')}}</option>
    @else
        <option disabled selected>{{__('Choose an option')}}</option>
    @endif

    @foreach($countries as $iso_code=>$name)
        <option value="{{strtolower($iso_code)}}" @if(($selected)&&strtoupper($selected)===$iso_code)selected="selected"@endif>{{$name}}</option>
    @endforeach
</select>
