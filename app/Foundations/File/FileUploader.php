<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午9:52
 */
namespace App\Foundations\File;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
trait FileUploader
{
    public function getFullPath()
    {

    }

    public function simpleExecuteImage(UploadedFile $file, $width = 600, $height = null, $changeCanvas = false)
    {
        $image = \Image::make($file);
        $image->resize($width, $height, function (Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        if ($changeCanvas) {
            $image->resizeCanvas($width, $height, 'center', false);
        }

        $image->encode($file->getClientOriginalExtension(), 75);

        return $image;
    }
}