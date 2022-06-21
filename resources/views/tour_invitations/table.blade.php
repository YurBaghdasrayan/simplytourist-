<div class="table-responsive">
    <table class="table" id="tours-table">
        <thead>
        <tr>
            @if(Request::is('tours*')||Request::is('home*'))
                <th></th>
            @endif
            <th>{{__('Tour name')}}</th>
            <th>{{__('Tour type')}}</th>
            <th>{{__('Type rating')}}</th>
            <th>{{__('Condition rating')}}</th>
            <th>{{__('Open spots')}}</th>
            <th>{{__('Estimated costs')}}</th>
            <th>{{__('Start date')}}</th>
            <th>{{__('Start date')}}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($tours as $tour)
            <tr>
                @if(Request::is('tours*')||Request::is('home*'))
                    <td>
                        @if($tour->CanEdit)
                            <a href="/tours/{{$tour->id}}/edit" class="color-base"><i class="mdi mdi-pencil"></i></a>
                        @endif
                    </td>
                @endif


                <td>
                    @if((Request::is('tours*')||Request::is('home*')||Request::is('invitations*')))
                        <a href="/tours/{{$tour->id}}">{{$tour['tour_name'] }}</a>
                    @else
                        <a href="/public/tour/{{$tour->id}}">{{$tour['tour_name'] }}</a>
                    @endif
                </td>
                <td>
                    {{$tour->tourType['name_'.\App::getLocale()]}}
                </td>
                <td>
                    <star-input :grade="{{$tour['tour_type_rating']}}" :is-disabled="true"></star-input>
                </td>
                <td>
                    <star-input :grade="{{$tour['tour_condition_rating']}}" :is-disabled="true"></star-input>
                </td>
                <td>
                    {{$tour->open_places}}
                </td>
                <td>
                    {{$tour->estimated_costs}}
                </td>
                <td>
                    {{$tour->tour_date_start->format('d.m.Y')}}
                </td>
                <td>
                    <a class="btn btn-success btn-sm" href="/tourInvitations/{{$tour->id}}/status/allow">{{__('Connect to tour')}}</a>
                    <a class="btn btn-danger btn-sm mt-2" href="/tourInvitations/{{$tour->id}}/status/cancel">{{__('Cancel')}}</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

