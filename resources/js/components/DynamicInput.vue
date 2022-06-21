<template>
    <div id="app">
        <div class="row mb-2">
            <div class="col-4">
                <label for="tags">{{translate('Choose Type')}}</label>
                <select class="form-control" v-model="selected" :disabled="disabled">
                    <option value="email" selected>Email</option>
                    <option value="nickname">{{translate('Username')}}</option>
                </select>
            </div>
            <div class="col-8">
                <label for="tags">{{translate('Mailing list')}}</label>
                <vue-tags-input
                    v-model="tag"
                    :tags="tags"
                    :placeholder="translate('Input')+' '+selected"
                    class="form-control"
                    @tags-changed="newTags =>{ tags = newTags; if(this.tags.length>0) this.disabled=true; else this.disabled=false;}"
                    @before-adding-tag="CheckValue"

                />
            </div>
        </div>
        <input type="hidden" name="type" :value="selected">
        <input type="hidden" :name="name" v-for="item in tags" :key="item.id" :value="item.text">

    </div>
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
export default {
    name: "App",
    props:['name','placeholder','translations'],
    components: { VueTagsInput },
    data() {
        return {
            tag: '',
            values: [],
            main:null,
            result:[],
            tags:[],
            selected:'email',
            disabled: false,
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
        AddValue() {
            this.newTags=this.tags
        },
        validateEmail(email)
        {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        },
        CheckValue(obj){
            let ctx=this;
            if(this.selected=='email'){
                if(!this.validateEmail(obj.tag.text))
                    alert(this.translate('Email must be specified'));
                else
                    obj.addTag();
            }

            if(this.selected=='nickname')
                axios.get('/user/findOne/?search='+obj.tag.text).then(function (response) {
                    // handle success
                    if(response.data.name==obj.tag.text)
                        obj.addTag();
                    else
                        alert(ctx.translate('User not found'));
                });

        },
        RemoveValue(index) {
            this.values.splice(index, 1);
        },
    },
};
</script>
<style>
.ti-tag{
    background-color: #ECF2F8 !important;
    border: 1px solid #E2E8F0;
    color: #2D3748 !important;
    padding: 7px !important;
    position: relative;
    top: -5px !important;
    box-sizing: border-box;
    border-radius: 15px !important;
}
.ti-input{
    border:none !important;
    padding: 10px !important;
    padding-left: 0 !important;

}
.vue-tags-input{
    max-width: initial !important;
    position: relative;
    height: 50px;
    border-radius: 15px;
    border: 1px solid #E2E8F0;
    padding: 0px 20px;
    color: #718096;
    background-color: #fff;
}
</style>
