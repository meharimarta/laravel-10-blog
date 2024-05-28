<template>
    <div class="btn-wrapper">
        <input v-model="email" type="email" :placeholder="'subscribe to '+ user" /><button @click="subscribe" type="button"><span v-if="!loading">{{msg}}</span><i class="fa fa-spinner fa-spin" v-if="loading"></i></button>
        <span id="emailErr" v-if="emailErr!=''">{{emailErr}}</span>
    </div>
</template>

<script>
export default {
    name: 'user-subscriber',
    data() {
        return {
            email: '',
            loading: false,
            msg:'Subscribe',
            emailErr: ""
        }
    },
    props: ['user'],
    methods: {
        subscribe() {
            this.emailErr = '';
            if(this.email == '') return;
            this.loading = true;
            var fd = new FormData();
            fd.append('email',this.email);
            fd.append('user_name',this.user);
            axios.post('/subscribe',fd,{validateStatus: status=>true}).then((res)=>{
                if(res.data === 1 || res.data === true) {
                    this.msg = 'Sbscribed';
                }
                if(res.data.errors){
                   this.emailErr = res.data.errors.email[0]; 
                }
                this.loading = false;
            });
        }
    }
}
</script>

<style>
    #emailErr {
        display: block;
        background-color: #ff0d0d8a;
        width: 100%;
        color: white;
    }
</style>