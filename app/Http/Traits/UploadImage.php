<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;



trait UploadImage
{
    /**
     * Allowed File Extentions array
     *
     * @var array
     */

    protected $allowedFileExtentions = [
        'png',
        'jpg',
        'gif'
    ];

    /**
     * Upload image to S3 Bucket
     * Return image path
     *
     * @param  collecition $file
     * @param  string $folder
     * @return string
     */

    public function upload($file, $folder, $method = 'input')
    {

        if ($method == 'input') {
            if (!$this->isAllowedFile($file)) {
                return redirect()->back();
            }
            $name = str_random(255) . '.' . $file->getClientOriginalExtension();
            Storage::disk('s3')->put($this->buildFilePath($name, $folder), file_get_contents($file->getRealPath()));
        }
        
        if ($method == 'base64') {
            $name = str_random(255) . '.' . pathinfo($file['filename'], PATHINFO_EXTENSION);
            Storage::disk('s3')->put($this->buildFilePath($name, $folder), Image::make(base64_decode($file['base64']))->stream()->__toString());
        }

        
        if ($this->isImageExists($name, $folder)) {
            return $this->buildAbsoluteFilePath($name, $folder);
        }

    }

    /**
     * Check if file extention is allowed.
     *
     * @param  Symfony\Component\HttpFoundation\File\UploadedFile  $file
     * @return boolen
     */
    protected function isAllowedFile(UploadedFile $file)
    {
        return in_array($file->getClientOriginalExtension(), $this->allowedFileExtentions);
    }

    /**
     * Return S3 bucket file path
     *
     * @param string $name
     * @return string
     */
    protected function buildFilePath($name, $folder)
    {
        // return 'business/' . $name;
        return $folder . '/' . $name;
    }

    /**
     * Check if the file Exists in the S3 bucket
     *
     * @param  string $name
     * @return boolen
     */
    protected function isImageExists($name, $folder)
    {
        return Storage::disk('s3')->exists($this->buildFilePath($name, $folder));
    }

    /**
     * Build and return the abusolute image path
     *
     * @param  string $name
     * @return string Url Of Uploaded Image
     */

    protected function buildAbsoluteFilePath($name, $folder)
    {
        return 'https://s3-us-west-2.amazonaws.com/zeal.com/' . $this->buildFilePath($name, $folder);
    }
}
