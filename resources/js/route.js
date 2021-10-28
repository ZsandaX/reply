import Vue from 'vue'
import VueRouter from "vue-router";
import draggable from 'vuedraggable'

Vue.use(VueRouter);

const files = require.context('./components', true, /\.vue$/i)
Vue.component("draggable", draggable);
const components = files.keys().reduce((acc, key) => {
    let name = key.split('/').pop().slice(0, -4);
    acc[name] = Vue.component(name, files(key).default);
    return acc;
}, {});

const router = new VueRouter({ mode: "history" });
let routes = [];
Vue.directive('route', {
    bind: function (el, binding, vnode) {
        routes.push({ path: "/" + binding.value.path, component: components[binding.value.component], meta: binding.value.meta });
        router.addRoutes(routes);
    }
});

export { components, router };
