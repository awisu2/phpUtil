<?php
include "../FileUtil.php";
include "../Imagemaker.php";

use PhpUtil\FileUtil;

// 引数確認
echo "execute " . $argv[0] . "\n";
if(count($argv) <= 1)
{
    echo "stop : no arg" . "\n";
    return;
}

// ファイル存在確認
$filePath = $argv[1];
if(file_exists($filePath) == false)
{
    echo "stop : no exists file" . "\n";
    return;
}

// 画像保存用ディレクトリ作成
$dir = "xcodeImage";
if(!FileUtil::create_directory_with_check($dir)) {
	exit();
}

// pngからオブジェクト取得
$id = ImageMaker::MakeImageBaseFromPng($filePath);

// 保存(portal)
$sizes = array(
    "icon180" => array(180, 180),
    "icon152" => array(152, 152),
    "icon144" => array(144, 144),
    "icon120" => array(120, 120),
    "icon114" => array(114, 114),
    "icon76" => array(76, 76),
    "icon72" => array(72, 72),
    "icon57" => array(57, 57),
);

foreach($sizes as $filename => $size )
{
    $x = $size[0];
    $y = $size[1];
    
    // portal
    $customId = ImageMaker::changeSize($id, $x, $y, IMG_BICUBIC_FIXED);
    ImageMaker::savefile($customId, $dir . "/" . "icon" . $x . "_" . $y . ".png");
    ImageMaker::imagedestroy($customId);
}

ImageMaker::imagedestroy($id);

