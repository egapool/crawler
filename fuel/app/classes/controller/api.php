<?php

class Controller_Api extends Controller_Base
{
	public function post_search_page()
	{
		$res = [
			"ok" => true,
		];
		$post = Input::post();
		$priority = null;
		$tags = [];
		if (isset($post['priority']) && $post['priority'] !== null && $post['priority'] !== "") {
			$priority = $post['priority'];
		}
		if ( isset($post['tags']) && is_array($post['tags']) && count($post['tags']) > 0 ) {
			$tags = $post['tags'];
		}

		$res['page'] = Service_Search::getPages($this->site_id,$priority,$tags);

		$sec = floor(count($res['page']) * ($this->sleep) * 1.05);
		$res['endTime'] = date('m月d日 H時i分',strtotime("+{$sec} second"));
		return $this->response($res);
	}
}