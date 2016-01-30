<?php
include "../TextConverter.php";
include "../FileUtil.php";

use PhpUtil\FileUtil;
use PhpUtil\TextConverter;

function webGetAndWrite($url, $path, &$contents)
{
	// ディレクトリ作成
	if(!FileUtil::create_directory_with_check(dirname($path))) {
		echo "can't create Directory";
		exit();
	}
	
	//// 存在確認とウェブからの値取得
	$callback = file_get_contents;
	$callbackParams = array($url);
	$ret = FileUtil::FileReadOrExecute($path, $callback, $callbackParams, $contents);
	if(!$ret) {
		return false;
	}

	return true;
}

// 分析してファイル保存
function inspectAndWrite($text, $patterns, $path, &$matches)
{
	$converter = new TextConverter($text);
	$matches = array();
	foreach($patterns as $pattern) {
		$matches[] = $converter->match_all($pattern);
	}

	// ファイルに保存
	$ret = FileUtil::save($path, serialize($matches));
	if(!$ret) {
		return false;
	}

	return true;
}

// start
$saveDir = "www";
$testFile = $saveDir . "/" . "yahoo.html";
$url = "http://news.yahoo.co.jp/";

// ウェブから値取得(原型の保存)
$ret = webGetAndWrite($url, $testFile, $contents);
if(!$ret) {
	echo "webからの取得に失敗しました";
	exit();
}

// patternの取得
$patternFile = $saveDir . "/" . "pattern";
$patterns = array();
if(file_exists($patternFile)) {
	$serial = file_get_contents($patternFile);
	$patterns = unserialize($serial);
} else {
	echo "test:patternが保存されたファイルが見つからなかったので作成します". "\n";
	$patterns = array(
		'<{%} class="ttl"><a href="{%}" onmousedown="this.href='."'".'{%}'."'".'">{%}</a></{%}>',
	);
	FileUtil::save($patternFile, serialize($patterns));
}

// 分析して、値を取得(一次分析結果の保存)
$convertFile = $saveDir . "/" . "convert";
$ret = inspectAndWrite($contents, $patterns, $convertFile, $matches);
if(!$ret && count($matches) == 0) {
	echo "分析に失敗しました";
	exit();
}

// 出力
foreach($matches[0] as $match) {
	echo $match[4] . "\n";
}


