<template>
<div class="comments-wrapper">
    <div class="comment-count">Comments <span class="count">{{ comments.length }}</span></div>
    <div class="comments">
        <div id="comment" v-for="comment in comments" v-if="comment.parent_id == null">
            <div class="name">
                
                <img v-if="comment.user" :src="comment.user.profile_picture" id="user-img"/>
                <p>{{ comment.name }}</p>
            </div>
            <div class="comment-content">
                <p>{{comment.comment}}</p>
                <i class="fa fa-spinner fa-spinn" v-if="comment.new_comment"></i>
            </div>
<!--            replys-->
            <div id="comment-reply" v-for="reply in comment.reply">
                <div class="name">
                    <img v-if="reply.user" :src="reply.user.profile_picture" id="user-img"/> 
                    <p>{{ reply.name }}</p>
                </div>
                <div class="comment-content">
                    <p>{{reply.comment}}</p>
                    <i class="fa fa-spinner fa-spinn" v-if="reply.new_comment"></i>
<!--                    <button id="replay-btn" @click.prevent="reply(comment.id)"><i class="fa fa-reply"></i></button>-->
                </div>
            </div>
            <button id="replay-btn" @click.prevent="reply(comment.id)"><i class="fa fa-reply"></i></button>
        </div>

    </div>
    <div class="write-comment" :class="{replyFormPosition: replying}">
        <div>{{replayToName}}<button id="cancel-reply" v-if="commentReply" @click="cancelReply" title="Cancel reply" >X</button></div>
        <form method="post" action="http://localhost/blog/public/comment">
            <div id="name-email" v-if="!showNameInputField">
                <div class="name-input">
                    <label for="name">Name</label>
                    <input type="text" name="name" required v-model="name"/>
                </div>
            </div>
            <span v-if="nameError" style="color: red">Invalid name</span>
            <label for="comment">Write Your comment</label>
            <textarea name="comment" rows="5" v-model="comment">... </textarea>
            <span v-if="commentError" style="color: red">You should enter atleast 6 characters</span>
            <button type="submit" id="comment-btn" @click.prevent="sendComment">
                <i v-if="!loading" class="fa fa-paper-plane"></i>
                <i v-if="loading" style="color:white" class= "fa fa-spinner fa-spinn" ></i>
            </button>
        </form>
    </div>
</div>
</template>

<script>
export default {
    name: 'comment-component',
    data() {
        return {
            name: this.usercommented ? this.usercommented.commenter_name: '',
            replayToName: 'Your comment',
            comment: '',
            commentId: '',
            comments: this.data.comments,
            nameError: false,
            commentError: false,
            loading: false,
            commentReply: false,
            replying: false,
            is_admin: this.admin ? this.admin.is_admin : false,
            commented_before: this.usercommented ? this.usercommented.commenter_name: false
        }
    },
    props: ['data','admin','usercommented'],
    mounted() {
        //chack the admin prop is not undefined and set its value to name data
        //if it has a value set its name valiue to name data else set name empy string
        this.name = this.admin ? this.admin.name : '';
    },
    methods: {
        sendComment() {
            this.loading = true;
            //if the user is already logd in or set his name we dont need to run the validation agin
            if(!this.showNameInputField) {
                    if(this.name.length <3) {
                    this.nameError = true;
                    this.loading = false;
                    return;
                }
            }

            if(this.comment.length < 6) {
                this.commentError = true;
                this.loading = false;
                return;
            }
            this.replying = false;
            var fd = new FormData();
            if(this.commentReply) {
                fd.append('parent_comment_id',this.commentId);    
            }
            fd.append('name',this.name);
            fd.append('comment',this.comment);
            fd.append('_token',this.data.csrf_token);
            fd.append('blog_id',this.data.id);
            //comment representation  untill the request to server is success
            let comment = {
                new_comment: true,
                comment : this.comment,
                name : this.name == "" ? this.commented_before : "anonymous",
                user: {
                    name: 'Anonymous',
                    profile_picture: '/assets/user.png'
                }
            };
            //set temporary comment on the comments array
            if(this.commentReply) {
                let parentComment = this.comments.find(comment => comment.id == this.commentId);
                //if there is no comment reply create new comment reply
                //else push to existing comment
                if(!parentComment.reply)
                    parentComment.reply = [comment];
                else
                    parentComment.reply.push(comment);
            }else {
                this.comments.push(comment);
            }
            axios.post('/comment',fd,{validateStatus: status => true }).then((res)=>{
                //push this
                if(res.data) {
                    //remove name input field
                    this.is_admin = true;
                    let name = this.name == '' ? this.commented_before : this.name ; 
                    //if the comment reply is set to true
                    //we will push the reply to its parent commet
                    //else it is not reply push it to the new comment
                    if(this.commentReply) {
                        //find the index of newly created comment reply and replace with the comment that is returned from the server
                        let parentComment = this.comments.find(comment=>comment.id == this.commentId);
                        let commentIndex = parentComment.reply.findIndex(comment => comment.new_comment);
                        parentComment.reply[commentIndex] = res.data[0];
                    } else {
                        //find the index of newly created comment and replace with the comment that is returned from the server
                        let commentIndex = this.comments.findIndex(comment => comment.new_comment);
                        this.comments[commentIndex] = res.data[0];
                    }
                    this.comment = "";
                    this.loading = false;
                    this.replayToName = "Your comment";
                    this.commentReply = false;
                }
            }).catch((err)=>{
                this.commentReply = false;
            });
        },
        reply(commentId) {
            this.commentId = commentId;
            this.commentReply = this.replying = true;
            let replyTo = this.comments.find(comment => comment.id == commentId);
            this.replayToName = "Replay on "+ replyTo.name;
        },
        cancelReply() {
            this.commentReply = this.replying = false,
            this.replayToName = "Your comment"
        }
    },
    computed: {
      showNameInputField() {
          if(this.is_admin || this.commented_before)
              return true;
          return false;
      }  
    },
    watch: {
        name(){
            this.nameError = false;
        },
        comment(){
            this.commentError = false;
        }
    }
}
</script>

<style scoped>
    #name-email {
        display: flex;
    }
    .name-input {
        margin-right: 5px;
    }
    .email-input {
        margin-right: 0;
    }
    .email-input label,.name-input label {
        text-align: left;
    }
    .comment-count {
        background-color: #1e90ff;
        color: #fff;
        padding: 3px;
        font-size: 1.5em;
        border-bottom: 1px solid #000;
        border-radius: 5px 5px 0 0;
        margin-top: 10px;
    }
    .count {
        background-color: rgb(71, 241, 135);
        border-radius: 50%;
        padding: 2px;
        display: inline-block;
        height: 25px;
        width: 25px;
        text-align: center;
    }
    .name {
        font-size: 1.3em;
        margin-left: 5px;
    }
    .name img {
        float: left
    }
    .name p {
        display: inline-block;
    }
    .comments-wrapper {
/*       background-color: #eee; */
        padding: 0 5px 5px 5px;
        display: flex;
        flex-direction: column;
    }
    .comment-content {
        padding-left: 25px;
        font-family: sans-serif;
        margin-top: -25px;
    }
    .write-comment form {
        display: flex;
        flex-direction: column;
       
    }
 
    .write-comment {
        background-color: aliceblue;
        font-size: 1.3em;
        border-radius: 5px;
        padding: 3px;
/*        box-shadow: 1px 1px 5px,-1px -1px 5px;*/
        margin-bottom: 10px;
        width: 98%;
    }
    .write-comment div{
        background-color: aliceblue;
        text-align: center;
    }
    .write-comment form input {
        margin-left: 0;
        width: 100%;
        border: 1px solid lightskyblue;
/*        border-bottom: 2px solid lightskyblue;*/
        font-size: 1em;
        padding: 5px;
    }
    .write-comment form textarea {
        font-size: 1.01em;
        border-color: deepskyblue;
        font-family: sans-serif;
    }
    .write-comment form label {
        margin-top: 10px;
        text-align: left;
    }
    #comment-reply,#comment {
        border-radius: 5px;
        background-color: whitesmoke;
        margin: 10px auto 10px auto;
        padding-bottom: 5px;
    }
    #comment-reply {
        background-color:#3d9ffd5c;
        margin: auto 5px 5px 30px;
    }

    #comment-btn {
        background-color: dodgerblue;
        margin-top: 5px;
        font-size: 1.3em;
        cursor: pointer;
        border: none;
        color: #fff;
    }
    #replay-btn {
        background: none;
        border: none;
        font-size: 1.3em;
        color: #1e90ff;
        border-radius: 5px;
        margin-left: 90%;
        box-sizing: border-box;
        margin: 5px;
        cursor: pointer;
        
    }
    #cancel-reply {
        display: inline;
        margin-bottom: -17px;
        float: right;
        color: red;
        background: none;
        border: none;
        font-size: 1.3em;
        cursor: pointer;
    }
    div.replyFormPosition {
        position: fixed;
        align-self: center;
        width: 50%;
        top: 10%;
        box-shadow: 3px 3px 5px #000;
        z-index: 2;
    }
    @media(max-width: 650px) {
        .write-comment form,.write-comment{
            width: 98%;
        }
        div.replyFormPosition {
            width: 95%;
        }
    }
</style>