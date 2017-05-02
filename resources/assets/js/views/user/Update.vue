<template>
    <create-or-update
            v-model="user"
            :saveAction="userApi.getUpdateUserAction()">

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
                user: {},
                userApi: userApi,
            }
        },

        created() {
            const id = this.$route.params['id'];

            this.$http.get(this.userApi.getOneAction(id))
                .then((resp) => {
                    if (resp.data.user) {
                        let {roles, ...user} = resp.data.user;

                        user.roles = roles.map((item) => {
                            return item.id;
                        });

                        this.user = user;
                    }
                })
                .catch((err) => {
                    this.$message.error('未知异常');
                })
            ;
        }

    }
</script>