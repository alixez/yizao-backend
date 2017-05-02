/**
 * Created by alixez on 17-4-4.
 */
/**
 * Created by alixez on 17-4-4.
 */
import api from './api';

class product extends api {

    constructor() {
        super();
    }

    static getTypesByIdAction(id = 0) {
        return this.Host + 'product/types/' + id;
    }

    static getTypesByLevelAndParentAction(level = 1, parent = 0) {
        return this.Host + 'product/types/' + level + '_' + parent;
    }

    static getCreateProductAction() {
        return this.Host + 'product/create';
    }

    static getTableDataAction() {
        return this.Host + 'product/list';
    }

    static getDeleteAction(id) {
        return this.Host + 'product/delete/' + id;
    }

    static getUpdateAction(id) {
        return this.Host + 'product/update/' + id;
    }

    static getOneAction(id) {
        return this.Host + 'product/info/' + id;
    }
}

export default product;