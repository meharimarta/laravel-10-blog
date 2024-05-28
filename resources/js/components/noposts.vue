<template>
    <div id="wrapper">
<!--        <div class="notice">-->
            <h2>{{ message }}</h2>
            <a href="./newblog" v-if="!trash.istrash">Create post <i class="fa fa-write"></i></a>
<!--        </div>-->
    </div>
</template>
<script>
export default {
    name: 'noblog-component',
    props:['trash'],
    computed: {
        message() {
            if(this.trash.istrash) {
                return "No trash"
            } else {
                return 'You dont have any posts Start now creating interesting posts';
            }
        }
    }
}
</script>

<style scoped>
    #wrapper {
        text-align: center;
    }
    #wrapper a {
        text-decoration: none;
        color: #fff;
        font-size: 1.5em;
        border-radius: 25px;
        padding: 10px;
        background-color: dodgerblue;
        height: 100%;
    }
    #wrapper h2{
        font-family: sans-serif;
        color: darkslategrey;
    }
</style>