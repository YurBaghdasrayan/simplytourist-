@if($tour['tour_status']!=='done')
<a class="btn btn-base float-right profile-save ml-2" href="/tours/{{$tour['id']}}/invitations/">
    <i class="mdi mdi-email-send"></i> {{__('Send invitations')}}
</a>
<a class="btn btn-base float-right profile-save ml-2" href="/tours/{{$tour['id']}}/candidate/">
    <i class="mdi mdi-account-group"></i> {{__('Tour applicants')}}
</a>

@endif
@if(request()->route()->getName()!='tours.edit')
<a class="btn btn-base float-right profile-save" href="/tours/{{$tour['id']}}/edit">
    <i class="mdi mdi-pencil"></i> {{__('Edit tour')}}
</a>
@endif
