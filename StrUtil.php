<?php namespace PHPUtil;

class StrUtil
{
	// 文字コードの詳細取得
	public static function detect_encoding_detail($str)
	{
		$code = mb_detect_encoding($str);

		if(!$code) {
			foreach(array('UTF-8', 'SJIS', 'EUC-JP', 'ASCII', 'JIS', 'SJIS-win') as $_code){
				if(mb_convert_encoding($str, $_code, $_code) == $str){
					$code = $_code;
					break;
				}
			}
		}

		return $code;
	}

	// 文字コードのチェックと変換
	public static function encode_with_detect($str, $toCode="UTF-8")
	{
		$code = StrUtil::detect_encoding_detail($str);
		if($code) {
			$str = mb_convert_encoding($str, $toCode, $code);
		}

		return $str;
	}
}
