<template>
    <div>
        <span v-if="editable">
            <simple-modal
                class="mb-2"
                :categories="categories"
                :translations="translations"
                :locale-lang="'name_'+localeLang"
                :has-callback="true"
                @callback="addEquip"
                :preselect="preselect"
            ></simple-modal>
        </span>
<!--        <div v-if="userEquip.length<equipment.length&&editable">{{translate('Equipment is currently loading...')}}</div>-->
        <div v-if="selectedCategories" class="equip_type">
            <div class="accordion_wrapper" v-for="row in selectedCategories" :key="row">
                <accordion >

                    <accordion-item >
                        <!-- This slot will handle the title/header of the accordion and is the part you click on -->
                        <template slot="accordion-trigger">
                            <span><i class="mdi mdi-chevron-right"></i><span class="accordion__trigger_text">{{getCategorieName(row)}}</span></span>
                        </template>
                        <!-- This slot will handle all the content that is passed to the accordion -->
                        <template slot="accordion-content">
                            <table id="usergroups-table" class="table">
                                <thead>
                                <tr>
                                    <th>
                                        <span v-if="editable">
                                            <input type="checkbox" @click="checkCategory(row,$event)" :checked="isAllChecked(row)">
                                        </span>
                                    </th>
                                    <th>{{translate('Equipment')}}</th>
                                    <th>{{translate('Quantity')}}</th>
                                    <th>{{translate('Description')}}</th>
                                    <th>{{translate('Shop')}}</th>
                                    <th v-if="!editable">{{translate('My equipment')}}</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-if="equipment.equipment_type_id==row" v-for="equipment in equipment" :key="equipment.id" :class="setTableRowClass(equipment.id)">
                                    <td>
                                        <span v-if="editable">
                                            <input type="checkbox" @click="checkRow(equipment.id,$event)" :checked="checkedRows.includes(equipment.id)">
                                        </span>
                                    </td>
                                    <td>{{ equipment['name_' + localeLang] }}</td>
                                    <td>
                                        <span v-if="editable">
                                            <input type="number" :value="getEquipQty(equipment.id)" min="1" @input="updateQty(equipment.id,$event)" @change="updateValQTY(equipment.id,$event)">
                                        </span>
                                        <span v-else>
                                                {{getEquipQty(equipment.id)}}
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="editable">
                                            <span v-if="noteObj">
                                                <user-equipment-comment
                                                    :id="equipment.id"
                                                    :has-callback="true"
                                                    @callback="updateNote"
                                                    :note="noteObj[equipment.id]"
                                                    :translations="translations"
                                                ></user-equipment-comment>
                                            </span>
                                            <span v-else>
                                                <user-equipment-comment
                                                    :id="equipment.id"
                                                    :has-callback="true"
                                                    @callback="updateNote"
                                                    :translations="translations"
                                                ></user-equipment-comment>
                                            </span>
                                        </span>
                                        <span v-else>
                                            {{noteObj[equipment.id]}}
                                        </span>

                                    </td>
                                    <td><span v-html="equipment['shop_'+localeLang]"></span></td>
                                    <td v-if="!editable">
<!--                                        <span v-if="editable">-->
<!--                                            {{//translate(getElById(equipment['id']))}}-->
<!--                                        </span>-->
                                        <span>
                                                <span v-if="getEquipInBag(equipment['id'])">{{ translate('Yes') }}</span>
                                                <span v-else>{{ translate('No') }}</span>
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </template>
                    </accordion-item>
                </accordion>
            </div>
            <span v-if="editable">
                <button @click="deleteItems" class="btn btn-base ml-2"><i class="mdi mdi-trash-can"></i> {{ translate('Delete') }}</button>
            </span>
        </div>
        <div v-else>
            Снаряжение пока не добавлено
        </div>
        <input type="hidden" :value="selectedEquip" name="tour_equipment">
        <input type="hidden" v-model="JSON.stringify(equipNote)" name="tour_equipment_notes">
        <input type="hidden" v-model="JSON.stringify(equipQTY)" name="tour_equipment_qty">
    </div>
</template>

<script>

export default {
    name: "TourEquipment",
    props: ["categories", "translations", "localeLang", "preselected","selectedQty","editable"],
    data() {
        return {
            showModal: false,
            equipment: false,
            preselect: [],
            selectedEquip: [],
            selectedCategories:[],
            equipNote: [],
            checkedRows:[],
            equipQTY:[],
            noteObj: false,
            userEquip:[],
            isLoading: true
        }
    },
    methods: {
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
        translate(word) {
            if (this.translations !== 'undefined') {
                for (const [k, v] of Object.entries(this.translations)) {
                    for (const [key, value] of Object.entries(v)) {
                        if (key === word) {
                            return value;
                        }
                    }

                }
            }
            return word;
        },
        updateNote(value) {
            let keys = [];
            this.equipNote.forEach(element => keys.push(element.id));

            if (!keys.includes(''+value.id)) {
                //Добавляем значение комментария + id снаряжения
                this.equipNote.push(value);
            } else {
                //Обновляем значение комментария
                //Получаем индекс заметки
                let objIndex = this.equipNote.findIndex((obj => obj.id == value.id));
                this.equipNote[objIndex].note = value.note;
            }
        },
        getCategorieName(value){
            let result=(this.categories.filter(function(item){
                return item.id === value;
            }));
            return result[0]['name_'+this.localeLang];
        },
        addEquip(value) {
            if(value){
                this.selectedEquip = value.join(',');
                let categorie_array_to_sort=[];
                let ctx=this;
                let categorie_sorting_array=this.categories.map(obj => {
                    return obj.id
                })
                console.log('categorie sorting',categorie_sorting_array)
                axios.get('/equipment/find/' + this.selectedEquip).then(response => {
                    this.equipment = response.data;
                    this.equipment.forEach((element) => {
                        //Извлекаем уникальные категории снаряжения из выбранного пользователем оборудования
                        if(!categorie_array_to_sort.includes(element.equipment_type_id)){
                            console.log('ELEMENT',element.equipment_type_id)
                            categorie_array_to_sort.push(element.equipment_type_id);
                        }

                        //Формируем массив для количества элементов снаряжения
                        if(ctx.equipQTY.length>0){
                            let need_add=ctx.equipQTY.filter(
                                function(data){ return data.id == element.id }
                            );
                            if(need_add.length===0){
                                ctx.equipQTY.push(
                                    {'id':element.id,'qty':1}
                                );
                            }
                        }else{
                            ctx.equipQTY.push(
                                {'id':element.id,'qty':1}
                            );
                        }

                    });
                    this.selectedCategories=this.sortByArray(categorie_array_to_sort,categorie_sorting_array);
                });


            }else{
                this.noteObj=false;
                this.equipment=false;
                this.selectedCategories=[];
                this.equipQTY=[];
            }
        },
        onlyUnique(value, index, self) {
            return self.indexOf(value) === index;
        },
        //Проверяем что все элементы в категории отмечены
        isAllChecked(categorie){
            let ctx=this;
            let isAllChecked=true;
            let result=(this.equipment.filter(function(item){
                if(item.equipment_type_id === categorie){
                    if(!ctx.checkedRows.includes(item.id)) {
                        isAllChecked=false;
                    }
                }
            }));
            return isAllChecked;
        },
        checkCategory(value,event){
            let ctx=this;
            let is_checked=event.target.checked;
            //В зависимости от того выбрана ли категория - очищаем массив или добавляем элементы категории
            if(is_checked){
                let result=(this.equipment.filter(function(item){
                    if(item.equipment_type_id === value){
                        ctx.checkedRows.push(item.id);
                        return item.id;
                    }
                }));
                this.checkedRows=this.checkedRows.filter(this.onlyUnique);
            }else{
                let result=(this.equipment.filter(function(item){
                    if(item.equipment_type_id === value){
                        ctx.checkedRows.pop(item.id);
                    }
                }));
            }
        },
        checkRow(value,event){
            let ctx=this;
            let is_checked=event.target.checked;
            if(is_checked){
                ctx.checkedRows.push(value);
                ctx.checkedRows=this.checkedRows.filter(this.onlyUnique);
            }else{
                ctx.checkedRows=ctx.checkedRows.filter(function(e) { return e !== value })
                ctx.checkedRows=this.checkedRows.filter(this.onlyUnique);
            }
        },
        deleteItems(){
            let ctx=this;
            let ids=[];
            this.equipment=this.equipment.filter(function(item){
                if(!ctx.checkedRows.includes(item.id)){
                    ids.push(item.id)
                    return item;
                }
            });
            //перерэндерим снаряжение, чтобы убрать пустые категории
            this.addEquip(ids);
            this.prepareNotes();
            //Очистим значение помеченных для удаления строк
            this.checkedRows=[];

        },
        //При удалении нужно сохранить значение заметок, т.к. после ререндера они стираются
        prepareNotes(){
            this.noteObj= {};
            let ctx=this;
            let objIndex = this.equipNote.filter(function(item){
                //Не сохраняем заметки, которые удаляются
                if(!(ctx.checkedRows.includes(parseInt(item.id)))){
                    ctx.noteObj[item.id]=item.note;
                }
            });
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
            this.equipQTY.filter(function(item){
                //Не сохраняем заметки, которые удаляются
                if(item.id===equip_id){
                    item.qty=QTY;
                }
            });
            if(this.editable)
                this.isInMyBag(equip_id)
            console.log(QTY)
        },
        //Получаем значение количества по id товара
        getEquipQty(equip_id){
            let result=1;
            this.equipQTY.filter((element)=>{
                if(element.id===equip_id){
                    result=element.qty;
                }
            });
            return result;
        },
        getEquipInBag(equip_id){
            let result=false;
            this.equipQTY.filter((element)=>{
                if(element.id===equip_id){
                    result=element.InMyEquipment;
                }
            });
            return result;
        },
        //Сортируем массив по аналогии с другим массивом
        sortByArray(array_to_sort,sorted_array){
            console.log(array_to_sort);
            let result=array_to_sort.sort(function(a, b) {
                console.log('a,b',a);
                return sorted_array.indexOf(a) - sorted_array.indexOf(b);
            });
            console.log('RES',result);
            return result;
        },
        //Проверяем наличие товаров у пользователя динамически
        async isInMyBag(equip_id){
            let QTY=this.getEquipQty(equip_id);
            let result='No'
            let val= await axios.get('/bagCheck/' + equip_id+'/'+QTY);
            if(val.data==1)
                result='Yes';
            //Обновляем значения
            //Find index of specific object using findIndex method.
            let objIndex = this.userEquip.findIndex((obj => obj['id'] == equip_id));
            if(objIndex==-1)
                this.userEquip.push({"id":equip_id,"val":result});
            else
                this.userEquip[objIndex].val=result;
        },
        getElById(equip_id){
            this.isInMyBag(equip_id);
            let res=this.userEquip.find(element=>{
                return element.id===equip_id
            })
            return res.val;
        },
        setTableRowClass(equipment){
            let result='No';

            if(this.editable){
                return 'Yes';
                //result=this.getElById(equipment)
            }else{
                if(this.getEquipInBag(equipment))
                    result='Yes';
            }
            console.log(result);
            if(result=='No'){
                return 'missed-equipment';
            }
        }

    },
    created() {

        if(this.selectedQty){
            this.equipQTY=JSON.parse(this.selectedQty);
        }
        if (this.preselected) {
            let values = JSON.parse(this.preselected)
            this.noteObj = values;
            this.equipment = Object.keys(values);
            this.preselect=this.equipment;
            console.log('before comments',values)
            //Обновляем комменты и количество
            for (const [key, value] of Object.entries(values)) {
                let obj = {};
                obj.id = key;
                obj.note = value;
                this.updateNote(obj);
            }
            this.addEquip(this.equipment);
            console.log('loaded')
        }
    },
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

.add-equipment {
    margin-bottom: 23px;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: bottom;
}

.equipment-list {
    height: 40px;
}

.tabl {
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

.modal-footer--counter {
    display: flex;
    padding: 10px;
}

.modal-footer--form {
    display: flex;
}


</style>
