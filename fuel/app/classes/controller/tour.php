<?php

class Controller_Tour extends Controller_Base
{
	public function action_index()
	{
        $v = [];
        $v['site'] = $this->site;
        $tours = \DB::select(['name','site_name'],'tours.*')
            ->from('tours')
            ->join('sites')
            ->on('tours.site_id','=','sites.id')
            ->where('site_id','=',$this->site['id'])
            ->order_by('created_at','DESC')
            ->execute()
            ->as_array();
        foreach  ( $tours as $tour ) {
            $tour['conditions'] = json_decode($tour['conditions'],true);
            $v['tours'][] = $tour;
        }
        $this->template->content = View::forge("tour/index",$v,FALSE);
    }

    public function action_add($history_id)
    {
        $post = Input::post();
        $v = [];
        if ( is_null($this->site) ) Response::redirect('/');
        $logs = [];
		$v['history'] = Service_History::getHistory($this->site['id'],$history_id);
		if ( is_null($v['history']) ) {
			return new HttpNotFoundException();
		}

        if ( $post ) {
            $title = $post['tour_name'];
            if ( $title !== "" ) {
                $res = Model_Tour::insert($this->site['id'],$this->user_id,$title,json_encode($v['history']['conditions']),$v['history']['count']);
                $hash = Model_Tour::generateHash($this->site['id'],$res[0]);
                Model_Tour::updateEnjoyKey($this->user_id,$res[0],$hash);
                Response::redirect('/tour');
            }
        }

        $cond = Service_History::getHistoryConditions($this->site['id'],$history_id);
        $v['pages'] = Service_Search::getPages($this->site['id'],$cond['priority'],$cond['tags'],$cond['freeWord']);


        $v['site'] = $this->site;
        $this->template->content = View::forge("tour/add",$v,FALSE);
    }

    public function action_enjoy($tour_hash)
    {
        $tour = \DB::select()->from('tours')->where('enjoykey',$tour_hash)->execute()->current();
        if ( empty($tour) ) {
            // なんか通知
            return;
        }
        $cond = json_decode($tour['conditions'],true);
        $pages = Service_Search::getPages($this->site['id'],$cond['priority'],$cond['tags'],$cond['freeWord']);
		if ( count($pages) != 0 ) {
			// historyにインサート
			$resp = \DB::insert('histories')->set([
				'site_id' 		=> $this->site['id'],
				'user_id' 		=> $this->user_id,
				'conditions' 	=> json_encode(['priority'=>$cond['priority'],'tags'=>$cond['tags'],'freeWord'=>$cond['freeWord']]),
				'count' 		=> count($pages),
				'start_at' 		=> date('Y-m-d H:i:s'),
			])->execute();
		}
		$history_id = $resp[0];

		foreach ( $pages as $key => $page ) {
			$urls[] = $page['url'];
		}

		$cr = new Service_Crawler();
        if ( $this->site['basic_user'] != "" ) {
            $cr->setBasic($this->site['basic_user'],$this->site['basic_paswd'])->setBaseUrl($this->site['url']);
        }
		$result = $cr->crawle($history_id,$urls);

		\DB::update('histories')
			->set(['finish_at'=>date('Y-m-d H:i:s')])
			->where(['id'=>$history_id])
			->execute();
        // あとしまつ
        exit;
    }
}
