<template>
    <div class="wrapper">
        <form method="post">
            <h2>Reset password</h2>
            <input type="hidden" name="_token" :value="csrf">
            <h3 style="color: #fbff01">{{ status }}</h3>
            <label for="email">Email: </label>
            <div class="email">
                <i class="fa fa-envelope"></i><input type="email" name="email" v-model="email"/>
            </div>
            <span style="color: #fbff01">{{ emailErr }}</span>
            
            <button id="login-btn" type="submit" @click.prevent="reset">Send password reset link 
            <i v-if="!login" class="fa fa-reset"></i>
            <i v-if="login" class="fa fa-spinner fa-spin"></i>
            </button>
        </form>
    </div>
</template>

<script>
export default {
    name: 'reset-password',
    data() {
        return {
            email: '',
            emailErr: '',
            status: '',
            login: false,
        }
    },
    props: ['csrf','reset_link'],
    methods: {
        reset() {
            let fd = new FormData();
            fd.append('email',this.email);
            axios.post(this.reset_link,fd,{validateStatus:status=>true}).then((res)=>{
//                console.log(res.data);
            }).catch((err)=>{
//                console.log(err);
            })
        }
    }
}
</script>

<style scoped>
    .wrapper {
        transition-duration: .5s;
        flex: 1;
        display: flex;
        height: 100%;
        margin-top: -40px;
        background-color: #183550;
/*        background-image: url(../../../assets/bg.jpg);*/
/*        background-position: center;*/
/*        background-size: cover;*/
/*        background-attachment: fixed;*/
/*        background-repeat: no-repeat;*/
        flex-direction: column;
        justify-content: center;
        align-content: center;
    }
    form h2 {
        text-align: center;
        color: #fff;
    }
    form {
        font-family: sans-serif;
        align-self: center;
        display: flex;
        flex-direction: column;
        width: 300px;
        box-shadow: 0 0 5px  #eee;
/*        height: 400px;*/
/*        background-color: rgb(16, 163, 232,.6);*/
        padding: 10px;
        padding-bottom: 30px;
        border-radius: 5px;
    }
    form label {
        margin-top: 10px;
        color: #fff;
        font-size: 1.2em;
    }
    form lable[for="email"] {
        margin-top: 20px;
    }
    form input {
        padding: 5px;
        font-size: 1.2em;
        color: #000;
/*        background: none;*/
        border: none;
        background: none;
        color: #fff;
/*        border-bottom: 1px solid #00a5fd;*/
/*        background-color: azure;*/
        outline: none;
        border-radius: 5px;
    }

    #login-btn {
        align-self: center;
        background-color: rgba(0,0,0,.2);
        box-shadow: 0 0 5px;
        color: #fff;
        margin-top: 15px;
        padding: 5px;
        font-size: 1.3em;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }
        .email,.passwd {
/*        background-color: azure;*/
        padding: 5px;
/*        font-size: 1.3em;*/
        border-radius: 3px;
        border-bottom: 2px solid azure;
    }
    .email i,.passwd i {
        font-size: 1.3em;
        color: #fff;
    }
</style>