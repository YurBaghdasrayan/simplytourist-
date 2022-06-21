<template>
    <div :class="(isDisabled)?'rating':(isMuted)?'muted rating filter '+hiddenInputName:'rating filter '+hiddenInputName">
        <ul class="list">
            <li :key="star" v-for="star in maxStars" :class="{ 'active': star <= stars }" @click="rate(star)" class="star">
                <i scale="2" :class="star <= stars ? 'mdi mdi-star' : 'mdi mdi-star-outline'"/>
            </li>
        </ul>
        <input type="hidden" :name="hiddenInputName" :value="stars">
    </div>
</template>

<script>
import {EventBus} from "../app";

export default {

    props: {
        grade: {
            type: Number,
            default:0
        },
        maxStars: {
            type: Number,
            default: 5
        },
        hasCounter: {
            type: Boolean,
            default: true
        },
        isDisabled: {
            type: Boolean,
            default: false
        },
        hiddenInputName:{
            type: String,
            default: 'rating'
        },
        dependedField:{
            type:String,
            default:''
        },
        dependedClassSelector:{
            type:String,
            default:''
        },
        endpoint:{
            type:String,
            default:'/help/rating/type_description/'
        }
    },
    data() {
        return {
            stars: this.grade,
            text:'',
            isMuted:false,
        }
    },
    methods: {
        rate(star) {
            if (
                !this.isMuted &&
                !this.isDisabled &&
                typeof star === 'number' &&
                star <= this.maxStars &&
                star >= 0

            )
                this.stars = this.stars === star ? star - 1 : star;
                EventBus.$emit('ratingChange',this.stars)
        },
        async toggleStar(){
            const field = await document.querySelector("input[name='"+this.dependedField+"']").value;
            if(field!==''){
                this.isMuted=false;
            }else{
                this.isMuted=true;
            }
        }
    },
    mounted(){
//Делаем активными звездочки при выборе select
        if(this.dependedClassSelector!==''){
            this.toggleStar();
            EventBus.$on('selectChangeCheckbox',  (article) => {
                console.log(article)
                this.toggleStar();
            });
        }
    },
}
</script>

<style scoped lang="scss">
.modal-content {
    color: black;
    font-size: 14px;
    line-height: 100%;
    letter-spacing: normal;
}

$active-color: #f3d23e;

.rating {
    color: #FFC700;
    font-size: 30px;
    line-height: 30px;
    letter-spacing: 0.2em;
}
.list {
    margin: 0 0 5px 0;
    padding: 0;
    list-style-type: none;
    &:hover {
        .star {
            color: $active-color;
        }
    }
}
.star {
    display: inline-block;
    cursor: pointer;
    &:hover {
        &~.star {
            &:not(.active) {
                color: inherit;
            }
        }
    }
}
.muted.rating.filter {
    cursor: default !important;
    color: gainsboro;
}
.muted.rating.filter:hover * {
    cursor: default !important;
    color: gainsboro;
}
.rating .list{
    display: flex;
}
.active {
    color: $active-color;
}
</style>
