<template>
    <div class="content">
        <div class="tile is-ancestor">
            <div class="tile is-parent is-vertical">
                <article class="tile is-child box">

                    <el-tabs v-model="activeName" @tab-click="handleClick">

                        <el-tab-pane label="基本信息" name="baseInfo">
                            <div class="columns">
                                <div class="column is-half is-offset-one-quarter">
                                    <el-form ref="productForm" :model="userData" label-width="100px">
                                        <el-form-item label="用户姓名" prop="name" style="width: 65%">
                                            <el-input v-model="userData.name"></el-input>
                                        </el-form-item>

                                        <el-form-item label="角色" prop="roles" style="width: 65%;">
                                            <su-simple-tree
                                                    v-model="userData.roles"
                                                    :data="roles"
                                                    :options="rolesTreeProps"
                                            >
                                            </su-simple-tree>
                                        </el-form-item>

                                        <el-form-item label="邮箱" prop="email" style="width: 65%">
                                            <el-input v-model="userData.email"></el-input>
                                        </el-form-item>

                                        <el-form-item label="密码" prop="password" style="width: 65%">
                                            <el-input type="password" v-model="userData.password"></el-input>
                                        </el-form-item>
                                    </el-form>

                                </div>
                            </div>
                        </el-tab-pane>

                        <el-tab-pane label="送餐地址" name="userAddress">
                            <div class="columns">
                                <div class="column">
                                    <el-table
                                            :data="userData.addresses"
                                            border
                                            style="width: 100%">
                                        <el-table-column
                                                prop="address_name"
                                                label="收货人"
                                                width="180">
                                        </el-table-column>
                                        <el-table-column
                                                prop="address_phone"
                                                label="联系电话"
                                                width="180">
                                        </el-table-column>
                                        <el-table-column
                                                prop="address_detail"
                                                label="地址">
                                        </el-table-column>
                                    </el-table>

                                </div>

                                <div class="column is-4">
                                    <el-form ref="addressForm" :model="address" label-width="100px">
                                        <el-form-item label="收货人" prop="address_name" style="width: 65%">
                                            <el-input v-model="address.address_name"></el-input>
                                        </el-form-item>

                                        <el-form-item label="联系电话" prop="address_phone" style="width: 65%">
                                            <el-input v-model="address.address_phone"></el-input>
                                        </el-form-item>

                                        <el-form-item label="地址" prop="address_detail" style="width: 65%">
                                            <el-input v-model="address.address_detail"></el-input>
                                        </el-form-item>

                                        <el-form-item>
                                            <el-button @click="addAddress">添加</el-button>
                                            <el-button @click="cancelAddAddress">取消</el-button>
                                        </el-form-item>
                                    </el-form>
                                </div>

                            </div>
                        </el-tab-pane>

                    </el-tabs>

                </article>

                <div class="tile is-child box">
                    <el-button @click="save">确定</el-button>
                    <el-button @click="cancel">取消</el-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {userApi} from '../../api';
    import SuSimpleTree from 'components/smileui/SuSimpleTree';
    export default {

        components: {
            SuSimpleTree,
        },

        props: {
            saveAction: {
                type: String,
                required: true,
            },
            saveSuccessText: {
                type: String,
                default: '修改成功',
            },
            value: {
                type: Object,
                default: null,
            }
        },

        watch: {
            value(val, old) {
                if (!old.id && val) {
                    this.userData = val;
                }
            }
        },

        data() {
            return {
                userApi: userApi,
                activeName: 'baseInfo',
                userData: {
                    id: null,
                    name: null,
                    email: null,
                    password: null,
                    roles: [],
                    addresses: [],
                },
                roles: [],
                rolesTreeProps: {
                    label: 'display_name',
                },
                address: {
                    address_name: null,
                    address_phone: null,
                    address_detail: null,
                }
            };
        },

        created() {
            this.getRoles();
        },

        mounted() {
        },

        methods: {

            handleClick(tab, event) {

            },

            getRoles() {
                this.$http.get(this.userApi.getUserRolesAction())
                    .then((resp) => {
                        if (resp.data.roles) {
                            this.roles = resp.data.roles;
                        }
                    })
                    .catch((err) => {
                        this.$message.error('对方不想理你，并向你抛了个异常');
                    })
                ;
            },

            save() {
                console.log(this.userData);
                this.$http.post(this.saveAction, this.userData)
                    .then((resp) => {
                        if (resp.data.user) {
                            this.$notify.success(this.saveSuccessText);
                            this.$router.push({name: 'list_user'});
                        }
                    })
                    .catch((err) => {
                        const resp = err.response;
                        if (resp) {
                            // todo 根据不同的状态进行反馈
                            if (resp.status === 404) {
                                this.$message.warning('没有找到您请求的资源');
                            }
                            if (resp.status === 403) {
                                this.$message.warning('抱歉，没有此操作的权限');
                            }
                        } else {
                            this.$message.error('对方不想理你，并向你抛了个异常');
                        }
                    })
                ;
            },

            addAddress() {
                this.userData.addresses.push(Object.assign({}, this.address));
                this.$refs.addressForm.resetFields();
            },

            cancelAddAddress() {
                this.$refs.addressForm.resetFields();
            },

            cancel() {
                this.$router.back();
            }
        }
    };
</script>