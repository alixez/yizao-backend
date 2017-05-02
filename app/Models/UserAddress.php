<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-7
 * Time: 下午3:02
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $primaryKey = 'address_id';

    protected $table = 'user_address';

    protected $fillable = [
        'user_id',
        'address_name',
        'address_phone',
        'address_detail',
    ];

    /**
     * User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}