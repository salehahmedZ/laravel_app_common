<?php

namespace Saleh\LaravelAppCommon\Helpers;

use ColorThief\ColorThief;
use Exception;

class DominantColor
{
    public static function get(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        try {
            $dominantColor = self::colorThief()->getColor($url, 1, outputFormat: 'hex');

            if (! empty($dominantColor)) {
                return str_replace('#', '', $dominantColor);
            } else {
                $dominantColor = self::simple_color_thief($url);
            }
        } catch (Exception $e) {
            return null;
        }

        return $dominantColor;
    }

    //can be url or path or file content

    public static function colorThief(): ColorThief
    {
        return app(ColorThief::class);
    }

    private static function simple_color_thief($img): ?string
    {
        if (@exif_imagetype($img)) {       // CHECK IF IT IS AN IMAGE
            $type = getimagesize($img)[2]; // GET TYPE
            if ($type === 1) { // GIF
                $image = imagecreatefromgif($img);
                // IF IMAGE IS TRANSPARENT (alpha=127) RETURN fff FOR WHITE
                if (imagecolorsforindex($image, imagecolorstotal($image) - 1)['alpha'] == 127) {
                    return 'fff';
                }
            } elseif ($type === 2) { // JPG
                $image = imagecreatefromjpeg($img);
                //dd($image);
            } elseif ($type === 3) { // PNG
                $image = imagecreatefrompng($img);
                // IF IMAGE IS TRANSPARENT (alpha=127) RETURN fff FOR WHITE
                if ((imagecolorat($image, 0, 0) >> 24) & 0x7F === 127) {
                    return 'fff';
                }
            } else { // NO CORRECT IMAGE TYPE (GIF, JPG or PNG)
                return null;
            }
        } else { // NOT AN IMAGE
            return null;
        }
        $newImg = imagecreatetruecolor(1, 1); // FIND DOMINANT COLOR
        imagecopyresampled($newImg, $image, 0, 0, 0, 0, 1, 1, imagesx($image), imagesy($image));

        return dechex(imagecolorat($newImg, 0, 0)); // RETURN HEX COLOR
    }
}
