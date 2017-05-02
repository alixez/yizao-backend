import Vue from 'vue';
import Vuex from 'vuex';
import pkg from 'package';
import * as actions from './action';
import * as getters from './getter';

import app from './modules/app';
import products from './modules/products';
import menu from './modules/menu';

Vue.use(Vuex);
const store = new Vuex.Store({
    strict: true,
    actions,
    getters,
    modules: {
        app,
        products,
        menu
    },
    state: {
        pkg
    },
    mutations: {

    }
});

export default store
