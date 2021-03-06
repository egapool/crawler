<?php

class Utils_Curl
{

	/**
	 * curlのハンドル
	 */
	private $ch = null;

	/**
	 * Cookie保存用のリソース
	 * 同一プロセス中は同一リソースを使いまわす
	 */
	private $cookie = null;

	/**
	 * リクエストURL
	 */
	private $url = null;

	/**
	 * POSTデータ
	 */
	private $postData = null;

	/**
	 * Basic認証ユーザーとパスワード
	 */
	private $basicUserAndPass = null;

	/**
	 * HTTPリクエストヘッダー
	 */
	private $httpHeader = [];

	/**
	 * レスポンスの詳細情報
	 */
	private $responseInfo = null;

	/**
	 * レスポンスボディ
	 */
	private $responseBody = null;

	/**
	 * レスポンスエラーテキスト
	 * @see https://curl.haxx.se/libcurl/c/libcurl-errors.html
	 */
	private $error = null;

	/**
	 * error number
	 * @see https://curl.haxx.se/libcurl/c/libcurl-errors.html
	 */
	private $errorNo = null;

	/**
	 * インスタンス生成時にcURLハンドル
	 * インスタンス生成時にCookie用リソース生成
	 */
	public function __construct()
	{
		if ( is_null($this->ch) ) {
			$this->ch = curl_init();
		}

		if ( is_null($this->cookie) ) {
			$this->cookie = tmpfile();
		}
	}

	/**
	 * リクエストURLをセット
	 * @return this Service_Request_Curl
	 */
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * Basic認証情報をセット
	 * @return this Service_Request_Curl
	 */
	public function setBasic($username, $password)
	{
		$this->basicUserAndPass = $username . ":" . $password;
		return $this;
	}

	/**
	 * POSTデータをセット
	 * @return this Service_Request_Curl
	 */
	public function setStringPostData(array $postData)
	{
		$this->postData = http_build_query($postData);
		return $this;
	}

	/**
	 * POSTデータをセット
	 * @return this Service_Request_Curl
	 */
	public function setFilePostData(array $postData)
	{
		$this->postData = $postData;
		return $this;
	}

	public function setHttpHeader(array $httpHeader)
	{
		$this->httpHeader += $httpHeader;
		return $this;
	}

	public function getInfo()
	{
		return $this->responseInfo;
	}

	public function getBody()
	{
		return $this->responseBody;
	}

	public function getError()
	{
		return $this->error;
	}

	public function getErrorNo()
	{
		return $this->errorNo;
	}

	public function getCurlResource()
	{
		return $this->ch;
	}

	public function fire()
	{
		// 転送前に前回のレスポンス内容をリセット
		$this->resetResponses();

		$cookie = stream_get_meta_data($this->cookie)['uri'];

		curl_setopt_array($this->ch, [
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1, // HTTP/1.1 を使用する
			CURLOPT_URL            => $this->url,            // 取得するURL
			CURLOPT_RETURNTRANSFER => true,                  // TRUE を設定すると、curl_exec()の返り値を文字列で返します。
			CURLOPT_HEADER         => true,                  // レスポンスヘッダー情報を取得するか
			CURLOPT_FOLLOWLOCATION => true,                  // リダイレクト先まで追跡するか(通常true推奨か？)
			CURLINFO_HEADER_OUT    => true,                  // リダイレクト先まで追跡するか(通常true推奨か？)
			CURLOPT_MAXREDIRS      => 3,                     // 何回リダイレクトを許すか
			CURLOPT_COOKIEJAR      => $cookie,               // ハンドルを閉じる際、すべての内部クッキーを保存するファイルの名前
			CURLOPT_COOKIEFILE     => $cookie,               // クッキーのデータを保持するファイルの名前
			CURLOPT_TIMEOUT        => 10,                    //
			CURLOPT_CONNECTTIMEOUT => 10,                    //
			// CURLOPT_VERBOSE        => true,                  // 詳細な情報を出力します。情報は STDERR か、または CURLOPT_STDERR で指定したファイルに出力されます
			// CURLOPT_STDERR         => fopen(APPPATH."s3/curl_logs/".date('Ymd'),"a") // ログ吐き出されないなぁ〜
		]);

		if ( !is_null($this->postData) ) {
			// var_dump($this->postData);
			curl_setopt($this->ch, CURLOPT_POSTFIELDS,$this->postData);
			curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST,'POST');
		}

		if ( !is_null($this->basicUserAndPass) ) {
			curl_setopt($this->ch, CURLOPT_USERPWD,$this->basicUserAndPass);
		}

		if ( $this->httpHeader !== [] ) {
			curl_setopt($this->ch, CURLOPT_HTTPHEADER,$this->httpHeader);
		}

		// 何かログ残してもいいかな
		$this->responseBody = curl_exec($this->ch);
		$this->responseInfo = curl_getinfo($this->ch);
		$this->error = curl_error($this->ch);

		// 転送後は転送に使用したオプション等をリセット
		$this->resetSettings();

		return $this;
	}

	public function destroy()
	{
		if ( !is_null($this->ch)) {
			curl_close($this->ch);
		}

		if ( !is_null($this->cookie) ) {
			fclose($this->cookie);
		}
	}

	/**
	 * すべての設定をリセットする
	 * CURLハンドルとcookieリソースはリセットしない
	 */
	private function resetSettings()
	{
		$this->url 				= null;
		$this->postData 		= null;
		$this->basicUserAndPass = null;
		$this->httpHeader 		= [];

		// すべてのオプションをリセットする
		$this->curl_reset($this->ch);
	}

	/**
	 * すべてのレスポンスをリセットする
	 */
	private function resetResponses()
	{
		$this->responseInfo 	= null;
		$this->responseBody		= null;
		$this->error 			= null;
		$this->errorNo 			= null;
	}

	/**
	 * PHP5.4以下のresetHACK
	 * @param
	 * @return
	 * @author egami
	 *
	 **/
	private function curl_reset(&$ch)
	{
		if ( function_exists('curl_reset') ) {
			curl_reset($ch);
		} else {
			 $ch = curl_init();
		}
	}
}