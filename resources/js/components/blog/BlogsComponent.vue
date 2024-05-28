<template>
<div id="table-wrapper">
    <div class="pagination">
        <paginate v-if="allBlogs.length > 0" :pdata="blogs" :pageTitle="status" @nextPage="nextPage" @loading="loading=true"></paginate>
    </div>
    <alert-warning 
               v-if="warn" 
               @no="no" 
               @yes="yesDelete"></alert-warning>
    <table v-if="allBlogs.length > 0">
        <tr>
            <th>Title</th>
            <th>Created at</th>
            <th>Views</th>
            <th>Action</th>
            <th>Published</th>
        </tr>
        <blog-component @deleteBlog="deleteBlog"
                                @restoreBlog="restore"
                                @no="no" v-for="(blog,index) in allBlogs" 
                                :blog="blog" :key="blog.id" 
                                :trash="trash"></blog-component>
    </table>
    <noposts v-if="allBlogs.length < 1" :trash="trash"></noposts>
    <info-dialog v-if="loading" :infoMsg="infoMsg"></info-dialog>
</div>
</template>

<script>
    export default {
        name: 'blogs-component',
        data () {
            return {
                blogId: 0,
                allBlogs: this.blogs.data,
                warnMsg: 'mesage',
                warn: false,
                loading: false,
                infoMsg: ''
            }
        },
        props:['blogs','trash','status'],
        methods: {
            nextPage(e) {
                this.allBlogs = e.page;
                this.loading = false;
            },
           deleteBlog(id) {
                this.blogId = id;
                let post = this.allBlogs.find(blog => blog.id == id);
                window.warnMsg = 'Post "' + post.title +'"\n will be';
               if(this.trash.istrash) 
                   window.warnMsg += ' permanently \ndeleted!';
               else
                   window.warnMsg += ' deleted';
                this.warn = true;
            },
            restore(id){
                this.loading = true;
                axios.post('/restore/' + id).then((res)=>{
                    if(res.data == 1) {
                        let post = this.allBlogs.findIndex(blog => blog.id == id);
                        this.allBlogs.splice(post,1);
                        this.infoMsg = "Post restored successfuly!";
                        setTimeout(()=>{
                            this.loading = false;
                            this.infoMsg = '';
                        },2000);
                    }else{
                        this.infoMsg = "Unable to restore";
                        setTimeout(()=>{
                            this.loading = false;
                            this.infoMsg = '';
                        },2000);
                    }
                }).catch((err)=>{
//                   console.log(err);
                    this.loading = false;
                });
            },
            no(){
                this.warn = false;
            },
            yesDelete() {
                
                axios.post(this.deleteLink + this.blogId).then((res)=>{
//                    console.log(this.deleteLink);
                let remove = this.allBlogs.findIndex(blog=>blog.id == this.blogId);
                this.allBlogs.splice(remove,1);
//                console.log(res.data);
                this.warn=false;
                });
            }
        },
        components: {
//            blog: 'blog'
        },
        computed: {
            deleteLink() {
                if(this.trash.istrash)
                    return '/delete/trash/';
                return '/delete/';
            }
        }
    }
</script>

<style scoped>
    .title p {
        padding: 7px;
        background-color: #e91e63;
        max-width: -webkit-fit-content;
        max-width: -moz-fit-content;
        max-width: fit-content;
        display: inline-block;
        color: #fff;
        border-radius: 30px;
        text-align: center;
        min-width: 50px;
        margin: 19px auto -9px 30px;
    }
        #table-wrapper {
        width: 100%;
        overflow: auto;
    }
    table {
        width: 1000px;
        padding: 5px;
        overflow: auto;
    }
    td,th {
    max-width: 250px;
    min-width: 250px;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding: 10px;
    font-size: 130%;
    text-align: center;
    }
    @media(min-width: 850px) {
        #table-wrapper {
            margin-left: 18.3%;
            width: 81.5%;
        }
    }
    .pagination {
/*        z-index: 556;*/
        display: block;
        position: sticky;
        left: 0;
    }

</style>