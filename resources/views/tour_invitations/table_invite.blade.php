<div class="table-responsive">
    <table class="table" id="tours-table">
        <thead>
            <tr>
                    <th>{{__('User name').'/'.__('Email')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Date')}}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($invitationsList as $invitationsList)
            <tr>
                    <td>
                        @if(isset($invitationsList->user_id))
                            {{$invitationsList->user->name}}
                        @else
                            {{$invitationsList->user_email}}
                        @endif
                    </td>
                    <td>
                        @if($invitationsList->send_status==1)
                            ✅
                        @else
                            ⌛
                        @endif
                    </td>
                    <td>
                        {{$invitationsList->updated_at}}
                    </td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
