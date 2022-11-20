<?php

namespace Saleh\LaravelAppCommon\Helpers;

use Exception;

class BlurHash
{
    public static function make($path): ?string
    {
        if (empty($path)) {
            return null;
        }

        try {
            $image = imagecreatefromstring(file_get_contents($path));
            $width = imagesx($image);
            $height = imagesy($image);

            $max_width = 20;
            if ($width > $max_width) {
                $image = imagescale($image, $max_width);
                $width = imagesx($image);
                $height = imagesy($image);
            }

            $pixels = [];
            for ($y = 0; $y < $height; $y++) {
                $row = [];
                for ($x = 0; $x < $width; $x++) {
                    $index = imagecolorat($image, $x, $y);
                    $colors = imagecolorsforindex($image, $index);

                    $row[] = [
                        $colors['red'],
                        $colors['green'],
                        $colors['blue'],
                    ];
                }
                $pixels[] = $row;
            }

            $components_x = 4;
            $components_y = 3;

            $blurhash = \kornrunner\Blurhash\Blurhash::encode($pixels, $components_x, $components_y);

            return $blurhash;
        } catch (Exception $exception) {
            //
            //dd($exception->getMessage());
        }

        return null;
    }
}
