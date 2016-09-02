<?php

class Controller_History extends Controller_Base
{
	public function action_index()
	{
        if ( is_null($this->site) ) Response::redirect('/');
        $v = [];
        $list = Service_History::getAllHistories($this->site['id']);
        $v['list'] = $list;
        $v['site'] = $this->site;
        // var_dump($list);die;


        $this->template->content = View::forge("history/index",$v,FALSE);
    }

    public function action_detail($history_id)
    {
        if ( is_null($this->site) ) Response::redirect('/');
        $logs = [];
		$v['history'] = Service_History::getHistory($this->site['id'],$history_id);
		if ( is_null($v['history']) ) {
			return new HttpNotFoundException();
		}
        $data = Model_Log::fetchByHistoryId($history_id);
        foreach ( $data as $key => $value ) {
            $value['url1'] = $this->site['url'].$value['url1'];
            $logs[$key] = $value;
        }
        $v['logs'] = $logs;
        $v['site'] = $this->site;
        $this->template->content = View::forge("history/detail", $v, FALSE);
    }

}
