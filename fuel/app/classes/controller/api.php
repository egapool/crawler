<?php

class Controller_Api extends Controller_Base
{
	public function post_search_page()
	{
		$limit = 1000;
		$res = [
			"ok" => true,
		];
		$post = Input::post();
		$priority = null;
		$tags = [];
		$freeWord = [];

		list($priority,$tags,$freeWord) = Service_Search::filterRequest($post);

		$res['page'] = Service_Search::getPages($this->site['id'],$priority,$tags,$freeWord);

		$sec = floor(count($res['page']) * ($this->sleep) * 1.05);
		$res['endTime'] = date('m月d日 H時i分',strtotime("+{$sec} second"));
		return $this->response($res);
	}

	public function post_crawle()
	{
		$post = Input::post();
		$urls = [];
		$priority = null;
		$freeWord = [];

		list($priority,$tags,$freeWord) = Service_Search::filterRequest($post);
		$pages = Service_Search::getPages($this->site['id'],$priority,$tags,$freeWord);
		if ( count($pages) != 0 ) {
			// historyにインサート
			$resp = \DB::insert('histories')->set([
				'site_id' 		=> $this->site['id'],
				'user_id' 		=> $this->user_id,
				'conditions' 	=> json_encode(['priority'=>$priority,'tags'=>$tags,'freeWord'=>$freeWord]),
				'count' 		=> count($pages),
				'start_at' 		=> date('Y-m-d H:i:s'),
			])->execute();
		}
		$history_id = $resp[0];

		foreach ( $pages as $key => $page ) {
			$urls[] = $page['url'];
		}

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

	public function post_download_result()
	{
		// すでにfileあれば返す
		$post = Input::post();
		$history_id = $post['history_id'];
		$filePath = APPPATH."/tmp/logs_{$history_id}.xlsx";

		$logs = \DB::select('url1','status_code1','url2','status_code2','url3','status_code3','title','h1','keywords','description','robots','canonical','next','prev')->from('logs')->where('history_id','=',$history_id)->execute()->as_array();

		$writer = Box\Spout\Writer\WriterFactory::create(Box\Spout\Common\Type::XLSX);
		$writer->openToFile($filePath);
		$writer->addRow(['url1','status_code1','url2','status_code2','url3','status_code3','title','h1','keywords','description','robots','canonical','next','prev']);
		$writer->addRows($logs);
		$writer->close();

		return $this->response(['ok'=>true,'history_id'=>$history_id]);
	}
}










