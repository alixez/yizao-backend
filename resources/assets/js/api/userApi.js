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

    static getUserLockOrUnlockAction(id, status)
    {
        return this.Host + 'users/lock/' + id + '/' + parseInt(status);
    }

    static getRolesWithPerm()
    {
        return this.Host + 'users/roles-with-permission';
    }

    static getAllPerm()
    {
        return this.Host + 'users/all-perms';
    }

    static getSyncPerms(id)
    {
        return this.Host + 'users/sync-perms/' + id;
    }

    static getCreateRole()
    {
        return this.Host + 'users/create-role';
    }

    static getDelivers()
    {
        return this.Host + 'users/delivers';
    }
}

export default userApi;

