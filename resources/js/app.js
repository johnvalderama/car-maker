require('./bootstrap');
require('../sass/app.scss')
import Vue from 'vue'

window.Vue = require('vue');

// router
import router from './router';
import store from './store';
import NavBar from './components/NavBar'

window.router = router;
window.Fire = new Vue();

const app = new Vue({
    el: '#app',
    store,
    router,
    components: {
      NavBar
    }
}).$mount('#app');