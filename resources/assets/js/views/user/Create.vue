<template>
    <create-or-update
        :saveAction="userApi.getCreateUserAction()">
    </create-or-update>
</template>

<script>
    import { userApi } from '../../api';
    import CreateOrUpdate from './CreateOrUpdate.vue';

    export default {
        components: {
            CreateOrUpdate,
        },

        data() {
            return {
                userApi: userApi,
            }
        },

    }
</script>