/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/zh-TW';
import { SurveyElementVue } from 'survey-vue';
import { router } from './route';

window.Vue = require('vue');
Vue.use(ElementUI, { locale, publicPath: '/' });

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    el: '#app',
    data: {
        permissions: [],
        isCollapse: false
    },
});
// Add a response interceptor
window.axios.interceptors.response.use(function (response) {
    // Any status code that lie within the range of 2xx cause this function to trigger
    // Do something with response data
    if (response.data.success == false) {
        throw response.data.errors;
    }
    return response;
}, function (error) {
    // Any status codes that falls outside the range of 2xx cause this function to trigger
    // Do something with response error
    switch (error.response.status) {
        case 401:
            app.$message.error("請重新登入");
            window.location.reload();
            return false;
            break;
        case 403:
            app.$message.error("無權限使用");
            return false;
            break;
    }
    return Promise.reject(error);
});
