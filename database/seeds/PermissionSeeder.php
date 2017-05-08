<?php

/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-5
 * Time: 下午1:37
 */
class PermissionSeeder extends \Illuminate\Database\Seeder
{
    public function getAllPermissions()
    {
        return [
            [
                'name' => 'product.create',
                'display_name' => '新增商品',
                'description' => '创建新的商品',
            ],
            [
                'name' => 'product.update',
                'display_name' => '更新商品',
                'description' => '编辑商品',
            ],
            [
                'name' => 'product.remove',
                'display_name' => '删除商品',
                'description' => '删除一个商品',
            ],
            [
                'name' => 'product.read',
                'display_name' => '查看商品',
                'description' => '查看商品信息',
            ]
        ];
    }

    public function run()
    {
        DB::table('permissions')->insert($this->getAllPermissions());
    }
}