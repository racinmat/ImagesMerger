<?php
/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 10. 1. 2016
 * Time: 22:34
 */
$images = array (
	0 => 'C:\\wamp\\www\\imagesMerger/imagesOld\\ZELENEJ\\ZELENEJ_doleva-36.png',
	1 => 'C:\\wamp\\www\\imagesMerger/imagesOld\\ZELENEJ\\ZELENEJ_doleva-38.png',
	2 => 'C:\\wamp\\www\\imagesMerger/imagesOld\\ZELENEJ\\ZELENEJ_doleva-40.png',
	3 => 'C:\\wamp\\www\\imagesMerger/imagesOld\\ZELENEJ\\ZELENEJ_doleva-42.png'
);

$numberOfImages = count($images);
$x = 267;
$y = 267;
$background = imagecreatetruecolor($x * $numberOfImages, $y);
if (!$background) {
	die('background not created');
}
imagesavealpha($background, true);

$trans_colour = imagecolorallocatealpha($background, 0, 0, 0, 127);
imagefill($background, 0, 0, $trans_colour);

$outputImage = $background;

$iter = 0;
foreach ($images as $imagePath) {
	$image = imagecreatefrompng($imagePath);
	imagepng($image, __DIR__ . '/imagesNew/' . 'testing' . "/$iter.png");
	imagecopy($outputImage, $image, $x*$iter, 0, 0, 0, $x, $y);
	$iter++;
}

imagepng($outputImage, __DIR__ . '/imagesNew/' . 'testing' . "/doleva-targetCell-part1.png");
