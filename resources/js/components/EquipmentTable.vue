<template>
    <div>
        <span v-if="selectedRows.length>0">
            <input type="hidden" name="equipment_ids[]" v-for="item in selectedRows" :key="item.id" :value="item">
        </span>
        <div v-if="tableData.length>0">
<!--            <simple-table :rows="columns" :data="tableData">-->

<!--            </simple-table>-->
            <ve-table
                style="width:100%"
                :columns="columns"
                :table-data="tableData"
                row-key-field-name="user_equipment_id"
                :checkbox-option="checkboxOption"
                :cell-style-option="cellStyleOption"
            />
        </div>
        <div v-else>
            {{'Not found'}}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['typeId','localeLang','translations'],
        data() {
            return {
                checkboxOption: {
                    // row select change event
                    selectedRowChange: ({ row, isSelected, selectedRowKeys }) => {
                        this.selectedRows=selectedRowKeys;
                    },
                    // selected all change event
                    selectedAllChange: ({ isSelected, selectedRowKeys }) => {
                        this.selectedRows=selectedRowKeys;
                        console.log(isSelected, selectedRowKeys);
                    },
                },
                selectedRows:[],
                cellStyleOption: {
                    headerCellClass	: ({ column,rowIndex }) => {
                        return "table-body-cell-class2";
                    },
                },
                columns: [
                    {
                        field: "",
                        key: "a",
                        // type=checkbox
                        type: "checkbox",
                        title: "",
                        width: 50,
                        align: "center",
                    },
                ],
                tableData: [

                ],
            };
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
            // translate(word){
            //     if(this.translations!=='undefined'&&this.translations!==null){
            //         for (const [k, v] of Object.entries(this.translations)) {
            //             for (const [key, value] of Object.entries(v)){
            //                 if(key===word){
            //                     return value;
            //                 }
            //             }
            //
            //         }
            //     }
            //     return word;
            // },
        },
        created() {
            let vm=this;
            axios.get('/equipmentType/'+this.typeId+'/get').then(function (response) {
                // handle success
                vm.columns=[...vm.columns,...response.data.columns];

                //Заметка о снаряжении
                vm.columns[2].renderBodyCell=({row, column, rowIndex}, h) => {
                    let sh=vm.columns[2].field;
                    return h('user-equipment-comment', {
                        props: {
                            id: row.user_equipment_id,
                            note: row[sh],
                            translations: vm.translations
                        }
                    });
                };
                //Ссылка на магазин
                vm.columns[3].renderBodyCell=({row, column, rowIndex}, h) => {
                    let sh=vm.columns[3].field;
                    return h('div', {
                            domProps: {
                                innerHTML: row[sh],
                            }
                        });
                };
                vm.tableData=response.data.data;
            });
        }
    };
</script>
<style>
.table-body-cell-class2 {
    font-weight: 600 !important;
    font-size: 12px !important;
    line-height: 150% !important;
    background: #ECF2F8 !important;
}
.ve-table-container.ve-table-border-around {
    border: none !important;
}
.ve-checkbox-content .ve-checkbox-inner{
    border: 2px solid #718096 !important;
}
</style>
