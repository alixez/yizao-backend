<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午10:02
 */

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
class ShowFileController extends BaseController
{
    public function getFile(Request $req, $type, $file)
    {
        // 判断是否根据id获取相应图片
        if (!is_numeric($file)) {
            $filePath = str_replace('_', '/', $file);
        } else {
            $f = File::find($file);
            if (!$f) return response('Not found');
            $filePath = $f->files_path;
        }

        if (!$this->storage->exists($filePath)) {
            echo $filePath;
            return response('Not found');
        }

        if ($type === File::TYPE_IMAGE) {
            return response()->file(storage_path('app/'.$this->directory.$filePath));
        }

        return response()->download(storage_path('app/'.$this->directory.$filePath));
    }
}