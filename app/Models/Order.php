<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-8
 * Time: 上午11:11
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_NOT_PAID = 'STATUS_NOT_PAID';
    const STATUS_PAID = 'STATUS_PAID';
    const STATUS_DELIVER = 'STATUS_DELIVER';
    const STATUS_DID_DELIVER = 'STATUS_DID_DELIVER';
    const STATUS_TRADE_FINISH = 'STATUS_TRADE_FINISH';

    protected $table = 'order';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_no',
        'order_address',
        'user_id',
        'order_status',
        'shipping_person',
        'shipping_address',
        'shipping_time',
        'shipping_money',
        'total_price',
        'remark'
    ];

    public function __construct(array $attributes = [])
    {
        if (isset($attributes['order_status']) && !$attributes['order_status']) {
            $attributes['order_status'] = self::STATUS_NOT_PAID;
        }

        parent::__construct($attributes);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getShippingTimeAttribute($value)
    {
        return config('yizao.deliver_time.'.strtolower($value));
    }

}