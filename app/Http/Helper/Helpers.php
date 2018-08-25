<?php
use Illuminate\Support\Facades\File;

function getImage($image, $folder, $type)
{
    $folderType = ($type == 'original' ? 'original' : 'thumbnail');

    $path = 'storage/' . $folder . '/' . $folderType;
    $filePath = $path . '/' . $image;

    $imageUrl = null;

    if (!File::exists($filePath)) {
        $imageUrl = asset("assets/img/noimage.png");
    } else {
        $imageUrl = asset($filePath);
    }
    return $imageUrl;
}
