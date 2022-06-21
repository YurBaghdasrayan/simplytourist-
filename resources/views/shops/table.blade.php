<div class="table-responsive">
    <table class="table" id="shops-table">
        <thead>
            <tr>
                <th>Name Ru</th>
        <th>Name En</th>
        <th>Name De</th>
        <th>Equipment Id</th>
        <th>Equipment Type Id</th>
        <th>Shop Url Ru</th>
        <th>Shop Url En</th>
        <th>Shop Url De</th>
        <th>Is Default</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($shops as $shop)
            <tr>
                <td>{{ $shop->name_ru }}</td>
            <td>{{ $shop->name_en }}</td>
            <td>{{ $shop->name_de }}</td>
            <td>{{ $shop->equipment_id }}</td>
            <td>{{ $shop->equipment_type_id }}</td>
            <td>{{ $shop->shop_url_ru }}</td>
            <td>{{ $shop->shop_url_en }}</td>
            <td>{{ $shop->shop_url_de }}</td>
            <td>{{ $shop->is_default }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['shops.destroy', $shop->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('shops.show', [$shop->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('shops.edit', [$shop->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
