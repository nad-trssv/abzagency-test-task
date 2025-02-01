<?php

namespace App\Services\ImageOptimization;

use Illuminate\Support\Facades\Http;

class TinyPngService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('TINYPNG_API_KEY');
    }

    public function optimizeImage($imagePath)
    {
        \Tinify\setKey($this->apiKey);
        $fullPath = storage_path('app/public/' . $imagePath);

        $source = \Tinify\fromFile($fullPath);
        $resized = $source->resize(array(
            "method" => "cover",
            "width" => 70,
            "height" => 70,
        ));

        $optimizedDir = storage_path('app/public/optimized/users/');
        if (!file_exists($optimizedDir)) {
            mkdir($optimizedDir, 0755, true);
        }

        $optimizedPath = $optimizedDir . '/' . pathinfo($imagePath, PATHINFO_FILENAME) . '.jpg';
        $resized->toFile($optimizedPath);

        return 'optimized/users/' . pathinfo($imagePath, PATHINFO_FILENAME) . '.jpg';
    }
}
