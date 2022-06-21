<div class="col-md-6">
    <div class="card tour col-md-12">
        <div class="row">
            @if($tour->image)
                <div class="col-md-5 card-tour--image-{{$index}}" style="background-image: url({{'/storage/tours/'.rawurlencode(str_replace('tours/','',$tour->image))}}) !important;">
            @else
                <div class="col-md-5 card-tour--image-{{$index}}">
            @endif
        </div>
            <div class="col-md-7 pl-4 pt-2">
                <h6 class="card-tour--header">{{$tour->tour_name}}</h6>
                <span class="card-tour--subheader">{{$tour->tourType['name_'.\App::getLocale()]}}</span>
                <span class=""><star-input :grade="{{$tour['tour_type_rating']}}" :is-disabled="true"></star-input></span>
                <span class="card-tour--main"><i class="mdi mdi-account-group"></i>{{$tour->open_places}}</span>
                <span class="card-tour--main"><i class="mdi mdi-cash"></i>{{$tour->estimated_costs}}</span>
                <span class="card-tour--main"><i class="mdi mdi-calendar"></i>{{$tour->tour_date_start->format('d.m.Y')}}</span>
            </div>
            <a href="/public/tour/{{$tour->id}}" class="stretched-link"></a>
        </div>
    </div>
</div>
