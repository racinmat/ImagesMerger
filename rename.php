<?php
/**
 * Created by PhpStorm.
 * User: Azathoth
 * Date: 11. 1. 2016
 * Time: 15:30
 */

require_once 'vendor/autoload.php';

use \Nette\Utils\Finder;
use \Nette\Utils\Strings;

/** @var \SplFileInfo $file */
foreach (Finder::findFiles('dol�*')->from(__DIR__ . '/imagesNew') as $file) {
	echo $file->getBasename() . PHP_EOL;
	\Nette\Utils\FileSystem::rename($file->getPathname(), Strings::replace($file->getPathname(), '~�~', 'u'));
}

$translateColors = ['FIALOV�' => 'violet', 'ZELENEJ' => 'green', 'MODREJ' => 'blue', '�ERVEN�' => 'red', '�ERNEJ' => 'black'];

foreach ($translateColors as $czech => $english) {
	/** @var \SplFileInfo $file */
	foreach (Finder::findDirectories("$czech*")->from(__DIR__ . '/imagesNew') as $file) {
		echo $file->getBasename() . PHP_EOL;
		\Nette\Utils\FileSystem::rename($file->getPathname(), Strings::replace($file->getPathname(), "~$czech~", $english));
	}
}
