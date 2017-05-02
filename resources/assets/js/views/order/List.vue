<template>
    <div class="tile is-ancestor is-vertical">

        <div class="tile is-parent">
            <div class="tile is-child box">

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
                                        @click="handleEdit(scope.$index, scope.row)">修改
                                </el-button>
                                <el-button
                                        size="mini"
                                        type="danger"
                                        @click="handleDelete(scope.$index, scope.row)">删除
                                </el-button>
                            </el-button-group>
                        </template>
                    </el-table-column>
                </su-data-table>
            </div>
        </div>
    </div>
</template>

<script>
    import { orderApi } from '../../api';
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
            }
        },

        methods: {

            handleSelect(val) {
                this.activeTab = val;
            },

            toggleAddProduct() {
                // 跳转路由，生成订单
                this.$router.push({name: 'create_order'});
            },

            handleEdit(index, row) {
                this.$router.push({name: 'update_order', params: {id: row.prod_id}});
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