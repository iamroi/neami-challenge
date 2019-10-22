// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import 'core-js/es6/promise'
import 'core-js/es6/string'
import 'core-js/es7/array'
// import cssVars from 'css-vars-ponyfill'
import Vuex from 'vuex';
import VeeValidate from 'vee-validate';
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import App from './App'
import router from './router'
import store from './store'
import {Model} from 'vue-api-query';
// import Permissions from './mixins/Permissions';
import veeValidateApi from "./plugins/veeValidateApi";
import VueToastr2 from 'vue-toastr-2';
import VueLadda from './components/vue-ladda';
import Multiselect from 'vue-multiselect';
import VueElementLoading from 'vue-element-loading'
Vue.component('VueElementLoading', VueElementLoading);
Vue.component('vue-ladda', VueLadda);
Vue.component('multiselect', Multiselect);

window.Vue = Vue;
window.toastr = require('toastr');

Vue.use(Vuex);
Vue.use(VueToastr2);
Vue.use(BootstrapVue);

// initialize VeeValidate with options
Vue.use(VeeValidate, {
    lang: 'es',
    // https://baianat.github.io/vee-validate/configuration.html
    inject: true,
    // important to name this something other than 'fields'
    fieldsBagName: 'veeFields',
    validity: true
});
Vue.use(veeValidateApi);

// Vue.mixin(Permissions);

// Initialize and configure default for Axios
window.axios = require('axios');
require('vue-axios-interceptors');
window.axios.defaults.baseURL = 'http://localhost:8000';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios.defaults.headers.common['token'] = store.state.auth.token;
Model.$http = axios;

// attach token on every axios request
axios.interceptors.request.use(function (config) {
    config.headers.token =  store.state.auth.token;
    return config;
});

// redirect guests to login page
// guard guests only pages from logged-in users
// allow only authorized users for protected routes using permissions
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.forGuests)) {
        if (store.getters.isLoggedIn) {
            next({
                path: '/dashboard'
            })
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!store.getters.isLoggedIn) {
            next({
                name: 'Login'
            })
        } else {
        }

        // User is logged in here
        // check if the user is authorized for the route
        // console.dir(to.meta);
        // let permission = to.matched.filter(record => record.meta.permission);
        // console.log(permission);
        if(to.meta.permission) {
            store.dispatch('getPermissions')
                .then(()=>{
                    // console.dir(store.getters.isPermissionsLoaded);
                    // console.dir(store.getters.permissions);
                    if(store.getters.permissions.includes(to.meta.permission)) {
                        next()
                    } else {
                        next({
                            path: '/home'
                        })
                    }
                });
        } else {
            next() // go to wherever I'm going
        }
    } else {
        next() // does not require auth, make sure to always call next()!
    }
})

// Listen for any intercepted responses.
// If token expired in any request, show users the 're-login' message
window.intercepted.$on('response', data => {
    let err = data.body;
    if (err.error && err.error.code === 'INVALID_TOKEN') { //err.status === 401 &&
        console.log('todo show login popup');
        window.toastr.error('Login expired. Please login again.', '', {
            "positionClass": "toast-top-center",
            "showDuration": "3000",
        });

        store.dispatch('unauthenticated');
        // window.location = `/login`;
        //this.$router.push('/logout');
    }
});

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {
        App
    }
})
