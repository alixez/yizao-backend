<?php

/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-3-26
 * Time: 下午4:29
 */
class UserTableSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => '超级用户',
                'email' => 'root@itspeed.cn',
                'password' => bcrypt('123456'),
            ],
            [
                'id' => 2,
                'name' => '小新',
                'email' => 'xiaoxin@itspeed.cn',
                'password' => bcrypt('123456'),
            ],
            [
                'id' => 3,
                'name' => '鬼厉',
                'email' => 'guili@itspeed.cn',
                'password' => bcrypt('123456'),
            ]
        ]);

        DB::table('role_user')
            ->insert([
                [
                    'user_id' => 1,
                    'role_id' => 1,
                ],
                [
                    'user_id' => 2,
                    'role_id' => 2,
                ]
            ]);
    }
}