<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午9:46
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    const TYPE_IMAGE = 'image';
    const TYPE_OTHERS = 'others';

    public static $filetypes = [
        'image'
    ];

    protected $primaryKey = 'files_id';

    protected $table = 'files';

    protected $fillable = [
        'files_type', 'files_name', 'files_path', 'files_path', 'files_disk', 'files_display_path'
    ];

    /**
     * @param $type
     * @return bool
     */
    public static function validateFileTypes($type)
    {
        return in_array($type, self::$filetypes);
    }
}