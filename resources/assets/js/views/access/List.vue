<template>
    <div class="content">
        <el-form :inline="true" :model="newGroup" class="demo-form-inline">
            <el-form-item label="组标识">
                <el-input v-model="newGroup.name" placeholder="e.g. new_group"></el-input>
            </el-form-item>
            <el-form-item label="组名">
                <el-input v-model="newGroup.display_name" placeholder="e.g. 新的组"></el-input>
            </el-form-item>

            <el-form-item>
                <el-button type="primary" @click="createGroup">创建</el-button>
            </el-form-item>

        </el-form>
        <div class="tile is-ancestor">
            <div class="tile is-parent is-2">
                <el-tree style="width: 100%" :data="roles" :props="roleProps" @node-click="handleNodeClick"></el-tree>
            </div>
            <div class="tile is-parent" v-if="permissionTransferTitle !== false">
                <el-transfer
                        filterable
                        :titles="permissionTransferTitle"
                        v-model="roleWithPerm"
                        :render-content="renderFunc"
                        :props="permissionProps"
                        @change="onTransferChange"
                        :data="permission">
                </el-transfer>
            </div>
        </div>
    </div>
</template>

<style>
    .transfer-footer {
        margin-left: 20px;
        padding: 6px 5px;
    }
</style>

<script>
    import {userApi} from '../../api';
    export default {

        computed: {

            permissionTransferTitle() {
                if (this.currentEditRole.display_name) {
                    return  ['未启用权限('+ this.currentEditRole.display_name +')', '已有权限(' + this.currentEditRole.display_name + ')'];
                }

                return false;
            }
        },

        data() {

            return {
                userApi: userApi,
                currentEditRole: {},
                roles: [],
                roleProps: {
                    children: 'children',
                    label: 'display_name',
                },

                permission: [],
                permissionProps: {
                    key: 'id',
                    label: 'display_name',
                },
                roleWithPerm: [],

                newGroup: {},

                renderFunc(h, option) {
                    return <span>{ option.id } - { option.display_name }</span>;
                }
            };
        },

        mounted() {
            this.getRolesWithPerm(userApi);
            this.getAllPerm(userApi);
        },

        methods: {

            getRolesWithPerm(userApi) {
                this.$http.get(userApi.getRolesWithPerm())
                    .then((resp) => {
                        const data = resp.data;
                        if (data.roles) {
                            this.roles = data.roles;
                        }
                        if (data.roles.length > 0) {
                            this.currentEditRole = data.roles[0];
                            this.roleWithPerm = data.roles[0].perms.map((item) => {
                                return item.id;
                            });
                        }
                    });
            },

            getAllPerm(userApi) {
                this.$http.get(userApi.getAllPerm())
                    .then(resp => {
                        const data = resp.data;
                        if (data.perms) {
                            this.permission = data.perms;
                        }
                    })
            },

            handleNodeClick(data) {

                const foundRoles = this.roles.find((item, index) => {
                    if (item.id === data.id) {
                        this.currentEditRole = {...data, index};
                        return true;
                    }
                });
                this.roleWithPerm = foundRoles.perms.map((item) => {
                    return item.id;
                });

            },

            onTransferChange(item) {
                const roleID = this.currentEditRole.id;
                const index = this.currentEditRole.index;
                this.$http.post(this.userApi.getSyncPerms(roleID), {perms: item})
                    .then((resp) => {
                        if (resp.data.roles) {
                            this.roles[index] = resp.data.roles;
                        }
                    });
            },

            createGroup() {
                this.$http.post(this.userApi.getCreateRole(), this.newGroup)
                    .then(resp => {
                        if (resp.data.role) {
                            this.roles.push(resp.data.role);
                        }
                    })
            }
        }
    };
</script>