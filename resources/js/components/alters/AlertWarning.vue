<template>
    <div class="wrapper">
        <div id="deleting">
            {{message}}<br>
            <div class="buttons" v-if="!deleteLoading">  
                <button id="yes" @click="yes">Yes</button>
                <button id="no" @click="no">No</button>
            </div>  
            <i style="color:red" v-if="deleteLoading" class= "fa fa-spinner fa-spin fa-2x fa-fw" ></i>
        </div>
    </div>
</template>

<script>
export default {
    name: 'warning',
    data() { 
           return {
               deleteLoading: false,
               message: window.warnMsg
        }
    },
    methods: {
        yes() {
            this.deleteLoading = true;
            this.message = "Deleting...";
            this.$emit('yes');
        },
        no() {
            this.$emit('no');
        }
    },
    props: ['deleting']
}
</script>

<style scoped>
    .wrapper {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        justify-content: center;
        align-content: center;
        background-color: rgba(0,0,0,.4);
    }
    #deleting {
        position: fixed;
        align-self: center;
        color: #fff;
        text-align: center;
        border-radius: 3px;
        box-shadow: 3px 3px 5px black;
        height: auto;
        width: 250px;
        font-size: 130%;
        color: black;
        z-index: 12;
        background-color:rgb(247, 247, 247);
    }
    .buttons {
        display: flex;
    }
    #yes,#no {
        background: none;
        border: none;
        padding: 5px;
        margin: 10px;
        width: 50px;
        box-shadow: 0 0 5px #000;
        border-radius: 5px;
/*        font-size: 120%;*/
        cursor: pointer;
        color: #fff;
        border-radius: 3px;
    }
    #yes {
        background-color: #da0404;
        margin-left: 10px;
    }
    #no {
        margin-right: 10px;
        margin-left: auto;
        background-color: #0d89ff;
    }
</style>