<?php namespace PHPUtil;

class TextConverter
{
	private $text;
	private $other;

	const PATTERN_ANY = '{%}';
	
	public function __construct($text)
	{
		$this->text = $text;
	}

	// 特定の文字列をエイリアスとして扱いmatcheパターンを返却
	public function match_all($pattern, $offset=0, $option = "sU")
	{
		// メソッド用のパターン作成
		$p = $pattern;
		$p = preg_quote($p);
		$quote_any = preg_quote(self::PATTERN_ANY);
		$p = str_replace($quote_any, '(.*\n*)', $p);
		$p = "|" . $p . "|" . $option;

		// マッチング
		$matches = array();
		preg_match_all($p, $this->text, $matches, PREG_SET_ORDER, $offset);

		// マッチ情報
		return $matches;
	}
}
