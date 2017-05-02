<template>
    <el-tree
            :data="data"
            :props="options"
            highlight-current
            show-checkbox
            node-key="id"
            default-expand-all
            ref="tree"
            empty-text="暂时没有数据哦！"
            @check-change="handleCheckedEvent"
            >
    </el-tree>
</template>

<script>
    export default {
        name: 'su-simple-tree',
        props: {
            value: {
                type: Array,
                default: []
            },
            data: {
                type: Array,
                default: []
            },
            options: {
                type: Object,
                default() {
                    return {
                        children: 'children',
                        label: 'label',
                    }
                }
            }
        },

        watch: {
            value(val, old) {
                if (old.length === 0) {
                    this.list = val;
                    this.setCheckedNode(val);
                }
            }
        },

        data() {
            return {
                list: []
            }
        },

        methods: {
            setCheckedNode(val) {
                this.$refs.tree.setCheckedKeys(val)
            },
            getCheckedNode() {
                return this.$refs.tree.getCheckedKeys();
            },
            handleCheckedEvent(node, isChecked, isChildChecked) {
                this.list = this.getCheckedNode();
                this.$emit('input', this.list);
            }
        }
    }
</script>