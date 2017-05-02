<?php
/**
 * Created by PhpStorm.
 * User: alixez
 * Date: 17-4-4
 * Time: 上午9:45
 */

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class BaseController extends Controller
{
    /**
     * @var string
     */
    protected $filesystem;

    /**
     * @var string;
     */
    protected $disk;

    /**
     * @var string
     */
    protected $directory = '';

    /**
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    protected $storage;

    /**
     * @var string
     */
    protected $fullpath = 'default/';

    protected $filename = '';

    public function __construct()
    {
        $this->filesystem = config('filesystems.default');

        if ($this->filesystem === 'local') {
            $this->disk = 'local';
            $this->directory = '';
        }

        if ($this->filesystem === 'public') {
            $this->disk = 'public';
            $this->directory = 'public/';
        }
        $this->filename = Str::random(20);
        $this->storage = \Storage::disk($this->disk);
    }
}