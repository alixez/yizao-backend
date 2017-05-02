<template>
    <div class="content">
        <div class="tile is-ancestor">
            <div class="tile is-parent is-vertical">
                <article class="tile is-child box">
                    <el-form ref="productForm" :model="productData" label-width="100px">
                        <el-tabs v-model="activeName" @tab-click="handleClick">

                            <el-tab-pane label="基本信息" name="baseInfo">
                                <div class="columns">
                                    <div class="column is-half is-offset-one-quarter">
                                        <el-form-item label="商品类别" prop="prod_type_ids">
                                            <el-cascader
                                                    :value="productData.prod_type_ids"
                                                    :options="products.productTypes"
                                                    :props="prod_types_props"
                                                    @change="onTypeChange"
                                                    change-on-select
                                            ></el-cascader>
                                        </el-form-item>

                                        <el-form-item label="商品名" prop="prod_title" style="width: 65%">
                                            <el-input v-model="productData.prod_title"></el-input>
                                        </el-form-item>

                                        <el-form-item label="封面" prop="prod_cover_id">
                                            <su-upload-cover :action="file.getUploadImageAction('default', 300, 200)"
                                                             v-model="productData.prod_cover_id"
                                                             :width="315">
                                            </su-upload-cover>
                                        </el-form-item>

                                        <el-form-item label="商品价格(元)" prop="prod_price" style="width: 65%">
                                            <el-input-number v-model="productData.prod_price"
                                                             :step="1.5"></el-input-number>
                                        </el-form-item>

                                        <el-form-item label="商品描述" prop="prod_desc">
                                            <el-input type="textarea"
                                                      :autosize="{minRows: 3, maxRows: 4}"
                                                      v-model="productData.prod_desc"></el-input>
                                        </el-form-item>

                                        <el-form-item label="商品详情" prop="prod_body">
                                            <el-input type="textarea"
                                                      :autosize="{minRows: 4, maxRows: 6}"
                                                      v-model="productData.prod_body"></el-input>
                                        </el-form-item>
                                    </div>
                                </div>
                            </el-tab-pane>
                            <!--
                            <el-tab-pane label="商品规格" name="productStandard">

                                <el-form-item label="商品描述" prop="prod_desc" style="width: 65%">
                                    <el-input v-model="productData.prod_desc"></el-input>
                                </el-form-item>

                            </el-tab-pane>
                            <el-tab-pane label="价格设置" name="productPrice">
                                价格设置
                            </el-tab-pane>
                            <el-tab-pane label="其他" name="others">
                                其他

                            </el-tab-pane>
                            -->
                        </el-tabs>
                    </el-form>
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
    import SuUploadCover from 'components/smileui/SuUploadCover';
    import {file, product} from '../../api';
    import {mapGetters, mapActions} from 'vuex';

    export default {
        components: {
            SuUploadCover,
        },

        computed: {
            ...mapGetters([
                'app',
                'products',
            ])
        },

        data() {
            return {
                file: file,
                product: product,
                activeName: 'baseInfo',
                productData: {
                    prod_type_id: null,
                    prod_type_ids: [],
                    prod_title: null,
                    prod_desc: null,
                    prod_body: null,
                    prod_price: null,
                },
                prod_types_props: {
                    value: 'type_id',
                    label: 'type_name',
                },
                prod_types: [],
                prod_id: null,
            };
        },

        created() {
            this.toggleProductTypes();
            const prodId = this.$route.params.id;
            console.log(prodId);
            if (!prodId) {
                this.$router.push({name: 'list_product'});
            }
            this.prod_id = prodId;
            this.$http.get(this.product.getOneAction(prodId))
                .then((resp) => {
                    if (resp.status === 404) {
                        this.$router.back();
                    }

                    if (resp.status === 200 && !resp.data.error) {
                        const product = resp.data.product;
                        this.productData.prod_type_id = product.prod_type_id;
                        this.productData.prod_type_ids = [
                            product.product_type.type_parent,
                            product.product_type.type_id,
                        ];
                        this.productData.prod_cover_id = product.prod_cover_id;
                        this.productData.prod_title = product.prod_title;
                        this.productData.prod_desc = product.prod_desc;
                        this.productData.prod_body = product.prod_body;
                        this.productData.prod_price = product.prod_price;
                    } else if (!resp.data.product) {
                        this.$router.push({name: 'list_product'});
                    } else {
                        this.$notify.error('): 服务器不想理你，并向你抛了个异常');
                    }
                })
                .catch((err) => {
                    if (err.response.status === 404) {
                        this.$router.push({name: 'list_product'});
                    } else {
                        this.$notify.error('): 服务器不想理你，并向你抛了个异常');
                    }
                })
            ;
        },

        mounted() {},

        methods: {
            ...mapActions(['toggleProductTypes']),
            getFileUploadAction() {

            },

            handleClick(tab, event) {
                console.log(tab, event);
            },


            save() {
                this.$http.post(this.product.getUpdateAction(this.prod_id), this.productData)
                    .then((resp) => {
                        if (resp.status === 200 && resp.data.product) {
                            this.$router.push({name: 'list_product'});
                        }
                    })
                    .catch(err => {
                        if (err.response) {
                            return;
                        } else {
                            this.$notify.error('): Error'+err.message);
                        }
                        this.$notify.error('): 服务器不想理你，并向你抛了个异常');
                    })
                ;
            },

            cancel() {
                this.$router.back();
            },

            onTypeChange(val) {
                this.productData.prod_type_id = val[val.length - 1];
            }
        }
    };
</script>