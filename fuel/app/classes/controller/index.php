<?php

class Controller_Index extends Controller_Base
{
	public function action_index()
	{
		$limit = 1000;
		$v['site']  = $this->site;
		$v['pages'] = Model_Page::fetchPages($this->site['id'],$limit);
		$v['tags']  = Model_Tag::fetchTags($this->site['id']);
		$v['count'] = count($v['pages']);
		$sec = floor($v['count'] * ($this->sleep) * 1.05);
		$v['endTime'] = date('m月d日 H時i分',strtotime("+{$sec} second"));

		$this->template->content = View::forge("index/index",$v,FALSE);
		// var_dump($site,$pages,$tags);die;
	}
}
