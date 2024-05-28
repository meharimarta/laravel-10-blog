var mixin = {
	data: {
		id:'',
		firstName: '',
		lastName: '',
		email: '',
		skill:'',
		about:'',
		profileImg:'',
		oldPasswd: '12345qwert',
		newPasswd: 'qwertyui',
		confNewPasswd: 'qwertyui',
		changePasswd:false,
		check: false,
		anotherSkill: false,
		showAlert: false,
		alertMessage: '',
		map:'',
		mapLoading: true,
		mapWarning: false,
	    locationMessage:'Loading your location...'
	},
	created: function(){
		var uri = window.location.href.split('?');
		if(uri)
		{
			if(uri.length == 2)
			{
				var temp = uri[1];
				    temp = temp.split('=');
				this.id = temp[1];
				axios.get('./userActivity.php?id='+ this.id).
				then((res)=>{
					var data = res.data[0];
					//alert(res.data[1].firstName);
					 this.firstName = data.firstName;
					 this.lastName = data.lastName;
					 this.email = data.email;
					if(data.skill != null) this.skill = data.skill;
					if(data.about != null) this.about = data.about;
					 this.profileImg = (data.profile_pic != null) ? 'Application/object/profile/' + data.profile_pic : "user.jpg";
					}).
					catch((err)=>{
						alert(err);
					});
			}
		}
		if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((pos) => {
              var coords = pos.coords.latitude+','+pos.coords.longitude;
              var img = 'http://maps.googleapis.com/maps/api/staticmap?markers='
              +coords+'&zoom=11&size=200x200&sensor=false';
              this.map = img;
              this.mapLoading = false;
              this.mapWarning = false;
              this.locationMessage="Your current location.";
            },(pp)=>{
            	this.locationMessage="Unable to load your location:-(";
                this.mapLoading = false;
                this.mapWarning = true;
            });
          } 
	},
	methods: {
		save: function() {
			var fd = new FormData();
			fd.append('oldPassword',this.oldPasswd);
			fd.append('firstName',this.firstName);
			fd.append('lastName',this.lastName);
			fd.append('update_info','update');
			fd.append('email',this.email);
			fd.append('id',this.id);
			if(this.skill.length > 5) fd.append('skill',this.skill);
			if(this.about.length >30) fd.append('about',this.about);
			if(this.check)
			{
				fd.append('newPassword',this.newPasswd);
				fd.append('confNewPassword',this.confNewPasswd);
			}
			if(this.profileImg)
			{
				//fd.append('profileImg',this.profileImg);
			}
			if(this.check && !this.validPasswd)
			{
				this.alertBox('please fix your errors first');
				return;
			}
			axios.post('./userActivity.php',fd,{headers:{'Content-type': 'multipart/form-data'}}).
			then((res)=>{
				alert(res.data);
			}).catch((err)=>{
				alert(err);
			});
		},
		upload: function(){
			var fd = new FormData();
			this.profileImg = this.$refs.file.files[0];
			fd.append('profileImg',this.profileImg);
			fd.append('id',this.id);
			var has_profile_pic = this.profileImg != "user.jpg" ? true: false;
			/*if(has_profile_pic) {
				fd.append('haspic',true);
			}else{
				fd.append('haspic',false);
			}*/
			axios.post('./userActivity.php',fd,{headers:{'Content-type': 'multipart/form-data'}}).
			then((res)=>{
				//alert(res.data);
				this.profileImg = 'Application/object/profile/'  + res.data;
			}).catch((err)=>{
				alert(err);
			});
		},
		alertBox: function(msg) {
			this.alertMessage = msg;
			this.showAlert = this.showAlert ? false :true;
		}
	},
	computed: {
		deactiveBtn: function(){
			if(this.changePasswd)
			return true;
			return false;
		},
		disableSkill: function(){
			return this.anotherSkill ? false: true;
		},
		validPasswd: function() {
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
		}
	},
	watch: {
		oldPasswd: function(pwd) {
			if(pwd.length == 8)
			alert(pwd);
		},
		newPasswd: function() {
			this.changePasswd = true;
		},
		confNewPasswd: function(conf) {
			if(conf == this.newPasswd)
			{
				this.changePasswd = false;
			} else {
				this.changePasswd = true;
			}
		},
		map: function(m) {
			alert(m);
		},
		check: function(ch){
			if(ch) {
				this.alertBox("Your password will be changed");
			}
		}
	}
}
