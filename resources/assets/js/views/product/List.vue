<template>
    <div class="tile is-ancestor is-vertical">

        <div class="tile is-parent tile-fix-flex">
            <div class="tile is-child box">

                <su-data-table
                        ref="dataTable"
                        :action="productApi.getTableDataAction()"
                        :attributes="tableAttribute"
                        @on-add="toggleAddProduct"
                >

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
    import {product} from '../../api';
    import SuDataTable from 'components/smileui/SuDataTable';

    export default {
        components: {
            SuDataTable,
        },

        data() {
            return {
                name: '商品列表',
                productApi: product,
                tableAttribute: {
                    'prod_id': {
                        label: 'ID',
                        width: 65
                    },
                    'prod_title': {
                        label: '商品名',
                    },
                    'product_type.type_name': {
                        label: '商品分类',
                    },
                    'prod_desc': {
                        label: '商品描述',
                    },
                    'prod_price': {
                        label: '商品价格',
                        isAmount: true,
                    },
                    'prod_total_sales': {
                        label: '总销量',
                    },
                    'prod_permonth_sales': {
                        label: '月销量',
                    },
                    'prod_daily_sales': {
                        label: '日销量',
                    }
                }
            }
        },

        methods: {
            toggleAddProduct() {
                // 跳转路由，添加商品
                this.$router.push({name: 'create_product'});
            },

            handleEdit(index, row) {
                this.$router.push({name: 'update_product', params: {id: row.prod_id}});
            },

            handleDelete(index, row) {
                const uri = this.productApi.getDeleteAction(row.prod_id);
                this.$http.get(uri)
                    .then((resp) => {
                        if (resp.status === 200 && !resp.data.error) {
                            this.$notify.success('删除成功');
                            this.$refs.dataTable.removeRow(index);
                        } else {
                            this.$notify.error(resp.data.msg);
                        }
                    })
                    .catch((err) => {
                        this.$notify.error('对方不想理你，并向你抛了个异常');
                    })
                ;
            }

        }
    }
</script>