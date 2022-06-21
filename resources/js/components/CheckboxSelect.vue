<template>
    <div>
        <FormSelect
            :legend="legend"
            v-model="options"
            :input-name="inputName"
            :options="data"
        />
    </div>
</template>

<script>
import FormSelect from "./select/FormSelect";
import {EventBus} from "../app";
export default {
    components:{
        FormSelect
    },
    props:['data','filter','inputName','legend'],
    name: "CheckboxSelect",
    data(){
        return{
            options:[]
        }
    },
    created() {
        if(this.filter){
            this.options=this.filter.split(',');
        }
    },
    updated(){
        //Делаем активными звездочки при выборе select
        EventBus.$emit('selectChangeCheckbox',this.options);
    }

}
</script>

<style scoped>

</style>
