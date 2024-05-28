<template>
<div id="login-wrapper">
    
    <form method="post">
<!--        <img src="imafe" id="login-img"/>-->
        <h2 v-if="isRegister">Register PROTECH</h2>
        <h2 v-if="!isRegister">Reset password</h2>
        <input type="hidden" name="_token" :value="csrf.token">
       
        <label for="name" v-if="isRegister">User name:</label>
        <div class="email" v-if="isRegister">
             <input type="text" name="name" v-model="name"/>
        </div>
        <span class="error" v-if="isRegister"> {{ nameErr }} </span>
        
        <label for="email">Email: </label>
        <div class="email">
            <input type="email" name="email" v-model="email"/>
        </div>
        <span class="error">{{ emailErr}} </span>
        
        <label for="password">Password:</label>
        <div class="passwd">
            <input type="password" autocomplete name="password" placeholder="password" v-model="passwd"/>
        </div>
        <span class="error"> {{ passwdErr }} </span>
        
        <label for="conf_password">Confirm password</label>
        <div class="passwd">
            <input type="password" autocomplete name="password_confirmation" placeholder="password" v-model="confPasswd"/>
        </div>
        <span class="error"> {{ confPasswdErr }} </span>
        <button id="login-btn" type="submit" @click.prevent="register">
            <span v-if="isRegister">Register</span>
            <span v-if="!isRegister">Reset password</span>
            <i v-if="!registering" class="fa fa-sign-in-alt"></i>
            <i v-if="registering" class="fa fa-spinner fa-spin"></i></button>
        <a href="/login" v-if="isRegister">Already have an account <br> login here</a>
    </form>
</div>
</template>

<script>
export default {
    name: 'register-component',
    data() {
        return {
            name: '',
            nameErr: '',
            
            email: '',
            emailErr: '',
            
            passwd: '',
            passwdErr: '',
            
            confPasswd: '',
            confPasswdErr: '',
            
            registering: false
        }
    },
    props: ['csrf','state','link'],
    methods: {
        register() {
            this.registering = true;
            let fd = new FormData();
            fd.append('token',this.csrf.token)
            fd.append('name',this.name);
            fd.append('email',this.email);
            fd.append('password',this.passwd);
            fd.append('password_confirmation',this.confPasswd);
            axios.post(this.link,fd,{validateStatus:(status)=>{return true}}).then((res)=>{
//                    console.log(res);
                if(res.status == 201) {
                    window.location.href = '.' + res.data.redirect;
                }
                if(res.status == 200 && this.state == 'reset') {
                    window.location.href = '/login';
                }
                if(res.data.errors) {
                    let err = res.data.errors;
                    this.emailErr = err.email ? err.email[0] : '';
                    this.nameErr = err.name ? err.name[0] : '';
                    this.passwdErr = err.password ? err.password[0] : '';
                    this.confPasswdErr = err.password ? err.password[0] : '';
                }
                this.registering = false;
            }).catch((err)=>{
//                console.log(err);
            });
        }
    },
    computed: {
      isRegister() {
          if(this.state == 'register')
              return true;
          return false;
      }  
    },
    watch: {
        name() {
            this.nameErr = '';
        },
        email() {
            this.emailErr = '';
        },
        passwd() {
            this.passwdErr = '';
        },
        confPasswd() {
            this.confPasswdErr = '';
        }
    }
}
    
</script>

<style scoped="true">
/*
    input:-webkit-autofill, textarea:-webkit-autofill{
        background-color: none;
        background-image: none;
        background: none;
    }
    input:-internal-autofill-selected, textarea:-internal-autofill-selected{ 
        background-color: none;
    }
*/
    input:-internal-autofill-selected {
        background-color: transparent;
        background-image: none;
        color: #fff;
    }
    .error {
        color: #fffe01;
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
    #login-wrapper {
        background: linear-gradient(to bottom,#183550,#e91e63);
        transition-duration: .4s;
        flex: 1;
        display: flex;
        height: 100%;
        margin-top: -50px;
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
        font-family: sans-serif;
        align-self: center;
        display: flex;
        flex-direction: column;
        width: 300px;
        box-shadow: 0 0 5px  #eee;
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
        border: none;
        background: none;
        color: #fff;
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
        border-radius: 3px;
        border: none;
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
</style>