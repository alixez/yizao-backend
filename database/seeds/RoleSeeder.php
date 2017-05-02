<?php

/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-5
 * Time: 下午1:37
 */
class RoleSeeder extends \Illuminate\Database\Seeder
{
    public function allRoles()
    {
        return [
            [
                'id' => 1,
                'name' => 'root',
                'display_name' => '超级用户',
                'description' => '超级管理员，拥有所有权限'
            ],
            [
                'id' => 2,
                'name' => 'admin',
                'display_name' => '管理员',
                'description' => '管理员，可以管理除用户模块外的所有模块'
            ],
            [
                'id' => 3,
                'name' => 'member',
                'display_name' => '会员',
                'description' => '会员'
            ]
        ];
    }

    public function run() {
        DB::table('roles')
            ->insert($this->allRoles())
        ;
    }
}