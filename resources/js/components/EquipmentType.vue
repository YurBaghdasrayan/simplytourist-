<template>
    <div>
        <div v-if="tableData" class="equip_type">
            <div class="accordion_wrapper" v-for="row in tableData" :key="row.id">
                <accordion >

                    <accordion-item >
                        <!-- This slot will handle the title/header of the accordion and is the part you click on -->
                        <template slot="accordion-trigger">
                            <span><i class="mdi mdi-chevron-right"></i><span class="accordion__trigger_text">{{row[localeLang]}}</span></span>
                        </template>
                        <!-- This slot will handle all the content that is passed to the accordion -->
                        <template slot="accordion-content">
                            <equipment-table :type-id="row.id" :translations="translations"></equipment-table>
                        </template>
                    </accordion-item>
                </accordion>
            </div>
        </div>
        <div v-else>
            Снаряжение пока не добавлено
        </div>
    </div>
</template>

<script>
    import EquipmentTable from "./EquipmentTable";
    export default {
        components: {EquipmentTable},
        props: ['tableData','localeLang','translations'],

        data() {
            return {
                expandOption: {
                    trigger: "row",
                    render: ({ row, column, rowIndex }, h) => {
                        return h('div', {class: 'graph-wrapper'}, [
                            h('equipment-table', {
                                props: {
                                    typeId: row.id,
                                }
                            })]);
                    },
                },
                cellStyleOption: {
                    headerCellClass	: ({ column,rowIndex }) => {
                            return "table-body-cell-class2";
                    },
                },
                columns: [
                    {
                        field: "",
                        key: "a",
                        // 设置需要显示展开图标的列
                        type: "expand",
                        title: "",
                        width: 20,
                        align: "center",
                    },

                ],
            };
        },
        computed:{
            locale:function(){
              return this.lang;
            },
            localeColumns: function (){
                // `this` points to the vm instance
                let new_col=this.columns;
                new_col[1]={
                    key: "b",
                    title: "Name",
                    align: "left",
                };
                new_col[1]['field']=this.localeLang;
                return new_col;
            }
        },
        created() {
        },
        methods: {
            changeExpandIcon: function() {
                this.isActive = !this.isActive;
                // some code to filter users
            }
        }
    };
</script>
<style>
    .equip_type > div > div> table >thead {
        display:none;
    }
    .accordion__trigger.accordion__trigger_active >span >i::before {
        content: "\F0140";
    }
</style>
