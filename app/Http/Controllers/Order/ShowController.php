<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-10
 * Time: 下午1:21
 */

namespace App\Http\Controllers\Order;


use App\Criteria\Order\GetByStatusCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    private $repository;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->repository = $orderRepo;
    }

    public function showTableData(Request $req, $state = 'not_paid')
    {
        $orderStatus = 'STATUS_'.strtoupper($state);

        $limit = $req->get('limit');

        $list = $this->repository->getTableDataByStatus($orderStatus, $limit);
        //dump($orderStatus);
        //dump($list);

        return response()->json($list);
    }


}