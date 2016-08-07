<?php

class Controller_Base extends Controller_Hybrid
{
	public $site_id = 1;
	public $sleep = 0.5; // sec
	public $css = "";
	public $js = "";
	public function before()
	{
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

		return $response;
	}
}