<template>
    <div>
        <v-select
                  placeholder="Выберите язык"
                  :filterable="false"
                  :options="options"
                  :selected="selectedMod"
                  v-model="selected"
                  :reduce="country => country.language_iso"
                  label="name_en"
                  index="name_en"
                  @search="onSearch"
                   >
            <template slot="no-options">
                Input language name to search...
            </template>
            <template slot="option" slot-scope="option">
                <div class="d-center">
                    {{ option.name_en }}
                </div>
            </template>

        </v-select>
        <input type="hidden" :name="(hiddenName)?hiddenName:'filter[country_iso]'" :value="selected">
    </div>
</template>

<script>
import FormSelect from "./select/FormSelect";
export default {
    name: "LanguageSelect",
    props:['selected','baseUrl','hiddenName'],
    data() {
        return {
            options: [],
            countries:null,
            selectedMod:null,
            result:null
        }
    },
    components:{
        FormSelect
    },
    methods:{
        onSearch(search, loading) {
            if(search.length>1) {
                loading(true);
                this.search(loading, search, this);
            }
        },
        search: _.debounce((loading, search, vm) => {
            axios.get(
                vm.baseUrl+'/languages/'+search+'/'
            ).then(res => {
                vm.options = res.data.data;
                loading(false);
            });
        }, 350)

    },
    created() {
        if(this.selected){
            let vm=this;
            axios.get(this.baseUrl+'/languages/'+this.selected+'/show/').then(res=>{
                vm.options = [res.data];
                vm.selectedMod = res.data;
            })
        }
    }
}
</script>

<style lang="scss">
$placeholder-color: #979797;
$form-control-padding: 0.75em;

@mixin form-control {
    display: block;
    padding: $form-control-padding;
    width: 100%;
    border: 1px solid;
    border-radius: 0.1875em;
    outline: none;
    background-color: #fff;
    transition: border-color 0.2s;
    line-height: 1;

    &:focus,
    &--focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
}
.form-group + .form-group {
    margin-top: 1em;
}

.u-visually-hidden {
    border: 0;
    clip: rect(0, 0, 0, 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    white-space: nowrap;
    width: 1px;
}
.FormSelect {
    position: relative; // 1
    height: 2.65em; // 1

    &__control {
        @include form-control();

        padding: 0;
    }

    &__legend {
        width: 100%; // 2
        float: left; // 2
        cursor: pointer;
    }

    &__legend-inner {
        display: flex;
        justify-content: space-between;
        padding: $form-control-padding;
    }

    &__legend-body {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    &__placeholder {
        color: $placeholder-color;
    }

    &__icon {
        transition: transform 0.2s;

        &--rotate-180 {
            transform: rotate(180deg);
        }
    }

    &__options {
        padding-right: $form-control-padding;
        padding-bottom: $form-control-padding;
        padding-left: $form-control-padding;
    }

    &__option {
        display: block;

        &:not(:first-child) {
            margin-top: 0.25em;
        }
    }

    &__input {
        margin-right: 0.125em;
    }
}
</style>
