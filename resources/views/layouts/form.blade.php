@switch($row['type'])
    @case('image')
    @if($row['field']=='avatar')
        <div class="row">
            <div class="col-md-4 mr-4">
                <label class="form-label d-flex" for="">{{__('My photo')}}</label>
                <img alt="{{Auth::user()->name}}"
                     src="@if((strpos($data[0]['avatar'],'https://')) !== 0)/storage/@endif{{$data[0]['avatar']}}"
                     class="avatar"/>
            </div>
            <div class="col-md-7 ">
                <div class="col-12 h-100">
                    <span id="file-chosen" class="mt-4">{{__('No file chosen')}}</span>
                    <label for="avatar" class="btn btn-basic avatar__upload mb-0"><i class="mdi mdi-account-box"></i>{{__('Upload photo')}}</label>
                    <input id="avatar" class="avatar__upload" type="file" name="{{$row['field']}}"/>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-4 mr-4">
                <label class="form-label" for="">{{__($row['display_name'])}}</label>
                @if(isset($data[0][$row['field']]))
                <img alt="{{Auth::user()->name}}"
                     src="/storage/{{$data[0][$row['field']]}}"
                     class="avatar"/>
                @endif
            </div>
            <div class="col-md-7 ">
                <div class="col-12 h-100">
                    <span id="file-chosen" class="mt-4">{{__('No file chosen')}}</span>
                    <label for="avatar" class="btn btn-basic avatar__upload mb-0"><i class="mdi mdi-image"></i>{{__('Upload photo')}}</label>
                    <input id="avatar"  style="display:none;" type="file" name="{{$row['field']}}"/>
                </div>
            </div>
        </div>

    @endif
    @break

    @case('text')
    <label class="form-label d-flex" for="{{$row['field']}}">
        {{__($row['display_name'])}}
        <field-help class="ml-1" :field-name="{{json_encode($row['display_name'])}}"></field-help>
    </label>
    <input type="text" class="form-control" name="{{$row['field']}}" placeholder="{{__($row['display_name'])}}"
           value="{{$data[0][$row['field']]}}"><br/>
    @break
    @case('relationship')
    @break
    @case('text_area')
    <label class="form-label d-flex" for="{{$row['field']}}">{{__($row['display_name'])}}<field-help class="ml-1" :field-name="{{json_encode($row['display_name'])}}"></field-help></label>
    <textarea type="text" class="form-control resize-ta" name="{{$row['field']}}" placeholder="{{__($row['display_name'])}}"
    >{{$data[0][$row['field']]}}</textarea><br/>
    @break
    @case('checkbox')
    <div class="form-check">
        {{Form::hidden($row['field'],0)}}
        <toggle-button @if($data[0][$row['field']]>0||$data[0][$row['field']]=='on')value="on"
                       @endif
                       @if(isset($row['disabled']))
                           :disabled="true"
                       @endif
                       :name="{{json_encode($row['field'])}}" :labels="false"></toggle-button>
        {{--        <input type="checkbox" class="form-check-input" name="{{$row['field']}}" @if($data[0][$row['field']]>0||$data[0][$row['field']]=='on')checked="checked"@endif/>--}}
        <label class="form-check-label d-inline-flex">{{__($row['display_name'])}}<field-help class="ml-1" :field-name="{{json_encode($row['display_name'])}}"></field-help></label>
    </div>
    @break
    @default
    {{__($row['display_name'])}}:<br/>
    <input type="text" class="form-control" name="{{$row['field']}}" placeholder="{{__($row['display_name'])}}"
           value="{{$data[0][$row['field']]}}"><br/>
@endswitch
