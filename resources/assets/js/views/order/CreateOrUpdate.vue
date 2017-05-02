<template>
    <div class="content">
        <div class="tile is-ancestor">
            <div class="tile is-parent is-vertical">
                <article class="tile is-child box">

                    <el-tabs v-model="activeName" @tab-click="handleClick">

                        <el-tab-pane label="订单详情" name="baseInfo">
                            <div class="columns">
                                <div class="column is-half is-offset-one-quarter">

                                    <el-form ref="productForm" :model="orderData" label-width="100px">
                                        <!--
                                        <el-form-item label="订单号" prop="order_no" style="width: 65%">
                                            <el-input v-model="orderData.order_no"></el-input>
                                        </el-form-item>
                                        -->
                                        <el-form-item label="所属用户" prop="user_id">
                                            <el-select v-model="orderData.user_id" placeholder="请选择">
                                                <el-option
                                                        v-for="item in users"
                                                        :label="item.name"
                                                        :value="item.id">
                                                    <span style="float: left">{{ item.name }}</span>
                                                    <span style="float: right; color: #8492a6; font-size: 13px">{{ item.email
                                                        }}</span>
                                                </el-option>
                                            </el-select>
                                        </el-form-item>

                                        <el-form-item label="配送地址"  prop="order_address">

                                            <el-select v-model="orderData.order_address"
                                                       @change="selectShippingAddress"
                                                       :disabled="orderData.user_id === null"
                                                       clearable placeholder="请选择">
                                                <el-option
                                                        v-for="address in userAddresses"
                                                        :label="address.address_detail"
                                                        :value="address.address_id">
                                                </el-option>
                                            </el-select>

                                            <!--<el-input v-model="orderData.order_address"></el-input>-->
                                        </el-form-item>

                                        <el-form-item label="配送时间" prop="shipping_time">
                                            <el-radio-group v-model="orderData.shipping_time">
                                                <el-radio-button label="TIME_PERIOD_FIRST">8:00-8:30</el-radio-button>
                                                <el-radio-button label="TIME_PERIOD_SECOND">8:30-9:00</el-radio-button>
                                                <el-radio-button label="TIME_PERIOD_THIRD">9:00-9:30</el-radio-button>
                                                <el-radio-button label="TIME_PERIOD_FOURTH">9:30-10:00</el-radio-button>
                                            </el-radio-group>

                                        </el-form-item>


                                        <el-form-item label="配送费(元)" prop="shipping_money">
                                            <el-input-number v-model="orderData.shipping_money"
                                                             :step="0.5"></el-input-number>
                                        </el-form-item>

                                        <el-form-item label="备注" prop="remark">
                                            <el-input type="textarea"
                                                      v-model="orderData.remark"
                                                      :autosize="{minRows: 3, maxRows: 4}"
                                            >
                                            </el-input>
                                        </el-form-item>

                                    </el-form>
                                </div>
                            </div>
                        </el-tab-pane>

                        <el-tab-pane label="商品信息" name="products">

                            <div class="box">
                                <div class="columns">
                                    <div class="column is-8 is-offset-2">
                                        <div class="columns">
                                            <div class="column">
                                                <el-card class="box-card">
                                                    <div v-for="(product, index) in orderData.products" class="text item">
                                                        <div class="level">
                                                            <div class="level-left">
                                                                {{ product.prod_title }} {{ product.prod_count }}份
                                                            </div>
                                                            <div class="level-right">
                                                                <el-button size="mini" @click="deleteProduct(index)" style="color: red" class="el-icon-delete"></el-button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </el-card>
                                            </div>

                                            <div class="column is-two-thirds">
                                                <el-card class="box-card">
                                                    <su-simple-data-table
                                                            ref="dataTable"
                                                            :action="productApi.getTableDataAction()"
                                                            :attributes="productTableAttribute">

                                                        <el-table-column label="操作" slot="action">
                                                            <template scope="scope">
                                                                <el-button-group>
                                                                    <el-button
                                                                            size="mini"
                                                                            type="primary"
                                                                            @click="handleSelect(scope.$index, scope.row)">选择
                                                                </el-button>
                                                                </el-button-group>
                                                            </template>
                                                        </el-table-column>

                                                    </su-simple-data-table>
                                                </el-card>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </el-tab-pane>


                    </el-tabs>

                    <div class="columns">
                        <div class="column is-half is-offset-one-quarter">
                            <div class="level">
                                <div class="level-left" style="padding-left: 100px;">
                                    <el-button type="primary" @click="save">保存</el-button>
                                    <el-button @click="cancel">取消</el-button>
                                </div>
                            </div>
                        </div>
                    </div>

                </article>

            </div>
        </div>
    </div>
</template>

<script>
    import {userApi, product} from '../../api';
    import SuSimpleTree from 'components/smileui/SuSimpleTree';
    import SuSimpleDataTable from 'components/smileui/SuSimpleDataTable';
    export default {

        components: {
            SuSimpleTree,
            SuSimpleDataTable,
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
                if (!old.order_id && val) {
                    this.userData = val;
                }
            },

            'orderData.user_id': function(value, oldValue) {
                if (value !== oldValue) {
                    this.orderData.order_address = null;
                    this.getUserAddress(value);
                }
            }
        },

        data() {
            return {
                productApi: product,
                userApi: userApi,
                activeName: 'baseInfo',
                users: [],
                userAddresses: [],
                orderData: {
                    order_id: null,
                    order_no: null,
                    order_address: null,
                    user_id: null,
                    order_status: null,
                    shipping_person: null,
                    shipping_address: null,
                    shipping_time: '',
                    shipping_money: null,
                    total_price: null,
                    remark: null,
                    products: [],
                },

                productTableAttribute: {
                    'prod_title': {
                        label: '商品名',
                    },
                    'product_type.type_name': {
                        label: '商品分类',
                    },
                    'prod_price': {
                        label: '商品价格',
                    },
                }
            };
        },

        created() {
            this.getRoles();
            this.getUsers();
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

            getUsers() {
                this.$http.get(this.userApi.getAllUsersAction())
                    .then(resp => {

                        this.users = resp.data[0];
                    })
                    .catch(err => {
                        this.$message.error('对方不想理你，并向你抛了个异常');
                    })
                ;
            },

            getUserAddress(id) {
                this.$http.get(this.userApi.getUserAddressAction(id))
                    .then(resp => {
                        this.userAddresses = resp.data;
                    })
                    .catch(err => {
                        this.$message.error('对方不想理你，并向你抛了个异常');
                    })
                ;
            },

            selectShippingAddress(value) {

                const address = this.userAddresses.find(item => {
                    return item.address_id === value;
                });

                if (address) {
                    this.orderData.shipping_address = address.address_detail;
                    this.orderData.shipping_person = address.address_name;
                }
            },

            handleSelect(index, row) {
                const data = Object.assign({}, row);
                this.$prompt('请输入商品数量', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    inputPattern: /\d+/,
                    inputErrorMessage: '请输入正确的数量',
                }).then(({ value }) => {

                    data.prod_count = parseInt(value);
                    const hasCurrentRow = this.orderData.products.find(item => {
                        if (item.prod_id === data.prod_id) {
                            item.prod_count = parseInt(value) + parseInt(item.prod_count);
                            return true;
                        }

                        return false;
                    });

                    if (!hasCurrentRow) {
                        this.orderData.products.push(data);
                    }
                    this.$message.success('添加商品成功');
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '取消输入',
                    });
                });
            },

            deleteProduct(index) {
                this.orderData.products.splice(index, 1);
            },

            save() {
                // console.log(this.orderData);
                this.orderData.shipping_money = this.orderData.shipping_money * 100;
                this.$http.post(this.saveAction, this.orderData)
                    .then((resp) => {
                        if (resp.data.order) {
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
//                this.userData.addresses.push(Object.assign({}, this.address));
//                this.$refs.addressForm.resetFields();
            },

            cancelAddAddress() {
//                this.$refs.addressForm.resetFields();
            },

            cancel() {
                this.$router.back();
            }
        }
    };
</script>