<template>
    <div class="new-members">
        <div class="new-member-label">
           <button class="previous" @click="previous" :disabled="previousLink==null"><i class="fa fa-arrow-left"></i></button> <p>Members {{current_page}}/{{last_page}}</p><button class="next" @click="next" :disabled="nextLink == null"><i class="fa fa-arrow-right"></i></button>
        </div>
        
        <div class="user" v-for="(user,index) in users" :key="index" @click="showUser(index)">
            <img :src="user.profile_picture"/> 
            <p>{{ user.name }}</p>
            <p>{{ user.email }}</p>
            <button @click.stop="email(index)">email</button>
        </div>
        <member-detail v-if="userDetail" :puser="user" @close="close" :email="userEmail"></member-detail>
        <info-dialog v-if="loading"></info-dialog>
    </div>
</template>

<script>
    import Vue from 'vue';
    Event = new Vue();
    export default {
        name: 'new-embers-component',
        data() {
            return {
                users: [],
                nextLink: '/dashboard/members',
                previousLink: '',
                current_page: 0,
                last_page: 0,
                userMail: '',
                userDetail: false,
                loading: false,
                userEmail: '',
                user:{}
            }
        },
        mounted() {
            this.getUsers(this.nextLink);
            Event.$on('detail',(e)=>{
                this.showUser(e.email);
            });
        },
        methods : {
            close() {
              this.userDetail = false;  
            },
            showUser(i) {
                this.loading = true;
                let user;
                if(typeof i == 'number') {
                    this.userEmail = user = this.users[i].email;                   
                }else{
                    this.userEmail = user = i;
                }
                axios.get('/dashboard/getuser?email='+user,{validateStatus:status=>true}).then((res)=>{
                    this.user = res.data[0];
                    this.userDetail = true;
                    this.loading = false
                });
            },
            next() {
                if(this.nextLink == null) return;
                 this.getUsers(this.nextLink);
            },
            previous() {
                if(this.previousLink == null) return;
                this.getUsers(this.previousLink);
            },
            getUsers(link) {
                axios.get(link,{validateStatus:status=>true}).then((res)=>{
                    this.current_page = res.data.current_page;
                    this.last_page = res.data.last_page;
                    this.users = res.data.data;
                    this.nextLink = res.data.next_page_url;
                    this.previousLink = res.data.prev_page_url;
                });
            },
            email(i) {
                Event.$emit('email',{
                    email: this.users[i].email
                });
            }
        }
    }

</script>

<style scoped>
    .users-enter-ative {
        transition: all .5s ease;
    }
    .users-enter {
        opacity: 0;
    }
    .new-members {
    /*    display: flex;*/
        width: 49.5%;
        height: inherit;
        overflow-y: auto;
        height: 250px;
        flex-wrap: wrap;
        display: flex;
    /*    flex-direction: column;*/
    }
    .new-members>.new-member-label {
        flex: 1;
        flex-basis: 100%;
    /*    width: fit-content;*/
        border-radius: 5px;
        text-align: center;

    }
    .new-member-label p{
        width: fit-content;
        padding: 5px;
        background-color: #E91E63;
        border-radius: 5px;
        margin: 3px;
        display: inline-block;
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
        height: 70px;
        width: 70px;
        margin: 3px;
        text-align: center;
        border-radius: 50%;
    /*    float: left;*/
    }
    @media(max-width: 550px) {
    .new-members {
        width: auto;
    }  
}
    .next {
        float: right;
    }
    .previous {
        float: left;
    }
    .next,.previous {
        margin: 3px;
        cursor: pointer;
        background-color: #E91E63;
        border-radius: 3px;
        border: none;
        color: #fff;
        outline: none;
        padding: 5px;
    }
    button:disabled {
        background-color: #ccc;
    }
</style>