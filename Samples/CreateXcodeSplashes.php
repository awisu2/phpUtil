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

// pathの情報を取得
$pathinfo = pathinfo($filePath);
$filename = $pathinfo['filename'];
$extension = $pathinfo['extension'];

// 画像保存用ディレクトリ作成
$dir = "xcodeImage";
if(!FileUtil::create_directory_with_check($dir)) {
	exit();
}

// pngからオブジェクト取得
$id;
switch ($extension) {
    case 'png':
    {
        echo "set extension png" . "`\n";
        $id = ImageMaker::MakeImageBaseFromPng($filePath);
        break;
    }
    case 'jpg':
    case 'jpeg':
    {
        echo "set extension jpeg" . "\n";
        $id = ImageMaker::MakeImageBaseFromJpg($filePath);
        break;
    }
    default:
    {
        echo "Error : can't type " . $extension;
        return;
    }
}

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

$i = 0;
foreach($sizes as $fileType => $size )
{
    $x = $size[0];
    $y = $size[1];

    // portal
    $customId = ImageMaker::changeSize($id, $x, $y, IMG_BICUBIC_FIXED);
    $name = $fileType . "_portal_" . $x . "_" . $y. "." . $extension;
    // ImageMaker::writeText($customId, 100, ($x / 2) - 100, ($y / 2) - 10, $name, 255, 0, 0);
    ImageMaker::savefile($customId, $dir . "/" . $name);
    echo "saved : " . $name . "\n";
    ImageMaker::imagedestroy($customId);

    // landscape
    $customId = ImageMaker::changeSize($id, $y, $x, IMG_BICUBIC_FIXED);
    $name = $fileType . "_landscape_" . $y . "_" . $x . "." . $extension;
    // ImageMaker::writeText($customId, 100, ($y / 2) - 100, ($x / 2) - 10, $name, 255, 0, 0);
    ImageMaker::savefile($customId, $dir . "/" . $name);
    echo "saved : " . $name . "\n";
    ImageMaker::imagedestroy($customId);
}

ImageMaker::imagedestroy($id);
echo "executed " . $argv[0] . "\n";
