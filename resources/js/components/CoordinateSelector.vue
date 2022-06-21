<template>
    <div>
        <v-select
            :options="options"
            :value="selected"
            :reduce="(text) => text.id"
            label="text"
            v-model="selected"
            @search="onChangeInput"
            :filterable="false"
        >
            <template v-slot:no-options="{ search, searching }"  class="pt-4 mt-4">
                <template v-if="searching&&search.length>=1">
                    <b>"{{ search }}"</b> {{ translate('Not Found') }}.
                </template>
                <em style="opacity: 0.5" v-else
                >{{ translate('Input destination name') }}</em
                >
            </template>
        </v-select>
        <input type="hidden" name="geo_object_id" :value="selected">
    </div>
</template>

<script>
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";

export default {
    name: "App",
    props: ['translations','preselected'],
    components: {
        vSelect,
    },
    data() {
        return {
            options: [],
            selected: null,
            citizen_id:null,
            form: {
                name: "",
                is_firm: null,
                firm:null,
                email: "",
                address: "",
                phone: "",
                comment: "",
                noRedirect:true,
            },
        };
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
        onChangeInput(search, loading) {

            if (search.length >= 1) {
                axios.get('/geo_object/find?q='+search).then((response) => {
                    this.options=response.data;
                    console.log(this.options)
                }, (error) => {
                    console.log(error);
                });
            }
        },

    },
    created() {
        this.selected=this.preselected.id;
        this.options=[this.preselected]
    }
};
</script>
<style>
.vm--modal {
    overflow: scroll;
}
.v-select.vs--single.vs--searchable {
    background: white;
}
.vs__dropdown-menu{
    margin-top:13px;
    padding-top:13px;
}
</style>
