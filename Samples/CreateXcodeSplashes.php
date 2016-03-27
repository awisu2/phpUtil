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
    "MobileSplashScreen" => array(320, 480),
    "iPhone3.5\"Retina" => array(640, 960),
    "iPhone4\"Retina" => array(640, 1136),
    "iPhone4.7\"Retina" => array(750, 1334),
    "iPhone5.5\"Retina" => array(1242, 2208),
    "iPad" => array(768, 1024),
    "iPadRetina" => array(1536, 2048),
);

foreach($sizes as $filename => $size )
{
    $x = $size[0];
    $y = $size[1];
    
    // portal
    $customId = ImageMaker::changeSize($id, $x, $y);
    ImageMaker::savefile($customId, $dir . "/" . $filename . "_portal_" . $x . "_" . $y . ".png");
    ImageMaker::imagedestroy($customId);

    // landscape
    $customId = ImageMaker::changeSize($id, $y, $x);
    ImageMaker::savefile($customId, $dir . "/" . $filename . "_landscape_" . $y . "_" . $x . ".png");
    ImageMaker::imagedestroy($customId);
}

ImageMaker::imagedestroy($id);

