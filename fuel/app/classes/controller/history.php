<?php

class Controller_History extends Controller_Base
{
	public function action_index()
	{
        $v = [];
        $list = Service_History::getAllHistories($this->site['id']);
        $v['list'] = $list;
        $v['site'] = $this->site;
        // var_dump($list);die;


        $this->template->content = View::forge("history/index",$v,FALSE);
    }

    public function action_detail($history_id)
    {
        $logs = [];
        $data = Model_Log::fetchByHistoryId($history_id);
        foreach ( $data as $key => $v ) {
            $v['url1'] = $this->site['url'].$v['url1'];
            $logs[$key] = $v;
        }
        $v['logs'] = $logs;
        $v['site'] = $this->site;
        $this->template->content = View::forge("history/detail", $v, FALSE);
    }
}
