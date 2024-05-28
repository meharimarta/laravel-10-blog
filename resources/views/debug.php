<div class="name-map">
    <div id="profile-head">
	  <h2>Edit your profile</h2>
      <h2><span> @{{firstName}}  </span><span> @{{lastName}} </span></h2>
		<div class="profile_img_div">
		  <img :src="profileImg" class="user_img"/>
		</div>
	</div>
<div id="map">
    <!--<h4> locationMessage </h4>-->
<img src="user.jpg" />
  <div id="error">

    <i v-if="mapLoading" class= "fa fa-spinner fa-spin fa-4x fa-fw" ></i><br>
    <i v-if="mapWarning" class="fa fa-exclamation-triangle fa-4x fa-fw"></i><br>
        <div> @{{locationMessage}} </div>
  </div>
</div>
</div>

<div class="profile-wrapper">
<div class="profile_n_e">
	      <label>Change profile picture: <i class="fa fa-user"></i></label>
		  <input type="file" ref="file" @change="upload" name="file"/>
		
		  <label>First Name: <i class="fa fa-check"></i></label>
		  <input type="text" v-model="firstName" name="first_name"/>
		  <span class="error"></span>
		
		  <label>Last Name: <i class="fa fa-check"></i></label>
		  <input type="text" v-model="lastName" name="last_name"/>
		  <span class="error"></span>
		
		  <label>Email: <i class="fa fa-check"></i></label>
		  <input type="text" v-model="email" name="email"/>
		  <span class="error"></span>
		
		  <label>password: <i class="fa fa-check"></i></label>
		  <input type="password" v-model="oldPasswd"/>
		  <span class="error" v-if="oldPasswd.length < 8">The password lenght should be greater than<strong> 8</strong> characters Alpha neumerically! </span>
		
		  <label>Wrirte something about yor self</label>
		  <textarea rows="7" v-model="about">Optional</textarea>
</div>

<div class="change_password_div">
			
          <span class="change_password"><i class="fa fa-key"></i>  Change password <input type="checkbox" v-model="check"/></span><br>
		  <label>New passowrd: <i class="fa fa-check"></i></label>
		  <input type="password" v-model="newPasswd" :disabled = "oldPasswd.length < 8 || !check"/>
		  <span class="error" v-if="newPasswd<8">Passwd should be greater than 8 characters</span>

		  <label>Confirm password <i v-show="!matchPasswd" class="fa fa-check"></i></label>
		  <input type="password" v-model="confNewPasswd" :disabled="newPasswd.length < 8 || !check" :class="{ redBorder: deactiveBtn }"/>
		  <span class="error" v-if="!matchPasswd">Confirm password is not match</span>
		
		  <label>select your skill</label>
			<select v-model="skill" :disabled="!disableSkill">
				<option>Programmer</option>
				<option>Enginnern</option>
				<option>Freelancer</option>
			</select>
		  <label>Other:<input v-model="anotherSkill" type="checkbox"/></label>
		  <input type="text" v-model="skill" :disabled="disableSkill" placeholder="other"/>
</div>
</div>