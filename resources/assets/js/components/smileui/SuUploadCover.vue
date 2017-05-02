<template>
    <el-upload
            class="cover-uploader"
            :action="action"
            :show-file-list="false"
            :on-success="handleCoverSuccess"
            :headers="uploadHeader"
            :before-upload="beforeCoverUpload">
        <img v-if="coverId"
             :src="baseShowUri+coverId"
             class="cover"
             :style="imageStyle">
        <i class="el-icon-plus cover-uploader-icon"
           v-else
           :style="iconStyle"></i>
    </el-upload>
</template>

<style lang="scss" rel="stylesheet/scss">
    .cover-uploader {
        .el-upload {
            border: 1px dashed #d9d9d9;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .el-upload:hover {
            border-color: #20a0ff;
        }
    }

    .cover-uploader-icon {
        font-size: 28px;
        color: #8c939d;

        text-align: center;
    }

    .cover {
        display: block;
    }
</style>

<script>
    export default {
        props: {
            baseShowUri: {
                type: String,
                default: '/files/image/'
            },
            action: [String],
            value: {
                type: [String, Number]
            },
            primary: {
                type: String,
                default: 'file_id'
            },
            width: {
                type: Number,
                default: 178
            },
            height: {
                type: Number,
                default: 178
            }
        },

        watch: {
            value(val, old) {
                if (!old && val) {
                    this.coverId = this.value;
                }
                if (!val) {
                    this.coverId = null;
                }
            }
        },

        computed: {
            imageStyle() {
                return {
                    width: this.width + 'px',
                    height: this.height + 'px',
                }
            },

            iconStyle() {
                return {
                    width: this.width + 'px',
                    height: this.height + 'px',
                    'line-height': this.height + 'px'
                }
            },

            uploadHeader() {
                return {
                    'X-CSRF-TOKEN': window.env.csrfToken,
                }
            }
        },

        data() {
            return {
                coverId: null,
            }
        },

        methods: {
            handleCoverSuccess(resp, file) {
                if (resp[this.primary]) {
                    this.coverId = resp[this.primary];
                    this.$emit('input', this.coverId);
                }
            },
            beforeCoverUpload(file) {

            }
        }
    }
</script>