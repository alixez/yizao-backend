<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午9:50
 */
namespace App\Http\Controllers\File;

use App\Foundations\File\FileUploader;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class UploadController extends BaseController
{
    use FileUploader;

    public function upload(Request $req, $type, $disk = 'default', $width = 1000, $height = null)
    {
        if ('default' === $disk) {
            $disk = config('filesystems.default');
        }
        $this->disk = $disk;

        $uploadedFile = $req->file('file');
        $this->fullpath = date('Ym').'/'.$this->filename.'.'.$uploadedFile->getClientOriginalExtension();
        if ($type === File::TYPE_IMAGE) {
            $file = $this->simpleExecuteImage($uploadedFile, $width, $height, true);
        } else {
            $file = $uploadedFile;
        }
        if ($this->storage->put($this->fullpath, $file)) {
            $status = trans('file.image.upload_success');
        } else {
            $status = trans('file.upload_unknown_error');
        }

        $newFile = File::create([
            'files_type' => $type,
            'files_name' => $this->filename.$uploadedFile->getClientOriginalExtension(),
            'files_path' => $this->fullpath,
            'files_disk' => $this->disk,
            'files_display_path' => route('files.get_file', [
                'type' => $type,
                'file' => str_replace('/', '_', $this->fullpath),
            ]),
        ]);

        if ($req->expectsJson() || $req->acceptsJson()) {
            return response()->json([
                'msg' => $status,
                'file_path' => $newFile->files_display_path,
                'file_id' => $newFile->files_id,
            ]);
        }

        return response($status);
    }
}