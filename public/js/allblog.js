var mixin = {
    data: {
        deleting: false,
        done:false,
        deletingMsg: 'Deleting...'
    },
    methods: {
        edit(id) {
            var url='./edit';
//            axios.get()
        },
        deleteBlog(id) {
            this.deleting = true;
            console.log(id);
            var fd = new FormData();
            fd.append('id',id);
            axios.delete('http://localhost/blog/public/delete/'+id,
                        {validateStatus:(status)=>{return true;}})
            .then((res)=>{
                this.deleting =false;
                this.done = true;
                setTimeout(()=>{this.done = false;},2000);
                console.log(res.data);})
            .catch((err)=>{console.log(err);})
        }
    }
}
//axios.post(ajax,fd,{headers:{'Content-type':'multipart/form-data'},validateStatus:(status)=>{return true;}}).