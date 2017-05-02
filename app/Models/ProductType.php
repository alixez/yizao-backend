<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午11:29
 */

namespace App\Models;


use App\Foundations\TypeWithChildren;
use App\Models\Scopes\TypeWithChildrenScope;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use TypeWithChildren;
    protected $table = 'product_types';
    protected $primaryKey = 'type_id';

    protected $fillable = [
        'level',
        'type_name',
        'type_slug',
        'type_parent',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        static::addGlobalScope(new TypeWithChildrenScope());
        parent::boot();
    }

    public function children()
    {
        return $this->hasMany(ProductType::class, 'type_parent', 'type_id');
    }
}