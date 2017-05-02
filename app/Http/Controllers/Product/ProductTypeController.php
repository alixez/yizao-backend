<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午11:54
 */

namespace App\Http\Controllers\Product;


use App\Criteria\ProductType\ByIdCriteria;
use App\Criteria\ProductType\ByLevelAndParentCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\ProductTypeRepository;

class ProductTypeController extends Controller
{


    public function getByLevelAndParent($level = 1, $parent = 0)
    {
        /**
         * @var $typeRepository ProductTypeRepository
         */
        $typeRepository = app(ProductTypeRepository::class);

        $typeRepository->pushCriteria(new ByLevelAndParentCriteria($level, $parent));

        $types = $typeRepository->all();

        return response()->json(compact('types'));
    }

    public function getById($id)
    {
        /**
         * @var $typeRepository ProductTypeRepository
         */
        $typeRepository = app(ProductTypeRepository::class);

        $typeRepository->pushCriteria(new ByIdCriteria($id));

        $types = $typeRepository->all();

        return response()->json(compact('types'));
    }
}