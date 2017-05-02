import api from './api';

class userApi extends api {

    static getUserTableDataAction() {
        return this.Host + 'users/list';
    }

    static getCreateUserAction() {
        return this.Host + 'users/create';
    }

    static getUserRolesAction() {
        return this.Host + 'users/get-roles';
    }

    static getUpdateUserAction() {
        return this.Host + 'users/update';
    }

    static getOneAction(id) {
        return this.Host + 'users/get-one/' + id;
    }

    static getAllUsersAction()
    {
        return this.Host + 'users/all';
    }

    static getUserAddressAction(id)
    {
        return this.Host + 'users/get-address/' + id;
    }
}

export default userApi;

