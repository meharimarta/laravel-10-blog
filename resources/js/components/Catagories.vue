<template>
    <div id="cat">
        <ul id="ul">
            <li v-for="cat in localCatagories">
                {{ cat.catagory }} <button @click="deleteCatagory(cat.id)" :disabled="deleting"><i class="fa fa-trash"></i></button>
            </li>
        </ul>
        <button class="newCat" @click="addNewshow"><i class="fa fa-plus"></i> New catagory</button>
        <div id="newCatagory" v-if="addNew">
            <button id="close-new" @click="close">X</button>
            <label>Enter new catagory</label>
            <input autofocus type="text" maxlength="20" v-model="newCatagory" :class="{redBorder: error}"/>
            <button class="save" @click="save" @keyup.enter="save" :disabled="loading"><i v-if="loading" class="fa fa-spinner fa-spin"></i><span v-if="!loading">Save</span></button>
        </div>
        <div  v-if="deleting" class="delting">
            <i class="fa fa-spinner fa-spin"></i>
        </div>
        <div class="info-delete" v-if="unableToDelete">
            <p>{{unableMsg}} :-( </p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'catagory-component',
    data() {
        return {
            localCatagories: this.catagories,
            newCatagory: '',
            addNew: false,
            error: false,
            loading: false,
            deleting: false,
            unableToDelete: false,
            unableMsg: ''
        }
    },
    props: ['catagories'],
    methods: {
        removeLoading() {
                setTimeout(()=>{
                        this.unableToDelete = false;
                    this.unableMsg = '';
                },1500);
        },
        deleteCatagory(id) {
            this.deleting = true;
            let cat = this.localCatagories.find(cat => cat.id == id);
            let catId = cat.id;
            axios.post('/dashboard/catagories/' + catId,{validateStatus: status => true }).then((res)=>{
                let status = res.status;
                if(status == 403) {
                    this.deleting = false;
                    this.unableToDelete = true;
                    this.unableMsg = 'Unable to delete Default Catagories'; 
                    this.removeLoading();
                    return;
                }
                if(status == 500 ) {
                    this.deleting = false;
                    this.unableToDelete = true;
                    this.unableMsg= 'Unable to delete';
                    this.removeLoading();
                    return;
                }
                var catToRemove = this.localCatagories.findIndex(catagory => catagory.id == id);
                this.localCatagories.splice(catToRemove,1);
                this.deleting = false;
            });
        },
        addNewshow(){
            this.addNew = true;
        },
        close() {
            this.addNew = false;
        },
        save() {
            if(this.newCatagory == '' || this.newCatagory.length < 3) {
                this.error = true;
                return;
            }
            this.loading = true;
            let fd = new FormData();
            fd.append('catagory',this.newCatagory);
            axios.post('/dashboard/catagories',fd,{validateStatus: status => true}).then((res)=>{
                this.localCatagories.push({'catagory':this.newCatagory,
                                           'id':res.data});
                this.addNew = false;
                this.loading = false;
                this.newCatagory = '';
            });
        }
    },
    watch: {
        newCatagory(){
            this.error = false;
        }
    }
}

</script>

<style scoped>
    @media(min-width: 850px){
        #cat {
            margin-left: 18.5%;
        }
    }
    #cat {
        margin-right: 15px;
        display: flex;
        flex-direction: column;
    }
    #cat ul {
        list-style-type: none;
        display: flex;
        flex-direction: column;
        margin-left: 0;
        padding-left: 0;
    }
    #ul li {
        width: 100%;
        background-color: rgb(247, 247, 247);
        display: block;
        padding: 5px;
        font-size: 1.3em;
        margin: 5px;
        border-radius: 3px;
    }
    #ul li button {
        float: right;
        background:none;
        background-color:  rgb(247, 247, 247);
        color: #ff4e4e;
        font-size: 1.3em;
        border: none;
/*        display: block;*/
        margin-left: auto;
        cursor: pointer;
    }
    #cat .newCat, .save {
        background-color: #0d89ff;
        margin-left: 5px;
        border-radius: 5px;
        padding: 10px;
        font-size: 1.3em;
        cursor: pointer;
        align-self: center;
        border: none;
        color: #fff;
    }
    #newCatagory {
        background-color: #eee;
        border-radius: 5px;
        box-shadow: 3px 3px 5px #ccc;
        height: 175px;
        width: 300px;
        display: flex;
        justify-content: center;
        align-content: center;
        flex-direction: column;
        top: 100px;
        position: fixed;
        align-self: center;
    }
    #close-new {
        align-self: flex-start;
        margin-left: auto;
        margin-right: 5px;
        color: red;
        border: none;
        font-weight: bold;
        font-size: 1.3em;
        cursor: pointer;
    }
    #newCatagory label {
        text-align: center;
        font-size: 1.3em;
    }
    #newCatagory input{
        border: none;
        border: 1px solid #0d89fff2;
        border-radius: 5px;
        outline: none;
        padding: 10px;
        margin: 10px;
        font-size: 1.2em
    }
    .redBorder {
        border: none;
        box-shadow: 2px 2px 5px red,-2px -2px 5px red;
    }
    .save {
        background-color: blue;
        align-self: center;
        padding: 5px;
        font-size: 1.6em;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    button:disabled {
        background-color: dodgerblue;
    }
    .delting,.info-delete {
        position: fixed;
        align-self: center;
        background-color: rgba(255,0,0,.7);
        font-size: 2em;
        top: 20%;
        height: 40px;
        width: 40px;
        color: #fff;
        box-shadow: 2px 2px 5px #eee;
        border-radius: 5px;
        text-align: center;
    }
    .info-delete {
        width: auto;
        font-size: 1.3em;
    }
    .info-delete p{
        padding: 5px;
        padding-top: 8px;
        margin: 0;
    }
</style>