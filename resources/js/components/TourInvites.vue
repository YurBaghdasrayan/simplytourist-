<template>
    <div>
        <users-modal
            class="mb-2"
            :categories="categories"
            :translations="translations"
            :locale-lang="'name_'+localeLang"
            :has-callback="true"
            @callback="addUsers"
            :selected="selectedUsers"
        ></users-modal>
        <table id="usergroups-table" class="table">
            <thead>
            <tr>
                <th></th>
                <th>{{ translate('User name') }}</th>
                <th>{{ translate('Administrator') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="selectedUsers.length>0" v-for="user in users" :key="user.id">
                <td>
                    <input type="checkbox" @click="checkRow(user.id,$event)" :checked="checkedRows.includes(user.id)">
                </td>
                <td>{{ user.name }}</td>

                <td>
                    <span v-if="tourAdmins.includes(user.id)">
                        <toggle-button name="is_admin" :labels="false" :value="true" @change="onChangeEventHandler(user.id, $event)"></toggle-button>
                    </span>
                    <span v-else>
                        <toggle-button name="is_admin" :labels="false" @change="onChangeEventHandler(user.id, $event)"></toggle-button>
                    </span>
                </td>
            </tr>
            </tbody>
        </table>
        <input type="hidden" name="selected_users" :value="selectedUsers">
        <input type="hidden" name="tour_admins" :value="tourAdmins">
        <button @click="deleteItems" class="btn btn-base ml-2"><i class="mdi mdi-trash-can"></i> {{ translate('Delete') }}</button>
    </div>
</template>

<script>
export default {
    name: "TourInvites",
    props: ["categories", "translations", "localeLang",'attends'],
    data() {
        return {
            showModal: false,
            users: false,
            selectedUsers: [],
            tourAdmins:[],
            checkedRows:[],
        }
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
        addUsers(value) {
            this.selectedUsers=[];
            this.selectedUsers = value.join(',');
            axios.get('/user/find/?ids=' + this.selectedUsers).then(response => {
                this.users=response.data;
            });
        },
        //Устанавливаем админов для туров
        onChangeEventHandler(user_id,event){
            if(event.value){
                if(!this.tourAdmins.includes(user_id))
                    this.tourAdmins.push(user_id)
            }else{
                //удаляем из админов
                if(this.tourAdmins.includes(user_id)){
                    const index = this.tourAdmins.indexOf(user_id);
                    if (index > -1) {
                        this.tourAdmins.splice(index, 1);
                    }
                }
            }
        },
        checkRow(value,event){
            let ctx=this;
            let is_checked=event.target.checked;
            if(is_checked){
                ctx.checkedRows.push(value);
                ctx.checkedRows=this.checkedRows.filter(this.onlyUnique);
            }else{
                ctx.checkedRows=ctx.checkedRows.filter(function(e) { return e !== value })
                ctx.checkedRows=this.checkedRows.filter(this.onlyUnique);
            }
        },
        deleteItems(){
            let ctx=this;
            let ids=[];
            this.users=this.users.filter(function(item){
                if(!ctx.checkedRows.includes(item.id)){
                    ids.push(item.id)
                    return item;
                }
            });
            this.addUsers(ids);
            //Очистим значение помеченных для удаления строк
            this.checkedRows=[];

        },


    },
    created() {
        let val=[];
        val=this.attends.map(x => x.user_id);
        this.tourAdmins=this.attends.filter(x => (x.tour_admin==1||x.admin==1)).map(x => x.user_id);
        //конвертим в массив
        val=JSON.parse(JSON.stringify(val))
        this.addUsers(val);
    }
}
</script>

<style scoped>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /*background-color: rgba(0, 0, 0, 0.5);*/
    display: table;
    transition: opacity 0.3s ease;
}

.add-equipment {
    margin-bottom: 23px;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: bottom;
}

.equipment-list {
    height: 40px;
}

.tabl {
    margin-top: 20px;
}

.modal-container {
    position: absolute;
    width: 386px;
    height: 540px;
    top: 0px;
    right: 20px;
    bottom: 20px;
    background: #ffffff;
    box-shadow: 0px 3.5px 50px rgba(0, 0, 0, 0.1);
    margin: 125px auto;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.modal-footer--counter {
    display: flex;
    padding: 10px;
}

.modal-footer--form {
    display: flex;
}


</style>
