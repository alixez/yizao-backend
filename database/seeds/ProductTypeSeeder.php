<?php

/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午11:21
 */
class ProductTypeSeeder extends \Illuminate\Database\Seeder
{
    public function run() {
        $data = [
            [
                'type_id' => 1,
                'type_level' => 1,
                'type_name' => '自选',
                'type_slug' => 'zixuan',
            ],
            [
                'type_id' => 2,
                'type_level' => 1,
                'type_name' => '每日套餐',
                'type_slug' => 'taocan_daily',
            ],
            [
                'type_id' => 3,
                'type_level' => 1,
                'type_name' => '每周套餐',
                'type_slug' => 'taocan_per_week',
            ]
        ];

        $otherData = [
            [
                'type_level' => 2,
                'type_name' => '粥',
                'type_slug' => 'zhou',
                'type_parent' => 1,
            ],
            [
                'type_level' => 2,
                'type_name' => '面点',
                'type_slug' => 'miandian',
                'type_parent' => 1,
            ],
            [
                'type_level' => 2,
                'type_name' => '糕点',
                'type_slug' => 'gaodian',
                'type_parent' => 1,
            ],
            [
                'type_level' => 2,
                'type_name' => '蛋',
                'type_slug' => 'dan',
                'type_parent' => 1,
            ],
            [
                'type_level' => 2,
                'type_name' => '油炸',
                'type_slug' => 'youzha',
                'type_parent' => 1,
            ],
            [
                'type_level' => 2,
                'type_name' => '粗粮',
                'type_slug' => 'culiang',
                'type_parent' => 1,
            ],
            [
                'type_level' => 2,
                'type_name' => '豆制品',
                'type_slug' => 'douzhipin',
                'type_parent' => 1,
            ],

        ];

        DB::table('product_types')->insert($data);
        DB::table('product_types')->insert($otherData);
    }
}