<template>
    <div class="paginate">
            <button class="previous" @click="previous" :disabled="prev_page_url==null">
                <i class="fa fa-arrow-left"></i>
            </button> 
            <p>{{title}} {{current_page}}/{{last_page}}</p>
            <button class="next" @click="next" :disabled="next_page_url == null">
                <i class="fa fa-arrow-right"></i>
            </button>
    </div>
</template>

<script>
    import Vue from 'vue';
    Event = new Vue();
    export default {
        name: 'paginate-component',
        data() {
            return {
                next_page_url: this.pdata.next_page_url,
                prev_page_url: this.pdata.prev_page_url,
                last_page: this.pdata.last_page,
                current_page: this.pdata.current_page,
                title: this.pageTitle ? this.pageTitle : 'page '
            }
        },
        props: ['pdata','pageTitle'],
        methods: {
             next() {
                if(this.next_page_url == null) return;
                this.$emit('loading');
                this.loading = true;
                this.getData(this.next_page_url);
            },
            previous() {
                if(this.prev_page_url == null) return;
                this.$emit('loading');
                this.loading = true;
                this.getData(this.prev_page_url);
            },
            getData(link) {
                axios.get(link,{validateStatus:status=>true}).then((res)=>{
                    this.current_page = res.data.current_page;
                    this.last_page = res.data.last_page;
                    this.allBlogs = res.data.data;
                    this.next_page_url = res.data.next_page_url;
                    this.prev_page_url = res.data.prev_page_url;
                    this.$emit('nextPage',{'page':res.data.data});
                });
        }
    }
    }
</script>
<style scoped>
    .next {
        float: right;
    }
    .previous {
        float: left;
    }
    .next,.previous {
        margin: 3px;
        cursor: pointer;
        background-color: #E91E63;
        border-radius: 3px;
        border: none;
        color: #fff;
        outline: none;
        padding: 5px;
    }
    button:disabled {
        background-color: #ccc;
    }
    .paginate {
/*        z-index: 556;*/
        display: block;
        left: 0;
        font-family: 'robotobold';
        margin-top: 15px;
        flex: 1;
        flex-basis: 100%;
    /*    width: fit-content;*/
        border-radius: 5px;
        text-align: center;

    }
    .paginate p{
        width: fit-content;
        padding: 5px;
        background-color: #E91E63;
        border-radius: 5px;
        margin: auto;
        display: inline-block;
        color: #fff;
    }
</style>