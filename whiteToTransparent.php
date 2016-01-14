<?php
/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 12. 1. 2016
 * Time: 11:35
 */

$imagePath = __DIR__ . '/imagesOld/segoeprbBlack.png';
$image = imagecreatefrompng($imagePath);
$white = imagecolorallocate($image, 255, 255, 255);

echo $white . PHP_EOL;
echo $bg_color = imagecolorat($image,255,255) . PHP_EOL;

imagesavealpha($image, true);

// Make the background transparent
imagecolortransparent($image, $bg_color);

// Save the image
imagepng($image, __DIR__ . '/imagesNew/segoeprbBlackTransparent.png');
