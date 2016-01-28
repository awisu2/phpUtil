<?php
class ImageMaker
{
	const TYPE_PNG = 1;

	public static function MakeSimpleImage($width, $height, $bgColorInfo = null) 
	{
		$id = self::MakeImageBase($width, $height);
		
		// 背景色設定
		if(!self::SetBackgroundColor($id, $bgColorInfo)) {
			return null;
		}

		return $id;
	}

	// ベースオブジェクトの作成
	public static function MakeImageBase($width, $height)
	{
		return imagecreatetruecolor($width, $height);
	}

	// 画像情報
	public static function MakeColorInfo($red = 0, $green = 0, $blue = 0)
	{
		$color = array();
		$color["red"]   = $red;
		$color["green"] = $green;
		$color["blue"]  = $blue;

		return $color;
	}

	// 画像情報
	public static function MakeColorInfoRand($min = 0, $max = 255)
	{
		$red   = mt_rand($min, $max);
		$green = mt_rand($min, $max);
		$blue  = mt_rand($min, $max);

		return self::MakeColorInfo($red, $green, $blue);
	}

	// 範囲情報取得
	public static function MakeRangeInfo($x=0, $y=0, $width=0, $height=0)
	{
		$rangeInfo = array(
			"x" => $x,
			"y" => $y,
			"x2" => $x + $width,
			"y2" => $y + $height,
		);
		return $rangeInfo;
	}

	// 色オブジェクト取得
	public static function SetColor($id, $colorInfo = null)
	{
		if(!$colorInfo) {
			$colorInfo = self::MakeColorInfo();
		}
		return imagecolorallocate($id, $colorInfo["red"], $colorInfo["green"], $colorInfo["blue"]);
	}

	// 背景色セット
	public static function SetBackgroundColor($id, $rangeInfo = null, $colorInfo = null)
	{
		if(!$rangeInfo) {
			$rangeInfo = self::MakeRangeInfo();
		}
		
		if(!$colorInfo) {
			$colorInfo = self::MakeColorInfo();
		}
		$color = self::SetColor($id, $colorInfo);

		return imagefilledrectangle($id, $rangeInfo["x"], $rangeInfo["y"], $rangeInfo["x2"], $rangeInfo["y2"], $color);
	}

	// ファイル保存
	public static function SaveFile($id, $file="IMG.png", $type = self::TYPE_PNG)
	{
		$ret = false;
		
		switch($type) {
		case self::TYPE_PNG:
			$ret = imagepng($id, $file);
			break;
		}

		return $ret;
	}

	// ランダム色をセット
	public static function SetBackgroundColorRand($id, $rangeInfo)
	{
		for ($x=$rangeInfo["x"]; $x <= $rangeInfo["x2"]; $x++) {
			for ($y=$rangeInfo["y"]; $y <= $rangeInfo["y2"]; $y++) {
				$cInfo = ImageMaker::MakeColorInfoRand();
				$rInfo = ImageMaker::MakeRangeInfo($x, $y, 0, 0);
				$ret = self::SetBackgroundColor($id, $rInfo, $cInfo);
				if(!$ret) return false;
			}
		}
		return true;
	}

	// 画像インスタンス削除
	public static function ImageDestroy($id)
	{
		imagedestroy($id);
	}
}



