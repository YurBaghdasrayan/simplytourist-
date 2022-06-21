<template>
    <div>
        <button id="show-modal" class="btn btn-basic" @click="showModal = true"><i class="mdi mdi-plus-circle"></i> {{translate('Add equipment')}}</button>
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
                            <span class="ml-3"> {{translate('Category')}} </span>
                            <select v-if="categories" class="form-control" @change="onCategorieChange($event)">
                                <option v-for="item in categories" :value="item.id" :key="item.id">
                                    {{ item[localeLang] }}
                                </option>
                            </select>
                            <div class="tabl ml-3 container-fluid">
                                <div v-if="equipment.length>0">
                                    <div class="equipment-list" v-for="item in equipment" :key="item.id">
                                        <div class="row">
                                        <div class="col-8">
                                        <span v-if="Object.values(selectedEquip).includes(''+item.id)">
                                            <input type="checkbox" @change="onEquipmentUnCheck($event)" :value="item.id" checked="checked"> {{item[localeLang]}}
                                        </span>
                                        <span v-else>
                                            <input type="checkbox" @change="onEquipmentCheck($event)" :value="item.id"> {{item[localeLang]}}
                                        </span>
                                        </div>
                                        <div class="col-3" v-if="!hasCallback">
                                            <input type="number" style="width: 100%" :value="getEquipQty(item['id'])" min="1" @input="updateQty(item['id'],$event)" @change="updateValQTY(item['id'],$event)">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    {{translate('Not found')}}
                                </div>
                            </div>
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <form action="/equipment/add" method="get" class="modal-footer--form" v-if="!hasCallback">
                                <span v-if="selectedEquip.length>0" class="modal-footer--counter">
                                    {{selectedEquip.length}} {{translate('selected')}}
                                    <input type="hidden" v-model="JSON.stringify(equipQTY)" name="equipment_qty">
                                    <input type="hidden" name="equipment_ids[]" v-for="item in selectedEquip" :key="item.id" :value="item">
                                </span>
                                <button class="btn btn-basic add-equipment"><i class="mdi mdi-plus-circle"></i> {{translate('Add')}}</button>
                            </form>
                            <span class="modal-footer--counter" v-else>
                                <span v-if="selectedEquip.length>0" class="modal-footer--counter">
                                    {{selectedEquip.length}} {{translate('selected')}}
                                </span>
                                <button class="btn btn-basic add-equipment" @click="addEquip"><i class="mdi mdi-plus-circle"></i> {{translate('Add')}}</button>
                            </span>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SimpleModal",
        props:["categories","translations","localeLang","hasCallback","callback","preselect"],
        data() {
            return {
                showModal: false,
                equipment: false,
                selectedEquip:[],
                equipQTY:[],
            }
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
            loadEquipment(ctx,equipment_id){

                let url='/equipmentType/'+equipment_id+'/all'
                console.log(url);
                if (this.hasCallback)
                    url+='?fetchAll=1';
                axios.get(url).then(function (response) {
                    // handle success
                    console.log(response.data.data)
                    ctx.equipment=response.data.data;
                });
            },
            onCategorieChange(event) {
                this.loadEquipment(this,event.target.value);
            },
            onEquipmentCheck(event){
                console.log(event.target);
                this.selectedEquip.push(event.target.value);
            },
            onEquipmentUnCheck(event){
                console.log(event.target);
                this.selectedEquip.pop(event.target.value);
            },
            addEquip(){
                this.$emit('callback', this.selectedEquip);
                this.showModal=false;
            },
            updateValQTY(equip_id,event){
                let QTY=parseInt(event.target.value);
                if(QTY>0){
                    event.target.value=QTY;
                }else{
                    event.target.value=1;
                }
                this.updateQty(equip_id,event);
            },
            //Обновляем количество снаряжения к айди товара
            updateQty(equip_id,event){
                let QTY=parseInt(event.target.value);
                let ctx=this;
                let need_add=ctx.equipQTY.filter(
                    function(data){ return data.id == equip_id }
                );
                if(need_add.length===0){
                    ctx.equipQTY.push(
                        {'id':equip_id,'qty':QTY}
                    );
                }
                this.equipQTY.filter(function(item){
                    //Не сохраняем заметки, которые удаляются
                    if(item.id===equip_id){
                        item.qty=QTY;
                    }
                });
                console.log(this.equipQTY)
                console.log(equip_id)

            },
            //Получаем значение количества по id товара
            getEquipQty(equip_id){
                let result=1;
                this.equipQTY.filter((element)=>{
                    if(element.id===equip_id){
                        result=element.qty;
                    }
                });
                console.log(equip_id)

                return result;
            },

        },
        created() {
            console.log(this.categories[0])
            let equipment_id=this.categories[0]['id'];
            console.log('EQUIP')
            console.log(equipment_id);
            this.loadEquipment(this,equipment_id);
            if(this.preselect)
                this.selectedEquip=this.preselect;
        }
    }
</script>

<style scoped>
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
        margin-bottom:23px;
    }
    .modal-wrapper {
        display: table-cell;
        vertical-align: bottom;
    }

    .equipment-list{
        min-height:40px;
    }
    .tabl{
        margin-top: 20px;
    }
    .modal-container {
        position: absolute;
        width: 386px;
        height: 540px;
        top: 0px;
        right: 20px;
        bottom: 20px;
        background: #ffffff;
        box-shadow: 0px 3.5px 50px rgba(0, 0, 0, 0.1);
        margin: 125px auto;
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    .modal-footer--counter{
        display: flex;
        padding: 10px;
    }
    .modal-footer--form{
        display: flex;
    }


</style>
