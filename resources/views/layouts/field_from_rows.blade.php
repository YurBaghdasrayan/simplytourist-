@foreach($rows as $row)
    @if($field===$row['field'])
        @include('layouts.form',['row'=>$row])
    @endif
@endforeach
