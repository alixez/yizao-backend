import api from './api';

class orderApi extends api {

    static getCreateOrderAction()
    {
        return this.Host + '/order/simple-create/';
    }

    static getTableDataAction(status) {
        return this.Host + 'order/table-data/' + status;
    }
}

export default orderApi;