<template>
    <create-or-update
        :saveAction="orderApi.getCreateOrderAction()">
    </create-or-update>
</template>

<script>
    import CreateOrUpdate from './CreateOrUpdate.vue';
    import {orderApi} from '../../api';
    export default {
        components: {
            CreateOrUpdate,
        },

        data() {
            return {
                name: 'create',
                orderApi: orderApi,
            }
        }
    }
</script>