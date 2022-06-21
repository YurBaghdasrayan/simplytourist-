<div class="table-responsive">
    <table class="table" id="tourCandidates-table">
        <thead>
            <tr>
                <th>{{__('Author')}}</th>
                <th>{{__('Status')}}</th>
                <th>{{__('Comment')}}</th>
                <th>{{__('Date')}}</th>
                @if($group->canEdit)
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach($groupCandidates as $groupCandidate)
            <tr>
                <td>{{ $groupCandidate->user->name }}</td>
                <td>{{ __($groupCandidate->status) }}</td>
                <td>{{ $groupCandidate->comment }}</td>
                <td>{{ $groupCandidate->created_at }}</td>
                @if($group->canEdit)
                <td>
                    @if($groupCandidate->status=='new')
                        @if(!\App\Models\Usergroups::isGroupMember($group->id,$groupCandidate->user->id))
                            <a href="/usergroupCandidates/{{$groupCandidate->id}}/status/allow" class="btn btn-basic mb-1"><i class="mdi mdi-account-plus-outline"></i>{{__('Add')}}</a>
                            <a href="/usergroupCandidates/{{$groupCandidate->id}}/status/cancel" class="btn btn-danger"><i class="mdi mdi-minus-circle"></i>{{__('Cancel')}}</a>
                        @endif
                    @endif
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
