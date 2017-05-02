import lazyLoading from './lazyLoading.js'

export default [
    {
        name: 'sales',
        meta: {
            label: '早餐交易',
            icon: 'fa-random',
            expanded: true,
        },
        children: [
            {
                path: '/order',
                meta: {
                    label: '订单管理',
                },
                component: lazyLoading('order', true),
                children: [
                    {
                        name: 'list_order',
                        path: '',
                        meta: {
                            label: '订单管理',
                            link: 'order/List.vue',
                        },
                        component: lazyLoading('order/List'),
                    },
                    {
                        name: 'create_order',
                        path: 'create',
                        meta: {
                            label: '生成订单',
                            link: 'order/Create.vue'
                        },
                        component: lazyLoading('order/Create'),
                    }
                ]
            },
            {
                path: '/distribution',
                meta: {
                    label: '配送中心',
                },
                component: lazyLoading('distribution', true),
                children: [
                    {
                        name: 'list_distribution',
                        path: '',
                        meta: {
                            label: '早餐配送',
                            link: 'distribution/List.vue',
                        },
                        component: lazyLoading('distribution/List')
                    }
                ]
            }
        ]
    }
]