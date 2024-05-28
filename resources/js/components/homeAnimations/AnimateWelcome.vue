<template>
<div>
    <transition name="msg">
            <welcome-msg v-if="show"></welcome-msg>
    </transition>
    <transition name="msg1">
        <welcome-msg1 v-if="!show"></welcome-msg1>
    </transition>
</div>
</template>

<script>
export default {
    name: 'animate-component',
    data() {
        return {
            show: true,
//            show1: false
        }
    },
    methods: {
        tog() {
            this.show = this.show ? false : true;
        }
    },
    mounted() {
        setInterval(()=>{
            this.show = this.show ? false : true;
        },4000);
    }
}
</script>

<style scoped="true">
    .msg-enter-active,.msg1-enter-active  {
        transition: all .4s ease;
    }
    .msg-leave-active,.msg1-leave-active {
        transition: all .4s ease;
    }
    .msg-enter,.msg1-enter {
/*        position: absolute;*/
        margin-left: -1000px;
/*        opacity: 0;*/
/*        transform: rotate(45deg);*/
    }
    .msg-leave-to,.msg1-leave-to {
/*        position: absolute;*/
        margin-left: -1000px;
        opacity: 0;
/*        transform: rotate(45deg);*/
    }
</style>