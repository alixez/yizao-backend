<?php

namespace App\Criteria\ProductType;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ByLevelAndParentCriteria
 * @package namespace App\Criteria\ProductType;
 */
class ByLevelAndParentCriteria implements CriteriaInterface
{
    private $level = null;
    private $parent = null;
    public function __construct($level, $parent)
    {
        $this->level = $level;
        $this->parent = $parent;
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
        return $model->where([
            ['type_level', '=', $this->level],
            ['type_parent', '=', $this->parent],
        ]);
    }
}
