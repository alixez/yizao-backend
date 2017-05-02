<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-8
 * Time: 上午11:07
 */

namespace App\Http\Controllers\Order;


use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrUpdateRequest;
use App\Models\Order;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\Response;

class CreateController extends Controller
{
    private $repository = null;
    private $orderProductRepo = null;

    public function __construct(OrderRepository $orderRepository, OrderProductRepository $orderProductRepo)
    {
        $this->repository = $orderRepository;
        $this->orderProductRepo = $orderProductRepo;
    }

    /**
     * 订单创建 [in backend]
     * @param CreateOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function simpleCreate(CreateOrUpdateRequest $request)
    {
        $data = $request->getBody();
        if (!$data['order_no']) {
            $data['order_no'] = 'YZ'.Carbon::now()->format('YmdHis').rand(0,9);
        }
        $totalPrice = 0;
        $data['order_status'] = Order::STATUS_NOT_PAID;
        $data['total_price'] = $totalPrice;
        $products = $request->get('products');
        $order = $this->repository->create($data);


        foreach ($products as $product) {
            $productData = [
                'order_id' => $order->order_id,
                'product_id' => $product['prod_id'],
                'product_name' => $product['prod_title'],
                'product_cover' => $product['prod_cover_id'],
                'product_price' => (int) $product['prod_price'],
                'product_total_price' => (int) $product['prod_price'] * (int) $product['prod_count'],
                'product_count' => (int) $product['prod_count'],
            ];

            $totalPrice = $totalPrice + (int) $productData['product_total_price'];
            $this->orderProductRepo->create($productData);
        }

        $order->total_price = $totalPrice + $order->shipping_money;
        $order->save();

        return response()->json([
            'msg' => '创建成功',
            'order' => $order,
        ]);
    }
}