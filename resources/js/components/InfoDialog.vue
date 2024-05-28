<template>
    <div class="info-box">
        <div class="info">
            <p>
                <span v-if="!infoMsg">Please wait...</span>
                <span v-if="infoMsg != ''"> {{ infoMsg }} </span> 
                <i class="fa fa-spinner fa-spin" v-if="!infoMsg" style="color: #0d89ff"></i>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
//                infoMsg: this.infoMsg
            }
        },
        components: {
        },
        props: ["infoMsg"]
    }
</script>

<style scoped>
        .info-box {
        position: fixed;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        top: 0;
        left: 0;
        background-color: rgba(0,0,0,.5);
        width: 100%;
        height: 100%;
        color: #000;
    }
    .info-box .info {
        background: #f7f7f7;
        width: 300px;
        font-size: 1.3em;
        align-self: center;
        text-align: center;
        border-left: 3px solid #fffe01;
        border-radius: 5px;
        box-shadow: 2px 2px 5px #ccc;
    }
    p>i {
        background-color: #eee;
    }
</style>