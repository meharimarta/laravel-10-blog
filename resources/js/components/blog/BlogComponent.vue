<template>
    <tr>
        <td>{{ blog.title }}</td>
        <td>{{ blog.created_at }}</td>
        <td>{{blog.views}}</td>
        <td>
            <a class="edit" target="_blank" :href="editLink"><button class="view" title="edit post"><i class="fa fa-edit"></i></button></a>
            <button class="delete" @click="deleteBlog(blog.id)"><i class="fa fa-trash"></i></button>
            <a :href="viewLink" target="_blank"><button class="view" title="view post"><i class="fa fa-eye"></i></button></a>
        </td>
        <td class="ispublished">
<!--            show restore button if it is in trash-->
            <button id="restore" v-if="trash.istrash" @click="restore(blog.id)" title="restore deleted post"><i class="fa fa-undo"></i></button>
<!--            show it is published or not other wise -->
            <span v-if="!trash.istrash">
                <i v-if="blog.published" style="color: green" class="fa fa-check"></i>
                <i v-if="!blog.published" style="color: red" class="fa fa-times"></i>
            </span>
        </td>
    </tr>
</template>

<script>
    
    export default {
        name:'blog',
        data () {
            return {
            }
        },
        methods: {
          deleteBlog(id) {
              this.$emit('deleteBlog',id);
          },
            restore(id) {
                this.$emit('restoreBlog',id);
            }
        },
        components: {
        },
        props:['blog','trash'],
        computed: {
            viewLink() {
                if(this.trash.istrash)
                    return "/blog/trash/" + this.blog.id;
                else
                    return "/blog/" + this.blog.id;
            },
            editLink() {
                if(this.trash.istrash)
                    return "/dashboard/edit/trash/" + this.blog.id;
                else
                    return "/dashboard/edit/" + this.blog.id;
            }
                
        }
    }
</script>

<style>
    td,th {
/*    flex: 1;*/
    max-width: 250px;
    min-width: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding: 10px;
    font-size: 130%;
    text-align: center;
}
.action {
  width: 30px;
} 
table tr {
    margin-top: 10px;
    background-color:rgb(247, 247, 247);
/*    width: 100%;*/
    display: table;
    box-shadow:  0 0 5px #000;
}
    td.action-btns {
        
    }
.greeting {
	text-align:center;
	margin-left:22%;
}
td button {
	background:none;
	color:#fff;
	border:0;
	font-weight:bold;
	font-size:1.1em;
	border-radius:3px;
	padding:5px;
	width: 75px;
    cursor: pointer;
}
    td.ispublished {
/*        min-width: 100px;*/
    }
button.delete {
	 color: red;
}
button.edit {
	color: blue;
	margin:auto 5px auto 5px;
}
button.view {
	color: #00A5FD;
}
button.publish {
	color: green;
}

tr{
/*    flex: 1;*/
/*    display: block;*/
    border-radius: 5px
}
    #restore {
        background-color: #0f74db;
    }
</style>