<?php
/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 10. 1. 2016
 * Time: 15:29
 */

require_once 'vendor/autoload.php';

use \Nette\Utils\Finder;
use \Nette\Utils\Strings;

$directions = ['nahoru' => true, 'dolù' => false, 'doleva' => true, 'doprava' => false];  //true øíká, zda je cílová buòka sudá

/** @var \SplFileInfo $colorDirectory */
foreach (Finder::findDirectories('*')->from(__DIR__ . '/imagesOld') as $colorDirectory) {
	\Nette\Utils\FileSystem::createDir(__DIR__ . '/imagesNew/' . $colorDirectory->getBasename());

	$directionImages = [];
	$directionImages['startCell'] = [];
	$startCellImages = [];
	$directionImages['targetCell'] = [];
	$targetCellImages = [];
	foreach (array_keys($directions) as $direction) {
		$directionImages['startCell'][$direction] = [];
		$directionImages['targetCell'][$direction] = [];
	}

	/** @var \SplFileInfo $image */
	foreach (Finder::find('*')->from($colorDirectory->getPathname()) as $image) {
//		echo $image->getPathname() . PHP_EOL;
		foreach ($directions as $direction => $isTargetEven) {
			//rozlišení smìru
			if (Strings::contains($image->getBasename(), $direction)) {
//				echo $direction . PHP_EOL;
				$matched = Strings::match($image->getBasename(), "~$direction-(\\d+)~");
				$number = $matched[1];
//				echo $matched[0] . PHP_EOL;
//				echo implode(', ', $matched) . PHP_EOL;
				$isEven = $number % 2 == 0;
				if ($isEven == $isTargetEven) { //sudé èíslo, cílová buòka
					$directionImages['targetCell'][$direction][] = $image->getPathname();
				} else {    //liché èíslo, poèáteèní buòka
					$directionImages['startCell'][$direction][] = $image->getPathname();
				}
				break;
			}
		}
	}

	processImagesInOneDirection('startCell', $directionImages['startCell'], $colorDirectory);
	processImagesInOneDirection('targetCell', $directionImages['targetCell'], $colorDirectory);

}

function processImagesInOneDirection($name, $array, \SplFileInfo $colorDirectory) {

	/**
	 * @var string $direction
	 * @var string[] $oneDirectionImages
	 */
	foreach ($array as $direction => $oneDirectionImages) {
		mergeImages($name, $direction, array_slice($oneDirectionImages, 0, 4) , $colorDirectory, '-part1');
		mergeImages($name, $direction, array_slice($oneDirectionImages, 4, 4) , $colorDirectory, '-part2');
		mergeImages($name, $direction, $oneDirectionImages , $colorDirectory, '');
	}

}

function mergeImages($name, $direction, array $oneDirectionImages, \SplFileInfo $colorDirectory, $suffix) {
	$numberOfImages = count($oneDirectionImages);
	$x = 267;
	$y = 267;
	$space = 1;
	$background = imagecreatetruecolor($x * $numberOfImages + $space * ($numberOfImages - 1), $y);
	if (!$background) {
		die('background not created');
	}
	imagesavealpha($background, true);

	$trans_colour = imagecolorallocatealpha($background, 0, 0, 0, 127);
	imagefill($background, 0, 0, $trans_colour);

	$outputImage = $background;

	$iter = 0;
	foreach ($oneDirectionImages as $imagePath) {
		$image = imagecreatefrompng($imagePath);
		imagecopy($outputImage, $image, $x * $iter + $iter * $space, 0, 0, 0, $x, $y);
		$iter++;
	}

	imagepng($outputImage, __DIR__ . '/imagesNew/' . $colorDirectory->getBasename() . "/$direction-$name$suffix.png");


}