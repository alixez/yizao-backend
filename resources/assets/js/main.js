import Vue from 'vue'
import NProgress from 'vue-nprogress'
import ElementUI from 'element-ui'

import { sync } from 'vuex-router-sync'
import axios from 'axios'
import lodash from 'lodash';
import router from './router'
import store from './store'
import * as filters from './filters'
import { TOGGLE_SIDEBAR } from './store/mutation-types'

import App from './App.vue'

import 'element-ui/lib/theme-default/index.css'
axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.env.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};


Vue.config.productionTip = false;
Vue.prototype.$http = axios;
Vue.axios = axios;
window.axios = axios;
Vue._ = lodash;
Vue.use(NProgress);
Vue.use(ElementUI);
Vue.config.devtools = true;
sync(store, router);

const progress = new NProgress({ parent: '.nprogress-container' });

const { state } = store;

router.beforeEach((route, redirect, next) => {
    if (state.app.device.isMobile && state.app.sidebar.opened) {
        store.commit(TOGGLE_SIDEBAR, false)
    }

    next();
});

Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key])
});

const app = new Vue({
    el: '#app',
    router,
    store,
    progress,
    render: h => h(App)
});


