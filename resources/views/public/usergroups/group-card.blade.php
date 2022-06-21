<div class="col-md-6">
    <div class="card tour col-md-12">
        <div class="row">
            @if($usergroup->image)
                <div class="col-md-5 card-tour--image-{{$index}}" style="background-image: url('{{'/storage/groups/'.rawurlencode(str_replace('groups/','',$usergroup->image))}}');">
            @else
                <div class="col-md-5 card-tour--image-{{$index}}">
           @endif
                </div>
            <div class="col-md-7 pl-4 pt-2">
                <h6 class="card-tour--header">{{$usergroup->usergroup_name}}</h6>
                <span class="card-tour--main"><i class="mdi mdi-account-group"></i>{{$usergroup->member_count}}</span>
                <span class="card-tour--main"><i class="mdi mdi-information"></i>
                    @if(strlen($usergroup->usergroup_description) > 100)
                        {{substr($usergroup->usergroup_description, 0, 100)}}...
                    @else
                        {{$usergroup->usergroup_description}}
                    @endif
                </span>
            </div>
            <a href="/usergroup/{{$usergroup->id}}/" class="stretched-link"></a>
        </div>
    </div>
</div>
