// 加载资源库
require('./bootstrap');

import { SimpleNavbar } from './components/layouts'

const app = new Vue({
    components: {
        SimpleNavbar,
    },
    el: '#app'
});


