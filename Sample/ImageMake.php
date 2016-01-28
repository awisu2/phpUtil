<?php
include "ImageMaker.php";

$width = 100;
$height = 100;

$id = ImageMaker::MakeImageBase($width, $height);
for($i = 0; $i < 100; $i++) {
	$rangeInfo = ImageMaker::MakeRangeInfo(0, 0, $width, $height);
	ImageMaker::SetBackgroundColorRand($id, $rangeInfo);
	ImageMaker::SaveFile($id, "img/image".$i.".png");
}

ImageMaker::ImageDestroy($id);
