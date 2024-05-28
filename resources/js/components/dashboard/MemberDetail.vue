<template>
    <div class="wrapper">
        <div class="user">
            <div class="user-profile">
                <img :src="user.profile_picture">
                <p>{{user.name}}</p>
                <p>{{email}}</p>
            </div>
            <div class="detail">
                <p>user total posts<button @click="view">View posts</button></p>
                <p>Ban user<button @click="ban"><span v-if="user.banned">Banned</span><span v-else>Ban</span></button></p>
                <p>delete users post<button @click="deletePost"><span v-if="deleted">Deleted</span><span v-else>Delete</span></button></p>
            </div>
            <button @click="close">close</button>
        </div>
        <info-dialog v-if="loading"></info-dialog>
    </div>
</template>

<script>
    export default {
        name: 'member-detail',
        data() {
            return {
                loading: false,
                user: this.puser,
                deleted: false
            }
        },
        methods: {
            close() {
                this.$emit('close');      
            },
            deletePost() {
                this.showLoading();
                let fd = new FormData();
                fd.append('email',this.email);
                axios.post('/dashboard/deleteuserpost',fd,{validateStatus:status=>true}).then((res)=>{
                    if(res.data == 1)
                        this.deleted = true;
                    this.showLoading();
                });
            },
            view() {
                this.showLoading();
                window.open('/page/'+this.user.name,'_blank');
                setTimeout(()=>{
                    this.showLoading();
                },1500);
            },
            ban() {
                this.showLoading();
                let fd = new FormData();
                fd.append('email',this.email);
                axios.post('/dashboard/ban',fd,{validateStatus:status=>true}).then((res)=>{
                   this.user.banned = res.data;
                    this.showLoading();
                });
            },
            showLoading() {
                this.loading = this.loading ? false : true;
            }
        },
        props: ['puser','email']
    }
</script>

<style scoped>
    .wrapper {
        position: fixed;
        display: flex;
        top: 0;
        left: 0;
        z-index: 3;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-content: center;
        background-color: rgba(0,0,0,.5);
        color: #000;
    }
    .user {
        align-self: center;
        height: 85%;
        background-color: #eee;
        box-shadow: 0 0 5px #000;
        position: absolute;
    }
    
    .user-profile {
        text-align: center;
        margin: 10px;
    }
    .user-profile>img {
        height: 100px;
        width: 100px;
        border-radius: 50%;
    }
    .detail {
        width: 300px;
        padding: 10px;
    }
    .detail>p {
        padding: 12px;
    }
    .detail>p button, .user>button {
        float: right;
        width: 100px;
        background: none;
        border: none;
        background-color: #E91E63;
        color: #fff;
        padding: 5px;
        border-radius: 3px;
        margin-bottom: 5px;
        cursor: pointer;
    }
    .user>button {
        vertical-align: bottom;
        float: non;
        position: absolute;
        bottom: 0;
        left: 35%;
    }
</style>