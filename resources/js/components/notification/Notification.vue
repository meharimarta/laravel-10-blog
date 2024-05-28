<template>
    <div id="notification-wraper">
        <div class="notification" v-for="notification in showNotifications" :class="{newnotification: !notification.seen}">
            <img id="notification-img" :src="notification.user.profile_picture"/> 
            <div @click="getComment(notification.blog_id,notification.id)">
                <strong>{{ notification.user.name }}</strong>
                <span v-if="notification.subject == 'Comment'">Commented on</span>
                <span v-if="notification.subject == 'like'">Liked</span>
                <strong v-if="notification.post">{{notification.post.title}}</strong>
            </div>
        </div>
        <div class="comment-component-wrapper" v-if="showNotfication">
            <button class="close-comment-component-wrapper-btn" @click="closecommentcomponent">X</button>
            <comments :data="data" v-if="showNotfication" :admin="admin"></comments>
        </div>
        <infoDialog v-if="loading"></infoDialog>
    </div>
</template>

<script>
    export default {
        name: 'Notification-component',
        data() {
            return {
                //set empty array for comments it will be poplated when the user clicked on the notification
                data: {"comments": [],
                       "csrf_token": this.csrf.token,
                       "id":0},
                showNotfication: false,
                loading: false,
                showNotifications: this.notifications
            }
        },
        props: ['image','notifications','csrf','admin','uservisited'],
        methods: {
            getComment(blog_id,notification_id) {
                this.data.id = blog_id;
                this.loading = true;
                axios.get('/dashboard/comment/'+ blog_id +'/' + notification_id ).then((res)=>{
                    this.data.comments = res.data;
                    let notification = this.showNotifications.find(notfication => notfication.id == notification_id );
                    notification.seen = 1;
                    this.showNotfication = true;
                    this.loading = false;
//                    console.log(res.data);
                }).catch((err)=>{
//                   console.log(err); 
                });
            },
            closecommentcomponent() {
                this.showNotfication = false;
            }
        }
    }
</script>

<style scoped>
    #notification-wraper {
        display: flex;
        flex-direction: column;
        margin-left: 18.5%;
        margin-top: 10px;
        margin-right: 5px;
    } 
    .notification {
        background-color: #eee;
        border-radius: 5px;
        margin-top: 5px; 
        min-height: 50px;
        transition-duration: .4s;
        cursor: pointer;
    } 
    .notification:hover {
        box-shadow: 2px 2px 5px #000,-2px -2px 5px #000;
        background-color: azure;
        background-color: #0f75dd;
        color: #fff;
    }
    .newnotification {
         background-color: #275b8e;
        color: #fff;
    }
    .notification div {
        height: 100%;
        font-size: 1.2em;
        padding-top: 14px;
        display: block;
        padding-left: 55px;
    }
    #notification-img {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        float: left;
    }
    .subject{
        font-size: 1.4em;
        margin-top: -40px;
        margin-left: 60px;
/*        width: 60px;*/
    }
    .comment-component-wrapper {
        position: fixed;
        top: 50px;
        height: 87.5%;
        width: 81%;
        background-color: #10a3e8;
        box-shadow: 2px 2px 5px #000,-2px -2px 5px #000;
        border-radius: 5px;
        overflow: auto;
    }
    .close-comment-component-wrapper-btn {
        position: fixed;
        right: 32px;
        top: 54px;
        color: #fff;
        font-size: 1.5em;
        z-index: 2;
        height: 40px;
        width: 40px;
        cursor: pointer;
        background-color: #ff3e3e;
        border-radius: 50%;
    }
    @media(max-width: 850px) {
        #notification-wraper {
            margin-left: 5px;
        }
        .comment-component-wrapper{
            width: 98%;
        }
    }
</style>