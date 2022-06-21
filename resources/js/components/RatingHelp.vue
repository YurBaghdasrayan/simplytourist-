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
    name: "RatingHelp",
    props:{
        fieldName: {
            type: String,
        },
        ratingName: {
            type: String,
        },
        popupName: {
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
            const field = document.querySelector("input[name='"+this.fieldName+"']").value;
            const rating = document.querySelector("input[name='"+this.ratingName+"']").value;
            console.log('/help/rating/'+this.popupName+'/'+rating+'/'+field)
            axios.get('/help/rating/'+this.popupName+'/'+rating+'/'+field).then((response)=>{
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
.v-popper__inner li {
    display: block;
}
</style>
