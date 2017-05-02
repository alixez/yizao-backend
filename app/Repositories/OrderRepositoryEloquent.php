<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-8
 * Time: 上午11:20
 */

namespace App\Repositories;


use App\Models\Order;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    public function model()
    {
        return Order::class;
    }

    /**
     * @param $status
     * @param int $limit
     * @return mixed
     */
    public function getTableDataByStatus($status, $limit = 25)
    {
//        $this->applyConditions([
//            ['order_status', $status]
//        ]);
        $this->applyConditions([
            ['order_status', '=', $status]
        ]);

        return $this->with(['user', 'products'])
            ->paginate($limit)
        ;
    }

}