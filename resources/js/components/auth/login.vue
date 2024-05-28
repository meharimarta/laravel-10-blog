<template>
<div id="login-wrapper">
    
    <form method="post">
        <img v-if="islogin" :src="defaultimg" id="login-img"/>
                <h2 v-if="islogin">Login PRO TECH</h2>
                <h2 v-if="!islogin">Reset password</h2>
        <input type="hidden" name="_token" :value="csrf.token">
        <h3 style="color: #fbff01">{{ status }}</h3>
        <h3 style="color: #3fff00" v-if="resetMessage != ''">{{ resetMessage }}</h3>
        <label for="email">Email: </label>
        <div class="email">
            <i class="fa fa-envelope"></i><input type="email" name="email" v-model="email"/>
        </div>
        <span style="color: #fbff01">{{ emailErr }}</span>
        
        <label for="password" v-if="islogin">Password:</label>
        <div class="passwd" v-if="islogin">
            <i class="fa fa-key"></i><input type="password" name="password" v-model="password"/>
        </div>
        <span style="color: #fbff01" v-if="islogin">{{ passwordErr }}</span>
        
        <p style="color: #fff" v-if="islogin"><input type="checkbox" name="remember" value="Remember me"/> Remember me</p>
        <span><a :href="reset" v-if="islogin">Forgot your password?</a></span>
        <button id="login-btn" type="submit" @click.prevent="loginUser">
            <span v-if="islogin">Login</span>
            <span v-if="!islogin">Reset password</span> 
            <i v-if="!login && islogin" class="fa fa-sign-in-alt"></i>
            <i v-if="login" class="fa fa-spinner fa-spin"></i>
        </button>
        <a href="/register" v-if="islogin">Dont have an account <br> Register here</a>
    </form>
</div>
</template>

<script>
export default {
    name: 'login-component',
    data() {
        return {
            login: false,
            email: '',
            emailErr: ' ',
            password: '',
            passwordErr: ' ',
            status: '',
            resetMessage: ''
        }
    },
    props: ['csrf','defaultimg','state','link','reset'],
    methods: {
        loginUser() {
            this.login = true;
            this.status = "";
            let fd = new FormData();
            fd.append('email',this.email);
            fd.append('password',this.password);
            axios.post(this.link,fd,{validateStatus:(status)=>{return true}}).then((res)=>{
                this.login = false;
                if(res.data.errors) {
                    let err = res.data.errors;
                    this.emailErr = err.email ? err.email[0] : '';
                    this.passwordErr = err.password ? err.password[0] : '';
                    return;
                }
                if(res.data.message)
                    this.resetMessage = res.data.message;
                if(res.data.url && this.state == 'login')
                    window.location.href = res.data.url;
                if(res.data.loginerr)
                    this.status = "incorrect password or email";
            }).catch((err)=>{
//               console.log(err);            
            });
        }
    },
    computed: {
        islogin() {
            if(this.state == 'login')
                return true;
            return false;
        }
    },
    watch: {
        email() {
            this.emailErr = ' ';
        },
        password() {
            this.passwordErr = ' ';
        }
    }
}
    
</script>

<style scoped="true">
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
    #login-wrapper {
        overflow: hidden;
        transition-duration: .5s;
        flex: 1;
        display: flex;
        height: 100%;
        margin-top: -40px;
        background-color: #183550;
        flex-direction: column;
        justify-content: center;
        align-content: center;
    }
    #login-wrapper {
        background: linear-gradient(to bottom,#183550,#e91e63);
    }
    #login-img{
        display: block;
        align-self: center;
        margin-top: -50px;
        height: 100px;
        width: 100px;
        border-radius: 50%;
    }
    form h2 {
        text-align: center;
        color: #fff;
    }
    form {
        z-index: 1;
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
        mix-blend-mode: difference;
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
    a {
        text-decoration: none;
        color: #eee;
        display: inline;
        margin-top: 8px;
/*        float: right;*/
/*        align-self: a*/
        direction: rtl;
    }
    a:hover {
/*        border-bottom: 1px solid #eee;*/
        
    }
</style>