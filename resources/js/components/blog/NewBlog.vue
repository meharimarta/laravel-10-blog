<template>
<div id="newblog">
    <h2 v-if="editblog" >Edit Your  blog <i class="fa fa-blog"></i></h2>
    <h2 v-if="!editblog">Create new Blog <i class="fa fa-blog"></i></h2>
    
    <form method="post" action="" enctype="multipart/form-data">
        
            <span class="error">{{titleErr}}</span><br>
            <input type="text" placeholder="write title" name="title" v-model="blogTitle" autocomplete="off"><br><br>
            <input type = "hidden" value="seesion" ref="id"/>
        
            <span class="error" v-if="catagoryErr != ''">{{ catagoryErr }}</span><br>
            <span>Select catagory</span><br>
            <select v-model="selected">
          	     <option v-for="cat in catagorys" :value="cat.id">{{cat.catagory}}</option>
            </select><br>
            <span class="error">{{ postErr }}</span>
            <div class="editor">
             <editor
                    :init="{
                            mobile: {
                                menubar: true
                            },
                            plugins: 'codesample image tools Table link lists advlist',
                            menu:{
                                    file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
                                    edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
                                    view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
                                    insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
                                    format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
                                    tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
                                    table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
                                    help: { title: 'Help', items: 'help' }
                                  },
                            toolbar:'codesample image alignLeft alignRight link bullist numlist bold italic underline strikethrough codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat',
                            height: '500',
                            relative_urls: false,
                            resolve_script_host: false,
                            convert_urls: false,
                            codesample_global_prismjs: true,
                            codesample_content_css: 'http://localhost/blog/public/prism/css/prism2.css',
                           }
                           "

                     v-model="post"></editor>
            <button type="submit" :disabled="!title || !selectedCatagory || !postValid" id="publish" :class="{saveChange: editblog }" value="Publish" name="blg" @click.prevent="publish">
                <i v-if="editblog">Save changes <i class="fa fa-save"></i></i> 
                <i v-if="!editblog">Publish</i>
            </button>
            <button v-if="!editblog" :disabled="!title || !selectedCatagory || !postValid" type="submit" id="draft" value="Save" name="blg" @click.prevent="save">Save <i class="fa fa-save"></i></button>
        <div id="cover-imgs">
          <div id="cover-img">
            <label for="file">Add cover image</label><br>
            <input type="file" name="img" @change="upload('cover')" ref="file" :disabled="!title || !selectedCatagory"/>
              Or <button id="addAlbum" @click.prevent="toggleAlbum('cover')"><i class="fa fa-plus"> Add from Album</i> </button>
            <span class="error">{{imgErr}}</span><br>
            <div id="loding" v-if="uploading" style="text-align:center">
                <i style="color:green" class= "fa fa-spinner fa-spin fa-2x fa-fw" ></i><br><br>
          	</div>  
            <img v-if="img" :src="img" /><br>
          </div>
          	
          <div id="post-img">
            <label for="file">image for your post</label><br>
            <input type="file" name="img" @change="upload('post')" ref="file1" :disabled="!title || !selectedCatagory"/>
              Or <button id="addAlbum" @click.prevent="toggleAlbum('post')"><i class="fa fa-plus"> Add from Album</i> </button><br><br>
            <img v-for="image in postImg" :src="image"  @click.prevent="insertImage(image)"/><br>
          </div>
        </div>
	       </div>
    	</form>
        <div class="done-wrapper" v-if="publishing">
        <div id="done">
                {{waitMsg}}<br>
                <i v-if="!loading && !errSign" style="color:#0d89ff;font-size:150%" class= "fa fa-check"></i>
                <i v-if="loading && !errSign" style="color:#0d89ff" class= "fa fa-spinner fa-spin fa-2x fa-fw" ></i>
                <i v-if="!loading && errSign" style="color:#FFC107; margin: 10px" class= "fa fa-exclamation fa-2x fa-fw" ></i>
            </div>
        </div>
        <div class="album-wrapper" v-if="showAlbum">
            <div class="album">
                <button id="close-album" @click.prevent="toggleAlbum('none')">X</button>
                <div class="cover-images">
                    <p class="title"><i class="fa fa-images"></i> Cover images</p>
                    <hr/>
                    <div class="images">
                        <img v-for="(image,index) in coverAlbum[0]" :src="image" @click="addImage(index,'cover')"/> 
                    </div>
                </div>
                <div class="post-images">
                    <p class="title"><i class="fa fa-images"></i> Post images</p>
                    <hr/>
                    <div class="images">
                        <img v-for="(image,index) in postAlbum[0]" :src="image" @click="addImage(index,'post')"/>
                    </div>
                </div>
                
            </div>
        </div>
    <infoDialog v-if="loadingAlbum" :infoMsg="infoMsg"></infoDialog>
    </div>
</template>


<script>
import Editor from "@tinymce/tinymce-vue";

export default {
    name: 'NewBlog',
    components: {
      "editor": Editor  
    },
    data() {
        return {
            errSign : false,
            
            blogTitle:this.editblog ? this.editblog[0].title : '',
            titleErr : '',
            
            img:this.editblog ? this.editblog[0].image : '',
            imgErr: '',
            
            postImg:[],
            
            blogDir:'',
            
            alertMessage:'',
            
            post: '',
            postErr: '',
            
            initialValue: this.editblog ? this.editblog[0].post :'',
            
            selected:this.editblog ? this.editblog[0].catagory_id : '',
            catagoryErr: '',
            
            showAlert: false,
            uploading: false,
            waitMsg: 'Please wait...',
            publishing: false,
            loading: false,
            
            loadingAlbum: false,
            showAlbum: false,
            
            coverAlbum: [],
            postAlbum: [],
            to: '',
            
            infoMsg: '',
            autoSave: false,
            saving: false
        }
    },
    props:['editblog','catagorys','post_images'],
    
    mounted() {
        setTimeout(()=>{
            tinymce.activeEditor.setContent(this.editblog ? this.editblog[0].post : '');
            this.post = this.editblog ? this.editblog[0].post : '';
            if(this.post_images) {
                this.postImg = this.post_images;
            }
        },1000);
        setInterval(()=>{
            //auto save the post every 5 seconds
            if(this.title && this.postValid && !this.loading && this.autoSave && !this.saving) {
                this.request('save','auto');
            }
        },5000)
	},
	methods:{
		 alertBox() {
			this.showAlert = this.showAlert ? false :true;
			//this.alertMessage = '';
		},
        addImage(index,type) {
            let image = (type == "cover") ? this.coverAlbum[0][index] : this.postAlbum[0][index];
            if(this.to == 'cover') {
                this.img = image;
            }else{
                this.postImg.push(image);
            }
        },
        toggleAlbum(to) {
            this.to = (to == "cover") ? "cover" : "post";
            if(to == "none") {
                this.showAlbum = false;
                return;
            }else {
                this.loadingAlbum = true;  
            }
            if(this.coverAlbum.length >= 1 || this.postAlbum.length >= 1) {
                this.showAlbum = true;
                this.loadingAlbum = false;
                return;
            }
            axios.get('/dashboard/album').then((res)=>{
                let cover_imgs = res.data.cover_images;
                let post_imgs = res.data.cover_images;
                if(cover_imgs.length == 0 && post_imgs.length == 0) {
                    this.infoMsg = "No album found plase upload!";
                    setTimeout(()=>{
                        this.loadingAlbum = false;
                    },2000);
                    return;
                }
                this.coverAlbum.push(res.data.cover_images);
                this.postAlbum.push(res.data.post_images);
                this.showAlbum = true;
                this.loadingAlbum = false;  
            }).catch((err)=>{
                        this.loadingAlbum = false;
//                console.log(err.data);
            });
        },
		insertImage(img) {
            this.imgErr = '';
            //coopies the clicked image address to the clip board to be pasted in the image address
            if(window.clipboardData && window.clipboardData.setData) {
                return clipboardData.setData("Text",img);
            }else if(document.queryCommandSupported && document.queryCommandSupported("copy")) {
                let textarea = document.createElement('textarea');
                textarea.value = img;
                textarea.style.position = "fixed";
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand("copy");
                    this.loading = true;
                    this.infoMsg = "Image adress copied to clipboard!"
//                    alert("Image address copied to clip board");
                    return;
                } catch(ex) {
                    alert("unabele to copy to clip board" + ex);
                    return
                } finally {
                    document.body.removeChild(textarea);
                }
            }
            setTimeout(()=>{
               this.loading = false;
                this.infoMsg = '';
            },1000);
		},
		request(status,auto) {
            //auto save tell auto saver do not make request until the request is complete
            this.autoSave = false;
            //auto saving or saving flag
            this.saving = true;
            this.waitMsg = (status == 'publish')? 'Publishing...' : 'Saving...';
            if(auto == undefined) {
                this.publishing = true;
                this.loading = true;
            }
            
			var fd = new FormData();
//			fd.append('id',this.$refs.id.value);
            fd.append('catagory_id',this.selected);
            fd.append('id',this.blogId);
			fd.append('title',this.blogTitle);
			fd.append('post',this.post);
			fd.append('img',this.img);
			fd.append('status',status);
			if(this.blogId ==0)fd.append('blg',status);
			//ajax request
			var ajax = "/dashboard/createnewblog";
			if(this.blogId != 0) ajax +"?blogId=" + this.blogId + "&edit=1";
			axios.post(ajax,fd,{headers:{'Content-type':'multipart/form-data'},
                                validateStatus:(status)=>{return true;}}).
			then((res) => {
                //finished auto saving
                this.saving  = false;
                if(res.data.errors) {
                    var err = res.data.errors;
                    this.titleErr = err.title ? err.title[0] :'';
                    this.imgErr  = err.img ? "Please upload the cover image for your post!" : '';
                    this.catagoryErr = err.catagory_id ? err.catagory_id[0] : '';
                    this.postErr = err.post ? err.post[0] : '';
                    
                }
                this.blogId = res.data;
                this.loading = false;
                this.waitMsg = (status == 'publish')? 'Published successfuly' : 'Saved succesfuly';
                if(res.data.errors) {
                    this.waitMsg ="Please fix your errors"
                    this.errSign = true;
                }
                setTimeout(()=>{
                    this.publishing = false;
                    this.errSign = false;
                },2000);       
            }).
			catch((error) => {
                this.loading = false;
            });
		},
		publish() {
            this.request('publish');
//            console.log('publish');
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
			catch((err)=> {
//                alert(err);
            });
		},
		upload(type) { 
            this.loadingAlbum = true;
            this.imgErr = '';
			var fd = new FormData();
            if(type=='cover')
            fd.append('coverimg',this.$refs.file.files[0]);
            if(type=='post')
            fd.append('postimg',this.$refs.file1.files[0]);
            fd.append('catagory',this.selected);
            fd.append('catagory_id',this.selected);
//            console.log(fd);
//            uploading an image to the server
            axios.post('/upload',fd,
                        {headers:{'Content-type':'multipart/form-data'},
                        validateStatus:(status)=>{return true;}}).
                        then((res)=>{
                        if(res.status != 200) {
                            this.infoMsg = 'Unable to upload :-(';
                        }else {
                            this.infoMsg = 'Uploaded!'
                        }
                        setTimeout(()=>{
                            this.loadingAlbum = false;
                            this.infoMsg=''
                        },1500)
                        if(type=='cover') {
                            this.img = res.data.image;
                            this.blogId= res.data.id;
                        } else {
                            this.postImg.push(res.data);
                        }
		  }).catch((err)=>{
//                console.log(err)
            });
        }

    },
        computed: {
			title() {
                this.titleErr = '';
				if(this.blogTitle == null || this.blogTitle.length < 3) {
                    return false;   
                }
				return true;
            },
            selectedCatagory() {
                this.catagoryerr = '';
                if(typeof(this.selected) != 'number') {
                    return false;
                }
                return true;
            },
            postValid() {
                this.postErr = '';
                if(this.post.length < 300) {
                    return false;
                }
                return true;
            }
	   },
    watch: {
        post() {
            this.autoSave = true;
        },
        selected() {
            this.catagoryErr = '';
        }
    }
}
</script>


<style scoped>
    .error {
        color: red;
    }
    #newblog {
        margin-left: 18.5%;
    }
#newblog h2 {
	text-align:center;
	box-sizing:border-box;
}
input[type="text"] {
	font-size:1.4em;
	margin:0 auto;
	}
textarea,
select,
input[type="text"],
input[type="submit"],
input[type="file"] {
	box-sizing:border-box;
	padding:3px;
	outline:none;
	border:1px solid #e3e3e3;
}
select {
	background:none;
	width:50%;
}
#publish,#draft {
	background:none;
	padding:10px;
	font-size:120%;
	margin-left:21%;
    cursor: pointer;
}
#publish {
	background-color: green;
	color:#fff;
    margin: 10px;
    align-self: center;
}
    .saveChange {
        width: 200px;
    }
 button#publish:disabled,button#draft:disabled {
        background-color: #ccc;
        color: black;
        cursor: not-allowed;
    }
#draft {
	background-color: #1c61a9;
	margin-left: auto;
}

#warn {
	position: fixed;
	top:40%;
	width:100%;
	color:red;
	text-align:center;
	margin:5px;
	background-color:#ccc;
	border-radius:3px;
	z-index:80;
}
#content{
	width:70%;
}
button {
	background:none;
	color:#fff;
	border:none;
	margin:-1px;
	padding:5px;
	font-size:120%;
	border-radius:2px;
}
.btns {
	background-image:linear-gradient(to bottom,#19193c,#c6060e);
	padding:8px;
	width:99.4%;
}
.editor {
	position:relative;

	margin-right: 5px;
}
#editor {
	position:relative;
	width:100%;
	height:300px;
	padding:5px;
	font-size:120%;
	overflow:auto;
	border:1px solid Green;
}
    #cover-imgs {
/*    display: flex;*/
/*    width: 100%;*/
    box-sizing: border-box;
/*    border: 1px solid #e3e3e3;*/
}
    #cover-img {
/*        width: 100%;*/
        border-right: 2px solid #e3e3e3;
    }
    #post-img {
/*        width: 100%;*/
        max-height: 500px;
        overflow-x: auto; 
    }
#editor img {
	width:200px;
	height:300px;
}

#cover-img img {
    width:97%;
    height: 400px;
    margin-right: 5px;
}
#post-img img {
    width: 48%;
    height: 200px;
    border: 2px solid #4099ff61;
    border-radius: 3px;
    margin: 3px;
    cursor: pointer;
    
}
    @media(max-width: 550px){
        #post-img img {
            width: 97%;
        }
    }
    @media(max-width: 600px) {
        #cover-imgs {
            flex-direction: column;
            width: 100%;
        }
    }
@media(max-width:850px){
	#newblog {
	 margin-left: 5px;
	}
	.editor{
		width:99%;
	}
}
    .done-wrapper {
        position: fixed;
        display: flex;
        top: 0;
        left: 0;
        justify-content: center;
        align-content: center;
        height: 100%;
        width: 100%;
        background-color: rgba(0,0,0,0.4);
    }
#done{
/*    position: fixed;*/
    text-align: center;
    align-self: center;
    border-radius: 3px;
    box-shadow: 3px 3px 5px black;
    height: auto;
    width: 292px;
    font-size: 1.3em;
    color: black;
    padding: 5px;
    background-color: rgb(247, 247, 247);
    border-left: 5px solid  #0d89ff;
}
    .album-wrapper {
        position: fixed;
        display: flex;
        box-sizing: border-box;
        align-content: center;
        justify-content: center;
        left: 0;
        top: 10px;
        margin: 10px;
        height: 100%;
        width: 100%;
        padding: 10px;
        margin: 5px;
        z-index: 5;
        box-shadow: 0 0 5px #000;
        background-color: rgba(0,0,0,.5);
    }
    .album {
        overflow-y: auto;
        align-self: center;
        height: 85%;
        width: 90%;
        padding:10px;
        box-shadow: 0 0 5px;
/*        background-color: rgba(0,0,0,.6);*/
    }
    .cover-images {
        width: 100%;
    }
    .post-images {
        width: 100%;
    }
    .images {
        display: grid;
        grid-template-columns: auto auto auto auto;
        grid-row-gap: 15px;
        grid-column-gap: 15px;
    }
    @media(max-width: 1000px) {
        .images {
            grid-template-columns: auto auto auto;            
        }
    }
        @media(max-width: 800px) {
        .images {
            grid-template-columns: auto auto;            
        }
    }
        @media(max-width: 550px) {
        .images {
            grid-template-columns: auto;            
        }
    }
    .images img {        
        border-radius: 10px;
        height: 200px;
        width: 98%;
        padding: 5px;
        box-shadow: 0 0 5px #000;
        background-color: #0d89ff;
        cursor: pointer;
        
    }
    .title {
        width: 160px;
        background-color: #0d89ff;
        border-radius: 15px;
        padding: 5px;
        color: #fff;
        font-size: 1.3em;
        border-bottom: 1px solid #0d89ff;
        box-shadow: 0 0 5px #000;
    }
    #close-album {
        background-color: #ff6060;
        border-radius: 20px;
        float: right;
        box-shadow: 0 0 5px #000;
        height: 40px;
        /* color: red; */
        width: 40px;
        position: fixed;
        right: 10%;
        margin-top: 23px;
        cursor: pointer;
    }
    #addAlbum {
        background-color: #0d89ff;
        border-radius: 5px;
        margin-left: 10px;
        cursor: pointer;
    }
</style>