var mixin = {
	data:{
		blogTitle: POST.title || '',
		blogId: POST.id || 0,
	    img:POST.image || '',
		postImg:[],
		blogDir:'',
		alertMessage:'',
		post:POST.post || '',
		selected:'',
		showAlert: false,
        uploading: false,
        waitMsg: 'Please wait...',
        publishing: false,
        loading: false
	},
	mounted() {
        this.$refs.editor.innerHTML = this.post;
	},
	methods:{
		 alertBox() {
			this.showAlert = this.showAlert ? false :true;
			//this.alertMessage = '';
		},
		command(command) {
			if(command == 'insertImage')
			{
				document.execCommand(command,false,prompt('Enter img link','http://www.example.com'));
				return;
			}
			if(command == "createLink")
			{
				document.execCommand(command,false,prompt('Enter link address','http://www.example.com'));
				return;
			}
			if(command == "H")
			{
				document.execCommand("formatBlock",false,"H2");
				return;
			}
			if(command == "code")
			{
				document.execCommand("formatBlock",false,"code");
				return;
			}
			    document.execCommand(command,false);
		},
		insertImage(img) {
			document.execCommand('insertImage',false,img);
		},
		onInput(e) {
			this.post = e.target.innerHTML;
		},
		finish() {
			alert(this.$refs.id.value);
		},
		request(status) {
            
            this.waitMsg = (status == 'publish')? 'Publishing...' : 'Saving...';
            this.publishing = true;
            this.loading = true;
            
			var fd = new FormData();
//			fd.append('id',this.$refs.id.value);
            fd.append('id',this.blogId);
			fd.append('title',this.blogTitle);
			fd.append('content',this.post);
			fd.append('img',this.img);
			fd.append('status',status);
			if(this.blogId ==0)fd.append('blg',status);
			fd.append('catagory',this.selected);
			//ajax request
			var ajax = "http://localhost/blog/public/dashboard/createnewblog";
			if(this.blogId != 0) ajax +"?blogId=" + this.blogId + "&edit=1";
			axios.post(ajax,fd,{headers:{'Content-type':'multipart/form-data'},
                                validateStatus:(status)=>{return true;}}).
			then((res) => {
                this.blogId = res.data;
                this.loading = false;
                console.log(this.blogId);
                this.waitMsg = (status == 'publish')? 'Published successfuly' : 'Saved succesfuly';
                setTimeout(()=>{this.publishing = false;},2000);       
            }).
			catch((error) => {console.log(error)});
		},
		publish() {
            this.request('publish');
            console.log('publish');
		},
		save() {
			this.request('save');
		},
		getBlogImages() {
			axios.get('./upload.php?postImg='+this.title).
			then((res) => {
				this.postImg = res.data;
				alert(res.data);
				}).
			catch((err)=> {alert(err);});
		},
		upload(type) {  
            this.uploading = true;
			var fd = new FormData();
            if(type=='cover')
            fd.append('coverimg',this.$refs.file.files[0]);
            if(type=='post')
            fd.append('postimg',this.$refs.file1.files[0]);
            fd.append('id',this.blogId);
            console.log(fd);
//            uploading an image to the server
            axios.post('http://localhost/blog/public/upload',fd,
                        {headers:{'Content-type':'multipart/form-data'},
                        validateStatus:(status)=>{return true;}}).
                        then((res)=>{
//                        console.log(res.data);
                        if(type=='cover') {
                            this.img = res.data.image;
                            this.blogId= res.data.id;
                        }
                        else
                            this.postImg.push(res.data);
                this.uploading = false;
		  }).catch((err)=>{console.log(err)});
        }

    },
        computed: {
			title() {
				if(this.blogTitle < 6)
				return false;
				return true;
            }
	}
}
