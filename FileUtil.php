<?php namespace PHPUtil;

class FileUtil {

	// 存在確認と同時にディレクトリを作成する
	public static function create_directory_with_check($path, $permission=0777)
	{
		if(file_exists($path)) {
			if(is_dir($path)) {
				return true;
			}
			return false;
		}

		return mkdir($path, $permission, true);
	}

	// 存在確認をし、存在しなければdelegateメソッドの結果を利用し保存
	// TODO:保存してからの時間をチェックして再取得など
	public static function FileReadOrExecute($path, callable $callback, $params, &$contents)
	{
		if(file_exists($path)) {
			$contents = file_get_contents($path);
		
		} else {
			$contents = call_user_func_array($callback, $params);
			if(!$contents) {
				echo "callbackの呼び出しに失敗しました";
				return false;
			}

			if(!self::save($path, $contents)) {
				return false;
			}
		}

		return true;
	}

	// 保存
	public static function save($path, $val)
	{
		$ret = file_put_contents($path, $val);
		if(!$ret)
		{
			echo "ファイル書き込みに失敗しました";
			return false;
		}
		return true;
	}
}

