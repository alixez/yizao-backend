<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午11:35
 */

namespace App\Foundations;


trait TypeWithChildren
{
    public function toArray()
    {
        $data = parent::toArray();

        if (isset($data['children']) && count($data['children']) == 0) {

            unset($data['children']);
        }
        return $data;
    }
}