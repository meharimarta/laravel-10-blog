<template>
    <div id="welcome-msg">
        <div id="info">
            <p>Start now writing proffetional posts in our site</p>
            <p>We are here for u!</p>
        </div>
    </div>
</template>

<script>
    let wcmssg = document.getElementById('welcome-msg');
export default {
    name: "welcome-msg",
    data() {
        return {
            imgUrl: "http://localhost/blog/public/assets/",
        }
    },
    props:['show']
}
</script>

<style scoped="true"> 
#welcome-msg {
    position: absolute;
    display: block;
    transition-duration: .5s;
    width: 100%;
    height: 400px;
    margin-top: -60px;
    background-image: url(http://localhost/blog/public/assets/bgh.jpg);
    background-position: center;
    background-attachment: fixed;
    background-size: cover;
}
    #info {
        justify-content: center;
        align-content: center;
        flex-direction: column;
    }
    #info p {
        font-size: 2.5em;
        color: #fff;
        align-self: center;
    }
</style>