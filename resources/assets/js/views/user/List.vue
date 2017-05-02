<template>
    <div class="tile is-ancestor is-vertical">

        <div class="tile is-parent tile-fix-flex">
            <div class="tile is-child box">

                <su-data-table
                        ref="dataTable"
                        :action="userApi.getUserTableDataAction()"
                        :attributes="tableAttribute"
                        @on-add="toggleAddProduct"
                >

                    <el-table-column label="操作" slot="action" width="200" fixed="right">
                        <template scope="scope">
                            <el-button-group>
                                <el-button
                                        size="mini"
                                        type="primary"
                                        icon="edit"
                                        @click="handleEdit(scope.$index, scope.row)">修改
                                </el-button>

                                <el-button
                                        size="mini"
                                        type="primary"
                                        @click="handleView(scope.$index, scope.row)">查看
                                </el-button>
                            </el-button-group>

                                <el-button
                                        size="mini"
                                        type="danger"
                                        icon="warning"
                                        @click="handleBand(scope.$index, scope.row)">禁用
                                </el-button>

                        </template>
                    </el-table-column>
                </su-data-table>
            </div>
        </div>

    </div>
</template>

<script>
    import { userApi } from '../../api';
    import SuDataTable from 'components/smileui/SuDataTable';

    export default {
        components: {
            SuDataTable,
        },

        data() {
            return {
                name: '商品列表',
                userApi,
                tableAttribute: {
                    'id': {
                        label: 'ID',
                        width: 65
                    },
                    'name': {
                        label: '用户姓名',
                    },
                    'email': {
                        label: '用户邮箱',
                    }
                }
            }
        },

        methods: {
            toggleAddProduct() {
                // 跳转路由，添加商品
                this.$router.push({name: 'create_user'});
            },

            handleEdit(index, row) {
                this.$router.push({name: 'update_user', params: {id: row.id}});
            },

            handleView(index, row) {

            },

            handleBand(index, row) {

            },

            handleDelete(index, row) {
//                const uri = this.productApi.getDeleteAction(row.prod_id);
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