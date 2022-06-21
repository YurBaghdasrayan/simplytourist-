<div class="table-responsive">
    <table class="table" id="tourCandidates-table">
        <thead>
            <tr>
                <th>{{__('Author')}}</th>
                <th>{{__('Status')}}</th>
                <th>{{__('Comment')}}</th>
                <th>{{__('Date')}}</th>
                @if($tour->canEdit)
                    <th></th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach($tourCandidates as $tourCandidates)
            <tr>
                <td>{{ $tourCandidates->user->name }}</td>
                <td>{{ __($tourCandidates->status) }}</td>
                <td>{{ $tourCandidates->comment }}</td>
                <td>{{ $tourCandidates->created_at }}</td>
                @if($tour->canEdit)
                <td>
                    @if($tourCandidates->status=='new')
                        @if(!\App\Models\Tours::isTourMember($tour->id,$tourCandidates->user->id))
                            <a href="/tourCandidates/{{$tourCandidates->id}}/status/allow" class="btn btn-basic mb-1"><i class="mdi mdi-account-plus-outline"></i>{{__('Add')}}</a>
                            <a href="/tourCandidates/{{$tourCandidates->id}}/status/cancel" class="btn btn-danger"><i class="mdi mdi-minus-circle"></i>{{__('Cancel')}}</a>
                        @endif
                    @endif
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
