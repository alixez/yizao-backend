<?php

namespace App\Criteria\Order;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class GetByStatusCriteria
 * @package namespace App\Criteria\Order;
 */
class GetByStatusCriteria implements CriteriaInterface
{
    private $status = null;
    public function __construct($status)
    {
        $this->status = $status;
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
        return $model->where('status', $this->status);
    }
}
