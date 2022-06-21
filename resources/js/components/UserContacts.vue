<template>
    <!-- Modal -->
    <VDropdown>
        <!-- This will be the popover target (for the events and position) -->
        <button @click="loadHelp" class="btn btn-base">
            <i class="mdi mdi-contacts"></i>{{translate('Contacts')}}
        </button>
        <!-- This will be the content of the popover -->
        <template #popper>
            <span v-if="modalText!='...LOADING'">
                <div v-for="(value, name) in modalText">
                    <b>{{ name }}</b>: {{ value }} <br/>
                </div>
            </span>
            <span v-else>
                {{modalText}}
            </span>
        </template>
    </VDropdown>
</template>

<script>
export default {
    name: "UserContacts",
    props:{
        userId: {},
        translations:{},
        //group  или tour
        type: {},
        //id группы или тура
        extId:{}
    },
    data() {
        return {
            modalText: '...LOADING'
        }
    },
    methods: {
        loadHelp(){
            axios.get('/user/contacts/'+this.userId+'/?'+this.type+'_id='+this.extId).then((response)=>{
                this.modalText=response.data;
            });
        },
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
    }
}
</script>

<style>
.v-popper__wrapper {
    max-width: 600px;
}
</style>
