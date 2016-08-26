<?php

class Service_Responseparser
{
	/**
	 * httpレスポンスボディからヘッダーを抜き出す
	 * @param string $response
	 * @return string http header
	 * @author egami
	 *
	 **/
	static public function getHttpHeader($response)
	{
		$res = '';
		$pos = strpos($response,"\n\n") - 2;
		$res = substr($response,0,$pos);
		return $res;
	}

	/**
	 * リダイレクトのヘッダーを分割する
	 * @param  string $header http response header
	 * @return array
	 * @author egami
	 */
	static public function splitHeader($header)
	{
		$output = [];
		$res = explode("\n", $header);
		$t = '';
		$res[] = '';
		foreach ( $res as $line ) {
			$line = trim($line);
			$t .= $line . "\n";
			if ( $line == "" ) {
				$output[] = trim($t);
				$t = '';
			}
		}
		// var_dump($output);die;
		return $output;
	}

	/**
	 * httprespponseheaderからステータスコードを取得
	 * @param  [string] $header http response header
	 * @return [atring]
	 * @author egami
	 */
	static public function getStatusCode($header)
	{
		$firstLine = explode("\n",$header)[0];
		if ( mb_strpos($firstLine, "HTTP/") !== 0 ) {
			return "";
		}

		preg_match("#HTTP/(1\.1|2) ([1-5][0-9]{2}) .+#",$firstLine,$matches);

		if ( !preg_match("/[1-5][0-9]{2}/", $matches[2]) ) {
			return "";
		}

		return $matches[2];
	}

	/**
	 * http response header からLocationを取得
	 * @param  string $header http response header
	 * @return string
	 * @author egami
	 */
	static public function getLocation($header)
	{
		$lines = explode("\n", $header);
		foreach ( $lines as $line ) {
			if ( preg_match("/^Location: (.+)/", $line, $matches) ) {
				return trim($matches[1]);
			}
		}
		return "";
	}
}
