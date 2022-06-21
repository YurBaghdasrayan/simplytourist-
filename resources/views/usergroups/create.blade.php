@extends('layouts.app')

@section('content')

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <form id="add_tour" method="post" action="{{route('usergroups.store')}}" onsubmit="return false;" enctype="multipart/form-data">
            @method('post')
            @csrf

                <div class="card mb-4">


                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-basic float-right profile-save"  onclick="formSubmit(true)"><i class="mdi mdi-content-save"></i> {{__('Save changes')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label d-flex" for="usergroup_name">
                                    {{__('Name of usergroup')}}
                                    <field-help class="ml-1" :field-name="{{json_encode('Usergroup name')}}"></field-help>
                                </label>
                                <input type="text" class="form-control" name="usergroup_name" placeholder="{{__('Name of usergroup')}}"
                                       required="required"><br/>
                            </div>
                            <div class="col-md-8">
                                <div class="col-md-12">
                                    @include('layouts.field_from_rows',['rows'=>$rows,'field'=>'image'])
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label  class="form-label d-flex" for="">
                                    {{__('Language')}}
                                    <field-help class="ml-1" field-name="Language"></field-help>
                                </label>
                                <select name="language_iso" class="form-control">
                                    <option value="ru" @if(App::getlocale()=='ru') selected="selected"@endif>Русский</option>
                                    <option value="en" @if(App::getlocale()=='en') selected="selected"@endif>English</option>
                                    <option value="de" @if(App::getlocale()=='de') selected="selected"@endif>Deutsch</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label  class="form-label d-flex" for="country_iso">
                                    {{__('Usergroup country')}}
                                    <field-help class="ml-1" field-name="Usergroup country"></field-help>
                                </label>
                                @include('layouts.partials.country',['country_name'=>'country_iso','selected'=>request('filter')['country_iso']])
                            </div>
                            <div class="col-md-4">
                                <label  class="form-label d-flex" for="country_iso">
                                    {{__('Group type')}}
                                    <field-help class="ml-1" field-name="Group type"></field-help>
                                </label>
                                <select name="usergroup_privat" id="" class="form-control" required="required">
                                    <option disabled selected value="">
                                        {{__('Choose group type')}}
                                    </option>
                                    <option value="0">{{__('Public')}}</option>
                                    <option value="1">{{__('Private')}}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                @include('layouts.field_from_rows',['rows'=>$rows,'field'=>'usergroup_description'])
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <tour-invites
                            :translations="[
                                {'Back':'{{__('Back')}}'},
                                {'Add':'{{__('Add')}}'},
                                {'Users':'{{__('Users')}}'},
                                {'Add users':'{{__('Add users')}}'},
                                {'Yes':'{{__('Yes')}}'},
                                {'No':'{{__('No')}}'},
                                {'User name':'{{__('User name')}}'},
                                {'Country':'{{__('Country')}}'},
                                {'Administrator':'{{__('Administrator')}}'},
                                {'Delete':'{{__('Delete')}}'},
                                {'Not found':'{{__('Not Found')}}'},
                                {'selected':'{{__('selected')}}'},
                                ]"
                            locale-lang="{{App::getLocale()}}"
                        ></tour-invites>
                    </div>
                </div>
        </form>
    </div>
    @include('layouts.partials.autoresize_textarea_script')
@endsection
@push('scripts')
    <script>
        function formSubmit(fromButton=false){
            if(!fromButton){
                event.PreventDefault();
                return fromButton;
            }else{
                let form=document.getElementById('add_tour');
                let chk_status = form.checkValidity();
                console.log(form.reportValidity())
                form.reportValidity();
                if (chk_status) {
                    form.submit();
                }
            }
        }
        document.addEventListener('DOMContentLoaded', init, false);
        function init(){
            const actualBtn = document.getElementById('avatar');
            const fileChosen = document.getElementById('file-chosen');
            actualBtn.addEventListener("change", function(){
                fileChosen.textContent = this.files[0].name
            })
        };

    </script>
@endpush
