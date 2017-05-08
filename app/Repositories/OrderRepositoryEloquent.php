<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-8
 * Time: 上午11:20
 */

namespace App\Repositories;


use App\Models\Order;
use App\Models\User;
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
            ->paginate($limit);
    }

    public function updateStatus($id, $status)
    {
        $allStatus = [
            'STATUS_NOT_PAID',
            'STATUS_PAID',
            'STATUS_DELIVER',
            'STATUS_DID_DELIVER',
            'STATUS_TRADE_FINISH',
        ];
        $status = strtoupper($status);
        if (!in_array($status, $allStatus)) {
            throw new \Exception('不支持的状态');
        }

        return $this->update([
            'order_status' => $status,
        ], $id);
    }

    public function updateDeliver($id, $userID)
    {
//        $user = User::findOne(['id' => $userID]);
//        if (!$user) {
//            throw new \Exception('没有该用户');
//        }

        return $this->update([
            'deliver' => $userID,
        ], $id);
    }
}