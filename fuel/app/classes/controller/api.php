<?php

class Controller_Api extends Controller_Base
{
	public function post_page_search()
	{
		$post = Input::post();
		var_dump($post);die;

		$res = Service_Search::getPages($this->site_id,5,[]);
		var_dump($res);die;
	}
}