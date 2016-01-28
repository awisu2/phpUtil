<?php

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
}

