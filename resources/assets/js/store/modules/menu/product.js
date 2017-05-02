import lazyLoading from './lazyLoading.js'

export default [
    {
        name: 'product',
        meta: {
            label: '商品管理',
            icon: 'fa-random',
            expanded: true,
        },
        children: [
            {
                name: 'list_product',
                path: '/product/list',
                meta: {
                    label: '商品列表',
                    link: '/product/List.vue',
                },
                component: lazyLoading('product/List')
            },
            {
                name: 'create_product',
                path: '/product/create',
                meta: {
                    label: '新增商品',
                    link: '/product/Create.vue',
                },
                component: lazyLoading('product/Create')
            },
            {
                name: 'update_product',
                path: '/product/update/:id',
                hidden: true,
                meta: {
                    label: '修改商品',
                    link: '/product/Update.vue',
                },
                component: lazyLoading('product/Update')
            },
        ]
    }
]