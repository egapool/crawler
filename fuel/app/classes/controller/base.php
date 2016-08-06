<?php

class Controller_Base extends Controller_Hybrid
{
	public $css = "";
	public $js = "";
	public function before()
	{
		$this->template = "common/template";
		parent::before();
		$this->css .=  Asset::css("style.css");
		$this->js  .=  Asset::js("app.js");
	}

	public function after($response) {
		$response = parent::after($response);

		$this->template->set_safe('css', $this->css);
		$this->template->set_safe('js', $this->js);

		return $response;
	}
}