<?php
include "../FileUtil.php";
include "../Imagemaker.php";

use PhpUtil\FileUtil;

// 画像保存用ディレクトリ作成
if(!FileUtil::create_directory_with_check("img")) {
	exit();
}

// ランダム画像作成ディレクトリ作成
$width = 100;
$height = 100;

$id = ImageMaker::makeimagebase($width, $height);
$colorInfo = ImageMaker::MakeColorInfo(255, 255, 255);
$rangeInfo = ImageMaker::makerangeinfo(0, 0, $width, $height);
$font = 'arial.ttf';
for($i = 0; $i < 100; $i++) {
	ImageMaker::setbackgroundcolorrand($id, $rangeInfo);
	ImageMaker::SetLine($id, $rangeInfo, $colorInfo);

	// 保存
	ImageMaker::savefile($id, "img/IMG".$i.".png");
}

ImageMaker::imagedestroy($id);

