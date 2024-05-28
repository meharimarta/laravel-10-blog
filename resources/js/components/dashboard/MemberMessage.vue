<template>
<div class="message">
    <p>Write email</p>
    <form>
        <div>To: 
            <input type="email" name="email" v-model="email">
            <div class="users-dropdown" tabindex="0">
                <p>Find Member</p>
                <div class="dropdown-content">
                    <p style="text-align: center" @click="all"><i class="fa fa-user"></i>All</p>
                    <p id="search"><input type="text" placeholder="Search user" v-model="search"/><button @click.prevent="searchUser"><i v-if="searching" class="fa fa-spinner fa-spin"></i><i v-if="!searching" class="fa fa-search"></i></button></p>
                    <p v-for="(user,index) in users" @click.stop="mail(index)"><i @click.stop="showDetail(index)" class="fa fa-user"></i>User: {{user.email}} </p>
                </div>
            </div>
        </div>
        <textarea rows="5" v-model="message">message</textarea>
        <div><button @click.prevent="mailuser">Send <i class="fa fa-spinner fa-spin" v-if="loading"></i></button><span class="success">{{error}}</span></div>
    </form>
</div>
</template>

<script>
    import Vue from 'vue';
    Event = new Vue();
    export default {
        name: 'member-message-component',
        data() {
            return {
                email: '',
                search: '',
                users: [],
                message: '',
                error: '',
                loading:false,
                toAll: false,
                searching: false
            }
        },
        mounted() {
            Event.$on('email',e=>{
                this.email = e.email;
            });
        },
        methods: {
            showDetail(i) {
              Event.$emit('detail',{email:this.users[i].email});
                
            },
            searchUser() {
                if(this.search.length > 1) {
                    this.searching = true;
                    axios.get('dashboard/search?query='+this.search).then((res)=>{
                        this.users = res.data;
                        this.searching = false;
                    });
                }  
            },
            mail(i){
                this.email = this.users[i].email;
            },
            all(){
              this.email = 'all';
            this.toAll = true;
            },
            mailuser(){
                this.loading = true;
                this.error = 'Sending please wait...';
                if(this.message == '' || this.email == '') {
                    this.loading =false;
                    this.error = '';
                    return;
                }
                var fd = new FormData();
                if(this.toAll) fd.append('toAll',true);
                fd.append('email',this.email);
                fd.append('message',this.message);
                axios.post('dashboard/email',fd,{validateStatus: status => true})
                    .then((res)=>{
                    this.loading =false;
//                    console.log(res.data);
                    if(res.data.errors) {
                        this.error = "Error has occured try agin";
                        return
                    }
                    this.error = 'Message sent'; 
                    this.email = '';
                    this.toAll = false;
                });
            }
        }
    }
</script>

<style scoped>
    p#search{
        width: 200px;
        border: none;
        padding: 0;
        height: 40px;
    }
    #search>input {
        position: relative;
        padding: 5px;
        width: 100%;
    }
    #search>button {
        width: fit-content;
    }
    .success {
/*        float: right;*/
        color: #7a00ff;
    }
    .users-dropdown {
        cursor: pointer;
        position: relative;
        display: inline-block;
        width: 210px;
    /*    box-shadow: 0 0 5px #000;*/
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
         border: 1px solid dodgerblue;
    }
    .users-dropdown>p {
        margin: 2px;
        padding: 2px;

    }
    .dropdown-content {
    /*    transition-duration: .5s;*/
        display: none;
        width: 200px;
        max-height: 250px;
        padding: 5px;
        overflow-y: auto;
        position: absolute;
        background-color: #fff;
        border-radius:0 0 5px 5px;
            box-shadow: 0 0 5px #000;

    }
    .dropdown-content p{
        margin: 0;
        padding: 5px;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }
    .dropdown-content p:nth-child(odd) {
        background-color: #1e90ff3b;
    }
    .message {
        width: 50%;
    }
    .message p{
        color: black;
    }
    .message form {
        display: flex;
        flex-direction: column;
    }
    .message form input,
    .message form textarea,
    .message form button{
    /*    background: none;*/
        padding: 5px;
        border: 1px solid dodgerblue;
        border-radius: 5px;
    /*    width: 96%;*/
        margin: 5px;
    }
    .message form button {
        width: 100px;
        cursor: pointer;
    }
    .message form div {
        color: black;
    /*    width: 100%;*/
    }
    .user {
        flex: 1;

        background-color:  #fff;
        margin: 5px;
        text-align: center;
        min-width: 150px;
        padding: 5px;
        float: left;
        border-radius: 5px;
        transition-duration: .5s;
    }
    .user:hover {
        box-shadow: 0 0 5px #000;
    }
    .user button {
        background: none;
        border: none;
        font-size: 1.3em;
        background-color: #009688;
        color: #fff;
        border-radius: 3px;
        padding: 5px;
        cursor: pointer;
    /*    box-shadow: 0 0 5px #000;*/
    }
    .user p {
        color: #000;
        margin: 0;
    }
    .user img {
        height: 40px;
        width: 40px;
        margin: 3px;
        text-align: center;
        border-radius: 50%;
    /*    float: left;*/
    }
@media(max-width: 550px) {
     .message {
        width: auto;
    }  
}
</style>