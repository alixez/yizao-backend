import api from './api';

class orderApi extends api {

    static getCreateOrderAction()
    {
        return this.Host + '/order/simple-create/';
    }

    static getTableDataAction(status) {
        return this.Host + 'order/table-data/' + status;
    }

    static getChangeStatusAction(id, status) {
        return this.Host + 'order/change_status/order_' + id + '/' + status;
    }

    static getChangeDeliverAction(id, userID) {
        return this.Host + 'order/update_deliver/order_'+ id +'/' + userID;
    }

}

export default orderApi;