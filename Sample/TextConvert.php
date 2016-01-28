<?php
include "../TextConverter/TextConverter.php";
include "../FileUtil/FileUtil.php";

$saveDir = "www";

$testFile = $saveDir . "/" . "yahoo.html";
$convertFile = $saveDir . "/" . "convert";

// ディレクトリ作成
if(!FileUtil::create_directory_with_check($saveDir)) {
	echo "can't create Directory";
	exit();
}

//// 存在確認とウェブからの値取得
$callback = file_get_contents;
$params = array("http://news.yahoo.co.jp/");

// TODO:リトライ処理
FileUtil::FileReadOrExecute($testFile, $callback, $params, $contents);

// 分析して、値を取得
// TODO:ここを入れ子にしたり複数回実行させたりしたい
$converter = new PHPUtil\TextConverter($contents);
$patterns = array(
	'<{%} class="ttl"><a href="{%}" onmousedown="this.href='."'".'{%}'."'".'">{%}</a></{%}>',
);
$matches = array();
foreach($patterns as $pattern) {
	$matches[] = $converter->match_all($pattern);
}

// カスタムして出力
FileUtil::save($convertFile, serialize($matches[0]));
var_dump($matches[0]);


foreach($matches[0] as $match) {
	echo $match[4] . "\n";
}


