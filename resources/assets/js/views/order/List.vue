<template>
    <div class="tile is-ancestor is-vertical">

        <div class="tile is-parent">
            <div class="tile is-child box">

                <el-dialog title="选择配送人"
                           :modal="false"
                           :visible.sync="dialogSelectDeliverVisible">
                    <el-form :model="deliver">
                        <el-form-item label="配送人" label-width="40">
                            <el-select v-model="deliver.id" placeholder="请选择活动区域">
                                <el-option v-for="item in delivers" :key="item.id" :label="item.name" :value="item.id"></el-option>
                            </el-select>
                        </el-form-item>
                    </el-form>
                    <div slot="footer" class="dialog-footer">
                        <el-button @click="dialogSelectDeliverVisible = false">取 消</el-button>
                        <el-button type="primary" @click="updateDeliver">确 定</el-button>
                    </div>
                </el-dialog>

                <su-data-table
                        ref="dataTable"
                        :action="orderApi.getTableDataAction(activeTab)"
                        :attributes="tableAttribute"
                        @on-add="toggleAddProduct"
                >

                    <el-menu :default-active="activeTab" class="el-menu-demo" slot="headerLeft" mode="horizontal" @select="handleSelect">
                        <el-menu-item index="not_paid">未支付</el-menu-item>
                        <el-menu-item index="paid">已支付</el-menu-item>
                        <el-menu-item index="deliver">配送中</el-menu-item>
                        <el-menu-item index="did_deliver">配送完成</el-menu-item>
                        <el-menu-item index="trade_finish">交易完成</el-menu-item>
                    </el-menu>

                    <el-table-column label="操作" slot="action" width="200" fixed="right">
                        <template scope="scope">
                            <el-button-group>
                                <el-button
                                        size="mini"
                                        :plain="true"
                                        type="primary"
                                        @click="handleShow(scope.$index, scope.row)">查看
                                </el-button>
                                <!--<el-button-->
                                        <!--size="mini"-->
                                        <!--type="danger"-->
                                        <!--@click="handleDelete(scope.$index, scope.row)">删除-->
                                <!--</el-button>-->
                            </el-button-group>
                            <el-button
                                size="mini"
                                :plain="true"
                                type="warning"
                                v-if="scope.row.order_status !== 'STATUS_TRADE_FINISH'"
                                @click="handleChangeStatus(scope.$index, scope.row)">
                                {{getStatusText(scope.row)}}
                            </el-button>
                        </template>
                    </el-table-column>

                </su-data-table>

            </div>
        </div>

    </div>
</template>

<script>
    import { orderApi, userApi } from '../../api';
    import SuDataTable from 'components/smileui/SuDataTable';

    export default {
        components: {
            SuDataTable,
        },

        computed: {

        },

        data() {
            return {
                name: '订单列表',
                orderStatus: [
                    'STATUS_NOT_PAID',
                    'STATUS_PAID',
                    'STATUS_DELIVER',
                    'STATUS_DID_DELIVER',
                    'STATUS_TRADE_FINISH'
                ],
                orderApi: orderApi,
                tableAttribute: {
                    'order_id': {
                        label: 'ID',
                        width: 65
                    },
                    'order_no': {
                        label: '订单号',
                    },
                    'user.name': {
                        label: '用户',
                    },
                    'shipping_person': {
                        label: '收货人',
                    },
                    'shipping_address': {
                        label: '收货地址',
                    },
                    'shipping_time': {
                        label: '收货时间',
                    },
                    'shipping_money': {
                        label: '配送费',
                        isAmount: true,
                    },
                    'total_price': {
                        label: '总金额',
                        isAmount: true,
                    },
                    'remark': {
                        label: '备注',
                    }
                },
                activeTab: 'not_paid',

                delivers: [],

                deliver: {
                    id: null,
                    orderID:null,
                },
                dialogSelectDeliverVisible: false,
            }
        },

        mounted() {
            this.getDelivers(userApi);
        },

        methods: {

            getDelivers(userApi) {
                this.$http.get(userApi.getDelivers())
                    .then(resp => {
                        console.log(resp);
                        this.delivers = resp.data.delivers;

                    });
            },

            handleSelect(val) {
                this.activeTab = val;
            },

            toggleAddProduct() {
                // 跳转路由，生成订单
                this.$router.push({name: 'create_order'});
            },

            handleShow(index, row) {
                this.$router.push({name: 'show_order', params: {id: row.prod_id}});
            },

            getStatusText(row) {
                const orderStatus = row.order_status;
                switch (orderStatus) {
                    case 'STATUS_NOT_PAID':
                        return '已付款';
                    case 'STATUS_PAID':
                        return '配送';
                    case 'STATUS_DELIVER':
                        return '完成配送';
                    case 'STATUS_DID_DELIVER':
                        return '完成交易';
                }
            },

            handleChangeStatus(index, row) {
                const status = row.order_status;
                const statusIndex = this.orderStatus.indexOf(status);
                if (statusIndex + 1 === this.orderStatus.length) {
                    return null;
                }

                if (this.orderStatus[statusIndex + 1] === 'STATUS_DELIVER') {
                    console.log(123);
                    this.dialogSelectDeliverVisible = true;
                    this.deliver.orderID = row.order_id;
                    this.deliver.orderStatus = this.orderStatus[statusIndex + 1];
                    this.deliver.index = index;
                    //const changeDeliverUri = this.orderApi.getChangeDeliverAction(row.order_id, )
                } else {
                    const uri = this.orderApi.getChangeStatusAction(row.order_id, this.orderStatus[statusIndex + 1]);
                    this.$http.post(uri)
                        .then(resp => {
                            if (resp.status === 200 && resp.data.code === 1) {
                                this.$notify.success(resp.data.message);
                                this.$refs.dataTable.removeRow(index);
                            } else {
                                this.$notify.error(resp.data.message);
                            }
                        }).catch(err => {});
                }
            },

            updateDeliver() {
                const changeDeliverUri = this.orderApi.getChangeDeliverAction(this.deliver.orderID, this.deliver.id);
                const index = this.deliver.index;
                this.$http.post(changeDeliverUri)
                    .then(resp => {
                        if (resp.data.code && resp.data.code === 1) {
                            const uri = this.orderApi.getChangeStatusAction(this.deliver.orderID, this.deliver.orderStatus);
                            this.$http.post(uri)
                                .then(resp => {
                                    if (resp.status === 200 && resp.data.code === 1) {
                                        this.$notify.success(resp.data.message);
                                        this.$refs.dataTable.removeRow(index);
                                    } else {
                                        this.$notify.error(resp.data.message);
                                    }
                                    this.dialogSelectDeliverVisible = false;
                                }).catch(err => {});
                        }
                    });
            },

            handleDelete(index, row) {
                //const uri = this.productApi.getDeleteAction(row.prod_id);
//                this.$http.get(uri)
//                    .then((resp) => {
//                        if (resp.status === 200 && !resp.data.error) {
//                            this.$notify.success('删除成功');
//                            this.$refs.dataTable.removeRow(index);
//                        } else {
//                            this.$notify.error(resp.data.msg);
//                        }
//                    })
//                    .catch((err) => {
//                        this.$notify.error('对方不想理你，并向你抛了个异常');
//                    })
//                ;
            }
        }
    }
</script>