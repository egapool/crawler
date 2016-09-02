<?php

class Service_Crawler
{
	/**
	 * Basic認証ユーザーとパスワード
	 */
	private $basic_user = null;
	private $basic_pawd = null;

	/**
	 * beseURl
	 * @var string
	 */
	private $baseUrl = null;

	public function setBasic($basic_user , $basic_pawd)
	{
		$this->basic_user = $basic_user;
		$this->basic_pawd = $basic_pawd;
		return $this;
	}

	public function setBaseUrl($baseUrl)
	{
		$this->baseUrl = $baseUrl;
		return $this;
	}

	public function crawle($history_id, $urls = [],$options = [])
	{
		$result = [];
		$curl = new Utils_Curl();

		foreach ( $urls as $url ) {
			$fullUrl = $this->baseUrl . $url;
			$res = [];
			$curl->setUrl($fullUrl);

			if ( !is_null($this->basic_user) && !is_null($this->basic_pawd) ) {
				$curl->setBasic($this->basic_user,$this->basic_pawd);
			}

			$curl->fire();

			$responseBody = $curl->getBody();
			$header = Service_Responseparser::getHttpHeader($responseBody);
			$headers = Service_Responseparser::splitHeader($header);
			$res[] = ['url' => $url];
			foreach ( $headers as $key => $v ) {
				$statusCode = Service_Responseparser::getStatusCode($v);
				$location 	= Service_Responseparser::getLocation($v);
				$res[$key]['statusCode'] = $statusCode;
				if ( $location !== "") {
					$res[($key + 1)] = ['url' => $location];
				}
			}

			// scrape
			$scraper = new Utils_Scrape($responseBody);
			$title 		= $scraper->getTitle();
			$h1 		= $scraper->getH1();
			$keywords 	= $scraper->getMeta('Keywords');
			$description = $scraper->getMeta('description');
			$robots 	= $scraper->getMeta('robots');
			$next 		= $scraper->getLink('next');
			$prev 		= $scraper->getLink('prev');
			$canonical 	= $scraper->getLink('canonical');

			$log = [
				'history_id' 	=> $history_id,
				'url1' 			=> isset($res[0]['url']) ? $res[0]['url'] : "",
				'status_code1' 	=> isset($res[0]['statusCode']) ? $res[0]['statusCode'] : "",
				'url2' 			=> isset($res[1]['url']) ? $res[1]['url'] : "",
				'status_code2' 	=> isset($res[1]['statusCode']) ? $res[1]['statusCode'] : "",
				'url3' 			=> isset($res[2]['url']) ? $res[2]['url'] : "",
				'status_code3' 	=> isset($res[2]['statusCode']) ? $res[2]['statusCode'] : "",
				'created_at' 	=> date('Y-m-d H:i:s'),
				'title' 		=> $title,
				'h1' 			=> $h1,
				'keywords' 		=> $keywords,
				'description' 	=> $description,
				'robots' 		=> $robots,
				'next' 			=> $next,
				'prev' 			=> $prev,
				'canonical' 	=> $canonical,
			];
			Service_Responselogger::logging($log);
			// usleep(50000);
		}
		return $result;
	}
}
