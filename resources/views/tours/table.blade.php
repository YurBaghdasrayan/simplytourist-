<div class="table-responsive">
    <table class="table" id="tours-table">
        <thead>
            <tr>
{{--                @if(Request::is('tours*')||Request::is('home*'))--}}
{{--                    <th></th>--}}
{{--                @endif--}}
                    <th>{{__('Tour name')}}</th>
                    <th>{{__('Tour type')}}</th>
                    <th>{{__('Type rating')}}</th>
                    <th>{{__('Condition rating')}}</th>
                    <th>{{__('Open spots')}}</th>
                    <th>{{__('Estimated costs')}}</th>
                    <th>{{__('Start date')}}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tours as $tour)
            <tr>
{{--                @if(Request::is('tours*')||Request::is('home*'))--}}
{{--                <td>--}}
{{--                    @if($tour->CanEdit)--}}
{{--                        <a href="/tours/{{$tour->id}}/edit" class="color-base"><i class="mdi mdi-pencil"></i></a>--}}
{{--                    @endif--}}
{{--                </td>--}}
{{--                @endif--}}


                    <td>
                        @if((Request::is('tours*')||Request::is('home*')))
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
                        {{$tour->OpenPlacez}}
                    </td>
                    <td>
                        {{$tour->estimated_costs}}
                    </td>
                    <td>
                        {{$tour->tour_date_start->format('d.m.Y')}}
                    </td>
{{--                        @if($row['field']=='tour_name')--}}
{{--                            @if((Request::is('tours*')||Request::is('home*')))--}}
{{--                                <a href="/tours/{{$tour->id}}">{{$tour[$row['field']] }}</a>--}}
{{--                            @else--}}
{{--                                <a href="/public/tour/{{$tour->id}}">{{$tour[$row['field']] }}</a>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            @if($row->type == 'relationship')--}}

{{--                                    @php--}}
{{--                                        $relationshipData = (isset($data)) ? $data : $dataTypeContent;--}}
{{--                                        $model = app($row->details->model);--}}
{{--                                        $query = $model::where($row->details->key,$tour[$row->details->column])->first();--}}
{{--                                    @endphp--}}

{{--                                    @if(isset($query))--}}
{{--                                        @if($row['field']==='tour_belongsto_language_relationship')--}}
{{--                                            {{\App\Models\Languages::getCountry($tour['country_iso'])}}--}}
{{--                                        @else--}}
{{--                                            <p>{{ $query->{$row->details->label} }}</p>--}}
{{--                                        @endif--}}
{{--                                    @else--}}
{{--                                        <p>{{ __('voyager::generic.no_results') }}</p>--}}
{{--                                    @endif--}}
{{--                            @else--}}
{{--                                @if(in_array($row['field'],['tour_condition_rating','tour_type_rating']))--}}
{{--                                    <star-input :grade="{{$tour[$row['field']]}}" :is-disabled="true"></star-input>--}}

{{--                                @else--}}
{{--                                    {{$tour[$row['field']] }}--}}
{{--                                @endif--}}
{{--                            @endif--}}
{{--                        @endif--}}
{{--                    </td>--}}
{{--                <td width="120">--}}
{{--                    {!! Form::open(['route' => ['tours.destroy', $tour->id], 'method' => 'delete']) !!}--}}
{{--                    <div class='btn-group'>--}}
{{--                        <a href="{{ route('tours.show', [$tour->id]) }}" class='btn btn-default btn-xs'>--}}
{{--                            <i class="far fa-eye"></i>--}}
{{--                        </a>--}}
{{--                        <a href="{{ route('tours.edit', [$tour->id]) }}" class='btn btn-default btn-xs'>--}}
{{--                            <i class="far fa-edit"></i>--}}
{{--                        </a>--}}
{{--                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
{{--                    </div>--}}
{{--                    {!! Form::close() !!}--}}
{{--                </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
