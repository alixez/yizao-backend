/**
 * Created by alixez on 17-4-4.
 */
import * as types from '../mutation-types';

const state = {
    productTypes: [],
    combProductTypes: [],
};

const mutations = {

    [types.TOGGLE_PRODUCT_TYPES] (state, caseTypes) {
        const {first, others} = caseTypes;
        state.productTypes = [first];
        state.combProductTypes = others;
    }
};

export default {
    state,
    mutations
}
