<template>
    <!-- Modal -->
    <VDropdown>
        <!-- This will be the popover target (for the events and position) -->
        <span  @click="loadHelp" class="cursor-pointer" role="button"><i class="mdi mdi-help-circle-outline"></i></span>
        <!-- This will be the content of the popover -->
        <template #popper>
            <span v-html="modalText"></span>
        </template>
    </VDropdown>
</template>

<script>
export default {
    name: "FieldHelp",
    props:{
        fieldName: {
            type: String,
        },
    },
    data() {
        return {
            modalText: '...LOADING'
        }
    },
    methods: {
        loadHelp(){
            axios.get('/help/field/'+this.fieldName).then((response)=>{
                this.modalText=response.data;
            });
        }
    }
}
</script>

<style>
.v-popper__wrapper {
    max-width: 600px;
}
</style>
