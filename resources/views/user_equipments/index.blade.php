@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Equipments</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('userEquipments.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="clearfix"></div>
            <equipment-type :table-data="{{json_encode($equipmentsType)}}" :locale-lang="{{json_encode('name_'.App::getLocale())}}"></equipment-type>

        </div>
    </div>

@endsection
