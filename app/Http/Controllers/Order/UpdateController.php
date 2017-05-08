<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-10
 * Time: 下午3:05
 */

namespace App\Http\Controllers\Order;


use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;

class UpdateController extends Controller
{
    protected $orderRepo = null;
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function setStatus($orderID, $orderStatus)
    {
        $statusPermissionMap = [
            'STATUS_NOT_PAID' => 'order.update_not_paid',
            'STATUS_PAID' => 'order.update_paid',
            'STATUS_DELIVER' => 'order.update_deliver',
            'STATUS_DID_DELIVER' => 'order.update_did_deliver',
            'STATUS_TRADE_FINISH' => 'order.trade_finish',
        ];

        $this->authorizeBetter($statusPermissionMap[$orderStatus]);
        $order = $this->orderRepo->updateStatus($orderID, $orderStatus);

        return response()->json([
            'code' => 1,
            'message' => '订单状态修改成功',
            'order' => $order,
        ]);
    }

    /**
     * @param $orderID
     * @param $userID
     * @return \Illuminate\Http\JsonResponse
     */
    public function setDeliver($orderID, $userID)
    {
        $this->authorizeBetter('order.update_deliver');

        $updatedOrder = $this->orderRepo->updateDeliver($orderID, $userID);

        return response()->json([
            'code' => 1,
            'message' => '制定配送人成功',
            'order' => $updatedOrder
        ]);
    }
}