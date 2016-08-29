<?php

class Controller_Base extends Controller_Hybrid
{
	public $user_id = 1;
	public $sleep = 0.5; // sec
	public $css = "";
	public $js = "";

	public function before()
	{
		$session = Session::instance();

		$siteUrl = Input::get('site');
		if ( !is_null($siteUrl) ) {
			$site = Model_Site::fetchSiteByUrl($siteUrl);
			if ( !is_null($site) ) {
				Session::set('site', $site);
			}
		}
		$this->site = Session::get('site');

		$this->template = "common/template";
		parent::before();
		$this->css .=  Asset::css("style.css");
		$this->js  .=  Asset::js("jquery.min.js");
		$this->js  .=  Asset::js("app.js");
	}

	public function after($response) {
		$response = parent::after($response);
		if (Input::is_ajax()) return $response;

		$this->template->set_safe('css', $this->css);
		$this->template->set_safe('js', $this->js);
		$this->template->set_safe('sites', Model_Site::fetchAllSite());

		return $response;
	}
}
