<?php

namespace App\Criteria\ProductType;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ByIdCriteria
 * @package namespace App\Criteria\ProductType;
 */
class ByIdCriteria implements CriteriaInterface
{
    private $id = 0;
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('type_id', $this->id);
    }
}
