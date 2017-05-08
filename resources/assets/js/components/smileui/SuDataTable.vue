<template>
    <div class="tile">
        <div class="tile is-parent is-vertical">
            <div class="tile is-child">
                <div class="level">
                    <div class="level-left">
                        <div class="level-item">
                            <slot name="headerLeft"></slot>
                        </div>
                    </div>

                    <div class="level-right">
                        <div class="level-item">
                            <slot name="headerRight"></slot>
                        </div>
                        <div class="level-item">
                            <el-button
                                    type="success"
                                    @click="handleAdd"
                            >新增</el-button>
                        </div>
                    </div>

                </div>

            </div>
            <div class="tile is-child">
                <el-table :data="tableData" :height="height">
                    <slot name="selection"></slot>
                    <template v-for="(column,prop) in attributes">
                        <el-table-column
                                :prop="prop"
                                :width="column.width || ''"
                                :label="column.label">
                            <template scope="scope">
                                <el-tag v-if="column.isAmount">￥{{ scope.row[prop] / 100 }}</el-tag>
                                <span v-else>{{ getRowLabel(scope.row, prop) }}</span>
                            </template>
                        </el-table-column>
                    </template>
                    <slot name="action"></slot>
                </el-table>
            </div>
            <div class="tile is-child level">
                <div class="level-right">
                    <div class="level-item">
                        <el-pagination
                                @size-change="handleSizeChange"
                                @current-change="handleCurrentChange"
                                :current-page="pagination.currentPage"
                                :page-sizes="[15, 25, 50, 100]"
                                :page-size="pagination.perPage"
                                layout="total, sizes, prev, pager, next, jumper"
                                :total="pagination.total">
                        </el-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<style lang="scss" rel="stylesheet/scss">
    .el-pagination .number {
        border-radius: 0;
    }
</style>

<script>
    export default {
        name: 'su-data-table',
        props: {
            attributes: {
                required: true,
                type: Object,
                default: null
            },
            filterrules: {
                type: Object,
                default: null
            },
            height: {
                type: Number,
                default: null
            },
            action: {
                type: String,
                required: true
            }
        },

        watch: {
            action(val, old) {
                if (val !== old) {
                    this.refresh();
                }
            }
        },

        computed: {
            searchParams() {
                let searchs = {
                    fields: null,
                    search: null,
                }
                if (this.filterrules !== null) {
                    let rules = [];
                    let conditions = [];
                    let s = _.partition(this.filterrules, 'value')[0];

                    _.forEach(s, function(val, key) {
                        conditions.push(val.name + ':' + (val.condition || '='));
                        rules.push(val.name + ':' + val.value);
                    });

                    searchs.search = rules.join(';')
                    searchs.fields = conditions.join(';')
                }

                return searchs;
            }
        },

        data() {
            return {
                form: null,
                tableData: [],
                pagination: {
                    currentPage: 1,
                    lastPage: 1,
                    perPage: 15,
                    total: 0
                }
            }
        },

        methods: {
            handleSizeChange(val) {
                this.pagination.perPage = val;
                this.getTableData();
            },
            handleCurrentChange(val) {
                this.pagination.currentPage = val;
                this.getTableData();
            },

            getRowLabel(row, prop) {
                const props = prop.split('.');
                let result = '';
                for (let i = 0; i < props.length; i ++) {
                    let item = props[i];
                    if (result !== '') {
                        result = result[item];
                    } else {
                        result = row[item];
                    }
                }
                return result;
            },

            getTableData() {

                let conf = {
                    params: {
                        page: this.pagination.currentPage,
                        limit: this.pagination.perPage,
                        search: this.searchParams.search,
                        searchFields: this.searchParams.fields,
                    }
                };
                this.$http.get(this.action, conf)
                    .then((resp) => {
                        this.tableData = resp.data.data;
                        this.pagination.currentPage = parseInt(resp.data.current_page);
                        this.pagination.lastPage = parseInt(resp.data.last_page);
                        this.pagination.perPage = parseInt(resp.data.per_page);
                        this.pagination.total = parseInt(resp.data.total);
                    })
                    .catch((err) => {})
                ;
            },

            removeRow(index) {
                this.tableData.splice(index, 1);
            },

            updateRow(index, row) {
                this.tableData[index] = row;
            },

            handleAdd() {
                this.$emit('on-add');
            },

            doFilter() {
                this.getTableData();
            },

            refresh() {
               this.getTableData();
            }

        },

        created() {
            let vm = this;
            vm.getTableData();
        },

    }
</script>