@extends('layouts.app')

@section('content')

    <div class="content px-3">

        @include('flash::message')
        <div class="clearfix"></div>
        @include('profile.menu')
        <div class="tab-content" id="custom-content-below-tabContent">

                <section class="content-header mb-2 pl-0 pr-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <simple-modal
                                        :categories="{{\App\Models\EquipmentType::getEquipmentsType(App::getLocale())}}"
                                        :translations="[
                                            {'Back':'{{__('Back')}}'},
                                            {'Add':'{{__('Add')}}'},
                                            {'Category':'{{__('Category')}}'},
                                            {'Add equipment':'{{__('Add equipment')}}'},
                                            {'Not found':'{{__('Not Found')}}'},
                                            {'selected':'{{__('selected')}}'},
                                            ]"
                                        locale-lang="{{'name_'.App::getLocale()}}"
                                        delete
                                    ></simple-modal>
                                </div>
                            </div>
                            <div class="col-6 pr-0">
                                {!! Form::model($data, ['route' => ['profile.update', $data[0]->id], 'method' => 'patch','files'=>true]) !!}
                                <button class="btn btn-basic float-right profile-save"><i class="mdi mdi-content-save"></i> {{__('Save changes')}}</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </section>
            <form id="destroy-equip" method="get" action="/equipment/remove" onsubmit="return false;">
                <div class="tab-pane fade show active" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                    <equipment-type
                        :table-data="{{json_encode($equipmentsType)}}"
                        :locale-lang="{{json_encode('name_'.App::getLocale())}}"
                        :translations="[
                            {'Back':'{{__('Back')}}'},
                            {'Add':'{{__('Add')}}'},
                            {'Category':'{{__('Category')}}'},
                            {'Add equipment':'{{__('Add equipment')}}'},
                            {'Equipment':'{{__('Equipment')}}'},
                            {'Description':'{{__('Description')}}'},
                            {'Shop':'{{__('Shop')}}'},
                            {'My equipment':'{{__('My equipment')}}'},
                            {'Delete':'{{__('Delete')}}'},
                            {'Quantity':'{{__('Quantity')}}'},
                            {'Yes':'{{__('Yes')}}'},
                            {'No':'{{__('No')}}'},
                            {'Equipment is currently loading...':'{{__('Equipment is currently loading...')}}'},
                            {'Not found':'{{__('Not Found')}}'},
                            {'selected':'{{__('selected')}}'},
                            {'Note':'{{__('Note')}}'},
                            {'Save':'{{__('Save')}}'},
                            {'Add note':'{{__('Add note')}}'},
                            ]"
                    ></equipment-type>
                </div>
                <section class="content-header pb-0 pl-0 pr-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <button class="btn btn-base ml-2" onclick="formSubmit(true)"><i class="mdi mdi-trash-can"></i> {{__('Delete')}}</button>
                                </div>
                            </div>
                            <div class="col-sm-6 pr-0">
                            </div>
                        </div>
                    </div>
                </section>
            </form>


        </div>

    </div>


@endsection
@push('scripts')
    <script>
        function formSubmit(fromButton=false){
            if(!fromButton){
                event.PreventDefault();
                return fromButton;
            }else{
                let form=document.getElementById('destroy-equip');
                form.submit();
            }
        }
    </script>
@endpush
