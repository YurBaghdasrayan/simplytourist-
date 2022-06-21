<template>
    <div>
        <span v-if="userNote">
            {{userNote}}
        </span>
        <a href="#" @click="showModal = true"><i class="mdi mdi-pencil"></i></a>
        <div class="modal-mask" v-if="showModal==true">
            <div class="modal-wrapper"  @click="showModal=false" >
                <div class="modal-container" @click.stop="">

                    <div class="modal-header">
                        <slot name="header">
                            <span class="navigation-back" @click="showModal=false">
                                <i class="mdi mdi-arrow-left"></i> <span class="navigation-back--text">{{translate('Back')}}</span>
                            </span>
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <label class=""> {{translate('Note')}} </label>
<!--                            <select v-if="categories" class="form-control" @change="onCategorieChange($event)">-->
<!--                                <option v-for="(key,value) in categories" :value="value" :key="value">-->
<!--                                    {{ key }}-->
<!--                                </option>-->
<!--                            </select>-->
                            <div class="tabl">
                                <textarea :placeholder="translate('Add note')" cols="30" rows="10" class="form-control" v-model="userNote"></textarea>
                            </div>
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                                <span v-if="selectedEquip.length>0" class="modal-footer--counter">
                                    {{selectedEquip.length}} {{translate('selected')}}
                                    <input type="hidden" name="equipment_ids[]" v-for="item in selectedEquip" :key="item.id" :value="item">
                                </span>
                                <button class="btn btn-basic" @click="saveEquipment()">
                                    <i class="mdi mdi-plus-circle" ></i> {{translate('Save')}}
                                </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['note','id',"hasCallback","callback","translations"],
    data() {
        return {
            showModal: false,
            equipment: false,
            selectedEquip:[],
            userNote: '',
        }
    },
    name: "UserEquipmentComment",
    created() {
        this.userNote=this.note
    },
    methods:{
        //Генерирует перевод строк на основе json массива из props для компонента
        /*
        * Пример данных на входе. Переводы берутся из Laravel
        * :translations="[
                    {'Back':'{{__('Back')}}'},
                    {'Add':'{{__('Add')}}'},
                    {'Category':'{{__('Category')}}'},
                    {'Add equipment':'{{__('Add equipment')}}'}
          ]"
        * */
        translate(word){
            if(this.translations!=='undefined'){
                for (const [k, v] of Object.entries(this.translations)) {
                    for (const [key, value] of Object.entries(v)){
                        if(key===word){
                            return value;
                        }
                    }

                }
            }
            return word;
        },
        saveEquipment(){
            if(!this.hasCallback){
                axios.patch('/userEquipment/'+this.id, {
                    id:this.id,
                    note: this.userNote,
                }).then(function (response) {
                });
            }else{
                console.log('callback action child');
                let obj={};
                obj.id=this.id;
                obj.note=this.userNote;
                this.$emit('callback',obj);
            }
            this.showModal=false;
        }
    },
}
</script>

<style>
    .modal-header {
        padding: 1rem;
    }
    .navigation-back{
        margin-top:14px;
    }
    i.mdi-pencil{
        font-size: 21px;
    }
    .modal-body {
        position: relative;
        -webkit-flex: 1 1 auto;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1rem;
    }
    .form-control{
        padding: 0px 20px;
    }
    .modal-footer {
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-justify-content: flex-end;
        -ms-flex-pack: end;
        justify-content: flex-end;
        padding: .75rem;
    }
    .btn{
        padding: 10px 12px;
    }
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /*background-color: rgba(0, 0, 0, 0.5);*/
        display: table;
        transition: opacity 0.3s ease;
    }
    .add-equipment{
        margin-bottom:23px !important;
    }
    .modal-wrapper {
        display: table-cell;
        vertical-align: bottom;
    }

    .equipment-list{
        min-height:40px;
    }
    .tabl{
        margin-top: 20px !important;
    }
    .modal-container {
        position: absolute;
        width: 386px;
        height: 480px;
        top: 0px;
        right: 20px;
        bottom: 20px;
        background: #ffffff;
        box-shadow: 0px 3.5px 50px rgba(0, 0, 0, 0.1);
        margin: 125px auto !important;
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    .modal-footer--counter{
        display: flex;
        padding: 10px !important;
    }
    .modal-footer--form{
        display: flex;
    }

</style>
