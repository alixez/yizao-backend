import * as types from './mutation-types';
import {product} from '../api';

export const toggleSidebar = ({ commit }, opened) => commit(types.TOGGLE_SIDEBAR, opened)

export const toggleDevice = ({ commit }, device) => commit(types.TOGGLE_DEVICE, device)

export const expandMenu = ({ commit }, menuItem) => {
    if (menuItem) {
        menuItem.expanded = menuItem.expanded || false
        commit(types.EXPAND_MENU, menuItem)
    }
};

export const switchEffect = ({ commit }, effectItem) => {
    if (effectItem) {
        commit(types.SWITCH_EFFECT, effectItem)
    }
};

export const toggleProductTypes = ({commit, state}, refresh = false) => {
    if (state.products.productTypes.length === 0
        || state.products.productTypes.length === 0
        || refresh) {
        axios.get(product.getTypesByLevelAndParentAction(1, 0))
            .then((resp) => {
                if (resp.status === 200) {
                    const [first, ...others] = resp.data.types;
                    commit(types.TOGGLE_PRODUCT_TYPES, {first, others});
                } else {
                    commit(types.TOGGLE_PRODUCT_TYPES, {first: [], others: []});
                    //this.$notify.error('): 获取产品分类出错啦...')
                }
            })
            .catch((err) => {
                commit(types.TOGGLE_PRODUCT_TYPES, {first: [], others: []});
                //console.log(err);
                //this.$notify.error('): 对方不想理你，并向你抛了个异常 ')
            })
        ;
    }
};
