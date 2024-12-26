<?php

namespace App\Services;

use App\Contracts\Services\ImgurServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Exception;

class ImgurService implements ImgurServiceInterface
{
    public function uploadImage(UploadedFile $image): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('IMGUR_BEARER_TOKEN')
            ])->post('https://api.imgur.com/3/image', [
                'image' => base64_encode(file_get_contents($image->getRealPath()))
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'link' => $response->json()['data']['link']
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['data']['error'] ?? 'Failed to upload image'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
