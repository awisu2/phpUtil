<?php
include "../FileUtil.php";
include "../Imagemaker.php";

// 画像保存用ディレクトリ作成
if(!FileUtil::create_directory_with_check("img")) {
	exit();
}

// ランダム画像作成ディレクトリ作成
$width = 100;
$height = 100;

$id = imagemaker::makeimagebase($width, $height);
for($i = 0; $i < 100; $i++) {
	$rangeinfo = imagemaker::makerangeinfo(0, 0, $width, $height);
	imagemaker::setbackgroundcolorrand($id, $rangeinfo);
	imagemaker::savefile($id, "img/IMG".$i.".png");
}

imagemaker::imagedestroy($id);

