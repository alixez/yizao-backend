<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-8
 * Time: 下午2:23
 */

namespace App\Repositories;


use App\Models\OrderProduct;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderProductRepositoryEloquent extends BaseRepository implements OrderProductRepository
{
    public function model()
    {
        return OrderProduct::class;
    }

}