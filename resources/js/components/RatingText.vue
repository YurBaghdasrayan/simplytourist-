<template>
    <div>
        {{text}}
        <input type="hidden" v-model="text" :name="resultInput">
    </div>
</template>

<script>

export default {

    props: {
        grade: {
            type: Number,
            default:0
        },
        hiddenInputName:{
            type: String,
            default: 'rating'
        },
        dependedField:{
            type:String,
            default:''
        },
        endpoint:{
            type:String,
            default:'/help/rating/type_description/'
        },
        resultInput:{
            type:String,
            default: 'tour_type_description'
        }
    },
    data() {
        return {
            stars: this.grade,
            text:'',
            field:''
        }
    },
    methods: {
        loadHelp(){
            if(this.dependedField!=='') {

                this.stars = document.querySelector("[name=" + this.hiddenInputName + "]").value;
                this.field = document.querySelector("[name=" + this.dependedField + "]").value;
                console.log(this.stars)
                if(this.stars>0){
                    axios.get( this.endpoint + this.stars + '/' + this.field+'/0').then((response) => {
                        console.log(response)
                        this.text = response.data.replace(/(<([^>]+)>)/gi, "");
                    });
                }
            }
        },

    },
    mounted(){
        document.querySelector("[name=" + this.dependedField + "]").addEventListener('change', this.loadHelp);
        document.querySelector('.rating.'+this.hiddenInputName).addEventListener('click',this.loadHelp)
        this.loadHelp()
    },
}
</script>

