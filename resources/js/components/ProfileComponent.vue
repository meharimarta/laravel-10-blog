<template>
<div class="profile-outer-wrapper">
    <div class="name-map">
        <img id="cover" :src="cover_img"/>
        <div id="profile-head">
          <h2>Edit your profile</h2>
            <h2><span v-if="!firstLastName">{{ userName }}</span><span v-if="firstLastName" >{{firstName}} {{lastName}}  </span></h2>
            <div class="profile_img_div">
              <img :src="profileImg" class="user_img"/>
            </div>
        </div>
<!--
    <div id="map">
    <img src="user.png" />
      <div id="error">

        <i v-if="mapLoading" class= "fa fa-spinner fa-spin fa-4x fa-fw" ></i><br>
        <i v-if="mapWarning" class="fa fa-exclamation-triangle fa-4x fa-fw"></i><br>
            <div> {{locationMessage}} </div>
      </div>
    </div>
-->
    </div>

    <div class="profile-wrapper">
    <div class="profile_n_e">
              <label>Change profile picture: <i class="fa fa-user"></i></label>
              <input type="file" ref="file" @change="upload('profile')" name="file"/>    
        
            <label>Cover image: <i class="fa fa-image"></i></label>
              <input type="file" ref="cover" @change="upload('cover')" name="file"/>
        
              <label>Page: </label>
              <input type="text" v-model="pageName" name="page_name"/>
              <span class="error">{{pgerr}} </span>
        
              <label>First Name: </label>
              <input type="text" v-model="firstName" name="first_name"/>
              <span class="error">{{fnerr}} </span>

              <label>Last Name: </label>
              <input type="text" v-model="lastName" name="last_name"/>
              <span class="error"> {{lnerr}} </span>

        <label>Email: <!--<span class="info-change-success">{{ emailChanged }}</span>--></label>
              <input style="background-color: #ccc" disabled type="text" v-model="email" name="email"/>
<!--              <span class="error"> {{emailerr}} </span>-->

              <label>password:</label>
              <input type="password" v-model="oldPasswd"/>
              <span class="error" v-if="oldPasswd.length < 8">The password should be greater than<strong> 8</strong> characters </span>

              <label>Wrirte something about yor self</label>
              <textarea rows="7" v-model="about">Optional</textarea>
              <span class="error">{{ abouterr }}</span>
    </div>

    <div class="change_password_div">

        <span class="change_password"><i class="fa fa-key"></i>  Change password <input type="checkbox" v-model="check"/><span class="info-change-success">{{ pwdChanged }}</span></span><br>        
              <label>New passowrd:</label>
              <input type="password" v-model="newPasswd" :disabled = "oldPasswd.length < 8 || !check"/>
              <span class="error" v-if="check && newPasswd<8">Passwd should be greater than 8 characters</span>
                <span class="error">{{ newpwderr}}</span>

        
              <label>Confirm password</label>
              <input type="password" v-model="confNewPasswd" :disabled="newPasswd.length < 8 || !check" :class="{ redBorder: deactiveBtn }"/>
              <span class="error" v-if="!matchPasswd">Confirm password is not match</span>
                <span class="error">{{confpwderr}}</span>
        
              <label>select your skill</label>
                <select v-model="skill" :disabled="!disableSkill">
                    <option>Programmer</option>
                    <option>Enginnern</option>
                    <option>Freelancer</option>
                </select>
        <label>Other:<input v-model="anotherSkill" type="checkbox"/></label>
        <input type="text" v-model="skill" :disabled="disableSkill" placeholder="other"/>
        <span class="error"> {{ skillerr }} </span>
        <span class="sochial-link"><i class="fa fa-link"></i> Your shochial links</span>
        <span class="info-change-success">{{socialLinkUpdate}}</span>
        <div  class="input-wrapper">
            <i class="fab fa-twitter"></i><input v-model="stwt" type="text" placeholder="twitter"/>
            <span class="error"> {{stwterr}} </span>
        </div>        
        <div  class="input-wrapper">
            <i class="fab fa-facebook"></i><input v-model="sfb" type="text" placeholder="facebook"/>
            <span class="error">{{sfberr}}</span>
        </div>        
        <div  class="input-wrapper">
            <i class="fab fa-youtube"></i><input v-model="syb" type="text" placeholder="youtube"/>
            <span class="error"> {{syberr}} </span>
        </div>        
        <div  class="input-wrapper">
            <i class="fab fa-telegram"></i><input v-model="stg" type="text" placeholder="telegram"/>
            <span class="error"> {{stgerr}} </span>
        </div>
    </div>
    </div>
    <input type="submit" id="save" value="Save Changes" :disabled="disableSaveBtn" @keyup.enter="save" @click.prevent="save"/>
<!--    information box-->
<!--    -------------- -->
    <infoDialog :infoMsg="infoMsg" v-if="info"></infoDialog>
</div>
</template>

<script>
    import { watch , ref } from 'vue';
export default {
    
    name: 'profile-component',
    data() {
        return {
            pageName: this.user.name,
            pgerr: '',
            pg: false,
            
            userName: this.user.name,
            firstName: this.user.FirstName || '',
            fnerr: '',
            
            lastName:  this.user.LastName || '',
            lnerr: '',
            
            firstLastNameDirty: false,
            userInfoDirty: false,
            
            email: this.user.email || '',
            emailerr: '',
            changeEmail: false,
            emailChanged: '',
            
            skill:this.user.skill || '',
            skillerr: '',
            
            about:this.user.about || '',
            abouterr: '',
            
            profileImg: this.user.profile_picture == "user.jpg" ? this.defaultimg : this.user.profile_picture,
            oldPasswd: '',
            
            newPasswd: '',
            newpwderr: '',
            pwdChanged: '',
            
            confNewPasswd: '',
            confpwderr: '',
            
            changePasswd:false,
            check: false,
            anotherSkill: false,
            showAlert: false,
            alertMessage: '',
            map:'',
            mapLoading: true,
            mapWarning: false,
            locationMessage:'Loading your location...',
            
            //socilal links
            slinksdirt: false,
            socialLinkUpdate: '',
            
            sfb: this.user.fb || '',
            sfberr: '',
            
            stwt: this.user.twt || '',
            stwterr: '',
            
            stg: this.user.tg || '',
            stgerr: '',
            
            syb: this.user.yb ||'',
            syberr: '',
            //info
            info: false,
            infoMsg: '',
            
            cover_img: this.user.cover_image ? '/'+this.user.cover_image : '/assets/bg.jpg'
        }
    },
    props: ['user','defaultimg'],
//    mounted() {
//        if(navigator.geolocation) {
//            navigator.geolocation.getCurrentPosition((pos) => {
//              var coords = pos.coords.latitude+','+pos.coords.longitude;
//              var img = 'http://maps.googleapis.com/maps/api/staticmap?markers='
//              +coords+'&zoom=11&size=200x200&sensor=false';
//              this.map = img;
//              this.mapLoading = false;
//              this.mapWarning = false;
//              this.locationMessage="Your current location.";
//            },(pp)=>{
//            	this.locationMessage="Unable to load your location:-(";
//                this.mapLoading = false;
//                this.mapWarning = true;
//            });
//          }
//    },
    methods: {
        save() {
            this.info = true;
			var fd = new FormData();
//            on every request include the user password
			fd.append('oldPassword',this.oldPasswd);
			if(this.changeEmail) {
                fd.append('changeEmail',true);
			     fd.append('email',this.email);
            }
            //append then name off the page
            fd.append('name',this.pageName);
            //if the first name or last name is touched 
            //we will append first name and last names 
            // on the request
            if(this.firstLastNameDirty)
            {
                fd.append('firstLastNameDirty',true);
                fd.append('firstName',this.firstName);
                fd.append('lastName',this.lastName);
            }
            if(this.userInfoDirty)
            {
                fd.append('userInfoDirty',true);
			     fd.append('skill',this.skill);
			     fd.append('about',this.about);
            }
			if(this.check)
			{
                fd.append('changePwd',true)
				fd.append('newPassword',this.newPasswd);
				fd.append('confNewPassword',this.confNewPasswd);
			}
			if(this.check && !this.validPasswd)
			{
//				this.alertBox('please fix your errors first');
                this.infoMsg = "please fix your errors first";
                setTimeout(()=>{
                    this.info = false;
                    this.infoMsg = '';
                },3000);
				return;
			}
            if(this.slinksdirt)
            {
                fd.append('slinks',true);
                fd.append('sfb',this.sfb);
                fd.append('stg',this.stg);
                fd.append('syb',this.syb);
                fd.append('stwt',this.stwt);
            }
            axios.post('/dashboard/userinfo',fd,{headers:{'Content-type':'multipart/form-data'},
                                validateStatus:(status)=>{return true;}}).
			then((res)=>{
                if(res.data.errors) {
                    let err = res.data.errors;
                    this.pgerr = err.name ? err.name[0] : '';
                    this.fnerr = err.firstName ? err.firstName[0] : '';
                    this.lnerr = err.lastName ? err.lastName[0] : '';
                    this.skillerr = err.skill ? err.skill[0] : '';
                    this.abouterr = err.about ? err.about[0] : '';
                    this.newpwderr = err.newPassword ? err.newPassword[0] : '';
                    this.confpwderr = err.confNewPassword ? err.confNewPassword[0] : '';
                    this.emailerr = err.email ? err.email[0] : '';
                    this.sfberr = err.sfb ? 'invalid link': '';
                    this.syberr = err.syb ? 'invalid link': '';
                    this.stgerr = err.stg ? 'invalid link': '';
                    this.stwterr = err.stwt ? 'invalid link': '';
                    this.info = false;
                    this.infoMsg = 'Fix your errors or\ncheck other forms';
                    setTimeout(()=>{
                    this.info = false;
                    this.infoMsg = '';
                },2000);
                    return;
                }else{
                    this.changeEmail = this.firstLastNameDirty = this.userInfoDirty = this.check = false;
                }
                var msg = "";
                if(res.data.additionalinfo || res.data.name)
                    this.infoMsg = "Done";
                if(res.data.pswd) {
                    this.pwdChanged = res.data.pswd;
                    this.infoMsg = "Done";
                }
                if(res.data.incorrectpwd)
                    this.infoMsg = res.data.incorrectpwd;
                if(res.data.emailChange) {
                    this.emailChanged = res.data.emailChange;
                    this.infoMsg = "Done";
                }
                if(res.data.social_link)
                    this.socialLinkUpdate = res.data.social_link;
                setTimeout(()=>{
                    this.info = false;
                    this.infoMsg = '';
                },2000);
			}).catch((err)=>{
			});
		},
		upload(type){
            this.info = true;
            let image;
			var fd = new FormData();
            if(type == 'profile') {
			     image = this.$refs.file.files[0]; 
                fd.append('type','profile');
            }else{
			     image = this.$refs.cover.files[0];
                fd.append('type','cover');
            }
			fd.append('img',image);
			fd.append('id',this.id);
			var has_profile_pic = this.profileImg != "user.jpg" ? true: false;
			axios.post('/dashboard/userinfo/upload',fd,{headers:{'Content-type': 'multipart/form-data'},
                                                                                   validateStatus:(status)=>{return true;}}).
			then((res)=>{
                this.info = false;
                if(type == 'cover')
                    this.cover_img = res.data;
                else
				    this.profileImg = res.data;
			}).catch((err)=>{
			});
		},
		alertBox(msg) {
			this.alertMessage = msg;
			this.showAlert = this.showAlert ? false :true;
		} 
    },
        computed: {
            firstLastName(){
                if(this.firstName != 'firstname' &&
                this.lastName != 'lastname' &&
                this.firstName !='' &&
                this.lastName !='') return true;
                return false;
            },
            deactiveBtn(){
                if(this.changePasswd)
                return true;
                return false;
            },
            disableSkill(){
                return this.anotherSkill ? false: true;
            },
            validPasswd() {
                if(this.oldPasswd != '' &&
                    this.newPasswd !='' &&
                    this.confNewPasswd !='' &&
                    this.newPasswd === this.confNewPasswd)
                    return true;
                    //other wise return false
                    return false;
            },
            matchPasswd(){
                return (this.newPasswd == this.confNewPasswd) ? true : false;
            },
            disableSaveBtn() {
                if(
                    this.firstLastNameDirty|| 
                    this.userInfoDirty ||
                    this.check ||
                    this.changeEmail ||
                    this.slinksdirt ||
                    this.pg
                  ) return false;
                return true;
            }
        },
    	watch: {
        syb(){this.slinksdirt = true;this.syberr = ''},
        sfb(){this.slinksdirt = true;this.sfberr = ''},
        stg(){this.slinksdirt = true;this.stgerr = ''},
        stwt(){this.slinksdirt = true;this.twterr = ''},
		newPasswd() {
			this.changePasswd = true;
            this.newpwderr = '';
		},
        pageName(){
            this.pgerr='';
            this.pg=true;
        },
        email() {
            this.changeEmail = true;
            this.emailChanged = this.emailerr = '';
        },
		confNewPasswd(conf) {
			if(conf == this.newPasswd)
			{
				this.changePasswd = false;
			} else {
				this.changePasswd = true;
			}
            this.confpwderr = '';
		},
		map(m) {
			alert(m);
		},
		check(ch){
			if(ch) {
				this.alertBox("Your password will be changed");
			}
		},
        firstName() {
            this.firstLastNameDirty = true;
        },
        lastName() {
            this.firstLastNameDirty = true;
        },
        skill() {
            this.userInfoDirty = true;
        },
        about() {
            this.userInfoDirty = true;
        }
	}
}
</script>

<style scoped>
    #cover {
        position: absolute;
        height: 251px;
        width: 79.5%;
        left: 18.5%;
        top: 50px;
        z-index: -1;
    }
    .fa-telegram {
        color: darkcyan;
    }
    .info-change-success {
        color: #00d44b;
        margin: 5px;
    }
.profile-wrapper,.name-map {
    margin-left: 18.5%;
/*    display: flex;*/
}
.profile-wrapper {
    display: flex;
    justify-content: center;
    margin-top: -200px;
}
#map {
	position: absolute;
	margin-top: 10px;
	height: 200px;
	width: 81.5%;
}
#map img,#error {
	position: absolute;
	top:0;
	left:0;
	width:98.5%;
}
#map img {
	height: 200px;
}
@media(max-width: 850px) {
    .profile-wrapper {
        margin-left: 0;
    }
    .name-map {
        margin-left: 2px;
        width: 100%;
    }
    #map {
        width: 100%;
    }
}
.fa-check, .fa-times{
	display:inline-block;
	float: right;
	padding-left: -100px;
}
#profile-head {
/*	background: linear-gradient(to right,rgb(162, 0, 229),#1e90ff,yellow);*/
    background-color: rgba(0,0,0,0.4);
	border-radius:0 0 10px 10px;
	color: #fff;
    width: 98%;
/*    align-self: flex-start;*/
    flex: none;
}
input[type="checkbox"]
{
	background:none;
	border:1px solid red;
}
input[type="text"]:not(#nav-search),
input[type="password"],
input[type="file"],
textarea,
select
{
  display:block;
  width:95%;
  background:none;
  border:none;
/*
  border:1px solid green;
  border-radius: 5px;
*/
  border-bottom:2px solid #10A3E8;
/*  color:green;*/
  outline:none;
  margin:0 30px 30px 0;
  padding:10px;
  font-size:120%;
  transition:all .5 ease;
}
input[type="password"]
{
  border-bottom:1px solid #10A3E8;
}
input[type="password"]:disabled,
input[type="text"]:disabled,
select:disabled
{
	background-color: lightgray;
}

input[type="file"]
{
  margin-bottom:15px;
  background:none;
}
.profile
{
  padding:5px;
  height:100%;
  /*background-color: rgba(0,36,37,.5);*/
}
label
{
/*  color: green;*/
  top:70px;
  line-height:120%;
  font-size:120%;
  z-index: -100;
}
h2
{
  text-align:center;
}
input[type="submit"],button
{
  border:1px solid green;
  border-radius:5px;
  padding:15px;
  color:#fff;
  outline:none;
  background:none;
  background-color: green;
  font-size:120%;
  transition:all .5 ease;
}
input[type="submit"]:disabled {
	background-color: #ccc;
}
.redBorder 
{
	background-color:red;
}
.red
{
	color: red;
}
button:hover
{
  transform:scale(1.1);
}
.edit,.change_password
{
  position:absolute;
  left:65%;
  color:#002425;
  font-size:120%;
  font-weight: bold;
}
.change_password {
    
}
.hr
{
  border:1px solid #10A3E8;
}
.user_img
{
  height:150px;
  width:150px;
  border-radius:50%;
  z-index:-1;
  background-color:#ccc;
}
.profile_change
{
 display:block;
 margin-bottom:30px;
 color:#10A3E8;
 font-size:129%;
}
.profile
{
 
}
.profile_img_div
{
  text-align:center;
}
.profile_n_e,.change_password_div
{
    flex: 1;
    margin: 10px;
    margin-top: 215px;
}
.change_password
{
  position:relative;
  display:block;
  left:0;
  margin-bottom:20px;
}
.change_password_div
{
  margin-top:245px
}
.cancel
{
  float:right;
}
.error
{
  position:absolute;
  margin-top:-30px;
  font-size:110%;
  font-style:italic;
  color:Red;
  display:block;
}

#error {
	background-color: rgba(0,0,0,.5);
	height:200px;
	vertical-align: center;
	text-align: center;
	color: yellow;
}
    .profile-outer-wrapper {
        display: flex;
        flex-direction: column;
    }
#save {
	align-self: center;
    cursor: pointer;
/*    flex-direction: column;*/
    margin-bottom: 10px;
    background: none;
    color: #000;
    border-color: skyblue;
}
    #save:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
/*********************************/
/*********************************/
/***********media queres**********/
/*********************************/
/*********************************/
/*********************************/
@media(max-width: 850px) {
    .profile-wrapper {
        margin-left: 0;
    }
    #cover {
        left: 5px;
        width: 98%;
    }
    .name-map {
        margin-left: 2px;
        width: 100%;
    }
    #map {
        width: 100%;
    }
    .info-box {
        left: 0;
    }
}
@media(max-width: 500px) {
    .profile-wrapper {
        flex-direction: column;
    }
    .change_password_div {
        margin-top: auto;
    }
}
    .fa-twitter{
    color: dodgerblue;
    }
    .fa-facebook {
        color: blue;
    }
    .fa-youtube {
        color: red;
    }
    
</style>