<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 下午6:00
 */

namespace App\Http\Controllers\Product;


use App\Criteria\Product\WithCoverCriteria;
use App\Criteria\Product\WithTypeCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProduct;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getList()
    {
        $this->repository->pushCriteria(WithCoverCriteria::class);
        $this->repository->pushCriteria(WithTypeCriteria::class);
        $list = $this->repository->paginate();

        return response()->json($list);
    }

    public function delete($id)
    {
        if (!$id) return response()->json([
            'error' => 1000,
            'msg' => 'Error attribute',
        ]);
        $this->repository->delete($id);

        return response()->json([
            'msg' => '删除成功',
        ]);
    }

    public function getOne($id) {
        $this->repository->pushCriteria(WithCoverCriteria::class);
        $this->repository->pushCriteria(WithTypeCriteria::class);
        $res = $this->repository->find($id);

        return response()->json([
            'msg' => '查找成功',
            'product' => $res,
        ]);
    }

    public function update(CreateProduct $req, $id)
    {
        $data = $req->getBody();
        $res = null;
        try {
            if ($data) {
                $res = $this->repository->update($data, $id);
            }
            return response()->json([
                'msg' => '更改成功',
                'product' => $res,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 1000,
                'msg' => $e->getMessage()
            ]);
        }

    }
}