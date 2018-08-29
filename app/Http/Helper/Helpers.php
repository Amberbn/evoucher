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

function sqlDateFormat($date, $withTime = false)
{
    $formatTime = '';
    if ($withTime) {
        $formatTime = ' H:i:s';
    }
    $parseDate = date_create($date);
    return date_format($parseDate, 'd/m/Y' . $formatTime);
}

function formatRupiah($moneyInput)
{
    // $replaceZero = str_replace('.0000', '', $moneyInput);
    $moneyOutput = number_format($moneyInput, 2, ',', '.');
    return $moneyOutput;
}
