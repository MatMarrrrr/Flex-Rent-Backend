<?php

namespace App\Contracts\Services;

use Illuminate\Http\UploadedFile;

interface ImgurServiceInterface
{
    /**
     * Upload an image to Imgur.
     *
     * @param UploadedFile $image
     * @return array
     */
    public function uploadImage(UploadedFile $image): array;
}
