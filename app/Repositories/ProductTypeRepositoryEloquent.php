<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProductTypeRepository;
use App\Models\ProductType;
use App\Validators\ProductTypeValidator;

/**
 * Class ProductTypeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ProductTypeRepositoryEloquent extends BaseRepository implements ProductTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProductType::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
