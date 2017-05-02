<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 下午4:04
 */

namespace App\Http\Controllers\Product;


use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProduct;
use App\Repositories\ProductRepository;

class CreateProductController extends Controller
{
    private $repository = null;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateProduct $req)
    {
        $data = $req->getBody();

        $product = $this->repository->create($data);

        return response()->json(compact('product'));
    }
}