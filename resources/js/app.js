require('./bootstrap');
require('@coreui/coreui');

import Vue from 'vue';
import App from './App.vue';
import NProgress from 'vue-nprogress';
import VueToast from 'vue-toast-notification';
import store from './store';
import { createRouter } from './router';
import * as helpers from './helpers/functional';
import { initialize } from "./helpers/general";
import Select2 from 'v-select2-component';
import Pagination from './components/partials/Pagination';
import 'vue-toast-notification/dist/theme-sugar.css';

const plugin = {
    install () {
        Vue.helpers = helpers
        Vue.prototype.$helpers = helpers
    }
}

Vue.use(NProgress);
Vue.use(VueToast);
Vue.use(plugin);

Vue.component('Select2', Select2);
Vue.component('pagination', Pagination);

const nprogress = new NProgress();
const router = createRouter();

initialize(store, router);

const app = new Vue({
    nprogress,
    el: '#app',
    router,
    store,
    render: h => h(App)
});

router.beforeEach((to, from, next) => {
    NProgress.start();
    next()
});