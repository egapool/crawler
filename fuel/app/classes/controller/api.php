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

		list($priority,$tags) = Service_Search::filterRequest($post);

		$res['page'] = Service_Search::getPages($this->site['id'],$priority,$tags);

		$sec = floor(count($res['page']) * ($this->sleep) * 1.05);
		$res['endTime'] = date('m月d日 H時i分',strtotime("+{$sec} second"));
		return $this->response($res);
	}

	public function post_crawle()
	{
		$post = Input::post();
		$urls = [];
		$priority = null;
		$tags = [];

		list($priority,$tags) = Service_Search::filterRequest($post);
		$pages = Service_Search::getPages($this->site['id'],$priority,$tags);
		if ( count($pages) != 0 ) {
			// historyにインサート
			$resp = \DB::insert('histories')->set([
				'site_id' 		=> $this->site['id'],
				'user_id' 		=> $this->user_id,
				'conditions' 	=> json_encode(['priority'=>$priority,'tags'=>$tags]),
				'count' 		=> count($pages),
				'start_at' 		=> date('Y-m-d H:i:s'),
			])->execute();
		}
		$history_id = $resp[0];

		foreach ( $pages as $key => $page ) {
			$urls[] = $page['url'];
		}
		// var_dump($pages);die;
		$cr = new Service_Crawler();
		$cr->setBasic($this->site['basic_user'],$this->site['basic_paswd'])->setBaseUrl($this->site['url']);
		$result = $cr->crawle($history_id,$urls);

		\DB::update('histories')
			->set(['finish_at'=>date('Y-m-d H:i:s')])
			->where(['id'=>$history_id])
			->execute();
		//
		$res = [
			"ok" => true,
			"history_id" => $history_id,
		];
		return $this->response($res);

	}
}
