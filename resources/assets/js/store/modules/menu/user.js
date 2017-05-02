import lazyLoading from './lazyLoading.js'

export default [
    {
        name: 'userAndAccess',
        meta: {
            label: '用户 & 权限',
            icon: 'fa-random',
            expanded: true,
        },
        children: [
            {
                path: '/users',
                meta: {
                    label: '用户管理',
                },
                component: lazyLoading('user', true),
                children: [
                    {
                        name: 'list_user',
                        path: '',
                        meta: {
                            label: '用户列表',
                            link: 'user/List.vue',
                        },
                        component: lazyLoading('user/List'),
                    },
                    {
                        name: 'create_user',
                        path: 'create',
                        meta: {
                            label: '创建用户',
                            link: 'user/Create.vue',
                        },
                        component: lazyLoading('user/Create'),
                    },
                    {
                        name: 'update_user',
                        path: 'update/:id',
                        meta: {
                            label: '修改用户信息',
                            link: 'user/Update.vue',
                        },
                        component: lazyLoading('user/Update'),
                    }
                ]
            },
            {
                path: '/access',
                meta: {
                    label: '权限管理',
                },
                component: lazyLoading('access', true),
                children: [
                    {
                        name: 'list_access',
                        path: '',
                        meta: {
                            label: '权限管理',
                            link: 'access/List.vue',
                        },
                        component: lazyLoading('access/List')
                    }
                ]
            }
        ]
    }
]