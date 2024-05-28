/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//import $ from 'jquery';
let $ = require('jquery');
window.jquery = $;
window.$ = $;
//Uncaught SyntaxError: Function statements require a function name
require('./bootstrap');
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

 const files = require.context('./', true, /\.vue$/i)
 files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('blogs-component', require('./components/blogs.vue').default);
//Vue.component('blog', require('./components/blog.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
if(mixin == undefined)
{
	var mixin = {};
}
window.warnMsg = "";
window.done = false;
window.deleteLoading = false;
const app = new Vue({
    el: '#app',
    mixins: [mixin],
	data: {
        subscribing: false,
		mm: "pro",
		flipc: false,
		vis: false,//nav.style.display == "none" ? true : false,
		toggleSide: false,
        deleting: false,
        done: false,
        slideP: false,
        likes: window.likes ? window.likes : 0,
        //subscriber email
        email: '',
        subscriptionInfo: ''
	},
    methods: {
        slide() {
            this.slideP = true;
        },
        likepost(id) {
            axios.post('/like/' + id).then((res)=>{
                if(res.data)
                    this.likes =  res.data;
            }).catch((err)=>{
                
            });
        },
        flip() {
            this.flipc = this.flipc ? false : true;
            this.vis = this.vis ? false : true;
        },
        side(e){
            this.toggleSide = this.toggleSide ? false : true;
        },
        restore: function () {
            if(this.flipc)
            {
                this.flipc = false;
                this.vis = true;
            }
            if(this.toggleSide)
            this.toggleSide = false;
        },
        subscribe() {
            if(this.email == '') return;
            this.subscribing = true;
            let fd = new FormData();
            fd.append('email',this.email)
            axios.post('/subscribe',fd,{validateStatus:status=>true}).then((res)=>{
                this.subscribing = false;
                if(res.data == 1 && res.status == 200)
                    this.subscriptionInfo = "Subscribed check your inbox"
                if(res.data.errors && res.status == 422)
                    this.subscriptionInfo = res.data.errors.email[0];
            }).catch((err)=>{console.log(err)});
        }
    }
});
