<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Product extends Model implements Transformable
{
    use TransformableTrait;
    protected $table = 'product';
    protected $primaryKey = 'prod_id';
    protected $fillable = [
        'prod_cover_id',
        'prod_type_id',
        'prod_title',
        'prod_body',
        'prod_desc',
        'prod_price',
    ];

    public function cover()
    {
        return $this->belongsTo(File::class, 'prod_cover_id', 'files_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'prod_type_id', 'type_id');
    }

//    public function toArray()
//    {
//        $row =  parent::toArray();
//        $row['prod_price'] = $row['prod_price'] / 100;
//        return $row;
//    }
}
